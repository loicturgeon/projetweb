<?php
	if(!isset($_GET['id_produit'])){
		header("Location: index.php");
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
			Manager::content("info", "produit");
			Manager::partial("footer");
		?>

	</body>
</html>