<div class="container">
	<div class="row">

		<br/>
		<h1>Gestion des utilisateurs</h1>
		<br/>
		<?php
			if(defined("ERROR_AJOUT_ADMIN")){
				?>
					<div class="alert alert-danger">
					  <strong>Erreur!</strong> <?php echo ERROR_AJOUT_ADMIN; ?>
					</div>
				<?php
			}
			if(defined("SUCCESS_AJOUT_ADMIN")){
				?>
				<div class="alert alert-success">
				  <strong>Succès!</strong> <?php echo SUCCESS_AJOUT_ADMIN; ?>
				</div>
				<?php
			}
			if(defined("ERROR_AJOUT_USER_ADMIN_MDP_DIFF")){
				?>
				<div class="alert alert-danger">
				  <strong>Erreur!</strong> <?php echo ERROR_AJOUT_USER_ADMIN_MDP_DIFF; ?>
				</div>
				<?php
			}
		?>
		<br/>
		<div class="col-md-10 col-md-offset-1">

			<div class="panel panel-default panel-table">
				<div class="panel-heading">
					<div class="row">
						<div class="col col-xs-6">
						<h3 class="panel-title">Utilisateurs</h3>
						</div>
						<div class="col col-xs-6 text-right">
							<form method="post" action="index.php?page=gerer&context=admin_user" class="search-form" style="margin-bottom:5px;">
								<div id="custom-search-input">
									<div class="input-group col-md-12">
										<input name="input_recherche" type="text" class="form-control input-xs" placeholder="Rechercher" />
										<span class="input-group-btn">
											<button class="btn btn-info btn-xs" type="submit">
												<i class="glyphicon glyphicon-search"></i>
											</button>
										</span>
									</div>
								</div>
							</form>
							<button data-toggle="modal" data-target="#ajouterModal" class="btn btn-primary">Ajouter un utilisateur</button>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-bordered table-list">
					<thead>
						<tr>
							<th>Gestion</th>
							<th>Usager</th>
							<th>Email</th>
							<th>Adresse</th>
						</tr> 
					</thead>
					<tbody>
						<?php
							$pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
							
							if(isset($_POST['input_recherche']) && !empty($_POST['input_recherche'])){
								$query = "SELECT id,usager,email,adresse FROM utilisateur WHERE id <> ? AND (usager LIKE ? OR email LIKE ?)";
								$statement = $pdo->prepare($query);;
								$statement->execute(array($_SESSION['id'],"%".$_POST['input_recherche']."%","%".$_POST['input_recherche']."%"));
							} else {
								$query = "SELECT id,usager,email,adresse FROM utilisateur WHERE id <> ?";
								$statement = $pdo->prepare($query);
								$statement->execute(array($_SESSION['id']));
							}
							
							while($row = $statement->fetch(PDO::FETCH_ASSOC)){
								?>
									<tr>
										<td align="center">
										  <a href="index.php?context=admin_user&page=modifier&id_user=<?php echo $row['id']; ?>" class="btn btn-default"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
										  <a href="index.php?context=admin_user&page=supprimer&id_user=<?php echo $row['id']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
										</td>
										<td><?php echo $row['usager']; ?></td>
										<td><?php echo $row['email']; ?></td>
										<td><?php echo $row['adresse']; ?></td>
									</tr>
								<?php
							}
						?>
						
					</tbody>
				</table>

				</div>
				<div class="panel-footer">
					
				</div>
			</div>
		</div>
	</div>
</div>

<!-- line modal -->
<div class="modal fade" id="ajouterModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Fermer</span></button>
			<h3 class="modal-title" id="lineModalLabel">Ajouter un utilisateur</h3>
		</div>
		<div class="modal-body">
			
            <!-- content goes here -->
			<form action="index.php?context=admin_user&page=ajouter" method="post">
              <div class="form-group">
                <label for="TitreInput">Usager</label>
                <input name="usager" type="text" class="form-control" placeholder="Usager (pour se connecter)" />
              </div>
			  
			  <div class="form-group">
                <label>Mot de passe</label>
                <input name="mdp" type="password" class="form-control" placeholder="Mot de passe" />
              </div>
			  <div class="form-group">
                <label>Validation du mot de passe</label>
                <input name="mdpverif" type="password" class="form-control" placeholder="Validation du mot de passe">
              </div>
			  <div class="form-group">
                <label for="TitreInput">Email</label>
                <input name="email" type="text" class="form-control" placeholder="Email" />
              </div>
              <div class="form-group">
                <label>Adresse</label>
                <input name="adresse" type="text" class="form-control" placeholder="Adresse de l'utilisateur" />
              </div>
			  <input type="hidden" name="form_ajout_user_admin">
              <input type="submit" class="btn btn-default" value="Envoyer"/>
            </form>

		</div>
	</div>
  </div>
</div>