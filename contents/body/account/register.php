<div class="container">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" method="post" action="index.php?page=register&context=account">
                <span id="reauth-email" class="reauth-email"></span>
                <input name="user" type="text" id="inputEmail" class="form-control" placeholder="Utilisateur" required autofocus>
                <input name="mdp" type="password" id="inputPassword" class="form-control" placeholder="Mot de passe" required>
				<input name="mdpverif" type="password" id="inputVerif" class="form-control" placeholder="Confirmation du mot de passe" required>
                <input name="email" type="text" id="inputEmail" class="form-control" placeholder="Email" required>
				<input name="adresse" type="text" id="inputadresse" class="form-control" placeholder="Adresse" required>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Créer mon compte</button>
				<input type="hidden" name="register_form" value=""/>
            </form><!-- /form -->
	    <a href="index.php?page=login&context=account" class="forgot-password">
                Déjà un compte?
            </a>
	<?php
		if(defined("ERROR_REGISTRATION")){ ?>
			<div class="alert alert-danger">
			  <strong>Erreur!</strong> <?php echo ERROR_REGISTRATION; ?>
			</div>
		<?php }
	?>
        </div><!-- /card-container -->
    </div><!-- /container -->
