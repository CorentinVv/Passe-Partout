<?php

	session_start();
	include("../../connexion/logs.php");
	require_once("../../connexion/SQLconnect.php");

		// fonction pour le zip de l'aide au défi
	function updateZipFile($type,$imgAide,$videoAide,$sonAide,$lieu,$question,$aideExtImg,$aideTxt,$ID) {
		// on déplace les éléments dans le dossier download
		if ($type == 2) {
			// @typeName Nom du dossier dans download
			$typeName = "VocaTxt";
			// on récupère image/video/son
			if (is_file('../../uploadDefi/aide/img/'.$imgAide)) {
				copy('../../uploadDefi/aide/img/'.$imgAide, '../../download/'.$typeName.'/'.$imgAide);
			}
			if (is_file('../../uploadDefi/aide/video/'.$videoAide)) {
				copy('../../uploadDefi/aide/video/'.$videoAide, '../../download/'.$typeName.'/'.$videoAide);
			}
			if (is_file('../../uploadDefi/aide/son/'.$sonAide)) {
				copy('../../uploadDefi/aide/son/'.$sonAide, '../../download/'.$typeName.'/'.$sonAide);
			}
		}

		// on crée le fichier html
		$myfile = fopen("../../download/".$typeName."/monAide.html", "w") or die("Unable to open file!");

		$txt = "<!DOCTYPE html>\n<html>\n<head>\n<title>Fiche d'aide</title>\n<link href='files/aideDefi.css' rel='stylesheet' type='text/css'>\n<link href='https://fonts.googleapis.com/css?family=Unkempt:400,700' rel='stylesheet'>\n</head>\n<body>\n";
		$txt .= '<div id="aidePopup"><img onclick="" style="position: absolute;left: 94%;width: 6%;" src="files/croix.png"><div id="headHelp"><div id="lieuHelp">'.$lieu;
		$txt .= '<img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="files/logos-PAMINA.png"></div><div id="edHelp">Pamina</div></div>';
		$txt .= '<div id="bodyHelp"><div id="questionHelp">'.$question.'</div><div id="imgsHelp">';

		if ($imgAide != null) {
			if ($aideExtImg == "pdf") {
				$txt .= "<object width='100%' data='files/".$imgAide."' type='application/pdf'></object>";
			}else{
				$txt .= "<img style='width: 220px;height: 160px;background-color: red;margin-right: 10%;' src='files/".$imgAide."'></img>";
			}

		}

		$txt .= "<div style='width: 160px;height: 160px;background-color: green;'></div></div>";
		$txt .= "<div id='txtHelp'>".$aideTxt."</div>";
		$txt .= "<div id='mediaHelp'>";
		if ($videoAide != null) {
			$txt .= "<video width='260px' src='files/".$videoAide."' controls>Veuillez mettre à jour votre navigateur !</video>";
		}
		if ($sonAide != null) {
			$txt .= "<audio style='width:35%;' src='files/".$sonAide."' controls>Veuillez mettre à jour votre navigateur !</audio>";
		}
		$txt .= "</div></div>";
		$txt .= '<div id="footerHelp"><div style="float: right;width: 50%;margin-right: 15%;text-align: right;font-size: 13px;height: 100%;padding-top: 1%;">Télécharger en html 5 pour une consultation hors-ligne</div><a id="DwloadHelp" href=""><img src="files/bt_dwl.png" style="position: absolute;right: 6%;width: auto;height: 6%;"></img></a></div>';

		$txt .= '</body></html>';
		fwrite($myfile, $txt);
		fclose($myfile);
		chmod("../../download/".$typeName."/monAide.html", 0777);

		$zip = new ZipArchive();
		$filename = "../../download/".$typeName."/".$typeName.$ID.".zip";

		if ($zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE)!==TRUE) {
			exit("Impossible d'ouvrir le fichier <$filename>\n");
		}

		$zip->addFile("../../download/".$typeName."/aideDefi.css","Aide/files/aideDefi.css");
		$zip->addFile("../../download/".$typeName."/bt_dwl.png","Aide/files/bt_dwl.png");
		$zip->addFile("../../download/".$typeName."/croix.png","Aide/files/croix.png");
		$zip->addFile("../../download/".$typeName."/logos-PAMINA.png","Aide/files/logos-PAMINA.png");

		if (is_file("../../download/".$typeName."/".$imgAide)) {
			$zip->addFile("../../download/".$typeName."/".$imgAide,"Aide/files/".$imgAide);
		}
		if (is_file("../../download/".$typeName."/".$videoAide)) {
			$zip->addFile("../../download/".$typeName."/".$videoAide,"Aide/files/".$videoAide);
		}
		if (is_file("../../download/".$typeName."/".$sonAide)) {
			$zip->addFile("../../download/".$typeName."/".$sonAide,"Aide/files/".$sonAide);
		}
		if (file_exists("../../download/".$typeName."/monAide.html")) {
			$zip->addFile("../../download/".$typeName."/monAide.html","Aide/monAide.html");
		}

		$zip->close();

		// on supprime les éléments ajoutés dans le zip du serveur
		if (is_file("../../download/".$typeName."/".$imgAide)) {
			unlink("../../download/".$typeName."/".$imgAide);
		}
		if (is_file("../../download/".$typeName."/".$videoAide)) {
			unlink("../../download/".$typeName."/".$videoAide);
		}
		if (is_file("../../download/".$typeName."/".$sonAide)) {
			unlink("../../download/".$typeName."/".$sonAide);
		}
		unlink("../../download/".$typeName."/monAide.html");

	}


	$id = htmlspecialchars($_POST['idVocal']);
	$ED = htmlspecialchars($_POST['ed']);
	$langueDefi = htmlspecialchars($_POST['langueDef']);
	$lieu = htmlspecialchars($_POST['lieu']);
	$couleur = htmlspecialchars($_POST['color']);

	// catégorie et sous catégories 
	if (isset($_POST['category'])) {
		$cat1 = htmlspecialchars($_POST['category']);
		if (isset($_POST['res'])) {
			$cat2 = htmlspecialchars($_POST['res']);
		}else{
			$cat2 = null;
		}
		$cat3 = null;
	}

	// google Map
	$adresse = NULL;
	if (isset($_POST['aideMap'])) {
		$adresse = $_POST['aideMap'];
	}

	$titreQuestion = htmlspecialchars($_POST['titleQuestVocaTxt']);
	$question = htmlspecialchars($_POST['questionVocaTxt']);
	$reponse = htmlspecialchars($_POST['repVocale']);
	$motCle = htmlspecialchars($_POST['repCle']);

	// Auteur et copyright de l'aide au défi
	if (empty($_POST['aideImgAuteur'])) {
		$aideImgAuteur = null;
	}else{
		$aideImgAuteur = htmlspecialchars($_POST['aideImgAuteur']);
	}

	if (empty($_POST['copyrightImg'])) {
		$copyrightImg = null;
	}else{
		$copyrightImg = htmlspecialchars($_POST['copyrightImg']);
	}

	if (empty($_POST['aideVideoAuteur'])) {
		$aideVideoAuteur = null;
	}else{
		$aideVideoAuteur = htmlspecialchars($_POST['aideVideoAuteur']);
	}

	if (empty($_POST['copyrightVideo'])) {
		$copyrightVideo = null;
	}else{
		$copyrightVideo = htmlspecialchars($_POST['copyrightVideo']);
	}
		
	if (empty($_POST['aideSonAuteur'])) {
		$aideSonAuteur = null;
	}else{
		$aideSonAuteur = htmlspecialchars($_POST['aideSonAuteur']);
	}
	
	if (empty($_POST['copyrightSon'])) {
		$copyrightSon = null;
	}else{
		$copyrightSon = htmlspecialchars($_POST['copyrightSon']);
	}



	// -----!AIDE AU DEFI-----
	if (!empty($_POST['editorVocaTxt'])) {
		$aideTxt = $_POST['editorVocaTxt'];
		// $aideTxt = htmlspecialchars($_POST['aideTxt']);
	}else{
		$aideTxt = NULL;
	}


	// -----------------------------------------------
	// -----------------MEDIAS-------------------
	// -----------------------------------------------	
		// aide image
		$aideImgName = htmlspecialchars($_POST['aideImgOld']);
		$aideExtImg = NULL;
		if (isset($_FILES['aideImgVocaTxt'])) {
			if ($_FILES['aideImgVocaTxt']['size'] != 0 && $_FILES['aideImgVocaTxt']['name'] != ""){
				$aideExtImg  = pathinfo($_FILES['aideImgVocaTxt']['name'], PATHINFO_EXTENSION);
				if ($aideExtImg != "png" && $aideExtImg != "jpg" && $extension != "PNG" && $extension != "JPG" && $aideExtImg != "pdf") {
 					$_SESSION['error'] = "Veuillez vérifier les extensions de vos fichiers !";
				}else{
					if (!empty($_POST['aideImgOld'])) {
						$aideImgName = htmlspecialchars($_POST['aideImgOld']);
						move_uploaded_file($_FILES['aideImgVocaTxt']['tmp_name'], '../../uploadDefi/aide/img/'.$aideImgName);
					}else{
						$aideImgName = md5(uniqid()).'.'.$aideExtImg;
						move_uploaded_file($_FILES['aideImgVocaTxt']['tmp_name'], '../../uploadDefi/aide/img/'.$aideImgName);
					}
				}
			}
		}
		// aide video
		$aideVidName = htmlspecialchars($_POST['aideVideoOld']);
		if (isset($_FILES['aideVideoVocaTxt'])) {
			if ($_FILES['aideVideoVocaTxt']['size'] != 0 && $_FILES['aideVideoVocaTxt']['name'] != "") {
				$aideExtVid  = pathinfo($_FILES['aideVideoVocaTxt']['name'], PATHINFO_EXTENSION);

				if ($aideExtVid != "mp4") {
					$_SESSION['error'] = "Veuillez vérifier les extensions de vos fichiers !";
				}else {
					if (!empty($_POST['aideVideoOld'])) {
						$aideVidName = htmlspecialchars($_POST['aideVideoOld']);
						move_uploaded_file($_FILES['aideVideoVocaTxt']['tmp_name'], '../../uploadDefi/aide/video/'.$aideVidName);
					}else{
						$aideVidName = md5(uniqid()).'.'.$aideExtVid;
						move_uploaded_file($_FILES['aideVideoVocaTxt']['tmp_name'], '../../uploadDefi/aide/video/'.$aideVidName);
					}
				}
			}
		}
		// aide son
		$aideSonName = htmlspecialchars($_POST['aideSonOld']);
		if (isset($_FILES['aideSonVocaTxt'])) {
			if ($_FILES['aideSonVocaTxt']['size'] != 0 && $_FILES['aideSonVocaTxt']['name'] != "") {
				$aideExtSon  = pathinfo($_FILES['aideSonVocaTxt']['name'], PATHINFO_EXTENSION);

				if ($aideExtSon != "mp3") {
					$_SESSION['error'] = "Veuillez vérifier les extensions de vos fichiers !";
				}else {
					if (!empty($_POST['aideSonOld'])) {
						$aideSonName = htmlspecialchars($_POST['aideSonOld']);
						move_uploaded_file($_FILES['aideSonVocaTxt']['tmp_name'], '../../uploadDefi/aide/son/'.$aideSonName);
					}else{
						$aideSonName = md5(uniqid()).'.'.$aideExtSon;
						move_uploaded_file($_FILES['aideSonVocaTxt']['tmp_name'], '../../uploadDefi/aide/son/'.$aideSonName);
					}
				}
			}
		}
	// -----------------------------------------------
	// 			---------------------------
	// -----------------------------------------------

	// vérifie que tous les champs sont remplit
    if( !empty($_POST['ed']) && !empty($_POST['langueDef']) && !empty($_POST['lieu']) && !empty($_POST['color']) && !empty($_POST['titleQuestVocaTxt']) && !empty($_POST['questionVocaTxt']) && !empty($_POST['repVocale']) && !empty($_POST['repCle']) ){
    	//UPDATE de la base TexteAtrou
		if (!($req = $con->prepare("UPDATE VocalTexte SET ed = ?, langue_defi = ?, lieu = ?, region = ?, titre_question = ?, question = ?, reponse = ?, mot_cles = ?, helpTxt = ?, helpImg = ?, helpVideo = ?, helpAudio = ?, adresse = ?, cat1 = ?, cat2 = ?, cat3 = ?, imgHelpOwner = ?, imgHelpCR = ?, videoHelpOwner = ?, videoHelpCR = ?, audioHelpOwner = ?, audioHelpCR = ?, etat = 'moderer' WHERE id = ?"))) {
		    echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
		}

		if (!$req->bind_param("ssssssssssssssssssssssi", $ED,$langueDefi,$lieu,$couleur,$titreQuestion,$question,$reponse,$motCle,$aideTxt,$aideImgName,$aideVidName,$aideSonName,$adresse,$cat1,$cat2,$cat3,$aideImgAuteur,$copyrightImg,$aideVideoAuteur,$copyrightVideo,$aideSonAuteur,$copyrightSon,$id)) {
		    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
		}
		// LOGS
		$SQLrequest = "UPDATE VocalTexte SET ed = ".$ED.", langue_defi = ".$langueDefi.", lieu = ".$lieu.", region = ".$couleur.", titre_question = ".$titreQuestion.", question = ".$question.", reponse = ".$reponse.", mot_cles = ".$motCle.", helpTxt = ".$aideTxt.", helpImg = ".$aideImgName.", helpVideo = ".$aideVidName.", helpAudio = ".$aideSonName.", adresse = ".$adresse.", cat1 = ".$cat1.", cat2 = ".$cat2.", cat3 = ".$cat3.", imgHelpOwner = ".$aideImgAuteur.", imgHelpCR = ".$copyrightImg.", videoHelpOwner = ".$aideVideoAuteur.", videoHelpCR = ".$copyrightVideo.", audioHelpOwner = ".$aideSonAuteur.", audioHelpCR = ".$copyrightSon.", etat = 'moderer' WHERE id = ".$id;
		
		if (!$req->execute()) {
		    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
		}

		$req->close();

		// on update le zip
		updateZipFile(2,$aideImgName,$aideVidName,$aideSonName,$lieu,$question,$aideExtImg,$aideTxt,$id);

		// message de succès['etat']
		$_SESSION['etat'] = true;


    }else{
    	// message d'erreur
    	if (!isset($_SESSION['etat'])) {
    		$_SESSION['etat'] = false;
    	}
    }

    // mysqli_close($con);
    $filename = '../../SQLcustomLog.txt';
    include("../../connexion/customLogs.php");

?>

<?php 
	if ($_SESSION['user']['id'] == "35") {
		?>
		<script type="text/javascript">window.location.replace("../../vue/adminDefiBoard.php")</script>
		<?php
	}else{
		?>
		<script type="text/javascript">window.location.replace("../../vue/modifDefi.php")</script>
		<?php
	}
?>