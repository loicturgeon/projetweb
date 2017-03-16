<div class="container">    
    <?php 
	if(defined("ERROR_MDP")){ ?>
		<div class="alert alert-danger">
		  <strong>Erreur!</strong> <?php echo ERROR_MDP; ?>
		</div>
	<?php }
	if(defined("MDP_CHANGE")){ ?>
		<div class="alert alert-success">
		  <strong>Bravo!</strong> <?php echo MDP_CHANGE; ?>
		</div>
	<?php } ?>
    <div style=" margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Votre profil</div>
            </div>  
            <div class="panel-body" >
                <form class="form-horizontal" method="post" action="index.php?page=modifier&context=utilisateur">
                        
                        <div class="form-group required row">
                            <label class="control-label col-md-4 requiredField">Mot de passe actuel<span class="asteriskField">*</span> </label>
                            <div class="controls col-md-8 ">
                                <input class="input-md  textinput textInput form-control" name="mdpactu" placeholder="Mot de passe actuel" style="margin-bottom: 10px" type="password" />
                            </div>
                        </div>
                        <div class="form-group required row">
                            <label class="control-label col-md-4  requiredField">Nouveau mot de passe<span class="asteriskField">*</span> </label>
                            <div class="controls col-md-8 ">
                                <input class="input-md textinput textInput form-control" name="mdpnouv" placeholder="Mot de passe désiré" style="margin-bottom: 10px" type="password" />
                            </div>     
                        </div>
                        <div class="form-group required row">
                            <label class="control-label col-md-4  requiredField">Confirmation du mot de passe<span class="asteriskField">*</span> </label>
                            <div class="controls col-md-8 "> 
                                <input class="input-md textinput textInput form-control" name="mdpverif" placeholder="Confirmation du mot de passe" style="margin-bottom: 10px" type="password" />
                            </div>
                        </div>
                        
                        <div class="form-group row"> 
                            <div class="aab controls col-md-4 "></div>
                            <div class="controls col-md-8 ">
                                <input type="submit" name="SaveProfile" value="Enregistrer" class="btn btn-primary btn btn-info" />
                            </div>
                        </div>

                </form>
            </div>
        </div>
    </div> 
</div>
            