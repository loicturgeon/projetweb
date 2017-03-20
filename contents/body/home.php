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
<script>
	$(document).ready(function() {
    $('#list').click(function(event){event.preventDefault();$('#products .item').addClass('list-group-item');});
    $('#grid').click(function(event){event.preventDefault();$('#products .item').removeClass('list-group-item');$('#products .item').addClass('grid-group-item');});
	
	var showChar = 200;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Lire plus";
    var lesstext = "Cacher";
    

    $('.more').each(function() {
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
 
    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
});

</script>
<div class="container products-list">
  <div class="products-list__title">
    <h1>Inventaire</h1>
  </div>
  <div class="well well-sm">
	<div class="btn-group">
		<a href="#" id="list" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th-list">
		</span>Liste</a> <a href="#" id="grid" class="btn btn-default btn-sm"><span
			class="glyphicon glyphicon-th"></span>Grille</a>
	</div>
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
    <div class="row row3ds">
		
      <?php
        $pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
        $query = "SELECT p.id as id, p.titre as titre, p.prix as prix, c.titre as titrecat, p.description as descr, p.image as image FROM produit p INNER JOIN categorie c ON p.fk_categorieid = c.id ORDER BY p.titre";
        $statement = $pdo->prepare($query);
        $statement->execute();

        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
          ?>
				<div id="products">
					<div class="item col-xs-4 col-lg-4">
						<div class="thumbnail">
							<?php
						
								if($row['image'] === null){
									?>
										<img width="400" height="250" class="group list-group-image" src="<?php echo LIBS."/libs/images/default.jpg"; ?>" alt="" />
									<?php
								} else {
									?>
										<img width="400" height="250" class="group list-group-image" src="<?php echo $row['image']; ?>" alt="" />
									<?php
								}
							?>
							
							<div class="caption">
								<h4 class="group inner list-group-item-heading">
									<?php echo $row['titre']; ?></h4>
								<p class="group inner list-group-item-text">
									<span class="more"><?php echo $row['descr']; ?></span></p>
								<div class="row">
									<div class="col-xs-12 col-md-6">
										<p class="lead">
											<?php echo $row['prix']; ?>$</p>
									</div>
									<div class="col-xs-12 col-md-6">
										<?php if(isset($_SESSION['id'])){ ?>
												<button class="btn btn-success btn-add-to-cart" id="<?php echo $row['id']; ?>">Ajouter au panier</button>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
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
						$(".row3ds").empty();

						$.each(result, function(i, item){
							$(".row3ds").append(
								'<div id="products">'+
									'<div class="item col-xs-4 col-lg-4">'+
										'<div class="thumbnail">'+
										'<img width="400" height="250" class="group list-group-image" src="'+item.image+'" alt="" />'+
											'<div class="caption">'+
											'<h4 class="group inner list-group-item-heading">'+item.titre+'</h4>'+
												'<p class="group inner list-group-item-text">'+item.descr+'</p>'+
												'<div class="row">'+
													'<div class="col-xs-12 col-md-6">'+
														'<p class="lead">'+item.prix+'$</p>'+
													'</div>'+
													'<div class="col-xs-12 col-md-6">'+
														<?php if(isset($_SESSION['id'])){ ?>
															'<button class="btn btn-success btn-add-to-cart" id="<?php echo $row['id']; ?>">Ajouter au panier</button>'+
														<?php } ?>
													'</div>'+
												'</div>'+
											'</div>'+
										'</div>'+
									'</div>'+	
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
