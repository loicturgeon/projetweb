<?php
  if(isset($_SESSION['id'])){
    if(isset($_POST['produitId'])){
        $pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
    		$query = "delete from panier where id = ? and fk_utilisateurid=?";
    		$statement = $pdo->prepare($query);
    		$b = $statement->execute(array($_POST['produitId'], $_SESSION['id']));
    		if($b === false){
    			echo "echec";
    		} else {
    			echo "succes";
    		}
  	}else{
      echo "Échec! Il manque des infos pour le supprimer du panier.";
    }
  }else{
    echo "Échec! Vous devez être connecté pour suprimer un item du panier.";
  }
?>
