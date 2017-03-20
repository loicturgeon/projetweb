<?php
	if(!isset($_GET['token']) || !isset($_GET['usager'])){
		define("ERROR_EMAIL_VALIDE","Une erreur est survenue lors de votre confirmation d'email.");
		Manager::page("home");
		return;
	}
	
	try{
		$pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
		$query = "UPDATE utilisateur SET tokenemail = null WHERE usager = ? AND tokenemail = ?";
		$statement = $pdo->prepare($query);
		$statement->execute(array($_GET['usager'], $_GET['token']));
		if($statement->rowCount() === 0){
			define("ERROR_LINK_EXPIRED", "Votre lien n'est pas ou n'est plus valide.");
		} else {
			define("SUCCESS_EMAIL", "Vous pouvez maintenant accéder à votre profil.");
		}
		Manager::page("login", "account");
	} catch(PDOException $e){
		die("Une erreur c'est produite.");
	}
?>