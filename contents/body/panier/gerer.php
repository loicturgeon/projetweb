<div class="container products-list">
  <div class="cart__title">
    <h1>Contenu du panier</h1>
  </div>
  <div class="cart__list">
    <table class="table table-striped table-bordered table-list">
      <thead>
        <tr>
          <th>Gestion</th>
          <th></th>
          <th>Titre</th>
          <th>Quantité</th>
          <th>Prix unitaire</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
          $query = "SELECT pa.id as id, pa.qte as qte, pr.titre as titre, pr.prix as prix, pr.id as idpro FROM panier as pa INNER JOIN produit as pr ON pa.fk_produitid = pr.id WHERE pa.fk_utilisateurid = ? ORDER BY pr.titre";
          $statement = $pdo->prepare($query);
          $statement->execute(array($_SESSION['id']));
          while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            ?>
              <tr class="cart__list__item" id="cart__list__item--<?php echo $row['id']; ?>">
                <td align="center">
                  <a href="" class="btn btn-danger btn-delete-from-cart" id="<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                </td>
                <td>
                  <div class="cart__list__item__image">
                    <?php
						$image = "";
						$arr = array(LIBS."/libs/images/upload/".$row['idpro'].".jpg"=>ROOT."/libs/images/upload/".$row['idpro'].".jpg", LIBS."/libs/images/upload/".$row['idpro'].".jpeg"=>ROOT."/libs/images/upload/".$row['idpro'].".jpeg", LIBS."/libs/images/upload/".$row['idpro'].".png"=>ROOT."/libs/images/upload/".$row['idpro'].".png");
						foreach($arr as $key=>$value){

							if(file_exists($value)){
								$image = $key;
							}
						}
						if($image === ""){
							?>
								<img width="100" height="100" src="<?php echo LIBS."/libs/images/default.jpg"; ?>">
							<?php
						} else {
							?>
								<img width="100" height="100" src="<?php echo $image; ?>">
							<?php
						}
					?>
                  </div>
                </td>
                <td><?php echo $row['titre']; ?></td>
                <td>
                  <input type="number" class="form-control cart__list__item__qty" min="1" id="<?php echo $row['id']; ?>" value="<?php echo $row['qte']; ?>"></td>
                <td class="cart__list__item__prix"><?php echo $row['prix']; ?></td>
              </tr>
            <?php
          }
        ?>
      </tbody>
    </table>
    <div class="cart__list__checkout">
      <div class="cart__list__checkout__info">
        <div class="cart__list__checkout__info__total">
          <h3 class="cart__list__checkout__info__total__price">...</h3>
        </div>
        <button type="button" class="btn btn-success btn-lg cart__list__checkout__info__total__btn-checkout">Acheter &raquo;</button>
      </div>
    </div>
  </div> <!-- .cart__list -->
</div>

<script type="text/javascript">
  $(document).ready(function(){
    function majQtePanier(input){
      var id = input.attr("id");
      var qte = input.val();

      $.ajax({
        url: "index.php?page=majQte&context=panier",
        type: 'post',
        data: {
          produitId: id,
          qte: qte
        },
        success: function(result) {
          if(result === "echec"){
            $(".cart__list").prepend(
              '<div class="alert alert-danger">' +
                '<strong>Échec!</strong> La quantité n\'a pu être mise à jour.' +
              '</div>'
            );
          }else{
            alert();
          }

          setTimeout(deleteAlerts, 2000);
        }
      });

    }
    function deleteAlerts(){
      $(".alert").remove();
    }
    function calculerTotal(){
      var total = 0;
      var prixParItem = 0;
      var qte = 0;
      var id = 0;

      $(".cart__list__item").each(function(){
        prixParItem = parseFloat($(this).find(".cart__list__item__prix").text());
        qte = parseFloat($(this).find(".cart__list__item__qty").val());


        if(qte <= 0){
          $(this).find(".cart__list__item__qty").val("1");
          qte = parseFloat($(this).find(".cart__list__item__qty").val());
        }

        //majQtePanier();

        total += prixParItem * qte;
      });

      $(".cart__list__checkout__info__total__price").text("Total: $" + Math.round(total * 100) / 100);
    }

    $(".cart__list__item__qty").change(function() {
      calculerTotal();
      majQtePanier($(this));
    });

    $(".cart__list__checkout__info__total__btn-checkout").click(function(){
      alert();
    });

    $(".btn-delete-from-cart").click(function(e){
      e.preventDefault();

      var produitId = this.id;

      $.ajax({
        url: "index.php?page=supprimer&context=panier",
        type: 'post',
        data: {
          produitId: produitId
        },
        success: function(result) {
          if(result === "echec"){
            $(".cart__list").prepend(
              '<div class="alert alert-danger">' +
                '<strong>Échec!</strong> L\'item n\'a pu être supprimé de votre panier.' +
              '</div>'
            );
          }else{
            $(".cart__list").prepend(
              '<div class="alert alert-success">' +
                '<strong>Succès!</strong> Votre item a été supprimé du panier.' +
              '</div>'
            );

            $("#cart__list__item--" + produitId).remove();

            calculerTotal();
          }

          setTimeout(deleteAlerts, 2000);
        }
      });
    });

    calculerTotal();
  });
</script>
