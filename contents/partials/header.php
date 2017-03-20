<!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php?page=home">Le Gros de L'Info</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
		  <ul class="nav navbar-nav">
            <li><a href="index.php?page=entreprise">À propos</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
			<?php 
				if(isset($_COOKIE['USER_EQUIPE6H17'])){
					?>
							<p class="navbar-text">Bonjour <?php echo $_COOKIE['USER_EQUIPE6H17']; ?></p>
					<?php
				}
			?>
            <li><a href="index.php?page=gerer&context=panier"><span class="glyphicon glyphicon-shopping-cart aria-hidden="true" style="margin-right: 10px;"></span>Panier</a></li>
			<?php
				if(!isset($_SESSION['id'])){
					?>

						<li><a href="index.php?page=login&context=account"><span class="glyphicon glyphicon-log-in aria-hidden="true" style="margin-right: 10px;"></span>Se connecter</a></li>
					<?php
				} else {
					if(Auth::Admin()){
						?>
							<li class="dropdown">
							  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-flash aria-hidden="true" style="margin-right: 10px;"></span>Administration<span class="caret"></span></a>
							  <ul class="dropdown-menu">
								<li><a href="index.php?context=admin_produit&page=gerer"><span class="glyphicon glyphicon-cog aria-hidden="true" style="margin-right: 10px;"></span>Gérer les produits</a></li>
								<li><a href="index.php?context=admin_categorie&page=gerer"><span class="glyphicon glyphicon-cog aria-hidden="true" style="margin-right: 10px;"></span>Gérer les catégories</a></li>
								<li><a href="index.php?context=admin_user&page=gerer"><span class="glyphicon glyphicon-cog aria-hidden="true" style="margin-right: 10px;"></span>Gérer les utilisateurs</a></li>
							  </ul>
							</li>
						<?php
					}
					?>
					<li class="dropdown">
						  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user aria-hidden="true" style="margin-right: 10px;"></span><?php echo $_SESSION['usager']; ?><span class="caret"></span></a>
						  <ul class="dropdown-menu">
							<li><a href="index.php?context=utilisateur&page=modifier"><span class="glyphicon glyphicon-cog aria-hidden="true" style="margin-right: 10px;"></span>Gérer</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="index.php?page=logout&context=account"><span class="glyphicon glyphicon-log-out aria-hidden="true" style="margin-right: 10px;"></span>Se déconnecter</a></li>
						  </ul>
						</li>

					<?php
				}
			?>

          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
