<?php
	try{
	$pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
	$query = "SELECT p.id as id, p.titre as titre, p.description as descr, p.prix as prix, c.id as idcat FROM produit p INNER JOIN categorie c ON p.fk_categorieid = c.id WHERE p.id=? LIMIT 1";
	$statement = $pdo->prepare($query);
	$statement->execute(array($_GET['id_produit']));
	if($statement->rowCount() === 0){
		header("Location: index.php?context=admin_produit&page=gerer");
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
                <div class="panel-title">Modifier le produit</div>
            </div>  
            <div class="panel-body" >
                    <form  class="form-horizontal" method="post" action="index.php?page=modifier&context=admin_produit" enctype="multipart/form-data">
                        
                        <div class="form-group required row">
                            <label class="control-label col-md-4 requiredField">Titre<span class="asteriskField">*</span> </label>
                            <div class="controls col-md-8 ">
                                <input class="input-md  textinput textInput form-control" name="titre" placeholder="Titre du produit" style="margin-bottom: 10px" type="text" required value="<?php echo $row['titre']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group required row">
                            <label class="control-label col-md-4  requiredField">Prix<span class="asteriskField">*</span> </label>
                            <div class="controls col-md-8 ">
								<input class="input-md  textinput textInput form-control" name="prix" placeholder="Prix du produit" style="margin-bottom: 10px" type="text" required value="<?php echo $row['prix']; ?>"/>
                            </div>     
                        </div>
						<div class="form-group required row">
                            <label class="control-label col-md-4  requiredField">Catégorie<span class="asteriskField">*</span> </label>
                            <div class="controls col-md-8 ">
								<select name="categorie" class="form-control">
									<?php
										$pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
										$query = "SELECT id,titre FROM categorie";
										$statement = $pdo->prepare($query);
										$statement->execute();
										while($row2 = $statement->fetch(PDO::FETCH_ASSOC)){
											?>
												<option <?php if($row2['id'] === $row['idcat']) { echo "selected=\"selected\""; } ?> value="<?php echo $row2['id']; ?>"><?php echo $row2['titre']; ?></option>
											<?php
										}
									?>
								</select>
                            </div>     
                        </div>
						<div class="form-group required row">
                            <label class="control-label col-md-4  requiredField">Description<span class="asteriskField">*</span> </label>
                            <div class="controls col-md-8 ">
								<textarea class="input-md textinput textInput form-control" name="description" style="margin-bottom: 10px" required><?php echo $row['descr']; ?></textarea>
                            </div>     
                        </div>
						<div class="form-group required row">
                            <label class="control-label col-md-4  requiredField">Image<span class="asteriskField">*</span> </label>
                            <div class="controls col-md-8 ">
								<input type="file" name="image" />
                            </div>     
                        </div>

                        <div class="form-group row"> 
                            <div class="aab controls col-md-4 "></div>
                            <div class="controls col-md-8 ">
                                <input type="submit" value="Enregistrer" class="btn btn-primary btn btn-info" />
                            </div>
                        </div>
                        <input type="hidden" name="id_produit" value="<?php echo $_GET['id_produit']; ?>" />
						<input type="hidden" name="form_modifier_admin_produit" />
                    </form>
            </div>
        </div>
    </div> 
</div>