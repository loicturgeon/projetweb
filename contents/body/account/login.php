<div class="container">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" method="post" action="index.php?context=account&page=login">
                <span id="reauth-email" class="reauth-email"></span>
				
                <input name="user" type="text" id="inputEmail" class="form-control" placeholder="Utilisateur" required autofocus>
                <input name="mdp" type="password" id="inputPassword" class="form-control" placeholder="Mot de passe" required>
                
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Se connecter</button>
				<input type="hidden" name="login_form" value=""/>
            </form><!-- /form -->
            <a href="index.php?page=register&context=account" class="forgot-password">
                Se créer un compte
            </a>
			<?php
				if(defined("ERROR_LOGIN")){
					?>
					<br/>
					<div class="alert alert-danger">
						<strong>Erreur!</strong> <?php echo ERROR_LOGIN; ?>.
					</div>
					<?php
				}
			?>
			<?php
				if(defined("REGISTER_SUCCESS")){
					?>
					<br/>
					<div class="alert alert-success">
					  <strong>Succès</strong> <?php echo REGISTER_SUCCESS; ?>.
					</div>
					<?php
				}
			?>
        </div><!-- /card-container -->
    </div><!-- /container -->
