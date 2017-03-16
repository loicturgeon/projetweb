<?php
	if(Auth::Admin() === false){
		header("Location: index.php?context=admin_user&page=gerer");
		return;
	}
	if(!isset($_GET['id_user'])){
		header("Location: index.php?context=admin_user&page=gerer");
		return;
	}
	if($_SESSION['id'] == $_POST['id_user']){
		header("Location: index.php?context=admin_user&page=gerer");
		return;
	}
	try{
		$pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
		$query = "DELETE FROM utilisateur WHERE id = ?";
		$statement = $pdo->prepare($query);
		$statement->execute(array($_GET['id_user']));
	} catch (PDOException $e){
		die("Une erreur c'est produite.");
	}
	header("Location: index.php?context=admin_user&page=gerer");
?>