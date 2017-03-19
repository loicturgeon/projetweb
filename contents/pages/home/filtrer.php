<?php
  // TRÈS IMPORTANT, SINON LE JSON PASSE EN PLAIN TEXT
  header('Content-Type: application/json');
?>

<?php
  if(isset($_POST['categorie']) || isset($_POST['filtre'])){
    $categorie = $_POST['categorie'];
    $condition = "";

    if($categorie > 0){
      $condition = "WHERE p.titre LIKE '%" . $_POST['filtre'] . "%' AND p.fk_categorieid = " . $categorie;
    }else{
      $condition = "WHERE p.titre LIKE '%" . $_POST['filtre'] . "%'";
    }

    $pdo = new PDO(CONNECTIONSTRING, USER, PASSWORD);
    $query = "SELECT p.id as id, p.titre as titre, p.prix as prix, c.titre as titrecat, p.description as descr FROM produit p INNER JOIN categorie c ON p.fk_categorieid = c.id " . $condition . " ORDER BY p.titre";
    $statement = $pdo->prepare($query);
    $statement->execute();

    $resultats=$statement->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($resultats, JSON_FORCE_OBJECT);

    echo $json;

	}else{
    echo "Échec! Il manque des infos pour la filtration.";
  }
?>
