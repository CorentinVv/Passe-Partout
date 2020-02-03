<?php

	session_start();
	include("../../connexion/logs.php");
	require_once("../../connexion/SQLconnect.php");

	// fonction pour le zip de l'aide au défi
	function updateZipFile($type,$imgAide,$videoAide,$sonAide,$lieu,$question,$aideExtImg,$aideTxt,$ID) {
		// on déplace les éléments dans le dossier download
		if ($type == 5) {
			// @typeName Nom du dossier dans download
			$typeName = "Classement";
			// on récupère image/video/son
			if (is_file('../../uploadDefi/Classement/aide/img/'.$imgAide)) {
				copy('../../uploadDefi/Classement/aide/img/'.$imgAide, '../../download/'.$typeName.'/'.$imgAide);
			}
			if (is_file('../../uploadDefi/Classement/aide/video/'.$videoAide)) {
				copy('../../uploadDefi/Classement/aide/video/'.$videoAide, '../../download/'.$typeName.'/'.$videoAide);
			}
			if (is_file('../../uploadDefi/Classement/aide/son/'.$sonAide)) {
				copy('../../uploadDefi/Classement/aide/son/'.$sonAide, '../../download/'.$typeName.'/'.$sonAide);
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


	$id = htmlspecialchars($_POST['idClassement']);
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

	$titreQuestion = htmlspecialchars($_POST['titleQuestClassement']);
	$question = htmlspecialchars($_POST['questionClassement']);
	$nbValisette = htmlspecialchars($_POST['nbCatClassement']);
	$etiqType = htmlspecialchars($_POST['typeEtiqClassement']);


	// Nom des catégories (3 à 5 cat)
	for ($i=1; $i <= 5; $i++) { 
		if (isset($_POST['nameCat'.$i.'Classement'])) {
			${'nameCat'.$i} = htmlspecialchars($_POST['nameCat'.$i.'Classement']);
		}else{
			${'nameCat'.$i} = null;
		}
	}
	
	if ($etiqType == 3) {
		// Si le type d'étiquette est image alors on update toute les images
		for ($j=1; $j <= 5; $j++) {
			for ($k=1; $k <= 5; $k++) { 
				if (isset($_FILES['cat'.$j.'Etiq'.$k])) {

					${'cat'.$j.'Etiq'.$k} = htmlspecialchars($_POST['cat'.$j.'Etiq'.$k.'Old']);
					if ($_FILES['cat'.$j.'Etiq'.$k]['size'] != 0 && $_FILES['cat'.$j.'Etiq'.$k]['name'] != "") {
						$vignetteExt  = pathinfo($_FILES['cat'.$j.'Etiq'.$k]['name'], PATHINFO_EXTENSION);

						if ($vignetteExt != "png" && $vignetteExt != "jpg" && $vignetteExt != "PNG" && $vignetteExt != "JPG" && $vignetteExt != "pdf") {
							$_SESSION['error'] = "Veuillez vérifier les extensions de vos fichiers !";
						}else{
							if (!empty($_POST['cat'.$j.'Etiq'.$k.'Old'])) {
								${'cat'.$j.'Etiq'.$k} = htmlspecialchars($_POST['cat'.$j.'Etiq'.$k.'Old']);
								move_uploaded_file($_FILES['cat'.$j.'Etiq'.$k]['tmp_name'], '../../uploadDefi/Classement/'.${'cat'.$j.'Etiq'.$k});
							}else{
								${'cat'.$j.'Etiq'.$k} = md5(uniqid()).'.'.$vignetteExt;
								move_uploaded_file($_FILES['cat'.$j.'Etiq'.$k]['tmp_name'], '../../uploadDefi/Classement/'.${'cat'.$j.'Etiq'.$k});
							}
						}
					}

				}else{
					${'cat'.$j.'Etiq'.$k} = null;
				}

				// Auteur des images
				if (isset($_POST['v'.$j.'_e'.$k.'_Owner'])) {
					${'v'.$j.'_e'.$k.'_Owner'} = htmlspecialchars($_POST['v'.$j.'_e'.$k.'_Owner']);
				}else{
					${'v'.$j.'_e'.$k.'_Owner'} = null;
				}

				// Copyright des images
				if (isset($_POST['v'.$j.'_e'.$k.'_CR'])) {
					${'v'.$j.'_e'.$k.'_CR'} = htmlspecialchars($_POST['v'.$j.'_e'.$k.'_CR']);
				}else{
					${'v'.$j.'_e'.$k.'_CR'} = null;
				}
			}
		}
	}else{
		// contenu des etiquettes (mots ou groupe de mots)
		for ($j=1; $j <= 5; $j++) {
			for ($k=1; $k <= 5; $k++) { 
				if (isset($_POST['cat'.$j.'Etiq'.$k])) {
					${'cat'.$j.'Etiq'.$k} = htmlspecialchars($_POST['cat'.$j.'Etiq'.$k]);
				}else{
					${'cat'.$j.'Etiq'.$k} = null;
				}
			}
		}
	}

	// -----!AIDE AU DEFI-----
	if (!empty($_POST['editorClassement'])) {
		$aideTxt = $_POST['editorClassement'];
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
		if (isset($_FILES['aideImgClassement'])) {
			if ($_FILES['aideImgClassement']['size'] != 0 && $_FILES['aideImgClassement']['name'] != ""){
				$aideExtImg  = pathinfo($_FILES['aideImgClassement']['name'], PATHINFO_EXTENSION);
				if ($aideExtImg != "png" && $aideExtImg != "jpg" && $extension != "PNG" && $extension != "JPG" && $aideExtImg != "pdf") {
 					$_SESSION['error'] = "Veuillez vérifier les extensions de vos fichiers !";
				}else{
					if (!empty($_POST['aideImgOld'])) {
						$aideImgName = htmlspecialchars($_POST['aideImgOld']);
						move_uploaded_file($_FILES['aideImgClassement']['tmp_name'], '../../uploadDefi/Classement/aide/img/'.$aideImgName);
					}else{
						$aideImgName = md5(uniqid()).'.'.$aideExtImg;
						move_uploaded_file($_FILES['aideImgClassement']['tmp_name'], '../../uploadDefi/Classement/aide/img/'.$aideImgName);
					}
				}
			}
		}
		// aide video
		$aideVidName = htmlspecialchars($_POST['aideVideoOld']);
		if (isset($_FILES['aideVideoClassement'])) {
			if ($_FILES['aideVideoClassement']['size'] != 0 && $_FILES['aideVideoClassement']['name'] != "") {
				$aideExtVid  = pathinfo($_FILES['aideVideoClassement']['name'], PATHINFO_EXTENSION);

				if ($aideExtVid != "mp4") {
					$_SESSION['error'] = "Veuillez vérifier les extensions de vos fichiers !";
				}else {
					if (!empty($_POST['aideVideoOld'])) {
						$aideVidName = htmlspecialchars($_POST['aideVideoOld']);
						move_uploaded_file($_FILES['aideVideoClassement']['tmp_name'], '../../uploadDefi/Classement/aide/video/'.$aideVidName);
					}else{
						$aideVidName = md5(uniqid()).'.'.$aideExtVid;
						move_uploaded_file($_FILES['aideVideoClassement']['tmp_name'], '../../uploadDefi/Classement/aide/video/'.$aideVidName);
					}
				}
			}
		}
		// aide son
		$aideSonName = htmlspecialchars($_POST['aideSonOld']);
		if (isset($_FILES['aideSonClassement'])) {
			if ($_FILES['aideSonClassement']['size'] != 0 && $_FILES['aideSonClassement']['name'] != "") {
				$aideExtSon  = pathinfo($_FILES['aideSonClassement']['name'], PATHINFO_EXTENSION);

				if ($aideExtSon != "mp3") {
					$_SESSION['error'] = "Veuillez vérifier les extensions de vos fichiers !";
				}else {
					if (!empty($_POST['aideSonOld'])) {
						$aideSonName = htmlspecialchars($_POST['aideSonOld']);
						move_uploaded_file($_FILES['aideSonClassement']['tmp_name'], '../../uploadDefi/Classement/aide/son/'.$aideSonName);
					}else{
						$aideSonName = md5(uniqid()).'.'.$aideExtSon;
						move_uploaded_file($_FILES['aideSonClassement']['tmp_name'], '../../uploadDefi/Classement/aide/son/'.$aideSonName);
					}
				}
			}
		}
	// -----------------------------------------------
	// 			---------------------------
	// -----------------------------------------------

	// vérifie que tous les champs sont remplit
    if( !empty($_POST['ed']) && !empty($_POST['langueDef']) && !empty($_POST['lieu']) && !empty($_POST['color']) && !empty($_POST['titleQuestClassement']) && !empty($_POST['questionClassement']) && !empty($_POST['nbCatClassement']) && !empty($_POST['typeEtiqClassement']) && !empty($_POST['nameCat1Classement']) && !empty($_POST['nameCat2Classement']) && !empty($_POST['nameCat3Classement']) ){
    	//UPDATE de la base TexteAtrou
		if (!($req = $con->prepare("UPDATE DefiClassement SET ed = ?, langue_defi = ?, lieu = ?, region = ?, titre_question = ?, question = ?, nbValisette = ?, nom_valise_1 = ?, nom_valise_2 = ?, nom_valise_3 = ?, nom_valise_4 = ?, nom_valise_5 = ?, type_etiquette = ?, valise_1_etiquette_1 = ?, valise_1_etiquette_2 = ?, valise_1_etiquette_3 = ?, valise_1_etiquette_4 = ?, valise_1_etiquette_5 = ?, valise_2_etiquette_1 = ?, valise_2_etiquette_2 = ?, valise_2_etiquette_3 = ?, valise_2_etiquette_4 = ?, valise_2_etiquette_5 = ?, valise_3_etiquette_1 = ?, valise_3_etiquette_2 = ?, valise_3_etiquette_3 = ?, valise_3_etiquette_4 = ?, valise_3_etiquette_5 = ?, valise_4_etiquette_1 = ?, valise_4_etiquette_2 = ?, valise_4_etiquette_3 = ?, valise_4_etiquette_4 = ?, valise_4_etiquette_5 = ?, valise_5_etiquette_1 = ?, valise_5_etiquette_2 = ?, valise_5_etiquette_3 = ?, valise_5_etiquette_4 = ?, valise_5_etiquette_5 = ?, helpTxt = ?, helpImg = ?, helpVideo = ?, helpAudio = ?, adresse = ?, cat1 = ?, cat2 = ?, cat3 = ?, imgHelpOwner = ?, imgHelpCR = ?, videoHelpOwner = ?, videoHelpCR = ?, audioHelpOwner = ?, audioHelpCR = ?, v1_e1_Owner = ?, v1_e1_CR = ?, v1_e2_Owner = ?, v1_e2_CR = ?, v1_e3_Owner = ?, v1_e3_CR = ?, v1_e4_Owner = ?, v1_e4_CR = ?, v1_e5_Owner = ?, v1_e5_CR = ?, v2_e1_Owner = ?, v2_e1_CR = ?, v2_e2_Owner = ?, v2_e2_CR = ?, v2_e3_Owner = ?, v2_e3_CR = ?, v2_e4_Owner = ?, v2_e4_CR = ?, v2_e5_Owner = ?, v2_e5_CR = ?, v3_e1_Owner = ?, v3_e1_CR = ?, v3_e2_Owner = ?, v3_e2_CR = ?, v3_e3_Owner = ?, v3_e3_CR = ?, v3_e4_Owner = ?, v3_e4_CR = ?, v3_e5_Owner = ?, v3_e5_CR = ?, v4_e1_Owner = ?, v4_e1_CR = ?, v4_e2_Owner = ?, v4_e2_CR = ?, v4_e3_Owner = ?, v4_e3_CR = ?, v4_e4_Owner = ?, v4_e4_CR = ?, v4_e5_Owner = ?, v4_e5_CR = ?, v5_e1_Owner = ?, v5_e1_CR = ?, v5_e2_Owner = ?, v5_e2_CR = ?, v5_e3_Owner = ?, v5_e3_CR = ?, v5_e4_Owner = ?, v5_e4_CR = ?, v5_e5_Owner = ?, v5_e5_CR = ?, etat = 'moderer' WHERE id = ?"))) {
		    echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
		}

		if (!$req->bind_param("ssssssisssssisssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssi", $ED, $langueDefi, $lieu, $couleur, $titreQuestion, $question, $nbValisette, $nameCat1, $nameCat2, $nameCat3, $nameCat4, $nameCat5, $etiqType, $cat1Etiq1, $cat1Etiq2, $cat1Etiq3, $cat1Etiq4, $cat1Etiq5, $cat2Etiq1, $cat2Etiq2, $cat2Etiq3, $cat2Etiq4, $cat2Etiq5, $cat3Etiq1, $cat3Etiq2, $cat3Etiq3, $cat3Etiq4, $cat3Etiq5, $cat4Etiq1, $cat4Etiq2, $cat4Etiq3, $cat4Etiq4, $cat4Etiq5, $cat5Etiq1, $cat5Etiq2, $cat5Etiq3, $cat5Etiq4, $cat5Etiq5, $aideTxt, $aideImgName, $aideVidName, $aideSonName, $adresse, $cat1, $cat2, $cat3, $aideImgAuteur, $copyrightImg, $aideVideoAuteur, $copyrightVideo, $aideSonAuteur, $copyrightSon, $v1_e1_Owner, $v1_e1_CR, $v1_e2_Owner, $v1_e2_CR, $v1_e3_Owner, $v1_e3_CR, $v1_e4_Owner, $v1_e4_CR, $v1_e5_Owner, $v1_e5_CR, $v2_e1_Owner, $v2_e1_CR, $v2_e2_Owner, $v2_e2_CR, $v2_e3_Owner, $v2_e3_CR, $v2_e4_Owner, $v2_e4_CR, $v2_e5_Owner, $v2_e5_CR, $v3_e1_Owner, $v3_e1_CR, $v3_e2_Owner, $v3_e2_CR, $v3_e3_Owner, $v3_e3_CR, $v3_e4_Owner, $v3_e4_CR, $v3_e5_Owner, $v3_e5_CR, $v4_e1_Owner, $v4_e1_CR, $v4_e2_Owner, $v4_e2_CR, $v4_e3_Owner, $v4_e3_CR, $v4_e4_Owner, $v4_e4_CR, $v4_e5_Owner, $v4_e5_CR, $v5_e1_Owner, $v5_e1_CR, $v5_e2_Owner, $v5_e2_CR, $v5_e3_Owner, $v5_e3_CR, $v5_e4_Owner, $v5_e4_CR, $v5_e5_Owner, $v5_e5_CR, $id)) {
		    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
		}
		// LOGS
		$SQLrequest = "UPDATE DefiClassement SET ed = ".$ED.", langue_defi = ".$langueDefi.", lieu = ".$lieu.", region = ".$couleur.", titre_question = ".$titreQuestion.", question = ".$question.", nbValisette = ".$nbValisette.", nom_valise_1 = ".$nameCat1.", nom_valise_2 = ".$nameCat2.", nom_valise_3 = ".$nameCat3.", nom_valise_4 = ".$nameCat4.", nom_valise_5 = ".$nameCat5.", type_etiquette = ".$etiqType.", valise_1_etiquette_1 = ".$cat1Etiq1.", valise_1_etiquette_2 = ".$cat1Etiq2.", valise_1_etiquette_3 = ".$cat1Etiq3.", valise_1_etiquette_4 = ".$cat1Etiq4.", valise_1_etiquette_5 = ".$cat1Etiq5.", valise_2_etiquette_1 = ".$cat2Etiq1.", valise_2_etiquette_2 = ".$cat2Etiq2.", valise_2_etiquette_3 = ".$cat2Etiq3.", valise_2_etiquette_4 = ".$cat2Etiq4.", valise_2_etiquette_5 = ".$cat2Etiq5.", valise_3_etiquette_1 = ".$cat3Etiq1.", valise_3_etiquette_2 = ".$cat3Etiq2.", valise_3_etiquette_3 = ".$cat3Etiq3.", valise_3_etiquette_4 = ".$cat3Etiq4.", valise_3_etiquette_5 = ".$cat3Etiq5.", valise_4_etiquette_1 = ".$cat4Etiq1.", valise_4_etiquette_2 = ".$cat4Etiq2.", valise_4_etiquette_3 = ".$cat4Etiq3.", valise_4_etiquette_4 = ".$cat4Etiq4.", valise_4_etiquette_5 = ".$cat4Etiq5.", valise_5_etiquette_1 = ".$cat5Etiq1.", valise_5_etiquette_2 = ".$cat5Etiq2.", valise_5_etiquette_3 = ".$cat5Etiq3.", valise_5_etiquette_4 = ".$cat5Etiq4.", valise_5_etiquette_5 = ".$cat5Etiq5.", helpTxt = ".$aideTxt.", helpImg = ".$aideImgName.", helpVideo = ".$aideVidName.", helpAudio = ".$aideSonName.", adresse = ".$adresse.", cat1 = ".$cat1.", cat2 = ".$cat2.", cat3 = ".$cat3.", imgHelpOwner = ".$aideImgAuteur.", imgHelpCR = ".$copyrightImg.", videoHelpOwner = ".$aideVideoAuteur.", videoHelpCR = ".$copyrightVideo.", audioHelpOwner = ".$aideSonAuteur.", audioHelpCR = ".$copyrightSon.", v1_e1_Owner = ".$v1_e1_Owner.", v1_e1_CR = ".$v1_e1_CR .", v1_e2_Owner = ".$v1_e2_Owner.", v1_e2_CR = ".$v1_e2_CR .", v1_e3_Owner = ".$v1_e3_Owner.", v1_e3_CR = ".$v1_e3_CR .", v1_e4_Owner = ".$v1_e4_Owner.", v1_e4_CR = ".$v1_e4_CR .", v1_e5_Owner = ".$v1_e5_Owner.", v1_e5_CR = ".$v1_e5_CR .", v2_e1_Owner = ".$v2_e1_Owner.", v2_e1_CR = ".$v2_e1_CR .", v2_e2_Owner = ".$v2_e2_Owner.", v2_e2_CR = ".$v2_e2_CR .", v2_e3_Owner = ".$v2_e3_Owner.", v2_e3_CR = ".$v2_e3_CR .", v2_e4_Owner = ".$v2_e4_Owner.", v2_e4_CR = ".$v2_e4_CR .", v2_e5_Owner = ".$v2_e5_Owner.", v2_e5_CR = ".$v2_e5_CR .", v3_e1_Owner = ".$v3_e1_Owner.", v3_e1_CR = ".$v3_e1_CR .", v3_e2_Owner = ".$v3_e2_Owner.", v3_e2_CR = ".$v3_e2_CR .", v3_e3_Owner = ".$v3_e3_Owner.", v3_e3_CR = ".$v3_e3_CR .", v3_e4_Owner = ".$v3_e4_Owner.", v3_e4_CR = ".$v3_e4_CR .", v3_e5_Owner = ".$v3_e5_Owner.", v3_e5_CR = ".$v3_e5_CR .", v4_e1_Owner = ".$v4_e1_Owner.", v4_e1_CR = ".$v4_e1_CR .", v4_e2_Owner = ".$v4_e2_Owner.", v4_e2_CR = ".$v4_e2_CR .", v4_e3_Owner = ".$v4_e3_Owner.", v4_e3_CR = ".$v4_e3_CR .", v4_e4_Owner = ".$v4_e4_Owner.", v4_e4_CR = ".$v4_e4_CR .", v4_e5_Owner = ".$v4_e5_Owner.", v4_e5_CR = ".$v4_e5_CR .", v5_e1_Owner = ".$v5_e1_Owner.", v5_e1_CR = ".$v5_e1_CR .", v5_e2_Owner = ".$v5_e2_Owner.", v5_e2_CR = ".$v5_e2_CR .", v5_e3_Owner = ".$v5_e3_Owner.", v5_e3_CR = ".$v5_e3_CR .", v5_e4_Owner = ".$v5_e4_Owner.", v5_e4_CR = ".$v5_e4_CR .", v5_e5_Owner = ".$v5_e5_Owner.", v5_e5_CR = ".$v5_e5_CR.", etat = 'moderer' WHERE id = ".$id;
		
		if (!$req->execute()) {
		    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
		}

		$req->close();

		// on update le zip
		updateZipFile(5,$aideImgName,$aideVidName,$aideSonName,$lieu,$question,$aideExtImg,$aideTxt,$id);

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