<?php
	if(defined("ERROR_MUST_LOGIN")){
		?>
			<div class="container">
			<br/>
			<div class="alert alert-danger">
			  <strong>Erreur!</strong> <?php echo ERROR_MUST_LOGIN; ?>
			</div>
			</div>
		<?php
	}
?>
<div class="container products-list">
  <div class="products-list__title">
    <h1>Inventaire</h1>
  </div>
  <div class="products-list__list">
		<div class="products-list__list__filter form-inline">
			<select class="form-control" id="ddCategories">
				<option value="0">Toutes catégories</option>

				<?php
	        $pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
	        $query = "SELECT c.id as id, c.titre as titre FROM categorie c ORDER BY c.titre ASC";
	        $statement = $pdo->prepare($query);
	        $statement->execute();

	        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
	          ?>
							<option value="<?php echo $row['id']; ?>"><?php echo $row['titre']; ?></option>
	          <?php
	        }
	      ?>
	    </select>
			<input type="text" class="form-control" id="txtRechercher" placeholder="Rechercher">
			<br><br>
		</div>
    <div class="row">
      <?php
        $pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
        $query = "SELECT p.id as id, p.titre as titre, p.prix as prix, c.titre as titrecat, p.description as descr FROM produit p INNER JOIN categorie c ON p.fk_categorieid = c.id ORDER BY p.titre";
        $statement = $pdo->prepare($query);
        $statement->execute();

        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
          ?>
              <div class="col-md-4">
                <div class="products-list__list_item">
                  <div class="products-list__list_item__image">
					<?php
						$image = "";
						$arr = array(LIBS."/libs/images/upload/".$row['id'].".jpg"=>ROOT."/libs/images/upload/".$row['id'].".jpg", LIBS."/libs/images/upload/".$row['id'].".jpeg"=>ROOT."/libs/images/upload/".$row['id'].".jpeg", LIBS."/libs/images/upload/".$row['id'].".png"=>ROOT."/libs/images/upload/".$row['id'].".png");
						foreach($arr as $key=>$value){
							
							if(file_exists($value)){
								$image = $key;
							}
						}
						if($image === ""){
							?>
								<img width="200" height="200" src="<?php echo LIBS."/libs/images/default.jpg"; ?>">
							<?php
						} else {
							?>
								<img width="200" height="200" src="<?php echo $image; ?>">
							<?php
						}
					?>
                    
                  </div>
                  <div class="products-list__list_item__title">
                    <a href="#"><?php echo $row['titre']; ?></a>
                  </div>
                  <div class="products-list__list_item__price">
                    $<?php echo $row['prix']; ?>
                  </div>
									<?php if(isset($_SESSION['id'])){ ?>
										<div class="products-list__list_item__add-to-cart">
											<button class="btn btn-success btn-lg btn-add-to-cart" id="<?php echo $row['id']; ?>">Ajouter au panier</button>
										</div>
									<?php } ?>
                </div>
              </div>
          <?php
        }
      ?>
    </div> <!-- .row-->
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
		var categorie = $("#ddCategories").val();
		var filtre = "";

    function deleteAlerts(){
      $(".alert").remove();
    }
		$("#ddCategories").change(function(){
		 categorie = $(this).val();
		 filtrerInventaire();
	 });
	 $("#txtRechercher").on('keyup', function(){
		 filtre = $(this).val();
		 filtrerInventaire();
	 });
		function resetEvents(){
			$(".btn-add-to-cart").click(function(){
				var qte = 1;
				var produitId = this.id;

				$.ajax({
					url: "index.php?page=ajouter&context=panier",
					type: 'post',
					data: {
						qte: 1,
						fk_produitid: produitId
					},
					success: function(result) {
						if(result === "echec"){
							$(".products-list__title").prepend(
								'<div class="alert alert-danger">' +
									'<strong>Échec!</strong> L\'item n\'a pu être ajouter à votre panier.' +
								'</div>'
							);
						}else if(result === "echec panier"){
							$(".products-list__title").prepend(
								'<div class="alert alert-danger">' +
									'<strong>Échec!</strong> Cet item est déjà dans votre panier.' +
								'</div>'
							);
						}else{
							$(".products-list__title").prepend(
								'<div class="alert alert-success">' +
									'<strong>Succès!</strong> Votre item a été ajouté à votre panier.' +
								'</div>'
							);
						}

						setTimeout(deleteAlerts, 2000);
					}
				});
			});
		}

		function filtrerInventaire(){
			$.ajax({
        url: "index.php?page=filtrer&context=home",
        type: 'post',
        data: {
          categorie: categorie,
          filtre: filtre
        },
        success: function(result) {
          if(result === "echec"){
            alert(result);
          }else{
						$(".row").empty();

						$.each(result, function(i, item){
							$(".row").append(
								'<div class="col-md-4">' +
	                '<div class="products-list__list_item">' +
	                 '<div class="products-list__list_item__image">' +
	                    '<img src="https://fthmb.tqn.com/aG_csasiSllxQJt2CmM011UBbCE=/768x0/filters:no_upscale()/about/hp-computer-on-off-56a6f9e85f9b58b7d0e5cc8b.jpg">' +
	                  '</div>' +
	                  '<div class="products-list__list_item__title">' +
	                    '<a href="#">' + item.titre + '</a>' +
	                  '</div>' +
	                  '<div class="products-list__list_item__price">$' + item.prix + '</div>' +
										'<?php if(isset($_SESSION['id'])){ ?>' +
											'<div class="products-list__list_item__add-to-cart">' +
												'<button class="btn btn-success btn-lg btn-add-to-cart" id="' + item.id + '">Ajouter au panier</button>' +
											'</div>' +
										'<?php } ?>' +
	                '</div>' +
	              '</div>'
							);
						});

						resetEvents();
          }
        }
      });
		}

		resetEvents();
  });
</script>
