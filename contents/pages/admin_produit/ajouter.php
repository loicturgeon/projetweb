<?php
	if(!isset($_POST['form_ajout_produit_admin']) || !isset($_POST['titre'])
		|| !isset($_POST['prix']) || !isset($_POST['categorie']) || !isset($_POST['description'])){
		header("Location: index.php?context=admin_produit&page=gerer");
	}
	if(Auth::Admin()){
		try{
			$pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
			$query = "INSERT INTO produit (titre, prix, fk_categorieid, description) VALUES (?,?,?,?)";
			$statement = $pdo->prepare($query);
			$b = $statement->execute(array($_POST['titre'], $_POST['prix'], $_POST['categorie'], $_POST['description']));
			if($b === false){
				define("ERROR_AJOUT_ADMIN", "Une erreur c'est produite lors de l'ajout.");
			} else {
				define("SUCCESS_AJOUT_ADMIN", "L'ajout a été réussi!");
				if(isset($_FILES['image'])){
					$allowed =  array('png' ,'jpg', 'jpeg');
					$filename = $_FILES['image']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(!in_array($ext,$allowed) || $_FILES["image"]["size"] > 500000) {
						define("WARNING_AJOUT_ADMIN", "Le fichier est trop gros. Une image par défaut sera utilisé.");
						Manager::page("gerer", "admin_produit");
						return;
					}
					
					$query = "SELECT id FROM produit ORDER BY id DESC LIMIT 1";
					$statement = $pdo->prepare($query);
					$statement->execute();
					$row = $statement->fetch(PDO::FETCH_ASSOC);
					
					$target_dir = ROOT."/libs/images/upload/";
					$target_file = $target_dir . $row['id'].".".$ext;
					if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
						define("WARNING_AJOUT_ADMIN", "Une erreur est survenue lors du transfert de l'image. Une image par défaut sera utilisé.");
						Manager::page("gerer", "admin_produit");
						return;
					}
				} else {
					define("WARNING_AJOUT_ADMIN", "Vous n'avez pas choisi d'image. Une image par défaut sera utilisé.");
				}
			}
		}
		catch(PDOException $e){
			die("Une erreur c'est produite.");
		}
		
		Manager::page("gerer", "admin_produit");
		return;
	}
?>