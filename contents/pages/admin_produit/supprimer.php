<?php
	if(Auth::Admin() === false){
		header("Location: index.php?context=admin_produit&page=gerer");
		return;
	}
	if(!isset($_GET['id_produit'])){
		header("Location: index.php?context=admin_produit&page=gerer");
		return;
	}
	try{
		$pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
		$query = "DELETE FROM panier WHERE fk_produitid = ?;DELETE FROM produit WHERE id = ?";
		$statement = $pdo->prepare($query);
		$statement->execute(array($_GET['id_produit'],$_GET['id_produit']));
		
		// A faire marcher avec les 3 extensions
		/*if(file_exists(ROOT."/libs/images/upload/".$_GET['id_produit'].".png")){
			die("test");
			unlink(ROOT."/libs/images/upload/".$_GET['id_produit'].".png");
		}*/
		
	} catch (PDOException $e){
		die("Une erreur c'est produite.");
	}
	header("Location: index.php?context=admin_produit&page=gerer");
?>