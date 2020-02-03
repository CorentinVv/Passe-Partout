<?php
	require('../connexion/securite.php');
	if ($_SESSION['user']['cat_user'] != 2) {
		header('Location: ../');
		exit();
	}
	
	include("../lang/traduction.php");
?>
<!DOCTYPE html>
<!-- Corentin Vuillaume Nancy -->
<html>
<head>
	<meta name="viewport" content="user-scalable=no">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link rel="icon" type="image/png" href="/pamina/img/favicon.png" />
	<title>Passe Partout</title>
	<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
	<!-- <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' rel='stylesheet' type='text/css'> -->
	<style type="text/css">
		/*.panel-body {
			background-color: #f4f4f4;
		}*/
	</style>
		
</head>
<body>
	<div>
		<a href="gestionDefi.php" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <?php echo $translation['retour'][$lang]; ?></a>
	</div>
	<div class="container">
		<h1><?php echo $translation['moderationDefi'][$lang]; ?></h1>
		<hr>
		<div id="listDefiMod">
			<table class="table table-hover">
				<thead><tr><th>ID</th><th><?php echo $translation['titre'][$lang]; ?></th><th><?php echo $translation['groupe'][$lang]; ?></th><th><?php echo $translation['date'][$lang]; ?></th></tr></thead>
				<tbody id="resBody"></tbody>
			</table>
		</div>
		<div style="display: none;" id="detailDefiMod">
			<h3><?php echo $translation['detailDuDefi'][$lang]; ?><span class="idMod"></span></h3>

			<!-- CHAMPS DE BASE COMMUN -->
			<div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['type_defi'][$lang]; ?> : <span class="typeMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body">ID : <span class="idMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body">ED : <span class="edMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['langue_defi'][$lang]; ?> : <span class="langMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['region'][$lang]; ?> : <span class="regionMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['lieu'][$lang]; ?> : <span class="lieuMod"></span></div>
				</div>
			</div>

			<!-- QCM -->
			<div class="hide" id="qcmMod">
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['image_illustration2'][$lang]; ?> : <img height="300px" class="imageMod"></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['proprietaire_image_illustration_defi2'][$lang]; ?> : <span class="imgPropMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body">Copyright : <span class="imgCrMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['titre'][$lang]; ?> : <span class="titreMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['question'][$lang]; ?> : <span class="questMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body reponseQcm"><?php echo $translation['reponse'][$lang]; ?> 1 : <span class="rep1Mod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body reponseQcm"><?php echo $translation['reponse'][$lang]; ?> 2 : <span class="rep2Mod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body reponseQcm"><?php echo $translation['reponse'][$lang]; ?> 3 : <span class="rep3Mod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body reponseQcm"><?php echo $translation['reponse'][$lang]; ?> 4 : <span class="rep4Mod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body reponseQcm"><?php echo $translation['reponse'][$lang]; ?> 5 : <span class="rep5Mod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['numero_reponse_correcte'][$lang]; ?> : <span class="repJusteMod"></span></div>
				</div>
			</div>
			<!-- TEXTE TROU -->
			<div class="hide" id="txtTrouMod">
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['titre'][$lang]; ?> : <span class="titreMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['question'][$lang]; ?> : <span class="questMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['texte_a_trou'][$lang]; ?> : <span class="texteTrouMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['mot'][$lang]; ?> 1 : <span class="mot1Mod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['mot'][$lang]; ?> 2 : <span class="mot2Mod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['mot'][$lang]; ?> 3 : <span class="mot3Mod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['mot'][$lang]; ?> 4 : <span class="mot4Mod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['mot'][$lang]; ?> 5 : <span class="mot5Mod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['mot'][$lang]; ?> 6 : <span class="mot6Mod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['mot'][$lang]; ?> 7 : <span class="mot7Mod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['mot'][$lang]; ?> 8 : <span class="mot8Mod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['mot'][$lang]; ?> 9 : <span class="mot9Mod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['mot'][$lang]; ?> 10 : <span class="mot10Mod"></span></div>
				</div>
			</div>
			<!-- VOCAL -->
			<div class="hide" id="vocalTxtMod">
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['titre'][$lang]; ?> : <span class="titreMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['question'][$lang]; ?> : <span class="questMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body alert-success"><?php echo $translation['reponse'][$lang]; ?> : <span class="reponseMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['mots_cles'][$lang]; ?> : <span class="keywordMod"></span></div>
				</div>
			</div>
			<!-- FRISE -->
			<div class="hide" id="friseMod">
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['titre_frise'][$lang]; ?> : <span class="titreMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['date_debut_frise'][$lang]; ?> : <span class="dateDebMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['date_fin_frise'][$lang]; ?> : <span class="dateFinMod"></span></div>
				</div>

				<div class="panel panel-default">
					<div class="panel-body"><?php echo $translation['date_evenement2'][$lang]; ?> 1 : <span class="dv1Mod"></span></div>
					<div class="panel-body"><?php echo $translation['nom_evenement2'][$lang]; ?> 1 : <span class="tv1Mod"></span></div>
					<div class="panel-body"><?php echo $translation['vignette_evenement2'][$lang]; ?> 1 : <img height="300px" class="iv1Mod"></div>
					<div class="panel-body"><?php echo $translation['proprietaire_image2'][$lang]; ?> 1 : <span class="piv1Mod"></span></div>
					<div class="panel-body">Copyright 1 : <span class="civ1Mod"></span></div>
				</div>

				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['date_evenement2'][$lang]; ?> 2 : <span class="dv2Mod"></span></div>
				  <div class="panel-body"><?php echo $translation['nom_evenement2'][$lang]; ?> 2 : <span class="tv2Mod"></span></div>
				  <div class="panel-body"><?php echo $translation['vignette_evenement2'][$lang]; ?> 2 : <img height="300px" class="iv2Mod"></div>
				  <div class="panel-body"><?php echo $translation['proprietaire_image2'][$lang]; ?> 2 : <span class="piv2Mod"></span></div>
				  <div class="panel-body">Copyright 2 : <span class="civ2Mod"></span></div>
				</div>

				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['date_evenement2'][$lang]; ?> 3 : <span class="dv3Mod"></span></div>
				  <div class="panel-body"><?php echo $translation['nom_evenement2'][$lang]; ?> 3 : <span class="tv3Mod"></span></div>
				  <div class="panel-body"><?php echo $translation['vignette_evenement2'][$lang]; ?> 3 : <img height="300px" class="iv3Mod"></div>
				  <div class="panel-body"><?php echo $translation['proprietaire_image2'][$lang]; ?> 3 : <span class="piv3Mod"></span></div>
				  <div class="panel-body">Copyright 3 : <span class="civ3Mod"></span></div>
				</div>

				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['date_evenement2'][$lang]; ?> 4 : <span class="dv4Mod"></span></div>
				  <div class="panel-body"><?php echo $translation['nom_evenement2'][$lang]; ?> 4 : <span class="tv4Mod"></span></div>
				  <div class="panel-body"><?php echo $translation['vignette_evenement2'][$lang]; ?> 4 : <img height="300px" class="iv4Mod"></div>
				  <div class="panel-body"><?php echo $translation['proprietaire_image2'][$lang]; ?> 4 : <span class="piv4Mod"></span></div>
				  <div class="panel-body">Copyright 4 : <span class="civ4Mod"></span></div>
				</div>

				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['date_evenement2'][$lang]; ?> 5 : <span class="dv5Mod"></span></div>
				  <div class="panel-body"><?php echo $translation['nom_evenement2'][$lang]; ?> 5 : <span class="tv5Mod"></span></div>
				  <div class="panel-body"><?php echo $translation['vignette_evenement2'][$lang]; ?> 5 : <img height="300px" class="iv5Mod"></div>
				  <div class="panel-body"><?php echo $translation['proprietaire_image2'][$lang]; ?> 5 : <span class="piv5Mod"></span></div>
				  <div class="panel-body">Copyright 5 : <span class="civ5Mod"></span></div>
				</div>

				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['date_evenement2'][$lang]; ?> 6 : <span class="dv6Mod"></span></div>
				  <div class="panel-body"><?php echo $translation['nom_evenement2'][$lang]; ?> 6 : <span class="tv6Mod"></span></div>
				  <div class="panel-body"><?php echo $translation['vignette_evenement2'][$lang]; ?> 6 : <img height="300px" class="iv6Mod"></div>
				  <div class="panel-body"><?php echo $translation['proprietaire_image2'][$lang]; ?> 6 : <span class="piv6Mod"></span></div>
				  <div class="panel-body">Copyright 6 : <span class="civ6Mod"></span></div>
				</div>
			</div>
			<!-- CLASSEMENT -->
			<div class="hide" id="classementMod">
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['titre'][$lang]; ?> : <span class="titreMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['question'][$lang]; ?> : <span class="questMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['nombre_de_categorie'][$lang]; ?> : <span class="nbValMod"></span></div>
				</div>

				<div id="allNameValise">
					
				</div>

				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['type_etiquette2'][$lang]; ?> : <span class="typeEtiqMod"></span></div>
				</div>

				<div id="allEtiquettes">
					
				</div>
			</div>
			<!-- CHAMPS D'AIDE AU DÉFI -->
			<div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['texte_aide_defi2'][$lang]; ?> : <span class="helpTxtMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['image_aide_defi2'][$lang]; ?> : <img height="300px" class="helpImgMod"></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['video_aide_defi2'][$lang]; ?> : <video style="vertical-align: middle !important;" height="300px" controls class="helpVideoMod"></video></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['audio_aide_defi2'][$lang]; ?> : <audio style="vertical-align: middle !important;" controls class="helpAudioMod"></audio></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['categorie'][$lang]; ?> 1 : <span class="cat1Mod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['categorie'][$lang]; ?> 2 : <span class="cat2Mod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['date_de_creation'][$lang]; ?> : <span class="dateDefiMod"></span></div>
				</div>
				<!-- <div class="panel panel-default">
				  <div class="panel-body">Créateur id : <span class="createurMod"></span></div>
				</div> -->
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['adresse_ou_nom_exacte_du_lieu'][$lang]; ?> : <span class="adresseMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['prop_image_aide_defi2'][$lang]; ?> : <span class="imgHelpMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body">Copyright : <span class="imgHelpCrMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['prop_video_aide_defi2'][$lang]; ?> : <span class="videoHelpMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body">Copyright : <span class="videoHelpCrMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body"><?php echo $translation['prop_audio_defi2'][$lang]; ?> : <span class="audioHelpMod"></span></div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body">Copyright : <span class="audioHelpCrMod"></span></div>
				</div>
			</div>
			<!-- ***************************************** -->
			<div>
				<div>
					<div id="alertDefiGood" style="display: none;" class="alert alert-success">
						<?php echo $translation['defi_bien_publie'][$lang]; ?>
					</div>
					<div id="alertDefiBad" style="display: none;" class="alert alert-success">
						<?php echo $translation['defi_est_a_revoir'][$lang]; ?>
					</div>
					<div id="alertErreur" style="display: none;" class="alert alert-danger">
						<?php echo $translation['erreur'][$lang]; ?> !
					</div>
				</div>
				<div style="padding-left: 0;" class="col-xs-6">
					<button style="font-size: 1.2em;" id="validateDefi" class="col-xs-12 btn btn-success"><?php echo $translation['publierLeDefi'][$lang]; ?></button>
				</div>
				<div style="padding-right: 0;" class="col-xs-6">
					<button style="font-size: 1.2em;" id="btnRevoirDefi" class="col-xs-12 btn btn-danger"><?php echo $translation['aRevoir'][$lang]; ?></button>
				</div>
				<br><br><br>
				<div style="display: none;" id="toggleRemarqueDefi">
					<form onsubmit="return false;">
						<label><?php echo $translation['remarque'][$lang]; ?> :</label>
						<textarea id="txtRemarqueDefi" required class="form-control" rows="4"></textarea>
						<br>
						<button type="submit" id="sendRemarqueDefi" class="col-xs-12 col-sm-3 btn btn-primary"><?php echo $translation['envoyer'][$lang]; ?></button>
					</form>
				</div>
			</div>
			<br><br><br><br>
		</div>
	</div>
