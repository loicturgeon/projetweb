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
		$query = "DELETE FROM produit WHERE id = ?";
		$statement = $pdo->prepare($query);
		$statement->execute(array($_GET['id_produit']));
	} catch (PDOException $e){
		die("Une erreur c'est produite.");
	}
	header("Location: index.php?context=admin_produit&page=gerer");
?>