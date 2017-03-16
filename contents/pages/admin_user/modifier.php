<?php
	if(defined("INCLUDE_ONLY") === false){
		die("Une erreur c'est produite.");
	}
	if(isset($_POST['form_modifier_admin_user']) && isset($_POST['id_user']) && isset($_POST['usager']) && isset($_POST['email']) && isset($_POST['adresse'])){
		try{
			$pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
			if(isset($_POST['mdp']) && !empty($_POST['mdp']) && isset($_POST['mdpverif']) && !empty($_POST['mdpverif']) && $_POST['mdp'] === $_POST['mdpverif']){
				$query = "UPDATE utilisateur SET usager = ?, email = ?, adresse = ?, mdp = ? WHERE id = ?";
				$statement = $pdo->prepare($query);
				$statement->execute(array($_POST['usager'], $_POST['email'], $_POST['adresse'], md5($_POST['mdp']), $_POST['id_user']));
			} else {
				$query = "UPDATE utilisateur SET usager = ?, email = ?, adresse = ? WHERE id = ?";
				$statement = $pdo->prepare($query);
				$statement->execute(array($_POST['usager'], $_POST['email'], $_POST['adresse'], $_POST['id_user']));
			}
			
			header("Location: index.php?context=admin_user&page=gerer");
		} catch (PDOException $e){
			die("Une erreur c'est produite.");
		}
	}
	
	if(!isset($_GET['id_user'])){
		header("Location: index.php?context=admin_user&page=gerer");
		return;
	}
?>
<html>
<?php
	Manager::partial("head");
?>
	<body>
		<?php 
			Manager::partial("header");
			Manager::content("modifier", "admin_user");
			Manager::partial("footer");
		?>

	</body>
</html>