<?php

	session_start();
	include("../../connexion/logs.php");
	require_once("../../connexion/SQLconnect.php");

	// fonction pour le zip de l'aide au défi
	function updateZipFile($type,$imgAide,$videoAide,$sonAide,$lieu,$question,$aideExtImg,$aideTxt,$ID) {
		// on déplace les éléments dans le dossier download
		if ($type == 3) {
			// @typeName Nom du dossier dans download
			$typeName = "Frise";
			// on récupère image/video/son
			if (is_file('../../uploadDefi/FriseChrono/aide/img/'.$imgAide)) {
				copy('../../uploadDefi/FriseChrono/aide/img/'.$imgAide, '../../download/'.$typeName.'/'.$imgAide);
			}
			if (is_file('../../uploadDefi/FriseChrono/aide/video/'.$videoAide)) {
				copy('../../uploadDefi/FriseChrono/aide/video/'.$videoAide, '../../download/'.$typeName.'/'.$videoAide);
			}
			if (is_file('../../uploadDefi/FriseChrono/aide/son/'.$sonAide)) {
				copy('../../uploadDefi/FriseChrono/aide/son/'.$sonAide, '../../download/'.$typeName.'/'.$sonAide);
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


	$id = htmlspecialchars($_POST['idFrise']);
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
	
	$titreFrise = htmlspecialchars($_POST['titreFrise']);
	$dateDebFrise = htmlspecialchars($_POST['dateDebFrise']);
	$dateFinFrise = htmlspecialchars($_POST['dateFinFrise']);
	
	// les 6 vignettes
	$eventName1 = htmlspecialchars($_POST['eventName1']);
	$eventDate1 = htmlspecialchars($_POST['eventDate1']);

	$eventName2 = htmlspecialchars($_POST['eventName2']);
	$eventDate2 = htmlspecialchars($_POST['eventDate2']);

	$eventName3 = htmlspecialchars($_POST['eventName3']);
	$eventDate3 = htmlspecialchars($_POST['eventDate3']);

	$eventName4 = htmlspecialchars($_POST['eventName4']);
	$eventDate4 = htmlspecialchars($_POST['eventDate4']);

	$eventName5 = htmlspecialchars($_POST['eventName5']);
	$eventDate5 = htmlspecialchars($_POST['eventDate5']);

	$eventName6 = htmlspecialchars($_POST['eventName6']);
	$eventDate6 = htmlspecialchars($_POST['eventDate6']);

	// Copyright
	$eventImg1Auteur = htmlspecialchars($_POST['eventImg1Auteur']);
	$copyrightEventImg1 = htmlspecialchars($_POST['copyrightEventImg1']);

	$eventImg2Auteur = htmlspecialchars($_POST['eventImg2Auteur']);
	$copyrightEventImg2 = htmlspecialchars($_POST['copyrightEventImg2']);

	$eventImg3Auteur = htmlspecialchars($_POST['eventImg3Auteur']);
	$copyrightEventImg3 = htmlspecialchars($_POST['copyrightEventImg3']);

	$eventImg4Auteur = htmlspecialchars($_POST['eventImg4Auteur']);
	$copyrightEventImg4 = htmlspecialchars($_POST['copyrightEventImg4']);

	$eventImg5Auteur = htmlspecialchars($_POST['eventImg5Auteur']);
	$copyrightEventImg5 = htmlspecialchars($_POST['copyrightEventImg5']);
	
	$eventImg6Auteur = htmlspecialchars($_POST['eventImg6Auteur']);
	$copyrightEventImg6 = htmlspecialchars($_POST['copyrightEventImg6']);

	// -----!AIDE AU DEFI-----
	if (!empty($_POST['editorFrise'])) {
		$aideTxt = $_POST['editorFrise'];
		// $aideTxt = htmlspecialchars($_POST['aideTxt']);
	}else{
		$aideTxt = NULL;
	}


		// les 6 vignettes

		// image 1
		$eventImg1 = htmlspecialchars($_POST['eventOldImg1']);
		if (isset($_FILES['eventImg1'])) {
			if ($_FILES['eventImg1']['size'] != 0 && $_FILES['eventImg1']['name'] != "") {
				$aideExtImg  = pathinfo($_FILES['eventImg1']['name'], PATHINFO_EXTENSION);

				if ($aideExtImg != "png" && $aideExtImg != "jpg" && $extension != "PNG" && $extension != "JPG" && $extension != "pdf") {
					$_SESSION['error'] = "Veuillez vérifier les extensions de vos fichiers !";
				}else{
					if (!empty($_POST['eventOldImg1'])) {
						$eventImg1 = htmlspecialchars($_POST['eventOldImg1']);
						move_uploaded_file($_FILES['eventImg1']['tmp_name'], '../../uploadDefi/FriseChrono/'.$eventImg1);
					}else{
						$eventImg1 = md5(uniqid()).'.'.$aideExtImg;
						move_uploaded_file($_FILES['eventImg1']['tmp_name'], '../../uploadDefi/FriseChrono/'.$eventImg1);
					}
				}
			}
		}

		// image 2
		$eventImg2 = htmlspecialchars($_POST['eventOldImg2']);
		if (isset($_FILES['eventImg2'])) {
			if ($_FILES['eventImg2']['size'] != 0 && $_FILES['eventImg2']['name'] != "") {
				$aideExtImg  = pathinfo($_FILES['eventImg2']['name'], PATHINFO_EXTENSION);

				if ($aideExtImg != "png" && $aideExtImg != "jpg" && $extension != "PNG" && $extension != "JPG" && $extension != "pdf") {
					$_SESSION['error'] = "Veuillez vérifier les extensions de vos fichiers !";
				}else{
					if (!empty($_POST['eventOldImg2'])) {
						$eventImg2 = htmlspecialchars($_POST['eventOldImg2']);
						move_uploaded_file($_FILES['eventImg2']['tmp_name'], '../../uploadDefi/FriseChrono/'.$eventImg2);
					}else{
						$eventImg2 = md5(uniqid()).'.'.$aideExtImg;
						move_uploaded_file($_FILES['eventImg2']['tmp_name'], '../../uploadDefi/FriseChrono/'.$eventImg2);
					}
				}
			}
		}

		// image 3
		$eventImg3 = htmlspecialchars($_POST['eventOldImg3']);
		if (isset($_FILES['eventImg3'])) {
			if ($_FILES['eventImg3']['size'] != 0 && $_FILES['eventImg3']['name'] != "") {
				$aideExtImg  = pathinfo($_FILES['eventImg3']['name'], PATHINFO_EXTENSION);

				if ($aideExtImg != "png" && $aideExtImg != "jpg" && $extension != "PNG" && $extension != "JPG" && $extension != "pdf") {
					$_SESSION['error'] = "Veuillez vérifier les extensions de vos fichiers !";
				}else{
					if (!empty($_POST['eventOldImg3'])) {
						$eventImg3 = htmlspecialchars($_POST['eventOldImg3']);
						move_uploaded_file($_FILES['eventImg3']['tmp_name'], '../../uploadDefi/FriseChrono/'.$eventImg3);
					}else{
						$eventImg3 = md5(uniqid()).'.'.$aideExtImg;
						move_uploaded_file($_FILES['eventImg3']['tmp_name'], '../../uploadDefi/FriseChrono/'.$eventImg3);
					}
				}
			}
		}

		// image 4
		$eventImg4 = htmlspecialchars($_POST['eventOldImg4']);
		if (isset($_FILES['eventImg4'])) {
			if ($_FILES['eventImg4']['size'] != 0 && $_FILES['eventImg4']['name'] != "") {
				$aideExtImg  = pathinfo($_FILES['eventImg4']['name'], PATHINFO_EXTENSION);

				if ($aideExtImg != "png" && $aideExtImg != "jpg" && $extension != "PNG" && $extension != "JPG" && $extension != "pdf") {
					$_SESSION['error'] = "Veuillez vérifier les extensions de vos fichiers !";
				}else{
					if (!empty($_POST['eventOldImg4'])) {
						$eventImg4 = htmlspecialchars($_POST['eventOldImg4']);
						move_uploaded_file($_FILES['eventImg4']['tmp_name'], '../../uploadDefi/FriseChrono/'.$eventImg4);
					}else{
						$eventImg4 = md5(uniqid()).'.'.$aideExtImg;
						move_uploaded_file($_FILES['eventImg4']['tmp_name'], '../../uploadDefi/FriseChrono/'.$eventImg4);
					}
				}
			}
		}

		// image 5
		$eventImg5 = htmlspecialchars($_POST['eventOldImg5']);
		if (isset($_FILES['eventImg5'])) {
			if ($_FILES['eventImg5']['size'] != 0 && $_FILES['eventImg5']['name'] != "") {
				$aideExtImg  = pathinfo($_FILES['eventImg5']['name'], PATHINFO_EXTENSION);

				if ($aideExtImg != "png" && $aideExtImg != "jpg" && $extension != "PNG" && $extension != "JPG" && $extension != "pdf") {
					$_SESSION['error'] = "Veuillez vérifier les extensions de vos fichiers !";
				}else{
					if (!empty($_POST['eventOldImg5'])) {
						$eventImg5 = htmlspecialchars($_POST['eventOldImg5']);
						move_uploaded_file($_FILES['eventImg5']['tmp_name'], '../../uploadDefi/FriseChrono/'.$eventImg5);
					}else{
						$eventImg5 = md5(uniqid()).'.'.$aideExtImg;
						move_uploaded_file($_FILES['eventImg5']['tmp_name'], '../../uploadDefi/FriseChrono/'.$eventImg5);
					}
				}
			}
		}

		// image 6
		$eventImg6 = htmlspecialchars($_POST['eventOldImg6']);
		if (isset($_FILES['eventImg6'])) {
			if ($_FILES['eventImg6']['size'] != 0 && $_FILES['eventImg6']['name'] != "") {
				$aideExtImg  = pathinfo($_FILES['eventImg6']['name'], PATHINFO_EXTENSION);

				if ($aideExtImg != "png" && $aideExtImg != "jpg" && $extension != "PNG" && $extension != "JPG" && $extension != "pdf") {
					$_SESSION['error'] = "Veuillez vérifier les extensions de vos fichiers !";
				}else{
					if (!empty($_POST['eventOldImg6'])) {
						$eventImg6 = htmlspecialchars($_POST['eventOldImg6']);
						move_uploaded_file($_FILES['eventImg6']['tmp_name'], '../../uploadDefi/FriseChrono/'.$eventImg6);
					}else{
						$eventImg6 = md5(uniqid()).'.'.$aideExtImg;
						move_uploaded_file($_FILES['eventImg6']['tmp_name'], '../../uploadDefi/FriseChrono/'.$eventImg6);
					}
				}
			}
		}


	// -----------------------------------------------
	// -----------------MEDIAS-------------------
	// -----------------------------------------------	
		// aide image
		$aideImgName = htmlspecialchars($_POST['aideImgOld']);
		$aideExtImg = NULL;
		if (isset($_FILES['aideImgFrise'])) {
			if ($_FILES['aideImgFrise']['size'] != 0 && $_FILES['aideImgFrise']['name'] != ""){
				$aideExtImg  = pathinfo($_FILES['aideImgFrise']['name'], PATHINFO_EXTENSION);
				if ($aideExtImg != "png" && $aideExtImg != "jpg" && $extension != "PNG" && $extension != "JPG" && $aideExtImg != "pdf") {
 					$_SESSION['error'] = "Veuillez vérifier les extensions de vos fichiers !";
				}else{
					if (!empty($_POST['aideImgOld'])) {
						$aideImgName = htmlspecialchars($_POST['aideImgOld']);
						move_uploaded_file($_FILES['aideImgFrise']['tmp_name'], '../../uploadDefi/FriseChrono/aide/img/'.$aideImgName);
					}else{
						$aideImgName = md5(uniqid()).'.'.$aideExtImg;
						move_uploaded_file($_FILES['aideImgFrise']['tmp_name'], '../../uploadDefi/FriseChrono/aide/img/'.$aideImgName);
					}
				}
			}
		}
		// aide video
		$aideVidName = htmlspecialchars($_POST['aideVideoOld']);
		if (isset($_FILES['aideVideoFrise'])) {
			if ($_FILES['aideVideoFrise']['size'] != 0 && $_FILES['aideVideoFrise']['name'] != "") {
				$aideExtVid  = pathinfo($_FILES['aideVideoFrise']['name'], PATHINFO_EXTENSION);

				if ($aideExtVid != "mp4") {
					$_SESSION['error'] = "Veuillez vérifier les extensions de vos fichiers !";
				}else {
					if (!empty($_POST['aideVideoOld'])) {
						$aideVidName = htmlspecialchars($_POST['aideVideoOld']);
						move_uploaded_file($_FILES['aideVideoFrise']['tmp_name'], '../../uploadDefi/FriseChrono/aide/video/'.$aideVidName);
					}else{
						$aideVidName = md5(uniqid()).'.'.$aideExtVid;
						move_uploaded_file($_FILES['aideVideoFrise']['tmp_name'], '../../uploadDefi/FriseChrono/aide/video/'.$aideVidName);
					}
				}
			}
		}
		// aide son
		$aideSonName = htmlspecialchars($_POST['aideSonOld']);
		if (isset($_FILES['aideSonFrise'])) {
			if ($_FILES['aideSonFrise']['size'] != 0 && $_FILES['aideSonFrise']['name'] != "") {
				$aideExtSon  = pathinfo($_FILES['aideSonFrise']['name'], PATHINFO_EXTENSION);

				if ($aideExtSon != "mp3") {
					$_SESSION['error'] = "Veuillez vérifier les extensions de vos fichiers !";
				}else {
					if (!empty($_POST['aideSonOld'])) {
						$aideSonName = htmlspecialchars($_POST['aideSonOld']);
						move_uploaded_file($_FILES['aideSonFrise']['tmp_name'], '../../uploadDefi/FriseChrono/aide/son/'.$aideSonName);
					}else{
						$aideSonName = md5(uniqid()).'.'.$aideExtSon;
						move_uploaded_file($_FILES['aideSonFrise']['tmp_name'], '../../uploadDefi/FriseChrono/aide/son/'.$aideSonName);
					}
				}
			}
		}
	// -----------------------------------------------
	// 			---------------------------
	// -----------------------------------------------

	// vérifie que tous les champs sont remplit
    if( !empty($_POST['ed']) && !empty($_POST['langueDef']) && !empty($_POST['lieu']) && !empty($_POST['color']) && !empty($_POST['dateDebFrise']) && !empty($_POST['dateFinFrise']) && !empty($_POST['titreFrise']) && !empty($_POST['eventName1']) && !empty($_POST['eventDate1']) && !empty($_FILES['eventImg1']) && !empty($_POST['eventName2']) && !empty($_POST['eventDate2']) && !empty($_FILES['eventImg2']) && !empty($_POST['eventName3']) && !empty($_POST['eventDate3']) && !empty($_FILES['eventImg3']) && !empty($_POST['eventName4']) && !empty($_POST['eventDate4']) && !empty($_FILES['eventImg4']) && !empty($_POST['eventName5']) && !empty($_POST['eventDate5']) && !empty($_FILES['eventImg5']) && !empty($_POST['eventName6']) && !empty($_POST['eventDate6']) && !empty($_FILES['eventImg6']) ){
    	//UPDATE de la base TexteAtrou
		if (!($req = $con->prepare("UPDATE FriseChrono SET ed = ?, langue_defi = ?, lieu = ?, region = ?, titre_frise = ?, date_debut = ?, date_fin = ?, item1_date = ?, item1_title = ?, item1_img = ?, item1Owner = ?, item1CR = ?, item2_date = ?, item2_title = ?, item2_img = ?, item2Owner = ?, item2CR = ?, item3_date = ?, item3_title = ?, item3_img = ?, item3Owner = ?, item3CR = ?, item4_date = ?, item4_title = ?, item4_img = ?, item4Owner = ?, item4CR = ?, item5_date = ?, item5_title = ?, item5_img = ?, item5Owner = ?, item5CR = ?, item6_date = ?, item6_title = ?, item6_img = ?, item6Owner = ?, item6CR = ?, helpTxt = ?, helpImg = ?, helpVideo = ?, helpAudio = ?, adresse = ?, cat1 = ?, cat2 = ?, cat3 = ?, imgHelpOwner = ?, imgHelpCR = ?, videoHelpOwner = ?, videoHelpCR = ?, audioHelpOwner = ?, audioHelpCR = ?, etat = 'moderer' WHERE id = ?"))) {
		    echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
		}

		if (!$req->bind_param("sssssiiissssissssissssissssissssissssssssssssssssssi", $ED,$langueDefi,$lieu,$couleur,$titreFrise,$dateDebFrise,$dateFinFrise, $eventDate1, $eventName1, $eventImg1, $eventImg1Auteur, $copyrightEventImg1, $eventDate2, $eventName2, $eventImg2, $eventImg2Auteur, $copyrightEventImg2, $eventDate3, $eventName3, $eventImg3, $eventImg3Auteur, $copyrightEventImg3, $eventDate4, $eventName4, $eventImg4, $eventImg4Auteur, $copyrightEventImg4, $eventDate5, $eventName5, $eventImg5, $eventImg5Auteur, $copyrightEventImg5, $eventDate6, $eventName6, $eventImg6, $eventImg6Auteur, $copyrightEventImg6,$aideTxt,$aideImgName,$aideVidName,$aideSonName,$adresse,$cat1,$cat2,$cat3,$aideImgAuteur,$copyrightImg,$aideVideoAuteur,$copyrightVideo,$aideSonAuteur,$copyrightSon,$id)) {
		    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
		}
		// LOGS
		$SQLrequest = "UPDATE FriseChrono SET ed = ".$ED.", langue_defi = ".$langueDefi.", lieu = ".$lieu.", region = ".$couleur.", titre_frise = ".$titreFrise.", date_debut = ".$dateDebFrise.", date_fin = ".$dateFinFrise.", item1_date = ".$eventDate1.", item1_title = ".$eventName1.", item1_img = ".$eventImg1.", item1Owner = ".$eventImg1Auteur.", item1CR = ".$copyrightEventImg1.", item2_date = ".$eventDate2.", item2_title = ".$eventName2.", item2_img = ".$eventImg2.", item2Owner = ".$eventImg2Auteur.", item2CR = ".$copyrightEventImg2.", item3_date = ".$eventDate3.", item3_title = ".$eventName3.", item3_img = ".$eventImg3.", item3Owner = ".$eventImg3Auteur.", item3CR = ".$copyrightEventImg3.", item4_date = ".$eventDate4.", item4_title = ".$eventName4.", item4_img = ".$eventImg4.", item4Owner = ".$eventImg4Auteur.", item4CR = ".$copyrightEventImg4.", item5_date = ".$eventDate5.", item5_title = ".$eventName5.", item5_img = ".$eventImg5.", item5Owner = ".$eventImg5Auteur.", item5CR = ".$copyrightEventImg5.", item6_date = ".$eventDate6.", item6_title = ".$eventName6.", item6_img = ".$eventImg6.", item6Owner = ".$eventImg6Auteur.", item6CR = ".$copyrightEventImg6.", helpTxt = ".$aideTxt.", helpImg = ".$aideImgName.", helpVideo = ".$aideVidName.", helpAudio = ".$aideSonName.", adresse = ".$adresse.", cat1 = ".$cat1.", cat2 = ".$cat2.", cat3 = ".$cat3.", imgHelpOwner = ".$aideImgAuteur.", imgHelpCR = ".$copyrightImg.", videoHelpOwner = ".$aideVideoAuteur.", videoHelpCR = ".$copyrightVideo.", audioHelpOwner = ".$aideSonAuteur.", audioHelpCR = ".$copyrightSon.", etat = 'moderer' WHERE id = ".$id;
		
		if (!$req->execute()) {
		    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
		}

		$req->close();

		// on update le zip
		updateZipFile(3,$aideImgName,$aideVidName,$aideSonName,$lieu,$titreFrise,$aideExtImg,$aideTxt,$id);

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