</body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript">

		// Langue
		var lang = <?php echo json_encode($_SESSION['user']['langue']);?>;
		// Tableau équivalence des catégories
		var tabCat = {
			"c1" : {
				"FR" : "Science et technologie",
				"DE" : "Natur und Technik"
			},
			"c1i1" : {
				"FR" : "Nature",
				"DE" : "Natur"
			},
			"c1i2" : {
				"FR" : "Energie",
				"DE" : "Energie"
			},
			"c1i3" : {
				"FR" : "Matières et objets techniques",
				"DE" : "Materialien und Eigenschaften"
			},
			"c2" : {
				"FR" : "Histoire et Géographie",
				"DE" : "Raum und Zeit"
			},
			"c2i1" : {
				"FR" : "Vivre dans l'espace du Rhin supérieur",
				"DE" : "Gemeinsam leben am Oberrhein"
			},
			"c2i2" : {
				"FR" : "Se déplacer",
				"DE" : "Mobilität und Verkehr"
			},
			"c2i3" : {
				"FR" : "Caractériser le lieu de vie",
				"DE" : "Orientierung im Raum"
			},
			"c2i4" : {
				"FR" : "Passé, présent, avenir",
				"DE" : "Vergangenheit, Gegenwart, Zukunft"
			},
			"c3" : {
				"FR" : "Arts et culture",
				"DE" : "Kunst und Kultur"
			},
			"c3i1" : {
				"FR" : "Arts visuels",
				"DE" : "Kunst"
			},
			"c3i2" : {
				"FR" : "Musique",
				"DE" : "Musik"
			},
			"c3i3" : {
				"FR" : "Littérature",
				"DE" : "Literatur"
			},
			"c3i4" : {
				"FR" : "Culture et interculturalité",
				"DE" : "kulturelle Kompetenz"
			},
			"c4" : {
				"FR" : "Sports et loisirs",
				"DE" : "Sport und Freizeit"
			}
		};
		// Tableau équivalence des copyrights
		var tabCR = {
			"cr1" : "CC 0 - public domain",
			"cr2" : "CC BY",
			"cr3" : "CC BY SA",
			"cr4" : "CC BY SA ND",
			"cr5" : "CC BY SA NC",
		};
		
		// Affiche une fiche détaillée pour le professeur
		function showDetail(defiMod) {
console.log(defiMod);
			// ************************************************
			// ************************************************
			// ************************************************
			$('.typeMod').html(defiMod.type);
			$('.idMod').html(defiMod.id);
			$('.edMod').html(defiMod.ed);
			$('.langMod').html(defiMod.langue_defi);
			$('.regionMod').html(defiMod.region);
			$('.lieuMod').html(defiMod.lieu);
			// ************************************************
			// ************************************************
			// ************************************************

			// Type du défi
			var defiType = defiMod.type;

			switch(defiType) {
				case 'qcm' :
					$('#qcmMod').removeClass('hide');
					$('.imageMod').attr("src", "../uploadDefi/defi/"+defiMod.image);
					$('.titreMod').html(defiMod.titre_question);
					$('.questMod').html(defiMod.question);
					$('.rep1Mod').html(defiMod.reponse1);
					$('.rep2Mod').html(defiMod.reponse2);
					$('.rep3Mod').html(defiMod.reponse3);
					$('.rep4Mod').html(defiMod.reponse4);
					$('.rep5Mod').html(defiMod.reponse5);
					$('.repJusteMod').html(defiMod.nb_reponse_juste);

					// image principale
					$('.imgPropMod').html(defiMod.imgQcmOwner);
					// equivalence des valeurs copyright image principale
					$('.imgCrMod').html(tabCR[defiMod.imgQcmCR]);

					// Affiche la bonne réponse en vert
					var repTmp = $('.reponseQcm')[defiMod.nb_reponse_juste-1];
					$(repTmp).addClass('alert-success');
					// Aide au défi 
					// Test si il y a bien un fichier
					if ((defiMod.helpImg != '') && (defiMod.helpImg != null)) {
						$('.helpImgMod').attr("src", "../uploadDefi/aide/img/"+defiMod.helpImg);
					}else{
						$('.helpImgMod').hide();
						$('.helpImgMod').parent().parent().hide();
					}
					if ((defiMod.helpVideo != '') && (defiMod.helpVideo != null)) {
						$('.helpVideoMod').attr("src", "../uploadDefi/aide/video/"+defiMod.helpVideo);
					}else{
						$('.helpVideoMod').hide();
						$('.helpVideoMod').parent().parent().hide();
					}
					if ((defiMod.helpAudio != '') && (defiMod.helpAudio != null)) {
						$('.helpAudioMod').attr("src", "../uploadDefi/aide/son/"+defiMod.helpAudio);
					}else{
						$('.helpAudioMod').hide();
						$('.helpAudioMod').parent().parent().hide();
					}
					break;
				case 'vocal' :
					$('#vocalTxtMod').removeClass('hide');
					$('.titreMod').html(defiMod.titre_question);
					$('.questMod').html(defiMod.question);
					$('.reponseMod').html(defiMod.reponse);
					$('.keywordMod').html(defiMod.mot_cles);
					// Aide au défi 
					// Test si il y a bien un fichier
					if ((defiMod.helpImg != '') && (defiMod.helpImg != null)) {
						$('.helpImgMod').attr("src", "../uploadDefi/aide/img/"+defiMod.helpImg);
					}else{
						$('.helpImgMod').hide();
						$('.helpImgMod').parent().parent().hide();
					}
					if ((defiMod.helpVideo != '') && (defiMod.helpVideo != null)) {
						$('.helpVideoMod').attr("src", "../uploadDefi/aide/video/"+defiMod.helpVideo);
					}else{
						$('.helpVideoMod').hide();
						$('.helpVideoMod').parent().parent().hide();
					}
					if ((defiMod.helpAudio != '') && (defiMod.helpAudio != null)) {
						$('.helpAudioMod').attr("src", "../uploadDefi/aide/son/"+defiMod.helpAudio);
					}else{
						$('.helpAudioMod').hide();
						$('.helpAudioMod').parent().parent().hide();
					}
					break;
				case 'trou' :
					$('#txtTrouMod').removeClass('hide');
					$('.titreMod').html(defiMod.titre_question);
					$('.questMod').html(defiMod.question);
					$('.texteTrouMod').html(defiMod.texteAtrou);
					$('.mot1Mod').html(defiMod.mot1);
					$('.mot2Mod').html(defiMod.mot2);
					$('.mot3Mod').html(defiMod.mot3);
					$('.mot4Mod').html(defiMod.mot4);
					$('.mot5Mod').html(defiMod.mot5);
					$('.mot6Mod').html(defiMod.mot6);
					$('.mot7Mod').html(defiMod.mot7);
					$('.mot8Mod').html(defiMod.mot8);
					$('.mot9Mod').html(defiMod.mot9);
					$('.mot10Mod').html(defiMod.mot10);
					if (defiMod.mot4 == null) {
						$('.mot4Mod').parent().parent().hide();
					}
					if (defiMod.mot5 == null) {
						$('.mot5Mod').parent().parent().hide();
					}
					if (defiMod.mot6 == null) {
						$('.mot6Mod').parent().parent().hide();
					}
					if (defiMod.mot7 == null) {
						$('.mot7Mod').parent().parent().hide();
					}
					if (defiMod.mot8 == null) {
						$('.mot8Mod').parent().parent().hide();
					}
					if (defiMod.mot9 == null) {
						$('.mot9Mod').parent().parent().hide();
					}
					if (defiMod.mot10 == null) {
						$('.mot10Mod').parent().parent().hide();
					}
					if ((defiMod.helpImg != '') && (defiMod.helpImg != null)) {
						$('.helpImgMod').attr("src", "../uploadDefi/TexteTrou/aide/img/"+defiMod.helpImg);
					}else{
						$('.helpImgMod').hide();
						$('.helpImgMod').parent().parent().hide();
					}
					if ((defiMod.helpVideo != '') && (defiMod.helpVideo != null)) {
						$('.helpVideoMod').attr("src", "../uploadDefi/TexteTrou/aide/video/"+defiMod.helpVideo);
					}else{
						$('.helpVideoMod').hide();
						$('.helpVideoMod').parent().parent().hide();
					}
					if ((defiMod.helpAudio != '') && (defiMod.helpAudio != null)) {
						$('.helpAudioMod').attr("src", "../uploadDefi/TexteTrou/aide/son/"+defiMod.helpAudio);
					}else{
						$('.helpAudioMod').hide();
						$('.helpAudioMod').parent().parent().hide();
					}
					break;
				case 'frise' :
					$('#friseMod').removeClass('hide');
					$('.titreMod').html(defiMod.titre_frise);
					$('.dateDebMod').html(defiMod.date_debut);
					$('.dateFinMod').html(defiMod.date_fin);
					// Vignettes
					$('.dv1Mod').html(defiMod.item1_date);
					$('.tv1Mod').html(defiMod.item1_title);
					$('.iv1Mod').attr("src", "../uploadDefi/FriseChrono/"+defiMod.item1_img);
					$('.piv1Mod').html(defiMod.item1Owner);
					$('.civ1Mod').html(defiMod.item1CR);

					$('.dv2Mod').html(defiMod.item2_date);
					$('.tv2Mod').html(defiMod.item2_title);
					$('.iv2Mod').attr("src", "../uploadDefi/FriseChrono/"+defiMod.item2_img);
					$('.piv2Mod').html(defiMod.item2Owner);
					$('.civ2Mod').html(defiMod.item2CR);

					$('.dv3Mod').html(defiMod.item3_date);
					$('.tv3Mod').html(defiMod.item3_title);
					$('.iv3Mod').attr("src", "../uploadDefi/FriseChrono/"+defiMod.item3_img);
					$('.piv3Mod').html(defiMod.item3Owner);
					$('.civ3Mod').html(defiMod.item3CR);

					$('.dv4Mod').html(defiMod.item4_date);
					$('.tv4Mod').html(defiMod.item4_title);
					$('.iv4Mod').attr("src", "../uploadDefi/FriseChrono/"+defiMod.item4_img);
					$('.piv4Mod').html(defiMod.item4Owner);
					$('.civ4Mod').html(defiMod.item4CR);

					$('.dv5Mod').html(defiMod.item5_date);
					$('.tv5Mod').html(defiMod.item5_title);
					$('.iv5Mod').attr("src", "../uploadDefi/FriseChrono/"+defiMod.item5_img);
					$('.piv5Mod').html(defiMod.item5Owner);
					$('.civ5Mod').html(defiMod.item5CR);

					$('.dv6Mod').html(defiMod.item6_date);
					$('.tv6Mod').html(defiMod.item6_title);
					$('.iv6Mod').attr("src", "../uploadDefi/FriseChrono/"+defiMod.item6_img);
					$('.piv6Mod').html(defiMod.item6Owner);
					$('.civ6Mod').html(defiMod.item6CR);

					// Aide au défi 
					// Test si il y a bien un fichier
					if ((defiMod.helpImg != '') && (defiMod.helpImg != null)) {
						$('.helpImgMod').attr("src", "../uploadDefi/FriseChrono/aide/img/"+defiMod.helpImg);
					}else{
						$('.helpImgMod').hide();
						$('.helpImgMod').parent().parent().hide();
					}
					if ((defiMod.helpVideo != '') && (defiMod.helpVideo != null)) {
						$('.helpVideoMod').attr("src", "../uploadDefi/FriseChrono/aide/video/"+defiMod.helpVideo);
					}else{
						$('.helpVideoMod').hide();
						$('.helpVideoMod').parent().parent().hide();
					}
					if ((defiMod.helpAudio != '') && (defiMod.helpAudio != null)) {
						$('.helpAudioMod').attr("src", "../uploadDefi/FriseChrono/aide/son/"+defiMod.helpAudio);
					}else{
						$('.helpAudioMod').hide();
						$('.helpAudioMod').parent().parent().hide();
					}
					
					break;
				case 'classement' :
					$('#classementMod').removeClass('hide');
					$('.titreMod').html(defiMod.titre_question);
					$('.questMod').html(defiMod.question);

					// Nombre de valises
					$('.nbValMod').html(defiMod.nbValisette);
					for (var i = 1; i <= defiMod.nbValisette; i++) {
						$('#allNameValise').append('<div class="panel panel-default"><div class="panel-body">Nom de la valise '+i+' : <span class="nameValMod">'+defiMod['nom_valise_'+i]+'</span></div></div>');
					}

					// Type des étiquettes
					var typeEtiquetteClassement = "";
					switch(defiMod.type_etiquette) {
						case 1 :
							// Mot
							typeEtiquetteClassement = "Mot";
							break;
						case 2 :
							// Groupe de mots
							typeEtiquetteClassement = "Groupe de mots";
							break;
						case 3 :
							// Image
							typeEtiquetteClassement = "Image";
							break;
					}
					$('.typeEtiqMod').html(typeEtiquetteClassement);

					// Génération du code pour toutes les étiquettes
					for (var i = 1; i <= defiMod.nbValisette; i++) {
						for (var j = 1; j <= 5; j++) {
							if (defiMod.typeEtiquette != 3) {
								$('#allEtiquettes').append('<div class="panel panel-default"><div class="panel-body">Étiquette '+i+'_'+j+' : <span class="valueEtiqMod">'+defiMod['valise_'+i+'_etiquette_'+j]+'</span></div></div>');
							}else{
								// étiquette de type image
								$('#allEtiquettes').append('<div class="panel panel-default"><div class="panel-body">Étiquette '+i+'_'+j+' : <img height="300px" class="imageEtiqMod" src="../uploadDefi/Classement/'+defiMod['valise_'+i+'_etiquette_'+j]+'"></div></div>');
							}
						}
					}

					// Aide au défi 
					// Test si il y a bien un fichier
					if ((defiMod.helpImg != '') && (defiMod.helpImg != null)) {
						$('.helpImgMod').attr("src", "../uploadDefi/Classement/aide/img/"+defiMod.helpImg);
					}else{
						$('.helpImgMod').hide();
						$('.helpImgMod').parent().parent().hide();
					}
					if ((defiMod.helpVideo != '') && (defiMod.helpVideo != null)) {
						$('.helpVideoMod').attr("src", "../uploadDefi/Classement/aide/video/"+defiMod.helpVideo);
					}else{
						$('.helpVideoMod').hide();
						$('.helpVideoMod').parent().parent().hide();
					}
					if ((defiMod.helpAudio != '') && (defiMod.helpAudio != null)) {
						$('.helpAudioMod').attr("src", "../uploadDefi/Classement/aide/son/"+defiMod.helpAudio);
					}else{
						$('.helpAudioMod').hide();
						$('.helpAudioMod').parent().parent().hide();
					}
					break;
			}
			
			// ************************************************
			// ************************************************
			// ************************************************
			if (defiMod.helpTxt != null) {
				$('.helpTxtMod').html(defiMod.helpTxt);
			}else{
				$('.helpTxtMod').parent().parent().hide();
			}
			// equivalence des valeurs catégorie principale
			$('.cat1Mod').html(tabCat[defiMod.cat1][lang]);
			// equivalence des valeurs catégorie secondaire
			if (defiMod.cat2 != null) {
				$('.cat2Mod').html(tabCat[defiMod.cat2][lang]);
			}else{
				$('.cat2Mod').parent().parent().hide();
			}
			$('.dateDefiMod').html(defiMod.date_defi);
			// $('.createurMod').html(defiMod.createur_id);
			if (defiMod.adresse != "") {
				$('.adresseMod').html(defiMod.adresse);
			}else{
				$('.adresseMod').parent().parent().hide();
			}
			// equivalence des valeurs copyright image aide
			if (defiMod.imgHelpOwner != null) {
				$('.imgHelpMod').html(defiMod.imgHelpOwner);
				$('.imgHelpCrMod').html(tabCR[defiMod.imgHelpCR]);
			}else{
				$('.imgHelpMod').parent().parent().hide();
				$('.imgHelpCrMod').parent().parent().hide();
			}
			// equivalence des valeurs copyright vidéo aide
			if (defiMod.videoHelpOwner != null) {
				$('.videoHelpMod').html(defiMod.videoHelpOwner);
				$('.videoHelpCrMod').html(tabCR[defiMod.videoHelpCR]);
			}else{
				$('.videoHelpMod').parent().parent().hide();
				$('.videoHelpCrMod').parent().parent().hide();
			}	
			// equivalence des valeurs copyright audio aide
			if (defiMod.audioHelpOwner != null) {
				$('.audioHelpMod').html(defiMod.audioHelpOwner);
				$('.audioHelpCrMod').html(tabCR[defiMod.audioHelpCR]);
			}else{
				$('.audioHelpMod').parent().parent().hide();
				$('.audioHelpCrMod').parent().parent().hide();
			}

			$('#listDefiMod').hide();
			$('#detailDefiMod').show();
			// ************************************************
			// ************************************************
			// ************************************************

			// Bouton valider - refuser un défi
			$('#validateDefi').click(function() {
				// On passe l'état du défi à publier
				$.ajax({
					url : "../model/publishDefi.php",
					type : "POST",
					data : {id_defi : defiMod.id, type_defi : defiMod.type, id_creator : defiMod.createur_id},
					success : function(data) {
						// Message de succès
						$('#alertDefiGood').show();
						$("#validateDefi").prop("disabled",true);
						$("#revoirDefi").prop("disabled",true);
						setTimeout(function(){ location.reload(true); }, 3000);
					},
					error : function(data) {
						// Message d'erreur
						$('#alertErreur').show();
						$("#validateDefi").prop("disabled",true);
						$("#revoirDefi").prop("disabled",true);
					}
				});
			});
			$('#btnRevoirDefi').click(function() {
				$('#toggleRemarqueDefi').toggle();
			});
			$('#sendRemarqueDefi').click(function() {
				if ($("#txtRemarqueDefi").val() != "") {
					$.ajax({
						url : "../model/aRevoirDefi.php",
						type : "POST",
						data : {id_defi : defiMod.id, type_defi : defiMod.type, msg_defi : $("#txtRemarqueDefi").val()},
						success : function(data) {
							// Message de succès
							$('#alertDefiBad').show();
							$("#validateDefi").prop("disabled",true);
							$("#revoirDefi").prop("disabled",true);
							setTimeout(function(){ location.reload(true); }, 3000);
						},
						error : function(data) {
							// Message d'erreur
							$('#alertErreur').show();
							$("#validateDefi").prop("disabled",true);
							$("#revoirDefi").prop("disabled",true);
						}
					});
				}
			});
		}

		// Récupére tous les défis à modérer et les affiches dans un tableau
		// #1 Récupérer la liste de toutes les classes du professeur
		// #2 Récupérer la liste de tous les groupes du professeur
		// #3 Récupérer la liste de tous les élèves du professeur
		// #4 Récupérer la liste de tous les défis à modérer des élèves du professeur
		function moderationTabList() {
			var user = '<?php echo json_encode($_SESSION['user']);?>';
			user = JSON.parse(user);
			var userId = parseInt(user.id);
			$.ajax({
				url : "../model/getProfModerateDefi.php",
				type : "POST",
				data : {id_prof : userId},
				success : function(data) {
					res = JSON.parse(data);
					console.log(res);
					$.each(res, function(i) {
						if (res[i].titre_frise != undefined) {
							$('#resBody').append("<tr onclick='showDetail(res["+i+"])'><td>"+res[i].id+"</td><td>"+res[i].titre_frise+"</td><td>"+res[i].nom_groupe+"</td><td>"+res[i].date_defi+"</td></tr>");
						}else{
							$('#resBody').append("<tr onclick='showDetail(res["+i+"])'><td>"+res[i].id+"</td><td>"+res[i].titre_question+"</td><td>"+res[i].nom_groupe+"</td><td>"+res[i].date_defi+"</td></tr>");
						}						
					});
					
				}
			});
		}
		moderationTabList();

	</script>
</html>