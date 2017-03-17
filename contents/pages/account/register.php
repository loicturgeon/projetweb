<?php
	if(isset($_SESSION['id']) && $_SESSION['id'] !== 0){
		header("Location: index.php");
	}
	if(isset($_POST['register_form']) && isset($_POST['user']) && isset($_POST['mdp']) && isset($_POST['mdpverif'])){
		$user = $_POST['user'];
		$mdp = $_POST['mdp'];
		$mdpverif = $_POST['mdpverif'];
		if($mdp !== $mdpverif){
			define("ERROR_REGISTRATION", "Le mot de passe ne correspond pas à la validation.");
		} else if($mdp === null || $mdp === ""){
			define("ERROR_REGISTRATION", "Le mot de passe ne peut pas être vide.");
		} else {
			try{
				$pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
				$query = "INSERT INTO utilisateur (usager, mdp, email, typeusager, adresse) VALUES (?,?,?,?,?)";
				$statement = $pdo->prepare($query);
				$b = $statement->execute(array($_POST['user'], md5($_POST['mdp']), $_POST['email'], 0, $_POST['adresse']));
				if($b === false){
					define("ERROR_REGISTRATION", "Cet usager existe déjà.");
				} else {
					$query = "SELECT id,usager FROM utilisateur ORDER BY id DESC LIMIT 1";
					$statement = $pdo->prepare($query);
					$statement->execute();
					
					$row = $statement->fetch(PDO::FETCH_ASSOC);
					$tokenemail = md5($row['usager']);
					$id = $row['id'];
					
					$query = "UPDATE utilisateur SET tokenemail = ? WHERE id=?";
					$statement = $pdo->prepare($query);
					$bb = $statement->execute(array($tokenemail, $id));
					if($bb === true){
						$contenuEmail = "Bonjour, " . $_POST['user'] . ". Veuillez <a href='".$tokenemail."'>confirmer votre email ici</a>.";					
						//mail($_POST['email'], "Confirmation - Le gros de l'info", $contenuEmail);
						define("REGISTER_SUCCESS", "Votre enregistrement a été fait avec succès. Veuillez confirmer votre email.");
					} else {
						define("ERROR_REGISTRATION", "Impossible de générer votre code pour l'email.");
					}
					
					Manager::page("login", "account");
					return;
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
<?php Manager::partial("headlogin"); ?>
<body>
	<?php 
		Manager::partial("header");
		Manager::content("register", "account");
		Manager::partial("footer"); 
	?>
</body>
</html>
