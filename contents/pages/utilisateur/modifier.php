<?php
	if(isset($_POST['SaveProfile'])){
		$mdp = $_POST['mdpactu'];
		$mdpverif = $_POST['mdpverif'];
		$mdpnouv = $_POST['mdpnouv'];
		if($mdpnouv !== $mdpverif){
			define("ERROR_MDP", "Le mot de passe de confirmation n'est pas identique");
		} else if($mdpnouv === null || $mdpnouv === ""){
			define("ERROR_MDP", "Le mot de passe ne peut pas être vide.");
		} else {
			try{
				$pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
				$query = "SELECT id FROM utilisateur WHERE usager=? AND mdp=? LIMIT 1";
				$statement = $pdo->prepare($query);
				$statement->execute(array($_SESSION['usager'], md5($mdp)));
				if($statement->rowCount() >= 1){
					$query = "UPDATE utilisateur SET mdp=?";
					$statement = $pdo->prepare($query);
					$statement->execute(array(md5($mdpnouv)));
					define("MDP_CHANGE", "Votre mot de passe a été changé avec succès!");
				} else {
					define("ERROR_MDP", "Le mot de passe n'est pas valide.");
				}
			} catch(PDOException $e){
				$pdo = null;
				die("Une erreur c'est produite");
			}
			
			
			$pdo = null;
		}
	}
?>
<html>
<?php
	Manager::partial("head");
?>
	<body>
		<?php 
			Manager::partial("header");
			Manager::content("modifier", "utilisateur");
			Manager::partial("footer");
		?>

	</body>
</html>
