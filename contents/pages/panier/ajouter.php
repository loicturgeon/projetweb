<?php
  if(isset($_SESSION['id'])){
    if(isset($_POST['qte']) || isset($_POST['fk_produitid'])){
      $pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
      $query = "SELECT pa.id as id FROM panier as pa INNER JOIN produit as pr ON pa.fk_produitid = pr.id WHERE pa.fk_utilisateurid = ? and pa.fk_produitid = ?";
      $statement = $pdo->prepare($query);
  		$b = $statement->execute(array($_SESSION['id'], $_POST['fk_produitid']));
      if($statement->rowCount() == 0){ //nouvel item
        $query2 = "INSERT INTO panier (qte, fk_produitid, fk_utilisateurid) VALUES (?,?,?)";
    		$statement2 = $pdo->prepare($query2);
    		$b2 = $statement2->execute(array($_POST['qte'], $_POST['fk_produitid'], $_SESSION['id']));
    		if($b2 === false){
    			echo "echec";
    		} else {
    			echo "succes";
    		}
  		} else { //item déjà dans le panier
  			echo "echec panier";
  		}


  	}else{
      echo "Échec! Il manque des infos pour l'ajouter au panier.";
    }
  }else{
    echo "Échec! Vous devez être connecté pour ajouter un item au panier.";
  }
?>
