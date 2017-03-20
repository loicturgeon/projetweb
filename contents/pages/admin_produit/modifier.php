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
			if(isset($_FILES['image'])){
				$allowed =  array('png' ,'jpg', 'jpeg');
				$filename = $_FILES['image']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if(!in_array($ext,$allowed) || $_FILES["image"]["size"] > 500000) {
					header("Location: index.php?context=admin_produit&page=gerer");
					return;
				}
				
				$target_dir = ROOT."/libs/images/upload/";
				$target_file = $target_dir . $_POST['id_produit'] .".".$ext;
				
				if(file_exists($target_dir.$_POST['id_produit'].".jpg")) {unlink($target_dir.$_POST['id_produit'].".jpg");}
				if(file_exists($target_dir.$_POST['id_produit'].".jpeg")) {unlink($target_dir.$_POST['id_produit'].".jpeg");}
				if(file_exists($target_dir.$_POST['id_produit'].".png")) {unlink($target_dir.$_POST['id_produit'].".png");}
				
				
				move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
			}
			$query = "UPDATE produit SET image = ? WHERE id = ?";
			$statement = $pdo->prepare($query);
			$statement->execute(array(LIBS."/libs/images/upload/".$_POST['id_produit'].".".$ext, $_POST['id_produit']));
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