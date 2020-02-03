<?php 

	require('../connexion/securite.php');
	include('../lang/traduction.php');
	if ($_SESSION['user']['cat_user'] != 4) {
		header('Location: https://www.mon-passepartout.eu/');
		exit();
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport">
 	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>Gestion des défis</title>
	<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
	<link href='../css/previewDefi.css' rel='stylesheet' type='text/css'>

	<style type="text/css">
		.img-preview{
			width: auto;
    		max-height: 300px;
		}

		.vign-preview{
			width: auto;
    		max-height: 150px;
		}

 		#Calque_1 > path:hover {
 			fill: yellow;
 		}

 		.cascade {
		    display: none;
		}

		#propIntellec + label {
			font-weight: 100;
		}

		#rightImg + label {
			font-weight: 100;
		}

		.getIdOwner{
			background-color: red;
		}

 	</style>
		
</head>
<body>
	<div>
		<a href="jeuAccueil.php" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <?php echo $translation['retour'][$lang]; ?></a>
	</div>
	
	<div class="container">

		<div class="page-header">
 			<h2><?php echo $translation['modifier_defi'][$lang]; ?></h2>
 		</div>
 		<?php if (isset($_SESSION['etat'])) {
			if ($_SESSION['etat']) {
				// succès
				if ($lang == "FR") {
					echo '<div class="row"><div class="alert alert-success" role="alert"><strong>Votre défi a bien été modifié. </strong></div></div>';
				}else{
					// DE
					echo '<div class="row"><div class="alert alert-success" role="alert"><strong>Die Aufgabe wurde erfolgreich bearbeitet. </strong></div></div>';
				}
			}else{
				// echec
				if ($lang == "FR") {
					echo '<div class="row"><div class="alert alert-danger" role="alert"><strong>Erreur votre défi n\'a pas été modifié ! Veuillez vérifier que les différents champs soient bien remplis!</strong></div></div>';
				}else{
					// DE
					echo '<div class="row"><div class="alert alert-success" role="alert"><strong>Fehler! Die Aufgabe wurde nicht bearbeitet. Bitte überprüfen, ob die verschiedenen Felder richtig ausgefüllt sind. </strong></div></div>';
				}
			}
		} 
		if (isset($_SESSION['deleted_Defi'])) {
			// supprimer un défi
			if ($_SESSION['deleted_Defi']) {
				// succès
				if ($lang == "FR") {
					echo '<div class="row"><div class="alert alert-success" role="alert"><strong>Votre défi a bien été supprimé. </strong></div></div>';
				}else{
					// DE
					echo '<div class="row"><div class="alert alert-success" role="alert"><strong>Die Aufgabe wurde erfolgreich gelöscht. </strong></div></div>';
				}
			}
		} ?>
 		<!-- Div affichage liste défis -->
 		<div id="divData">
	 		<!-- Boutons pour affichage des données -->
		 	<div class="btn-group btn-group-justified" role="group" aria-label="...">
			  <div class="btn-group" role="group">
			    <button id="btnQcm" type="button" class="btn btn-default btn-lg"><?php echo $translation['qcm'][$lang]; ?></button>
			  </div>
			  <div class="btn-group" role="group">
			    <button id="btnTrou" type="button" class="btn btn-default btn-lg"><?php echo $translation['texte_a_trou'][$lang]; ?></button>
			  </div>
			  <div class="btn-group" role="group">
			    <button id="btnVocal" type="button" class="btn btn-default btn-lg"><?php echo $translation['reconnaissance_vocale'][$lang]; ?></button>
			  </div>
			  <div class="btn-group" role="group">
			    <button id="btnFrise" type="button" class="btn btn-default btn-lg"><?php echo $translation['frise_chronologique'][$lang]; ?></button>
			  </div>
			  <div class="btn-group" role="group">
			    <button id="btnClassement" type="button" class="btn btn-default btn-lg"><?php echo $translation['classement_thematique'][$lang]; ?></button>
			  </div>
			</div>
			<br/>

			<!-- table du créateur du défi -->
			<div class="row">
				<div class="page-header">
		 			<h2>Informations créateur du défi</h2>
		 		</div>
		 		<div class="table-responsive">
				  <table class="table table-hover">
				   	<thead>
				      <tr>
				        <th>ID</th>
				        <th>Email</th>
				      </tr>
				    </thead>
				    <tbody id="ownerTable"></tbody>
				  </table>
				</div>
			</div>
			<!-- table des données -->
			<div id="myDefis" class="list-group"></div>
		</div>

		<!-- Div affichage modifier le défi -->
		<div id="formDefiQcm" style="display: none;">
			<div class="container">
		 		<div class="page-header">
		 			<h2><?php echo $translation['qcm'][$lang]; ?></h2>
		 		</div>
				<?php 
					include("../vue/updateQcm.php");
				?>
		 	</div>
		</div>
		<div id="formDefiTrou" style="display: none;">
			<div class="container">
		 		<div class="page-header">
		 			<h2><?php echo $translation['texte_a_trou'][$lang]; ?></h2>
		 		</div>
				<?php 
					include("../vue/updateTrou.php");
				?>
		 	</div>
		</div>
		<div id="formDefiVocal" style="display: none;">
			<div class="container">
		 		<div class="page-header">
		 			<h2><?php echo $translation['reconnaissance_vocale'][$lang]; ?></h2>
		 		</div>
				<?php 
					include("../vue/updateVocal.php");
				?>
		 	</div>
		</div>
		<div id="formDefiFrise" style="display: none;">
			<div class="container">
		 		<div class="page-header">
		 			<h2><?php echo $translation['frise_chronologique'][$lang]; ?></h2>
		 		</div>
				<?php 
					include("../vue/updateFrise.php");
				?>
		 	</div>
		</div>
		<div id="formDefiClassement" style="display: none;">
			<div class="container">
		 		<div class="page-header">
		 			<h2><?php echo $translation['classement_thematique'][$lang]; ?></h2>
		 		</div>
				<?php 
					include("../vue/updateClassement.php");
				?>
		 	</div>
		</div>

		<?php
			include("modalQCM.php");
			echo "<br>";
			include("modalVoca.php");
			echo "<br>";
			include("modalFrise.php");
			echo "<br>";
			include("modalTrou.php");
			echo "<br>";
			include("modalClassement.php");
		?>
	</div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/pamina/plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/pamina/plugin/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript">
	
	var titre = '<?php echo $translation['titre'][$lang]; ?>';
	var categorie = '<?php echo $translation['categorie'][$lang]; ?>';
	var vignette = '<?php echo $translation['vignette'][$lang]; ?>';
	var proprietaire_image = '<?php echo $translation['proprietaire_image'][$lang]; ?>';
	var lieuDefi = '<?php echo $translation['lieu'][$lang]; ?>';
	
</script>
<script src="../js/modifDefiAdmin.js"></script>
<script type="text/javascript">
	function openHelp() {
		$('.cacheAide').css('display','block');
	}
	// ferme l'aide à la réponse
	function closeHelp() {
		$('.cacheAide').css('display','none');
		// Arret des médias lorsque l'on ferme le modal d'aide au défi
		$(".mediaStop").each(function() {

		    $(this)[0].pause();

		}); 
	}
</script>
</html>