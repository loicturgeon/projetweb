<?php
	if(isset($_SESSION['id']) && $_SESSION['id'] !== '0'){
		header("Location: index.php");
	}
	
	if(isset($_POST['login_form']) && isset($_POST['user']) & isset($_POST['mdp']) && !defined("ERROR_CONFIRM_EMAIL")){
		try{
			$pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
			$query = "SELECT * FROM utilisateur WHERE usager = ? AND mdp = ? LIMIT 1";
			$statement = $pdo->prepare($query);
			$statement->execute(array($_POST['user'], md5($_POST['mdp'])));
			
			if($statement->rowCount() === 0){
				define("ERROR_LOGIN", "L'usager ou le mot de passe n'est pas valide.");
			} else {
				$row = $statement->fetch(PDO::FETCH_ASSOC);
				if($row['tokenemail'] != null){
					define("ERROR_CONFIRM_EMAIL", "Confirmer votre email avant de pouvoir vous connecter");
					Manager::page("login", "account");
					return;
				}
				$_SESSION['id'] = $row['id'];
				$_SESSION['usager'] = $row['usager'];
				$_SESSION['email'] = $row['email'];
				$_SESSION['adresse'] = $row['adresse'];
				$_SESSION['typeusager'] = $row['typeusager'];
				header("Location: index.php");
			}
		} catch(PDOException $e){
			$pdo = null;
			die("Une erreur c'est produite");
		}
		$pdo = null;
	}
?>
<html>
<?php Manager::partial("headlogin"); ?>
<body>
	<?php 
		Manager::partial("header");
		Manager::content("login", "account");
		Manager::partial("footer"); 
	?>
</body>
</html>
