<?php
require('../connexion/securite.php');
include("../lang/traduction.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="icon" type="image/png" href="/pamina/img/favicon.png" />
	<title><?php echo $translation['gestion_classes_groupes'][$lang]; ?></title>
	<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
		
</head>
<body>
 	<div>
 		<a href="jeuAccueil.php" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <?php echo $translation['accueil'][$lang]; ?></a>
 	</div>
 		<div class="container">

			<div class="page-header">
	 			<h2><?php echo $translation['gestion_classes_groupes'][$lang]; ?></h2>
	 		</div>
	 		<!-- Div affichage liste défis -->
	 		<div id="divData">
		 		<!-- Boutons pour affichage des données -->
			 	<div class="btn-group btn-group-justified" role="group" aria-label="...">
				  <div class="btn-group" role="group">
				    <button id="btnAjoutCG" type="button" class="btn btn-default btn-lg"><?php echo $translation['ajouter_classe_groupe'][$lang]; ?></button>
				  </div>
				  <div class="btn-group" role="group">
				    <button id="btnVisuC" type="button" class="btn btn-default btn-lg"><?php echo $translation['mes_classes'][$lang]; ?></button>
				  </div>
				  <div class="btn-group" role="group">
				    <button id="btnVisuG" type="button" class="btn btn-default btn-lg"><?php echo $translation['mes_groupes'][$lang]; ?></button>
				  </div>
				</div>
				<br/>

				<!-- Affichage des classes et des groupes -->
				<div id="myClassGroup"></div>

				<!-- Modal -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title" id="myModalLabel"><?php echo $translation['supprimer_classe'][$lang]; ?></h4>
				      </div>
				      <div class="modal-body">
				        <?php echo $translation['warning_supprimer_classe'][$lang]; ?>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $translation['annuler'][$lang]; ?></button>
				        <button id="validDelete" type="button" class="btn btn-danger"><?php echo $translation['supprimer'][$lang]; ?></button>
				      </div>
				    </div>
				  </div>
				</div>

			</div>

		</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script type="text/javascript">
		var nom = '<?php echo $translation['nom'][$lang]; ?>';
		var nombre_enfants = '<?php echo $translation['nombre_enfants'][$lang]; ?>';
		var nom_groupe = '<?php echo $translation['nom_groupe'][$lang]; ?>';
		var nombre_enfants_groupe = '<?php echo $translation['nombre_enfants_groupe'][$lang]; ?>';
		var moyenne = 'Moyenne';
		var score = '<?php echo $translation['score'][$lang]; ?>';
	</script>
	<script src="../js/gestionProf.js"></script>

</body>
</html>