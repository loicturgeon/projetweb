<?php
	if(!isset($_POST['form_ajout_categorie_admin'])){
		header("Location: index.php?context=admin_categorie&page=gerer");
	}
	if(Auth::Admin()){
		$pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
		$query = "INSERT INTO categorie (titre, description) VALUES (?,?)";
		$statement = $pdo->prepare($query);
		$b = $statement->execute(array($_POST['titre'], $_POST['description']));
		if($b === false){
			define("ERROR_AJOUT_ADMIN", "Une erreur c'est produite lors de l'ajout");
		} else {
			define("SUCCESS_AJOUT_ADMIN", "L'ajout a été réussi!");
		}
		Manager::page("gerer", "admin_categorie");
		return;
	}
?>