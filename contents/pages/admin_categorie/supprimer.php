<?php
	if(Auth::Admin() === false){
		header("Location: index.php?context=admin_categorie&page=gerer");
		return;
	}
	if(!isset($_GET['id_categorie'])){
		header("Location: index.php?context=admin_categorie&page=gerer");
		return;
	}
	try{
		$pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
		$query = "DELETE FROM produit WHERE fk_categorieid = ?";
		$statement = $pdo->prepare($query);
		$statement->execute(array($_GET['id_categorie']));
		$query = "DELETE FROM categorie WHERE id = ?";
		$statement = $pdo->prepare($query);
		$statement->execute(array($_GET['id_categorie']));
	} catch (PDOException $e){
		die("Une erreur c'est produite.");
	}
	header("Location: index.php?context=admin_categorie&page=gerer");
?>