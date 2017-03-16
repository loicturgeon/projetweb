<?php
	if(defined("INCLUDE_ONLY") === false){
		die("Une erreur c'est produite.");
	}
	if(isset($_POST['form_modifier_admin_categorie']) && isset($_POST['id_categorie']) && isset($_POST['titre']) && isset($_POST['description'])){
		try{
			$pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
			$query = "UPDATE categorie SET titre = ?, description = ? WHERE id = ?";
			$statement = $pdo->prepare($query);
			$statement->execute(array($_POST['titre'], $_POST['description'], $_POST['id_categorie']));
			header("Location: index.php?context=admin_categorie&page=gerer");
		} catch (PDOException $e){
			die("Une erreur c'est produite.");
		}
	}
	
	if(!isset($_GET['id_categorie'])){
		header("Location: index.php?context=admin_categorie&page=gerer");
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
			Manager::content("modifier", "admin_categorie");
			Manager::partial("footer");
		?>

	</body>
</html>