<?php
	if(defined("INCLUDE_ONLY") === false){
		die("Une erreur c'est produite.");
	}
	if(!isset($_SESSION['id'])){
		define("ERROR_MUST_LOGIN", "Vous devez être connecté avant de pouvoir accéder à votre panier.");
		Manager::page("home");
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
			Manager::content("gerer", "panier");
			Manager::partial("footer");
		?>

	</body>
</html>
