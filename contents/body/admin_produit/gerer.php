
<div class="container">
	<div class="row">

		<br/>
		<h1>Gestion des produits</h1>
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
		?>
		<br/>
		<div class="col-md-10 col-md-offset-1">

			<div class="panel panel-default panel-table">
				<div class="panel-heading">
					<div class="row">
						<div class="col col-xs-6">
						<h3 class="panel-title">Produits</h3>
						</div>
						<div class="col col-xs-6 text-right">
							<button data-toggle="modal" data-target="#ajouterModal" class="btn btn-primary">Ajouter un produit</button>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-bordered table-list">
					<thead>
						<tr>
							<th>Gestion</th>
							<th>Titre</th>
							<th>Prix</th>
							<th>Catégorie</th>
							<th>Description</th>
						</tr> 
					</thead>
					<tbody>
						<?php
							$pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
							$query = "SELECT p.id as id, p.titre as titre, p.prix as prix, c.titre as titrecat, p.description as descr FROM produit p INNER JOIN categorie c ON p.fk_categorieid = c.id ORDER BY p.titre";
							$statement = $pdo->prepare($query);
							$statement->execute();
							while($row = $statement->fetch(PDO::FETCH_ASSOC)){
								?>
									<tr>
										<td align="center">
										  <a href="index.php?context=admin_produit&page=modifier&id_produit=<?php echo $row['id']; ?>" class="btn btn-default"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
										  <a href="index.php?context=admin_produit&page=supprimer&id_produit=<?php echo $row['id']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
										</td>
										<td><?php echo $row['titre']; ?></td>
										<td><?php echo $row['prix']; ?></td>
										<td><?php echo $row['titrecat']; ?></td>
										<td><?php echo $row['descr']; ?></td>
									</tr>
								<?php
							}
						?>
						
					</tbody>
				</table>

				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col col-xs-4">Page 1 of 5
						</div>
						<div class="col col-xs-8">
							<ul class="pagination hidden-xs pull-right">
								<li><a href="#">1</a></li>
								<li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
								<li><a href="#">4</a></li>
								<li><a href="#">5</a></li>
							</ul>
							<ul class="pagination visible-xs pull-right">
								<li><a href="#">«</a></li>
								<li><a href="#">»</a></li>
							</ul>
						</div>
					</div>
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
			<h3 class="modal-title" id="lineModalLabel">Ajouter un produit</h3>
		</div>
		<div class="modal-body">
			
            <!-- content goes here -->
			<form action="index.php?context=admin_produit&page=ajouter" method="post">
              <div class="form-group">
                <label for="TitreInput">Titre</label>
                <input name="titre" type="text" class="form-control" id="TitreInput" placeholder="Titre de votre produit" />
              </div>
			  <div class="form-group">
                <label for="PrixInput">Prix</label>
                <input name="prix" type="text" class="form-control" id="PrixInput" placeholder="Prix de votre produit" />
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Catégorie</label>
                <select name="categorie" class="form-control">
					<?php
						$pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
						$query = "SELECT id,titre FROM categorie";
						$statement = $pdo->prepare($query);
						$statement->execute();
						while($row = $statement->fetch(PDO::FETCH_ASSOC)){
							?>
								<option value="<?php echo $row['id']; ?>"><?php echo $row['titre']; ?></option>
							<?php
						}
					?>
				</select>
              </div>
			  <div class="form-group">
                <label for="PrixInput">Description</label>
                <textarea name="description" type="text" class="form-control" id="PrixInput" placeholder=""></textarea>
              </div>
              <div class="form-group">
                <label for="exampleInputFile">Image</label>
                <input type="file" id="exampleInputFile">
                <p class="help-block">Ajouter une image de votre produit.</p>
              </div>
			  <input type="hidden" name="form_ajout_produit_admin">
              <input type="submit" class="btn btn-default" value="Envoyer"/>
            </form>

		</div>
	</div>
  </div>
</div>