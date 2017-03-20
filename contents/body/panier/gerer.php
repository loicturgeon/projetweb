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
          $query = "SELECT pa.id as id, pa.qte as qte, pr.titre as titre, pr.prix as prix, pr.id as idpro, pr.image as image2 FROM panier as pa INNER JOIN produit as pr ON pa.fk_produitid = pr.id WHERE pa.fk_utilisateurid = ? ORDER BY pr.titre";
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
						
						if($row['image2'] === null){
							?>
								<img width="100" height="100" src="<?php echo LIBS."/libs/images/default.jpg"; ?>">
							<?php
						} else {
							?>
								<img width="100" height="100" src="<?php echo $row['image2']; ?>">
							<?php
						}
					?>
                  </div>
                </td>
                <td><?php echo $row['titre']; ?></td>
                <td>
                  <input type="number" class="form-control cart__list__item__qty" min="1" value="<?php echo $row['qte']; ?>"></td>
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
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
		<input type="hidden" name="cmd" value="_xclick">
		<input type="hidden" name="business" value="locturgeon@gmail.com">
		<input type="hidden" name="lc" value="CA">
		<input type="hidden" name="item_name" value="Montant">
		<input type="hidden" name="item_number" value="1234">
		<input id="paypalvalue" type="hidden" name="amount" value="400">
		<input type="hidden" name="currency_code" value="CAD">
		<input type="hidden" name="button_subtype" value="services">
		<input type="hidden" name="no_note" value="0">
		<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest">
		<input type="image" src="https://www.paypalobjects.com/fr_CA/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !">
		<img alt="" border="0" src="https://www.paypalobjects.com/fr_CA/i/scr/pixel.gif" width="1" height="1">
		</form>
      </div>
    </div>
  </div> <!-- .cart__list -->
</div>

<script type="text/javascript">
  $(document).ready(function(){
    function deleteAlerts(){
      $(".alert").remove();
    }
    function calculerTotal(){
      var total = 0;
      var prixParItem = 0;
      var qte = 0;
      $(".cart__list__item").each(function(){
        prixParItem = parseFloat($(this).find(".cart__list__item__prix").text());
        qte = parseFloat($(this).find(".cart__list__item__qty").val());

        total += prixParItem * qte;
		
      });
		$("#paypalvalue").val(Math.round(total * 100) / 100);
        $(".cart__list__checkout__info__total__price").text("Total: $" + Math.round(total * 100) / 100);
    }

    $(".cart__list__item__qty").change(function() {
      calculerTotal();
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
