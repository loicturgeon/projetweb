<?php
  if(isset($_SESSION['id'])){
    if(isset($_POST['qte']) || isset($_POST['produitId'])){
      $pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
      $query = "update panier set qte = ? where id = ? and fk_utilisateurid = ?";
      $statement = $pdo->prepare($query);
  		$b = $statement->execute(array($_POST['qte'], $_POST['produitId'], $_SESSION['id']));
      if($b === false){
        echo "echec";
      } else {
        echo "succes";
      }


  	}else{
      echo "Échec! Il manque des infos pour l'ajouter au panier.";
    }
  }else{
    echo "Échec! Vous devez être connecté pour ajouter un item au panier.";
  }
?>
