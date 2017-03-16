<?php
	if(!isset($_POST['form_ajout_produit_admin']) || !isset($_POST['titre'])
		|| !isset($_POST['prix']) || !isset($_POST['categorie']) || !isset($_POST['description'])){
		header("Location: index.php?context=admin_produit&page=gerer");
	}
	if(Auth::Admin()){
		$pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
		$query = "INSERT INTO produit (titre, prix, fk_categorieid, description) VALUES (?,?,?,?)";
		$statement = $pdo->prepare($query);
		$b = $statement->execute(array($_POST['titre'], $_POST['prix'], $_POST['categorie'], $_POST['description']));
		if($b === false){
			define("ERROR_AJOUT_ADMIN", "Une erreur c'est produite lors de l'ajout.");
		} else {
			define("SUCCESS_AJOUT_ADMIN", "L'ajout a été réussi!");
		}
		Manager::page("gerer", "admin_produit");
		return;
	}
?>