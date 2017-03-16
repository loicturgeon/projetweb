<?php
	try{
	$pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
	$query = "SELECT usager,email,adresse FROM utilisateur WHERE id=? LIMIT 1";
	$statement = $pdo->prepare($query);
	$statement->execute(array($_GET['id_user']));
	if($statement->rowCount() === 0){
		header("Location: index.php?context=admin_user&page=gerer");
		return;
	}
	$row = $statement->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $e){
		die("Une erreur c'est produite.");
	}
?>
<div class="container">
    <div style=" margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Modifier l'utilisateur</div>
            </div>  
            <div class="panel-body" >
                    <form  class="form-horizontal" method="post" action="index.php?page=modifier&context=admin_user">
                        
                        <div class="form-group required row">
                            <label class="control-label col-md-4 requiredField">Usager<span class="asteriskField">*</span> </label>
                            <div class="controls col-md-8 ">
                                <input class="input-md  textinput textInput form-control" name="usager" placeholder="Usager" style="margin-bottom: 10px" type="text" required value="<?php echo $row['usager']; ?>"/>
                            </div>
                        </div>
						<div class="form-group required row">
                            <label class="control-label col-md-4 requiredField">Mot de passe</label>
                            <div class="controls col-md-8 ">
                                <input class="input-md  textinput textInput form-control" name="mdp" placeholder="Mot de passe" style="margin-bottom: 10px" type="password"/>
                            </div>
                        </div>
						<div class="form-group required row">
                            <label class="control-label col-md-4 requiredField">Validation du mot de passe</label>
                            <div class="controls col-md-8 ">
                                <input class="input-md  textinput textInput form-control" name="mdpverif" placeholder="Validation du mot de passe" style="margin-bottom: 10px" type="password"/>
                            </div>
                        </div>
						<div class="form-group required row">
                            <label class="control-label col-md-4 requiredField">Email<span class="asteriskField">*</span> </label>
                            <div class="controls col-md-8 ">
                                <input class="input-md textinput textInput form-control" name="email" placeholder="Email" style="margin-bottom: 10px" type="text" required value="<?php echo $row['email']; ?>"/>
                            </div>
                        </div>
						<div class="form-group required row">
                            <label class="control-label col-md-4 requiredField">Adresse<span class="asteriskField">*</span> </label>
                            <div class="controls col-md-8 ">
                                <input class="input-md textinput textInput form-control" name="adresse" placeholder="Adresse" style="margin-bottom: 10px" type="text" required value="<?php echo $row['adresse']; ?>"/>
                            </div>
                        </div>
						

                        <div class="form-group row"> 
                            <div class="aab controls col-md-4 "></div>
                            <div class="controls col-md-8 ">
                                <input type="submit" value="Enregistrer" class="btn btn-primary btn btn-info" />
                            </div>
                        </div>
                        <input type="hidden" name="id_user" value="<?php echo $_GET['id_user']; ?>" />
						<input type="hidden" name="form_modifier_admin_user" />
                    </form>
            </div>
        </div>
    </div> 
</div>