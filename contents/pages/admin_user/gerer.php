<?php
	if(defined("INCLUDE_ONLY") === false){
		die("Une erreur c'est produite.");
	}
?>
<html>
<?php
	Manager::partial("head");
?>
	<body>
		<?php 
			Manager::partial("header");
			Manager::content("gerer", "admin_user");
			Manager::partial("footer");
		?>

	</body>
</html>