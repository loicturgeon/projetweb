<?php
	if(defined("INCLUDE_ONLY") === false){
		die("Une erreur c'est produite.");
	}
	if(isset($_POST['form_modifier_admin_produit']) && isset($_POST['id_produit']) && isset($_POST['titre']) && isset($_POST['description']) && isset($_POST['prix']) && isset($_POST['categorie'])){
		try{
			$pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
			$query = "UPDATE produit SET titre = ?, description = ?, prix = ?, fk_categorieid = ? WHERE id = ?";
			$statement = $pdo->prepare($query);
			$b = $statement->execute(array($_POST['titre'], $_POST['description'], $_POST['prix'], $_POST['categorie'], $_POST['id_produit']));
			header("Location: index.php?context=admin_produit&page=gerer");
		} catch (PDOException $e){
			die("Une erreur c'est produite.");
		}
	}
	
	if(!isset($_GET['id_produit'])){
		header("Location: index.php?context=admin_produit&page=gerer");
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
			Manager::content("modifier", "admin_produit");
			Manager::partial("footer");
		?>

	</body>
</html>