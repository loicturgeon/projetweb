<?php
	if(!isset($_POST['form_ajout_user_admin'])
		|| !isset($_POST['mdp']) || !isset($_POST['mdpverif'])
		|| !isset($_POST['usager']) || !isset($_POST['adresse']) || !isset($_POST['email'])){
		header("Location: index.php?context=admin_user&page=gerer");
	}
	if(Auth::Admin()){
		if($_POST['mdp'] !== $_POST['mdpverif']){
			define("ERROR_AJOUT_USER_ADMIN_MDP_DIFF", "Les mots de passe ne sont pas identiques.");
			Manager::page("gerer", "admin_user");
			return;
		}
		$pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
		$query = "INSERT INTO utilisateur (usager, mdp, adresse, email, tokenemail, typeusager) VALUES (?,?,?,?,?,0);";
		$statement = $pdo->prepare($query);
		$b = $statement->execute(array($_POST['usager'], md5($_POST['mdp']), $_POST['adresse'], $_POST['email'], md5($_POST['usager'])));
		if($b === false){
			define("ERROR_AJOUT_ADMIN", "Une erreur c'est produite lors de l'ajout.");
		} else {
			define("SUCCESS_AJOUT_ADMIN", "L'ajout a été réussi!");
		}
		Manager::page("gerer", "admin_user");
		return;
	}
?>