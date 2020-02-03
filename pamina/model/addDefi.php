 <?php

 	include("../connexion/logs.php");

 	session_start();	
 	unset($_SESSION['error']);
	require_once("../connexion/SQLconnect.php");
	require("../connexion/PassHash.php");

	// Log SQL
	$SQLrequest = '';
	$filename = '../SQLcustomLog.txt';

	// Message d'erreur
	$extensionFr = "Veuillez vérifier les extensions de vos fichiers ! Seuls les .jpg ou les .png sont acceptés.";
	$extensionDe = "Bitte die Dateiendungen überprüfen (nur .jpg oder png möglich).";

	$file_sizeFr = "Vos fichiers sont trop lourds ! Veuillez réduire leurs tailles.";
	$file_sizeDe = "Die Dateien sind zu groß ; bitte die Größe reduzieren!";


	//récupération des valeurs du formulaire table utilisateur
	$etat = "moderer";
	$dateInsertion = date("Y/m/d");
	$createurId = htmlspecialchars($_SESSION['user']['id']);
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
	// $image = ...;
	// $avatar = ...;
	$typeDefi = htmlspecialchars($_POST['defType']);

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
	

	// fonction pour le zip de l'aide au défi
	function createZipFile($type,$imgAide,$videoAide,$sonAide,$lieu,$question,$aideExtImg,$aideTxt,$ID) {
		// on déplace les éléments dans le dossier download
		if ($type == 1) {
			// @typeName Nom du dossier dans download
			$typeName = "QCM";
			var_dump($imgAide);
			// on récupère image/video/son
			if (is_file('../uploadDefi/aide/img/'.$imgAide)) {
				copy('../uploadDefi/aide/img/'.$imgAide, '../download/'.$typeName.'/'.$imgAide);
			}
			if (is_file('../uploadDefi/aide/video/'.$videoAide)) {
				copy('../uploadDefi/aide/video/'.$videoAide, '../download/'.$typeName.'/'.$videoAide);
			}
			if (is_file('../uploadDefi/aide/son/'.$sonAide)) {
				copy('../uploadDefi/aide/son/'.$sonAide, '../download/'.$typeName.'/'.$sonAide);
			}
		}
		if ($type == 2) {
			// @typeName Nom du dossier dans download
			$typeName = "VocaTxt";
			// on récupère image/video/son
			if (is_file('../uploadDefi/aide/img/'.$imgAide)) {
				copy('../uploadDefi/aide/img/'.$imgAide, '../download/'.$typeName.'/'.$imgAide);
			}
			if (is_file('../uploadDefi/aide/video/'.$videoAide)) {
				copy('../uploadDefi/aide/video/'.$videoAide, '../download/'.$typeName.'/'.$videoAide);
			}
			if (is_file('../uploadDefi/aide/son/'.$sonAide)) {
				copy('../uploadDefi/aide/son/'.$sonAide, '../download/'.$typeName.'/'.$sonAide);
			}
		}
		if ($type == 3) {
			// @typeName Nom du dossier dans download
			$typeName = "Frise";
			// on récupère image/video/son
			if (is_file('../uploadDefi/FriseChrono/aide/img/'.$imgAide)) {
				copy('../uploadDefi/FriseChrono/aide/img/'.$imgAide, '../download/'.$typeName.'/'.$imgAide);
			}
			if (is_file('../uploadDefi/FriseChrono/aide/video/'.$videoAide)) {
				copy('../uploadDefi/FriseChrono/aide/video/'.$videoAide, '../download/'.$typeName.'/'.$videoAide);
			}
			if (is_file('../uploadDefi/FriseChrono/aide/son/'.$sonAide)) {
				copy('../uploadDefi/FriseChrono/aide/son/'.$sonAide, '../download/'.$typeName.'/'.$sonAide);
			}
		}
		if ($type == 4) {
			// @typeName Nom du dossier dans download
			$typeName = "TexteTrou";
			// on récupère image/video/son
			if (is_file('../uploadDefi/TexteTrou/aide/img/'.$imgAide)) {
				copy('../uploadDefi/TexteTrou/aide/img/'.$imgAide, '../download/'.$typeName.'/'.$imgAide);
			}
			if (is_file('../uploadDefi/TexteTrou/aide/video/'.$videoAide)) {
				copy('../uploadDefi/TexteTrou/aide/video/'.$videoAide, '../download/'.$typeName.'/'.$videoAide);
			}
			if (is_file('../uploadDefi/TexteTrou/aide/son/'.$sonAide)) {
				copy('../uploadDefi/TexteTrou/aide/son/'.$sonAide, '../download/'.$typeName.'/'.$sonAide);
			}
		}
		if ($type == 5) {
			// @typeName Nom du dossier dans download
			$typeName = "Classement";
			// on récupère image/video/son
			if (is_file('../uploadDefi/Classement/aide/img/'.$imgAide)) {
				copy('../uploadDefi/Classement/aide/img/'.$imgAide, '../download/'.$typeName.'/'.$imgAide);
			}
			if (is_file('../uploadDefi/Classement/aide/video/'.$videoAide)) {
				copy('../uploadDefi/Classement/aide/video/'.$videoAide, '../download/'.$typeName.'/'.$videoAide);
			}
			if (is_file('../uploadDefi/Classement/aide/son/'.$sonAide)) {
				copy('../uploadDefi/Classement/aide/son/'.$sonAide, '../download/'.$typeName.'/'.$sonAide);
			}
		}


			// on crée le fichier html
			$myfile = fopen("../download/".$typeName."/monAide.html", "w") or die("Unable to open file!");

			$txt = "<!DOCTYPE html>\n<html>\n<head>\n<title>Fiche d'aide</title>\n<link href='files/aideDefi.css' rel='stylesheet' type='text/css'>\n<link href='https://fonts.googleapis.com/css?family=Unkempt:400,700' rel='stylesheet'>\n</head>\n<body>\n";
			$txt .= '<div id="aidePopup"><img onclick="" style="position: absolute;left: 94%;width: 6%;" src="files/croix.png"><div id="headHelp"><div id="lieuHelp">'.$lieu;
			$txt .= '<img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="files/logos-PAMINA.png"></div><div id="edHelp">Pamina</div></div>';
			$txt .= '<div id="bodyHelp"><div id="questionHelp">'.$question.'</div><div id="imgsHelp">';

			if ($aideExtImg != null) {
				if ($aideExtImg == "pdf") {
					$txt .= "<object width='100%' data='files/".$imgAide."' type='application/pdf'></object>";
				}else{
					$txt .= "<img style='width: 220px;height: 160px;background-color: red;margin-right: 10%;' src='files/".$imgAide."'></img>";
				}

			}

			$txt .= "</div>";
			$txt .= "<div id='txtHelp'>".$aideTxt."</div>";
			$txt .= "<div id='mediaHelp'>";
				if ($videoAide != null) {
					$txt .= "<video width='260px' src='files/".$videoAide."' controls>Veuillez mettre à jour votre navigateur !</video>";
				}
				if ($sonAide != null) {
					$txt .= "<audio style='width:35%;' src='files/".$sonAide."' controls>Veuillez mettre à jour votre navigateur !</audio>";
				}
			$txt .= "</div></div>";
			$txt .= '<div id="footerHelp"></div>';

			$txt .= '</body></html>';
			fwrite($myfile, $txt);
			fclose($myfile);
			chmod("../download/".$typeName."/monAide.html", 0777);

		// on zipe tous les fichiers
		$zip = new ZipArchive();
		$filename = "../download/".$typeName."/".$typeName.$ID.".zip";

		if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
		    exit("Impossible d'ouvrir le fichier <$filename>\n");
		}

		$zip->addFile("../download/".$typeName."/aideDefi.css","Aide/files/aideDefi.css");
		$zip->addFile("../download/".$typeName."/bt_dwl.png","Aide/files/bt_dwl.png");
		$zip->addFile("../download/".$typeName."/croix.png","Aide/files/croix.png");
		$zip->addFile("../download/".$typeName."/logos-PAMINA.png","Aide/files/logos-PAMINA.png");
		
		if (is_file("../download/".$typeName."/".$imgAide)) {
			$zip->addFile("../download/".$typeName."/".$imgAide,"Aide/files/".$imgAide);
		}
		if (is_file("../download/".$typeName."/".$videoAide)) {
			$zip->addFile("../download/".$typeName."/".$videoAide,"Aide/files/".$videoAide);
		}
		if (is_file("../download/".$typeName."/".$sonAide)) {
			$zip->addFile("../download/".$typeName."/".$sonAide,"Aide/files/".$sonAide);
		}
		if (file_exists("../download/".$typeName."/monAide.html")) {
			$zip->addFile("../download/".$typeName."/monAide.html","Aide/monAide.html");
		}

		$zip->close();

		// on supprime les éléments ajoutés dans le zip du serveur
		if (is_file("../download/".$typeName."/".$imgAide)) {
			unlink("../download/".$typeName."/".$imgAide);
		}
		if (is_file("../download/".$typeName."/".$videoAide)) {
			unlink("../download/".$typeName."/".$videoAide);
		}
		if (is_file("../download/".$typeName."/".$sonAide)) {
			unlink("../download/".$typeName."/".$sonAide);
		}
		unlink("../download/".$typeName."/monAide.html");
		
	}
	// --------------Fin fonction------------------

	// if QCM alors
	if ($typeDefi == "QCM") {
		$titreQuestion = htmlspecialchars($_POST['titleQuest']);
		$question = htmlspecialchars($_POST['question']);
		$reponse1 = htmlspecialchars($_POST['rep1']);
		$reponse2 = htmlspecialchars($_POST['rep2']);
		$reponse3 = htmlspecialchars($_POST['rep3']);
		$reponse4 = htmlspecialchars($_POST['rep4']);
		$reponse5 = htmlspecialchars($_POST['rep5']);
		$reponseCorrecte = htmlspecialchars($_POST['correct']);
		// propriétaire/copyright image QCM
		$ImgAuteur = htmlspecialchars($_POST['ImgAuteur']);
		
		if (empty($_POST['copyrightImgQcm'])) {
			$copyrightImgQcm = null;
		}else{
			$copyrightImgQcm = htmlspecialchars($_POST['copyrightImgQcm']);
		}
		
		$aideOk = true;

		// image principale
		$imgName = NULL;
		if (isset($_FILES['imageDefi'])) {

			// 10MO*1048576
			if ($_FILES['imageDefi']['size'] > 10485760) {
				$_SESSION['etat'] = false;
				$_SESSION['errorFR'] = $file_sizeFr;
				$_SESSION['errorDE'] = $file_sizeDe;
				header('Location: ../vue/ajoutDefi.php');
				exit("Size error");
			}

			if ($_FILES['imageDefi']['size'] != 0 && $_FILES['imageDefi']['name'] != ""){
				$extension  = pathinfo($_FILES['imageDefi']['name'], PATHINFO_EXTENSION);

				if ($extension != "png" && $extension != "jpg" && $extension != "PNG" && $extension != "JPG" && $extension != "pdf") {
 					$_SESSION['errorFR'] = $extensionFr;
 					$_SESSION['errorDE'] = $extensionDe;
 					$aideOk = false;
				}else{
					$imgName = md5(uniqid()).'.'.$extension;
					move_uploaded_file($_FILES['imageDefi']['tmp_name'], '../uploadDefi/defi/'.$imgName);
				}
			}
		}

		// -----!AIDE AU DEFI-----
		if (!empty($_POST['editor'])) {
			$aideTxt = $_POST['editor'];
			// $aideTxt = htmlspecialchars($_POST['aideTxt']);
		}else{
			$aideTxt = NULL;
		}

		// image
		$aideImgName = NULL;
		// A ajouter pour le zip
		$aideExtImg = NULL;
		if (isset($_FILES['aideImg'])) {

			// 1MO*1048576
			if ($_FILES['aideImg']['size'] > 1048576) {
				$_SESSION['etat'] = false;
				$_SESSION['errorFR'] = $file_sizeFr;
				$_SESSION['errorDE'] = $file_sizeDe;
				header('Location: ../vue/ajoutDefi.php');
				exit("Size error");
			}

			if ($_FILES['aideImg']['size'] != 0 && $_FILES['aideImg']['name'] != "") {
				$aideExtImg  = pathinfo($_FILES['aideImg']['name'], PATHINFO_EXTENSION);

				if ($aideExtImg != "png" && $aideExtImg != "jpg" && $aideExtImg != "PNG" && $aideExtImg != "JPG" && $aideExtImg != "pdf") {
					$_SESSION['errorFR'] = $extensionFr;
					$_SESSION['errorDE'] = $extensionDe;
					$aideOk = false;
				}else{
					$aideImgName = md5(uniqid()).'.'.$aideExtImg;
					move_uploaded_file($_FILES['aideImg']['tmp_name'], '../uploadDefi/aide/img/'.$aideImgName);
				}
			}
		}

		// video
		$aideVidName = NULL;
		if (isset($_FILES['aideVideo'])) {
			if ($_FILES['aideVideo']['size'] != 0 && $_FILES['aideVideo']['name'] != "") {
				$aideExtVid  = pathinfo($_FILES['aideVideo']['name'], PATHINFO_EXTENSION);

				if ($aideExtVid != "mp4") {
					$_SESSION['errorFR'] = $extensionFr;
					$_SESSION['errorDE'] = $extensionDe;
					$aideOk = false;
				}else {
					$aideVidName = md5(uniqid()).'.'.$aideExtVid;
					move_uploaded_file($_FILES['aideVideo']['tmp_name'], '../uploadDefi/aide/video/'.$aideVidName);
				}
			}
		}

		// son
		$aideSonName = NULL;
		if (isset($_FILES['aideSon'])) {
			if ($_FILES['aideSon']['size'] != 0 && $_FILES['aideSon']['name'] != "") {
				$aideExtSon  = pathinfo($_FILES['aideSon']['name'], PATHINFO_EXTENSION);

				if ($aideExtSon != "mp3") {
					$_SESSION['errorFR'] = $extensionFr;
					$_SESSION['errorDE'] = $extensionDe;
					$aideOk = false;
				}else {
					$aideSonName = md5(uniqid()).'.'.$aideExtSon;
					move_uploaded_file($_FILES['aideSon']['tmp_name'], '../uploadDefi/aide/son/'.$aideSonName);
				}
			}
		}

		// -----AIDE AU DEFI!-----
		//-----------------------------------------------//
		// vérifie que tous les champs sont remplit
	    if( !empty($_POST['ed']) && !empty($_POST['langueDef']) && !empty($_POST['lieu']) && !empty($_POST['color']) && !empty($_POST['defType']) && !empty($_POST['titleQuest']) && !empty($_POST['question']) && !empty($_POST['rep1']) && !empty($_POST['rep2']) && !empty($_POST['rep3']) && !empty($_POST['rep4']) && !empty($_POST['rep5']) && !empty($_POST['correct']) && $aideOk ){
	      	//ajout à la base QCM
			if (!($req = $con->prepare("INSERT INTO QCM (ed, langue_defi, lieu, region, image, titre_question, question, reponse1, reponse2, reponse3, reponse4, reponse5, nb_reponse_juste, helpTxt, adresse, helpImg, helpVideo, helpAudio, cat1, cat2, cat3, createur_id, date_defi, imgQcmOwner, imgQcmCR, imgHelpOwner, imgHelpCR, videoHelpOwner, videoHelpCR, audioHelpOwner, audioHelpCR, etat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
			    echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			if (!$req->bind_param("ssssssssssssissssssssissssssssss", $ED, $langueDefi, $lieu, $couleur, $imgName, $titreQuestion, $question, $reponse1, $reponse2, $reponse3, $reponse4, $reponse5, $reponseCorrecte, $aideTxt, $adresse, $aideImgName, $aideVidName, $aideSonName, $cat1, $cat2, $cat3, $createurId, $dateInsertion, $ImgAuteur, $copyrightImgQcm, $aideImgAuteur, $copyrightImg, $aideVideoAuteur, $copyrightVideo, $aideSonAuteur, $copyrightSon, $etat)) {
			    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
			}
			// LOGS
			$SQLrequest = "INSERT INTO QCM (ed, langue_defi, lieu, region, image, titre_question, question, reponse1, reponse2, reponse3, reponse4, reponse5, nb_reponse_juste, helpTxt, adresse, helpImg, helpVideo, helpAudio, cat1, cat2, cat3, createur_id, date_defi, imgQcmOwner, imgQcmCR, imgHelpOwner, imgHelpCR, videoHelpOwner, videoHelpCR, audioHelpOwner, audioHelpCR, etat) VALUES (". $ED.", ".$langueDefi.", ".$lieu.", ".$couleur.", ".$imgName.", ".$titreQuestion.", ".$question.", ".$reponse1.", ".$reponse2.", ".$reponse3.", ".$reponse4.", ".$reponse5.", ".$reponseCorrecte.", ".$aideTxt.", ".$adresse.", ".$aideImgName.", ".$aideVidName.", ".$aideSonName.", ".$cat1.", ".$cat2.", ".$cat3.", ".$createurId.", ".$dateInsertion.", ".$ImgAuteur.", ".$copyrightImgQcm.", ".$aideImgAuteur.", ".$copyrightImg.", ".$aideVideoAuteur.", ".$copyrightVideo.", ".$aideSonAuteur.", ".$copyrightSon.", ".$etat.")";

			if (!$req->execute()) {
			    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
			}else{
				// A ajouter pour le zip
				$ID = $req->insert_id;
			}

			
			$req->close();

			// on crée le zip
			createZipFile(1,$aideImgName,$aideVidName,$aideSonName,$lieu,$question,$aideExtImg,$aideTxt,$ID);

			// message de succès['etat']
			$_SESSION['etat'] = true;

	    }else {
	    	// message d'erreur
	    	if (!isset($_SESSION['etat'])) {
	    		$_SESSION['etat'] = false;
	    	}
	    }
	    //-----------------------------------------------//
	}





	// if vocale alors
	if ($typeDefi == "vocale") {
		$titreQuestion = htmlspecialchars($_POST['titleQuestVocaTxt']);
		$question = htmlspecialchars($_POST['questionVocaTxt']);
		$repVocaTxt = htmlspecialchars($_POST['repVocale']);
		$motsCles = htmlspecialchars($_POST['repCle']);

		$aideOk = true;

		// -----!AIDE AU DEFI-----
		if (!empty($_POST['editorVocaTxt'])) {
			$aideTxt = $_POST['editorVocaTxt'];
			// $aideTxt = htmlspecialchars($_POST['aideTxt']);
		}else{
			$aideTxt = NULL;
		}

		// aide img vocal
		$aideImgName = NULL;
		$aideExtImg = NULL;
		if (isset($_FILES['aideImgVocaTxt'])) {

			// 1MO*1048576
			if ($_FILES['aideImgVocaTxt']['size'] > 1048576) {
				$_SESSION['etat'] = false;
				$_SESSION['errorFR'] = $file_sizeFr;
				$_SESSION['errorDE'] = $file_sizeDe;
				header('Location: ../vue/ajoutDefi.php');
				exit("Size error");
			}

			if ($_FILES['aideImgVocaTxt']['size'] != 0 && $_FILES['aideImgVocaTxt']['name'] != "") {
				$aideExtImg  = pathinfo($_FILES['aideImgVocaTxt']['name'], PATHINFO_EXTENSION);

				if ($aideExtImg != "png" && $aideExtImg != "jpg" && $aideExtImg != "PNG" && $aideExtImg != "JPG" && $aideExtImg != "pdf") {
					$_SESSION['errorFR'] = $extensionFr;
					$_SESSION['errorDE'] = $extensionDe;
					$aideOk = false;
				}else{
					$aideImgName = md5(uniqid()).'.'.$aideExtImg;
					move_uploaded_file($_FILES['aideImgVocaTxt']['tmp_name'], '../uploadDefi/aide/img/'.$aideImgName);
				}
			}
		}

		// aide video vocal
		$aideVidName = NULL;
		if (isset($_FILES['aideVideoVocaTxt'])) {
			if ($_FILES['aideVideoVocaTxt']['size'] != 0 && $_FILES['aideVideoVocaTxt']['name'] != "") {
				$aideExtVid  = pathinfo($_FILES['aideVideoVocaTxt']['name'], PATHINFO_EXTENSION);

				if ( $aideExtVid != "mp4" ) {
					$_SESSION['errorFR'] = $extensionFr;
					$_SESSION['errorDE'] = $extensionDe;
					$aideOk = false;
				}else {
					$aideVidName = md5(uniqid()).'.'.$aideExtVid;
					move_uploaded_file($_FILES['aideVideoVocaTxt']['tmp_name'], '../uploadDefi/aide/video/'.$aideVidName);
				}
			}
		}

		// aide son vocal
		$aideSonName = NULL;
		if (isset($_FILES['aideSonVocaTxt'])) {
			if ($_FILES['aideSonVocaTxt']['size'] != 0 && $_FILES['aideSonVocaTxt']['name'] != "") {
				$aideExtSon  = pathinfo($_FILES['aideSonVocaTxt']['name'], PATHINFO_EXTENSION);

				if ($aideExtSon != "mp3") {
					$_SESSION['errorFR'] = $extensionFr;
					$_SESSION['errorDE'] = $extensionDe;
					$aideOk = false;
				}else {
					$aideSonName = md5(uniqid()).'.'.$aideExtSon;
					move_uploaded_file($_FILES['aideSonVocaTxt']['tmp_name'], '../uploadDefi/aide/son/'.$aideSonName);
				}
			}
		}

		// -----AIDE AU DEFI!-----
		//-----------------------------------------------//
		// vérifie que tous les champs sont remplit
	    if( !empty($_POST['ed']) && !empty($_POST['langueDef']) && !empty($_POST['lieu']) && !empty($_POST['color']) && !empty($_POST['defType']) && !empty($_POST['titleQuestVocaTxt']) && !empty($_POST['questionVocaTxt']) && !empty($_POST['repVocale']) && !empty($_POST['repCle']) && $aideOk ){
	      	//ajout à la base VocalTexte
			if (!($req = $con->prepare("INSERT INTO VocalTexte (ed, langue_defi, lieu, region, titre_question, question, reponse, mot_cles, helpTxt, adresse, helpImg, helpVideo, helpAudio, cat1, cat2, cat3, createur_id, date_defi, imgHelpOwner, imgHelpCR, videoHelpOwner, videoHelpCR, audioHelpOwner, audioHelpCR, etat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
			    echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			if (!$req->bind_param("ssssssssssssssssissssssss", $ED, $langueDefi, $lieu, $couleur, $titreQuestion, $question, $repVocaTxt, $motsCles, $aideTxt, $adresse, $aideImgName, $aideVidName, $aideSonName, $cat1, $cat2, $cat3, $createurId, $dateInsertion, $aideImgAuteur, $copyrightImg, $aideVideoAuteur, $copyrightVideo, $aideSonAuteur, $copyrightSon, $etat)) {
			    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
			}
			// LOGS
			$SQLrequest = "INSERT INTO VocalTexte (ed, langue_defi, lieu, region, titre_question, question, reponse, mot_cles, helpTxt, adresse, helpImg, helpVideo, helpAudio, cat1, cat2, cat3, createur_id, date_defi, imgHelpOwner, imgHelpCR, videoHelpOwner, videoHelpCR, audioHelpOwner, audioHelpCR, etat) VALUES (". $ED.", ".$langueDefi.", ".$lieu.", ".$couleur.", ".$titreQuestion.", ".$question.", ".$repVocaTxt.", ".$motsCles.", ".$aideTxt.", ".$adresse.", ".$aideImgName.", ".$aideVidName.", ".$aideSonName.", ".$cat1.", ".$cat2.", ".$cat3.", ".$createurId.", ".$dateInsertion.", ".$ImgAuteur.", ".$copyrightImgQcm.", ".$aideImgAuteur.", ".$copyrightImg.", ".$aideVideoAuteur.", ".$copyrightVideo.", ".$aideSonAuteur.", ".$copyrightSon.", ".$etat.")";
			
			if (!$req->execute()) {
			    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
			}else{
				// A ajouter pour le zip
				$ID = $req->insert_id;
			}

			$req->close();

			// on crée le zip
			createZipFile(2,$aideImgName,$aideVidName,$aideSonName,$lieu,$question,$aideExtImg,$aideTxt,$ID);

			// message de succès['etat']
			$_SESSION['etat'] = true;

	    }else {
	    	// message d'erreur
	    	if (!isset($_SESSION['etat'])) {
	    		$_SESSION['etat'] = false;
	    	}
	    }
	    //-----------------------------------------------//

	}

	// if frise alors
	if ($typeDefi == "frise") {
		$dateDebFrise = htmlspecialchars($_POST['dateDebFrise']);
		$dateFinFrise = htmlspecialchars($_POST['dateFinFrise']);
		$titreFrise = htmlspecialchars($_POST['titreFrise']);
		// les 6 vignettes
		$eventName1 = htmlspecialchars($_POST['eventName1']);
		$eventDate1 = htmlspecialchars($_POST['eventDate1']);

		// image
		$eventImg1 = NULL;
		if (isset($_FILES['eventImg1'])) {

			// 1MO*1048576
			if ($_FILES['eventImg1']['size'] > 1048576) {
				$_SESSION['etat'] = false;
				$_SESSION['errorFR'] = $file_sizeFr;
				$_SESSION['errorDE'] = $file_sizeDe;
				header('Location: ../vue/ajoutDefi.php');
				exit("Size error");
			}

			if ($_FILES['eventImg1']['size'] != 0 && $_FILES['eventImg1']['name'] != "") {
				$aideExtImg  = pathinfo($_FILES['eventImg1']['name'], PATHINFO_EXTENSION);

				if ($aideExtImg != "png" && $aideExtImg != "jpg" && $aideExtImg != "PNG" && $aideExtImg != "JPG" && $aideExtImg != "pdf") {
					$_SESSION['errorFR'] = $extensionFr;
					$_SESSION['errorDE'] = $extensionDe;
					$aideOk = false;
				}else{
					$eventImg1 = md5(uniqid()).'.'.$aideExtImg;
					move_uploaded_file($_FILES['eventImg1']['tmp_name'], '../uploadDefi/FriseChrono/'.$eventImg1);
				}
			}
		}

		// Copyright
		$eventImg1Auteur = htmlspecialchars($_POST['eventImg1Auteur']);
		$copyrightEventImg1 = htmlspecialchars($_POST['copyrightEventImg1']);

		$eventName2 = htmlspecialchars($_POST['eventName2']);
		$eventDate2 = htmlspecialchars($_POST['eventDate2']);
		// image
		$eventImg2 = NULL;
		if (isset($_FILES['eventImg2'])) {

			// 1MO*1048576
			if ($_FILES['eventImg2']['size'] > 1048576) {
				$_SESSION['etat'] = false;
				$_SESSION['errorFR'] = $file_sizeFr;
				$_SESSION['errorDE'] = $file_sizeDe;
				header('Location: ../vue/ajoutDefi.php');
				exit("Size error");
			}

			if ($_FILES['eventImg2']['size'] != 0 && $_FILES['eventImg2']['name'] != "") {
				$aideExtImg  = pathinfo($_FILES['eventImg2']['name'], PATHINFO_EXTENSION);

				if ($aideExtImg != "png" && $aideExtImg != "jpg" && $aideExtImg != "PNG" && $aideExtImg != "JPG" && $aideExtImg != "pdf") {
					$_SESSION['errorFR'] = $extensionFr;
					$_SESSION['errorDE'] = $extensionDe;
					$aideOk = false;
				}else{
					$eventImg2 = md5(uniqid()).'.'.$aideExtImg;
					move_uploaded_file($_FILES['eventImg2']['tmp_name'], '../uploadDefi/FriseChrono/'.$eventImg2);
				}
			}
		}

		// Copyright
		$eventImg2Auteur = htmlspecialchars($_POST['eventImg2Auteur']);
		$copyrightEventImg2 = htmlspecialchars($_POST['copyrightEventImg2']);

		$eventName3 = htmlspecialchars($_POST['eventName3']);
		$eventDate3 = htmlspecialchars($_POST['eventDate3']);
		// image
		$eventImg3 = NULL;
		if (isset($_FILES['eventImg3'])) {

			// 1MO*1048576
			if ($_FILES['eventImg3']['size'] > 1048576) {
				$_SESSION['etat'] = false;
				$_SESSION['errorFR'] = $file_sizeFr;
				$_SESSION['errorDE'] = $file_sizeDe;
				header('Location: ../vue/ajoutDefi.php');
				exit("Size error");
			}

			if ($_FILES['eventImg3']['size'] != 0 && $_FILES['eventImg3']['name'] != "") {
				$aideExtImg  = pathinfo($_FILES['eventImg3']['name'], PATHINFO_EXTENSION);

				if ($aideExtImg != "png" && $aideExtImg != "jpg" && $aideExtImg != "PNG" && $aideExtImg != "JPG" && $aideExtImg != "pdf") {
					$_SESSION['errorFR'] = $extensionFr;
					$_SESSION['errorDE'] = $extensionDe;
					$aideOk = false;
				}else{
					$eventImg3 = md5(uniqid()).'.'.$aideExtImg;
					move_uploaded_file($_FILES['eventImg3']['tmp_name'], '../uploadDefi/FriseChrono/'.$eventImg3);
				}
			}
		}

		// Copyright
		$eventImg3Auteur = htmlspecialchars($_POST['eventImg3Auteur']);
		$copyrightEventImg3 = htmlspecialchars($_POST['copyrightEventImg3']);

		$eventName4 = htmlspecialchars($_POST['eventName4']);
		$eventDate4 = htmlspecialchars($_POST['eventDate4']);
		// image
		$eventImg4 = NULL;
		if (isset($_FILES['eventImg4'])) {

			// 1MO*1048576
			if ($_FILES['eventImg4']['size'] > 1048576) {
				$_SESSION['etat'] = false;
				$_SESSION['errorFR'] = $file_sizeFr;
				$_SESSION['errorDE'] = $file_sizeDe;
				header('Location: ../vue/ajoutDefi.php');
				exit("Size error");
			}

			if ($_FILES['eventImg4']['size'] != 0 && $_FILES['eventImg4']['name'] != "") {
				$aideExtImg  = pathinfo($_FILES['eventImg4']['name'], PATHINFO_EXTENSION);

				if ($aideExtImg != "png" && $aideExtImg != "jpg" && $aideExtImg != "PNG" && $aideExtImg != "JPG" && $aideExtImg != "pdf") {
					$_SESSION['errorFR'] = $extensionFr;
					$_SESSION['errorDE'] = $extensionDe;
					$aideOk = false;
				}else{
					$eventImg4 = md5(uniqid()).'.'.$aideExtImg;
					move_uploaded_file($_FILES['eventImg4']['tmp_name'], '../uploadDefi/FriseChrono/'.$eventImg4);
				}
			}
		}

		// Copyright
		$eventImg4Auteur = htmlspecialchars($_POST['eventImg4Auteur']);
		$copyrightEventImg4 = htmlspecialchars($_POST['copyrightEventImg4']);

		$eventName5 = htmlspecialchars($_POST['eventName5']);
		$eventDate5 = htmlspecialchars($_POST['eventDate5']);
		// image
		$eventImg5 = NULL;
		if (isset($_FILES['eventImg5'])) {

			// 1MO*1048576
			if ($_FILES['eventImg5']['size'] > 1048576) {
				$_SESSION['etat'] = false;
				$_SESSION['errorFR'] = $file_sizeFr;
				$_SESSION['errorDE'] = $file_sizeDe;
				header('Location: ../vue/ajoutDefi.php');
				exit("Size error");
			}

			if ($_FILES['eventImg5']['size'] != 0 && $_FILES['eventImg5']['name'] != "") {
				$aideExtImg  = pathinfo($_FILES['eventImg5']['name'], PATHINFO_EXTENSION);

				if ($aideExtImg != "png" && $aideExtImg != "jpg" && $aideExtImg != "PNG" && $aideExtImg != "JPG" && $aideExtImg != "pdf") {
					$_SESSION['errorFR'] = $extensionFr;
					$_SESSION['errorDE'] = $extensionDe;
					$aideOk = false;
				}else{
					$eventImg5 = md5(uniqid()).'.'.$aideExtImg;
					move_uploaded_file($_FILES['eventImg5']['tmp_name'], '../uploadDefi/FriseChrono/'.$eventImg5);
				}
			}
		}

		// Copyright
		$eventImg5Auteur = htmlspecialchars($_POST['eventImg5Auteur']);
		$copyrightEventImg5 = htmlspecialchars($_POST['copyrightEventImg5']);

		$eventName6 = htmlspecialchars($_POST['eventName6']);
		$eventDate6 = htmlspecialchars($_POST['eventDate6']);
		// image
		$eventImg6 = NULL;
		if (isset($_FILES['eventImg6'])) {

			// 1MO*1048576
			if ($_FILES['eventImg6']['size'] > 1048576) {
				$_SESSION['etat'] = false;
				$_SESSION['errorFR'] = $file_sizeFr;
				$_SESSION['errorDE'] = $file_sizeDe;
				header('Location: ../vue/ajoutDefi.php');
				exit("Size error");
			}

			if ($_FILES['eventImg6']['size'] != 0 && $_FILES['eventImg6']['name'] != "") {
				$aideExtImg  = pathinfo($_FILES['eventImg6']['name'], PATHINFO_EXTENSION);

				if ($aideExtImg != "png" && $aideExtImg != "jpg" && $aideExtImg != "PNG" && $aideExtImg != "JPG" && $aideExtImg != "pdf") {
					$_SESSION['errorFR'] = $extensionFr;
					$_SESSION['errorDE'] = $extensionDe;
					$aideOk = false;
				}else{
					$eventImg6 = md5(uniqid()).'.'.$aideExtImg;
					move_uploaded_file($_FILES['eventImg6']['tmp_name'], '../uploadDefi/FriseChrono/'.$eventImg6);
				}
			}
		}

		// Copyright
		$eventImg6Auteur = htmlspecialchars($_POST['eventImg6Auteur']);
		$copyrightEventImg6 = htmlspecialchars($_POST['copyrightEventImg6']);

		$aideOk = true;

		// -----!AIDE AU DEFI-----
		if (!empty($_POST['editorFrise'])) {
			$aideTxt = $_POST['editorFrise'];
			// $aideTxt = htmlspecialchars($_POST['aideTxt']);
		}else{
			$aideTxt = NULL;
		}
		
		$aideImgName = NULL;
		$aideExtImg = NULL;
		if (isset($_FILES['aideImgFrise'])) {

			// 1MO*1048576
			if ($_FILES['aideImgFrise']['size'] > 1048576) {
				$_SESSION['etat'] = false;
				$_SESSION['errorFR'] = $file_sizeFr;
				$_SESSION['errorDE'] = $file_sizeDe;
				header('Location: ../vue/ajoutDefi.php');
				exit("Size error");
			}

			if ($_FILES['aideImgFrise']['size'] != 0 && $_FILES['aideImgFrise']['name'] != "") {
				$aideExtImg  = pathinfo($_FILES['aideImgFrise']['name'], PATHINFO_EXTENSION);

				if ($aideExtImg != "png" && $aideExtImg != "jpg" && $aideExtImg != "PNG" && $aideExtImg != "JPG" && $aideExtImg != "pdf") {
					$_SESSION['errorFR'] = $extensionFr;
					$_SESSION['errorDE'] = $extensionDe;
					$aideOk = false;
				}else{
					$aideImgName = md5(uniqid()).'.'.$aideExtImg;
					move_uploaded_file($_FILES['aideImgFrise']['tmp_name'], '../uploadDefi/FriseChrono/aide/img/'.$aideImgName);
				}
			}
		}

		$aideVidName = NULL;
		if (isset($_FILES['aideVideoFrise'])) {
			if ($_FILES['aideVideoFrise']['size'] != 0 && $_FILES['aideVideoFrise']['name'] != "") {
				$aideExtVid  = pathinfo($_FILES['aideVideoFrise']['name'], PATHINFO_EXTENSION);

				if ( $aideExtVid != "mp4" ) {
					$_SESSION['errorFR'] = $extensionFr;
					$_SESSION['errorDE'] = $extensionDe;
					$aideOk = false;
				}else {
					$aideVidName = md5(uniqid()).'.'.$aideExtVid;
					move_uploaded_file($_FILES['aideVideoFrise']['tmp_name'], '../uploadDefi/FriseChrono/aide/video/'.$aideVidName);
				}
			}
		}

		$aideSonName = NULL;
		if (isset($_FILES['aideSonFrise'])) {
			if ($_FILES['aideSonFrise']['size'] != 0 && $_FILES['aideSonFrise']['name'] != "") {
				$aideExtSon  = pathinfo($_FILES['aideSonFrise']['name'], PATHINFO_EXTENSION);

				if ($aideExtSon != "mp3") {
					$_SESSION['errorFR'] = $extensionFr;
					$_SESSION['errorDE'] = $extensionDe;
					$aideOk = false;
				}else {
					$aideSonName = md5(uniqid()).'.'.$aideExtSon;
					move_uploaded_file($_FILES['aideSonFrise']['tmp_name'], '../uploadDefi/FriseChrono/aide/son/'.$aideSonName);
				}
			}
		}

		// -----AIDE AU DEFI!-----
		//-----------------------------------------------//
		// vérifie que tous les champs sont remplit
	    if( !empty($_POST['ed']) && !empty($_POST['langueDef']) && !empty($_POST['lieu']) && !empty($_POST['color']) && !empty($_POST['defType']) && !empty($_POST['dateDebFrise']) && !empty($_POST['dateFinFrise']) && !empty($_POST['titreFrise']) && !empty($_POST['eventName1']) && !empty($_POST['eventDate1']) && !empty($_FILES['eventImg1']) && !empty($_POST['eventName2']) && !empty($_POST['eventDate2']) && !empty($_FILES['eventImg2']) && !empty($_POST['eventName3']) && !empty($_POST['eventDate3']) && !empty($_FILES['eventImg3']) && !empty($_POST['eventName4']) && !empty($_POST['eventDate4']) && !empty($_FILES['eventImg4']) && !empty($_POST['eventName5']) && !empty($_POST['eventDate5']) && !empty($_FILES['eventImg5']) && !empty($_POST['eventName6']) && !empty($_POST['eventDate6']) && !empty($_FILES['eventImg6']) && $aideOk ){

	      	//ajout à la base FriseChrono
	      	
			if (!($req = $con->prepare("INSERT INTO FriseChrono (ed, langue_defi, lieu, region, titre_frise, date_debut, date_fin, item1_date, item1_title, item1_img, item1Owner, item1CR, item2_date, item2_title, item2_img, item2Owner, item2CR, item3_date, item3_title, item3_img, item3Owner, item3CR, item4_date, item4_title, item4_img, item4Owner, item4CR, item5_date, item5_title, item5_img, item5Owner, item5CR, item6_date, item6_title, item6_img, item6Owner, item6CR, helpTxt, adresse, helpImg, helpVideo, helpAudio, cat1, cat2, cat3, createur_id, date_defi, imgHelpOwner, imgHelpCR, videoHelpOwner, videoHelpCR, audioHelpOwner, audioHelpCR, etat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
			    echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			// 29 champs $eventImg1Auteur, $copyrightEventImg1,
			if (!$req->bind_param("sssssiiissssissssissssissssissssissssssssssssissssssss", $ED, $langueDefi, $lieu, $couleur, $titreFrise, $dateDebFrise, $dateFinFrise, $eventDate1, $eventName1, $eventImg1, $eventImg1Auteur, $copyrightEventImg1, $eventDate2, $eventName2, $eventImg2, $eventImg2Auteur, $copyrightEventImg2, $eventDate3, $eventName3, $eventImg3, $eventImg3Auteur, $copyrightEventImg3, $eventDate4, $eventName4, $eventImg4, $eventImg4Auteur, $copyrightEventImg4, $eventDate5, $eventName5, $eventImg5, $eventImg5Auteur, $copyrightEventImg5, $eventDate6, $eventName6, $eventImg6, $eventImg6Auteur, $copyrightEventImg6, $aideTxt, $adresse, $aideImgName, $aideVidName, $aideSonName, $cat1, $cat2, $cat3, $createurId, $dateInsertion, $aideImgAuteur, $copyrightImg, $aideVideoAuteur, $copyrightVideo, $aideSonAuteur, $copyrightSon, $etat)) {
			    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
			}
			// LOGS
			$SQLrequest = "INSERT INTO FriseChrono (ed, langue_defi, lieu, region, titre_frise, date_debut, date_fin, item1_date, item1_title, item1_img, item1Owner, item1CR, item2_date, item2_title, item2_img, item2Owner, item2CR, item3_date, item3_title, item3_img, item3Owner, item3CR, item4_date, item4_title, item4_img, item4Owner, item4CR, item5_date, item5_title, item5_img, item5Owner, item5CR, item6_date, item6_title, item6_img, item6Owner, item6CR, helpTxt, adresse, helpImg, helpVideo, helpAudio, cat1, cat2, cat3, createur_id, date_defi, imgHelpOwner, imgHelpCR, videoHelpOwner, videoHelpCR, audioHelpOwner, audioHelpCR, etat) VALUES (".$ED.", ".$langueDefi.", ".$lieu.", ".$couleur.", ".$titreFrise.", ".$dateDebFrise.", ".$dateFinFrise.", ".$eventDate1.", ".$eventName1.", ".$eventImg1.", ".$eventImg1Auteur.", ".$copyrightEventImg1.", ".$eventDate2.", ".$eventName2.", ".$eventImg2.", ".$eventImg2Auteur.", ".$copyrightEventImg2.", ".$eventDate3.", ".$eventName3.", ".$eventImg3.", ".$eventImg3Auteur.", ".$copyrightEventImg3.", ".$eventDate4.", ".$eventName4.", ".$eventImg4.", ".$eventImg4Auteur.", ".$copyrightEventImg4.", ".$eventDate5.", ".$eventName5.", ".$eventImg5.", ".$eventImg5Auteur.", ".$copyrightEventImg5.", ".$eventDate6.", ".$eventName6.", ".$eventImg6.", ".$eventImg6Auteur.", ".$copyrightEventImg6.", ".$aideTxt.", ".$adresse.", ".$aideImgName.", ".$aideVidName.", ".$aideSonName.", ".$cat1.", ".$cat2.", ".$cat3.", ".$createurId.", ".$dateInsertion.", ".$aideImgAuteur.", ".$copyrightImg.", ".$aideVideoAuteur.", ".$copyrightVideo.", ".$aideSonAuteur.", ".$copyrightSon.", ".$etat.")";
			
			if (!$req->execute()) {
			    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
			}else{
				// A ajouter pour le zip
				$ID = $req->insert_id;
			}

			$req->close();

			// on crée le zip
			createZipFile(3,$aideImgName,$aideVidName,$aideSonName,$lieu,$titreFrise,$aideExtImg,$aideTxt,$ID);

			// message de succès['etat']
			$_SESSION['etat'] = true;

	    }else {
	    	// message d'erreur
	    	if (!isset($_SESSION['etat'])) {
	    		$_SESSION['etat'] = false;
	    	}
	    }
	    //-----------------------------------------------//
	}

	// if texte à trou alors
	if ($typeDefi == "trou") {
		$titreQuestion = htmlspecialchars($_POST['titleQuestTxtTrou']);
		$question = htmlspecialchars($_POST['questionTxtTrou']);
		$TAT = htmlspecialchars($_POST['txtTrou']);

		$mot1 = null;$mot2 = null;$mot3 = null;$mot4 = null;$mot5 = null;$mot6 = null;$mot7 = null;$mot8 = null;$mot9 = null;$mot10 = null;

		$counterMots = 0;
		if ($_POST['inputTxtTrou1'] != null) {
			$mot1 = htmlspecialchars($_POST['inputTxtTrou1']);
			$counterMots++;
		}
		if ($_POST['inputTxtTrou2'] != null) {
			$mot2 = htmlspecialchars($_POST['inputTxtTrou2']);
			$counterMots++;
		}
		if ($_POST['inputTxtTrou3'] != null) {
			$mot3 = htmlspecialchars($_POST['inputTxtTrou3']);
			$counterMots++;
		}
		if ($_POST['inputTxtTrou4'] != null) {
			$mot4 = htmlspecialchars($_POST['inputTxtTrou4']);
			$counterMots++;
		}
		if ($_POST['inputTxtTrou5'] != null) {
			$mot5 = htmlspecialchars($_POST['inputTxtTrou5']);
			$counterMots++;
		}
		if ($_POST['inputTxtTrou6'] != null) {
			$mot6 = htmlspecialchars($_POST['inputTxtTrou6']);
			$counterMots++;
		}
		if ($_POST['inputTxtTrou7'] != null) {
			$mot7 = htmlspecialchars($_POST['inputTxtTrou7']);
			$counterMots++;
		}
		if ($_POST['inputTxtTrou8'] != null) {
			$mot8 = htmlspecialchars($_POST['inputTxtTrou8']);
			$counterMots++;
		}
		if ($_POST['inputTxtTrou9'] != null) {
			$mot9 = htmlspecialchars($_POST['inputTxtTrou9']);
			$counterMots++;
		}
		if ($_POST['inputTxtTrou10'] != null) {
			$mot10 = htmlspecialchars($_POST['inputTxtTrou10']);
			$counterMots++;
		}

		// on vérifie qu'il y a autant de mot que d'input
		$counterInput = substr_count($TAT, 'INPUT');

		$counterOk = false;
		if ($counterMots == $counterInput) {
			$i = 1;
			while (strpos($TAT, 'INPUT') !== false) {
				$TAT = preg_replace("/INPUT\d*/", '<input type="text" id="inputTrou'.$i.'" name="inputTrou'.$i.'">', $TAT, 1);
				$i++;
			}
			$counterOk = true;
		}

		$aideOk = true;

		// -----!AIDE AU DEFI-----
		if (!empty($_POST['editorTxtTrou'])) {
			$aideTxt = $_POST['editorTxtTrou'];
			// $aideTxt = htmlspecialchars($_POST['aideTxt']);
		}else{
			$aideTxt = NULL;
		}

		$aideImgName = NULL;
		$aideExtImg = NULL;
		if (isset($_FILES['aideImgTxtTrou'])) {

			// 1MO*1048576
			if ($_FILES['aideImgTxtTrou']['size'] > 1048576) {
				$_SESSION['etat'] = false;
				$_SESSION['errorFR'] = $file_sizeFr;
				$_SESSION['errorDE'] = $file_sizeDe;
				header('Location: ../vue/ajoutDefi.php');
				exit("Size error");
			}

			if ($_FILES['aideImgTxtTrou']['size'] != 0 && $_FILES['aideImgTxtTrou']['name'] != "") {
				$aideExtImg  = pathinfo($_FILES['aideImgTxtTrou']['name'], PATHINFO_EXTENSION);

				if ($aideExtImg != "png" && $aideExtImg != "jpg" && $aideExtImg != "PNG" && $aideExtImg != "JPG" && $aideExtImg != "pdf") {
					$_SESSION['errorFR'] = $extensionFr;
					$_SESSION['errorDE'] = $extensionDe;
					$aideOk = false;
				}else{
					$aideImgName = md5(uniqid()).'.'.$aideExtImg;
					move_uploaded_file($_FILES['aideImgTxtTrou']['tmp_name'], '../uploadDefi/TexteTrou/aide/img/'.$aideImgName);
				}
			}
		}

		$aideVidName = NULL;
		if (isset($_FILES['aideVideoTxtTrou'])) {
			if ($_FILES['aideVideoTxtTrou']['size'] != 0 && $_FILES['aideVideoTxtTrou']['name'] != "") {
				$aideExtVid  = pathinfo($_FILES['aideVideoTxtTrou']['name'], PATHINFO_EXTENSION);

				if ( $aideExtVid != "mp4" ) {
					$_SESSION['errorFR'] = $extensionFr;
					$_SESSION['errorDE'] = $extensionDe;
					$aideOk = false;
				}else {
					$aideVidName = md5(uniqid()).'.'.$aideExtVid;
					move_uploaded_file($_FILES['aideVideoTxtTrou']['tmp_name'], '../uploadDefi/TexteTrou/aide/video/'.$aideVidName);
				}
			}
		}

		$aideSonName = NULL;
		if (isset($_FILES['aideSonTxtTrou'])) {
			if ($_FILES['aideSonTxtTrou']['size'] != 0 && $_FILES['aideSonTxtTrou']['name'] != "") {
				$aideExtSon  = pathinfo($_FILES['aideSonTxtTrou']['name'], PATHINFO_EXTENSION);

				if ($aideExtSon != "mp3") {
					$_SESSION['errorFR'] = $extensionFr;
					$_SESSION['errorDE'] = $extensionDe;
					$aideOk = false;
				}else {
					$aideSonName = md5(uniqid()).'.'.$aideExtSon;
					move_uploaded_file($_FILES['aideSonTxtTrou']['tmp_name'], '../uploadDefi/TexteTrou/aide/son/'.$aideSonName);
				}
			}
		}

		// -----AIDE AU DEFI!-----
		//-----------------------------------------------//
		// vérifie que tous les champs sont remplit
	    if( !empty($_POST['ed']) && !empty($_POST['langueDef']) && !empty($_POST['lieu']) && !empty($_POST['color']) && !empty($_POST['defType']) && !empty($_POST['titleQuestTxtTrou']) && !empty($_POST['questionTxtTrou']) && !empty($_POST['txtTrou']) && !empty($_POST['inputTxtTrou1']) && !empty($_POST['inputTxtTrou2']) && !empty($_POST['inputTxtTrou3']) && $aideOk && $counterOk ){
	      	//ajout à la base TexteTrous
			if (!($req = $con->prepare("INSERT INTO TexteTrous (ed, langue_defi, lieu, region, titre_question, question, texteAtrou, mot1, mot2, mot3, mot4, mot5, mot6, mot7, mot8, mot9, mot10, nbMots, helpTxt, adresse, helpImg, helpVideo, helpAudio, cat1, cat2, cat3, createur_id, date_defi, imgHelpOwner, imgHelpCR, videoHelpOwner, videoHelpCR, audioHelpOwner, audioHelpCR, etat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
			    echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			if (!$req->bind_param("sssssssssssssssssissssssssissssssss", $ED, $langueDefi, $lieu, $couleur, $titreQuestion, $question, $TAT, $mot1, $mot2, $mot3, $mot4, $mot5, $mot6, $mot7, $mot8, $mot9, $mot10, $counterMots, $aideTxt, $adresse, $aideImgName, $aideVidName, $aideSonName, $cat1, $cat2, $cat3, $createurId, $dateInsertion, $aideImgAuteur, $copyrightImg, $aideVideoAuteur, $copyrightVideo, $aideSonAuteur, $copyrightSon, $etat)) {
			    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
			}
			// LOGS
			$SQLrequest = "INSERT INTO TexteTrous (ed, langue_defi, lieu, region, titre_question, question, texteAtrou, mot1, mot2, mot3, mot4, mot5, mot6, mot7, mot8, mot9, mot10, nbMots, helpTxt, adresse, helpImg, helpVideo, helpAudio, cat1, cat2, cat3, createur_id, date_defi, imgHelpOwner, imgHelpCR, videoHelpOwner, videoHelpCR, audioHelpOwner, audioHelpCR, etat) VALUES (".$ED.", ".$langueDefi.", ".$lieu.", ".$couleur.", ".$titreQuestion.", ".$question.", ".$TAT.", ".$mot1.", ".$mot2.", ".$mot3.", ".$mot4.", ".$mot5.", ".$mot6.", ".$mot7.", ".$mot8.", ".$mot9.", ".$mot10.", ".$counterMots.", ".$aideTxt.", ".$adresse.", ".$aideImgName.", ".$aideVidName.", ".$aideSonName.", ".$cat1.", ".$cat2.", ".$cat3.", ".$createurId.", ".$dateInsertion.", ".$aideImgAuteur.", ".$copyrightImg.", ".$aideVideoAuteur.", ".$copyrightVideo.", ".$aideSonAuteur.", ".$copyrightSon.", ".$etat.")";
			
			if (!$req->execute()) {
			    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
			}else{
				// A ajouter pour le zip
				$ID = $req->insert_id;
			}

			$req->close();

			// on crée le zip
			createZipFile(4,$aideImgName,$aideVidName,$aideSonName,$lieu,$question,$aideExtImg,$aideTxt,$ID);

			// message de succès['etat']
			$_SESSION['etat'] = true;

	    }else {
	    	// message d'erreur
	    	if (!isset($_SESSION['etat'])) {
	    		$_SESSION['etat'] = false;
	    	}
	    }
	    //-----------------------------------------------//
	}

	// if Classement alors
	if ($typeDefi == "classement") {

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
			// Si le type d'étiquette est image alors on ajoute toute les images
			for ($j=1; $j <= 5; $j++) {
				for ($k=1; $k <= 5; $k++) { 
					if (isset($_FILES['cat'.$j.'Etiq'.$k])) {

						// 1MO*1048576
						if ($_FILES['cat'.$j.'Etiq'.$k]['size'] > 1048576) {
							$_SESSION['etat'] = false;
							$_SESSION['errorFR'] = $file_sizeFr;
							$_SESSION['errorDE'] = $file_sizeDe;
							header('Location: ../vue/ajoutDefi.php');
							exit("Size error");
						}

						${'cat'.$j.'Etiq'.$k} = NULL;
						if ($_FILES['cat'.$j.'Etiq'.$k]['size'] != 0 && $_FILES['cat'.$j.'Etiq'.$k]['name'] != "") {
							$aideExtImg  = pathinfo($_FILES['cat'.$j.'Etiq'.$k]['name'], PATHINFO_EXTENSION);

							if ($aideExtImg != "png" && $aideExtImg != "jpg" && $aideExtImg != "PNG" && $aideExtImg != "JPG" && $aideExtImg != "pdf") {
								$_SESSION['errorFR'] = $extensionFr;
								$_SESSION['errorDE'] = $extensionDe;
								$aideOk = false;
							}else{
								${'cat'.$j.'Etiq'.$k} = md5(uniqid()).'.'.$aideExtImg;
								move_uploaded_file($_FILES['cat'.$j.'Etiq'.$k]['tmp_name'], '../uploadDefi/Classement/'.${'cat'.$j.'Etiq'.$k});
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

		$aideOk = true;

		// -----!AIDE AU DEFI-----
		if (!empty($_POST['editorClassement'])) {
			$aideTxt = $_POST['editorClassement'];
			// $aideTxt = htmlspecialchars($_POST['aideTxt']);
		}else{
			$aideTxt = NULL;
		}

		$aideImgName = NULL;
		$aideExtImg = NULL;
		if (isset($_FILES['aideImgClassement'])) {

			// 1MO*1048576
			if ($_FILES['aideImgClassement']['size'] > 1048576) {
				$_SESSION['etat'] = false;
				$_SESSION['errorFR'] = $file_sizeFr;
				$_SESSION['errorDE'] = $file_sizeDe;
				header('Location: ../vue/ajoutDefi.php');
				exit("Size error");
			}

			if ($_FILES['aideImgClassement']['size'] != 0 && $_FILES['aideImgClassement']['name'] != "") {
				$aideExtImg  = pathinfo($_FILES['aideImgClassement']['name'], PATHINFO_EXTENSION);

				if ($aideExtImg != "png" && $aideExtImg != "jpg" && $aideExtImg != "PNG" && $aideExtImg != "JPG" && $aideExtImg != "pdf") {
					$_SESSION['errorFR'] = $extensionFr;
					$_SESSION['errorDE'] = $extensionDe;
					$aideOk = false;
				}else{
					$aideImgName = md5(uniqid()).'.'.$aideExtImg;
					move_uploaded_file($_FILES['aideImgClassement']['tmp_name'], '../uploadDefi/Classement/aide/img/'.$aideImgName);
				}
			}
		}

		$aideVidName = NULL;
		if (isset($_FILES['aideVideoClassement'])) {
			if ($_FILES['aideVideoClassement']['size'] != 0 && $_FILES['aideVideoClassement']['name'] != "") {
				$aideExtVid  = pathinfo($_FILES['aideVideoClassement']['name'], PATHINFO_EXTENSION);

				if ($aideExtVid != "mp4") {
					$_SESSION['errorFR'] = $extensionFr;
					$_SESSION['errorDE'] = $extensionDe;
					$aideOk = false;
				}else {
					$aideVidName = md5(uniqid()).'.'.$aideExtVid;
					move_uploaded_file($_FILES['aideVideoClassement']['tmp_name'], '../uploadDefi/Classement/aide/video/'.$aideVidName);
				}
			}
		}

		$aideSonName = NULL;
		if (isset($_FILES['aideSonClassement'])) {
			if ($_FILES['aideSonClassement']['size'] != 0 && $_FILES['aideSonClassement']['name'] != "") {
				$aideExtSon  = pathinfo($_FILES['aideSonClassement']['name'], PATHINFO_EXTENSION);

				if ($aideExtSon != "mp3") {
					$_SESSION['errorFR'] = $extensionFr;
					$_SESSION['errorDE'] = $extensionDe;
					$aideOk = false;
				}else {
					$aideSonName = md5(uniqid()).'.'.$aideExtSon;
					move_uploaded_file($_FILES['aideSonClassement']['tmp_name'], '../uploadDefi/Classement/aide/son/'.$aideSonName);
				}
			}
		}

		// -----AIDE AU DEFI!-----
		//----------------------------------------------//
		// vérifie que tous les champs sont remplit
	    if( !empty($_POST['ed']) && !empty($_POST['langueDef']) && !empty($_POST['lieu']) && !empty($_POST['color']) && !empty($_POST['defType']) && !empty($_POST['titleQuestClassement']) && !empty($_POST['questionClassement']) && !empty($_POST['nbCatClassement']) && !empty($_POST['typeEtiqClassement']) && !empty($_POST['nameCat1Classement']) && !empty($_POST['nameCat2Classement']) && !empty($_POST['nameCat3Classement']) && $aideOk ){
	      	//ajout à la base TexteTrous
			if (!($req = $con->prepare("INSERT INTO DefiClassement (ed, langue_defi, lieu, region, titre_question, question, nbValisette, nom_valise_1, nom_valise_2, nom_valise_3, nom_valise_4, nom_valise_5, type_etiquette, valise_1_etiquette_1, valise_1_etiquette_2, valise_1_etiquette_3, valise_1_etiquette_4, valise_1_etiquette_5, valise_2_etiquette_1, valise_2_etiquette_2, valise_2_etiquette_3, valise_2_etiquette_4, valise_2_etiquette_5, valise_3_etiquette_1, valise_3_etiquette_2, valise_3_etiquette_3, valise_3_etiquette_4, valise_3_etiquette_5, valise_4_etiquette_1, valise_4_etiquette_2, valise_4_etiquette_3, valise_4_etiquette_4, valise_4_etiquette_5, valise_5_etiquette_1, valise_5_etiquette_2, valise_5_etiquette_3, valise_5_etiquette_4, valise_5_etiquette_5, helpTxt, adresse, helpImg, helpVideo, helpAudio, cat1, cat2, cat3, createur_id, date_defi, imgHelpOwner, imgHelpCR, videoHelpOwner, videoHelpCR, audioHelpOwner, audioHelpCR, v1_e1_Owner, v1_e1_CR, v1_e2_Owner, v1_e2_CR, v1_e3_Owner, v1_e3_CR, v1_e4_Owner, v1_e4_CR, v1_e5_Owner, v1_e5_CR, v2_e1_Owner, v2_e1_CR, v2_e2_Owner, v2_e2_CR, v2_e3_Owner, v2_e3_CR, v2_e4_Owner, v2_e4_CR, v2_e5_Owner, v2_e5_CR, v3_e1_Owner, v3_e1_CR, v3_e2_Owner, v3_e2_CR, v3_e3_Owner, v3_e3_CR, v3_e4_Owner, v3_e4_CR, v3_e5_Owner, v3_e5_CR, v4_e1_Owner, v4_e1_CR, v4_e2_Owner, v4_e2_CR, v4_e3_Owner, v4_e3_CR, v4_e4_Owner, v4_e4_CR, v4_e5_Owner, v4_e5_CR, v5_e1_Owner, v5_e1_CR, v5_e2_Owner, v5_e2_CR, v5_e3_Owner, v5_e3_CR, v5_e4_Owner, v5_e4_CR, v5_e5_Owner, v5_e5_CR, etat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
			    echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			if (!$req->bind_param("ssssssisssssisssssssssssssssssssssssssssssssssissssssssssssssssssssssssssssssssssssssssssssssssssssssssss", $ED, $langueDefi, $lieu, $couleur, $titreQuestion, $question, $nbValisette, $nameCat1, $nameCat2, $nameCat3, $nameCat4, $nameCat5, $etiqType, $cat1Etiq1, $cat1Etiq2, $cat1Etiq3, $cat1Etiq4, $cat1Etiq5, $cat2Etiq1, $cat2Etiq2, $cat2Etiq3, $cat2Etiq4, $cat2Etiq5, $cat3Etiq1, $cat3Etiq2, $cat3Etiq3, $cat3Etiq4, $cat3Etiq5, $cat4Etiq1, $cat4Etiq2, $cat4Etiq3, $cat4Etiq4, $cat4Etiq5, $cat5Etiq1, $cat5Etiq2, $cat5Etiq3, $cat5Etiq4, $cat5Etiq5, $aideTxt, $adresse, $aideImgName, $aideVidName, $aideSonName, $cat1, $cat2, $cat3, $createurId, $dateInsertion, $aideImgAuteur, $copyrightImg, $aideVideoAuteur, $copyrightVideo, $aideSonAuteur, $copyrightSon, $v1_e1_Owner, $v1_e1_CR, $v1_e2_Owner, $v1_e2_CR, $v1_e3_Owner, $v1_e3_CR, $v1_e4_Owner, $v1_e4_CR, $v1_e5_Owner, $v1_e5_CR, $v2_e1_Owner, $v2_e1_CR, $v2_e2_Owner, $v2_e2_CR, $v2_e3_Owner, $v2_e3_CR, $v2_e4_Owner, $v2_e4_CR, $v2_e5_Owner, $v2_e5_CR, $v3_e1_Owner, $v3_e1_CR, $v3_e2_Owner, $v3_e2_CR, $v3_e3_Owner, $v3_e3_CR, $v3_e4_Owner, $v3_e4_CR, $v3_e5_Owner, $v3_e5_CR, $v4_e1_Owner, $v4_e1_CR, $v4_e2_Owner, $v4_e2_CR, $v4_e3_Owner, $v4_e3_CR, $v4_e4_Owner, $v4_e4_CR, $v4_e5_Owner, $v4_e5_CR, $v5_e1_Owner, $v5_e1_CR, $v5_e2_Owner, $v5_e2_CR, $v5_e3_Owner, $v5_e3_CR, $v5_e4_Owner, $v5_e4_CR, $v5_e5_Owner, $v5_e5_CR, $etat)) {
			    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
			}
			// LOGS
			$SQLrequest = "INSERT INTO DefiClassement (ed, langue_defi, lieu, region, titre_question, question, nbValisette, nom_valise_1, nom_valise_2, nom_valise_3, nom_valise_4, nom_valise_5, type_etiquette, valise_1_etiquette_1, valise_1_etiquette_2, valise_1_etiquette_3, valise_1_etiquette_4, valise_1_etiquette_5, valise_2_etiquette_1, valise_2_etiquette_2, valise_2_etiquette_3, valise_2_etiquette_4, valise_2_etiquette_5, valise_3_etiquette_1, valise_3_etiquette_2, valise_3_etiquette_3, valise_3_etiquette_4, valise_3_etiquette_5, valise_4_etiquette_1, valise_4_etiquette_2, valise_4_etiquette_3, valise_4_etiquette_4, valise_4_etiquette_5, valise_5_etiquette_1, valise_5_etiquette_2, valise_5_etiquette_3, valise_5_etiquette_4, valise_5_etiquette_5, helpTxt, adresse, helpImg, helpVideo, helpAudio, cat1, cat2, cat3, createur_id, date_defi, imgHelpOwner, imgHelpCR, videoHelpOwner, videoHelpCR, audioHelpOwner, audioHelpCR, v1_e1_Owner, v1_e1_CR, v1_e2_Owner, v1_e2_CR, v1_e3_Owner, v1_e3_CR, v1_e4_Owner, v1_e4_CR, v1_e5_Owner, v1_e5_CR, v2_e1_Owner, v2_e1_CR, v2_e2_Owner, v2_e2_CR, v2_e3_Owner, v2_e3_CR, v2_e4_Owner, v2_e4_CR, v2_e5_Owner, v2_e5_CR, v3_e1_Owner, v3_e1_CR, v3_e2_Owner, v3_e2_CR, v3_e3_Owner, v3_e3_CR, v3_e4_Owner, v3_e4_CR, v3_e5_Owner, v3_e5_CR, v4_e1_Owner, v4_e1_CR, v4_e2_Owner, v4_e2_CR, v4_e3_Owner, v4_e3_CR, v4_e4_Owner, v4_e4_CR, v4_e5_Owner, v4_e5_CR, v5_e1_Owner, v5_e1_CR, v5_e2_Owner, v5_e2_CR, v5_e3_Owner, v5_e3_CR, v5_e4_Owner, v5_e4_CR, v5_e5_Owner, v5_e5_CR, etat) VALUES (".$ED.", ".$langueDefi.", ".$lieu.", ".$couleur.", ".$titreQuestion.", ".$question.", ".$nbValisette.", ".$nameCat1.", ".$nameCat2.", ".$nameCat3.", ".$nameCat4.", ".$nameCat5.", ".$etiqType.", ".$cat1Etiq1.", ".$cat1Etiq2.", ".$cat1Etiq3.", ".$cat1Etiq4.", ".$cat1Etiq5.", ".$cat2Etiq1.", ".$cat2Etiq2.", ".$cat2Etiq3.", ".$cat2Etiq4.", ".$cat2Etiq5.", ".$cat3Etiq1.", ".$cat3Etiq2.", ".$cat3Etiq3.", ".$cat3Etiq4.", ".$cat3Etiq5.", ".$cat4Etiq1.", ".$cat4Etiq2.", ".$cat4Etiq3.", ".$cat4Etiq4.", ".$cat4Etiq5.", ".$cat5Etiq1.", ".$cat5Etiq2.", ".$cat5Etiq3.", ".$cat5Etiq4.", ".$cat5Etiq5.", ".$aideTxt.", ".$adresse.", ".$aideImgName.", ".$aideVidName.", ".$aideSonName.", ".$cat1.", ".$cat2.", ".$cat3.", ".$createurId.", ".$dateInsertion.", ".$aideImgAuteur.", ".$copyrightImg.", ".$aideVideoAuteur.", ".$copyrightVideo.", ".$aideSonAuteur.", ".$copyrightSon.", ".$v1_e1_Owner.", ".$v1_e1_CR.", ".$v1_e2_Owner.", ".$v1_e2_CR.", ".$v1_e3_Owner.", ".$v1_e3_CR.", ".$v1_e4_Owner.", ".$v1_e4_CR.", ".$v1_e5_Owner.", ".$v1_e5_CR.", ".$v2_e1_Owner.", ".$v2_e1_CR.", ".$v2_e2_Owner.", ".$v2_e2_CR.", ".$v2_e3_Owner.", ".$v2_e3_CR.", ".$v2_e4_Owner.", ".$v2_e4_CR.", ".$v2_e5_Owner.", ".$v2_e5_CR.", ".$v3_e1_Owner.", ".$v3_e1_CR.", ".$v3_e2_Owner.", ".$v3_e2_CR.", ".$v3_e3_Owner.", ".$v3_e3_CR.", ".$v3_e4_Owner.", ".$v3_e4_CR.", ".$v3_e5_Owner.", ".$v3_e5_CR.", ".$v4_e1_Owner.", ".$v4_e1_CR.", ".$v4_e2_Owner.", ".$v4_e2_CR.", ".$v4_e3_Owner.", ".$v4_e3_CR.", ".$v4_e4_Owner.", ".$v4_e4_CR.", ".$v4_e5_Owner.", ".$v4_e5_CR.", ".$v5_e1_Owner.", ".$v5_e1_CR.", ".$v5_e2_Owner.", ".$v5_e2_CR.", ".$v5_e3_Owner.", ".$v5_e3_CR.", ".$v5_e4_Owner.", ".$v5_e4_CR.", ".$v5_e5_Owner.", ".$v5_e5_CR.", ".$etat.")";
			
			if (!$req->execute()) {
			    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
			}else{
				// A ajouter pour le zip
				$ID = $req->insert_id;
			}

			$req->close();

			// on crée le zip
			createZipFile(5,$aideImgName,$aideVidName,$aideSonName,$lieu,$question,$aideExtImg,$aideTxt,$ID);

			// message de succès['etat']
			$_SESSION['etat'] = true;

	    }else {
	    	// message d'erreur
	    	if (!isset($_SESSION['etat'])) {
	    		$_SESSION['etat'] = false;
	    	}
	    }
	    //-----------------------------------------------//
	}

// mysqli_close($con);
include("../connexion/customLogs.php");

?>

<script type="text/javascript">window.location.replace("../vue/ajoutDefi.php")</script>