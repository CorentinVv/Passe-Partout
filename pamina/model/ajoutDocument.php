<?php

	include("../connexion/logs.php");
	require_once("../connexion/SQLconnect.php");
	require("../connexion/securite.php");

	//récupération des valeurs du formulaire
	$docName = htmlspecialchars($_POST['docName']);
	$lang = htmlspecialchars($_POST['lang']);
	$category = htmlspecialchars($_POST['category']);
	$doc = "";
	$statusError = false;

	if (isset($_FILES['doc']) && isset($_POST['docName']) && isset($_POST['lang']) && isset($_POST['category'])) {
		$extDoc = NULL;
		if ($_FILES['doc']['size'] != 0 && $_FILES['doc']['name'] != "") {
			$extDoc  = pathinfo($_FILES['doc']['name'], PATHINFO_EXTENSION);

			if ($extDoc != "png" && $extDoc != "jpg" && $extDoc != "PNG" && $extDoc != "JPG" && $extDoc != "pdf" && $extDoc != "txt" && $extDoc != "doc" && $extDoc != "docx") {
				$_SESSION['error'] = "Veuillez vérifier les extensions de vos fichiers !";
				$statusError = true;
			}else{
				$doc = $_FILES['doc']['name'];
				$i=0;
				while (file_exists('../download/Documents/'.$doc)) {
					$temp = $_FILES['doc']['name'];
					$doc = substr($temp, 0, strrpos($temp, '.'));
					$doc .= '-'.$i.'.';
					$doc .= $extDoc;
					$i++;
				}
				move_uploaded_file($_FILES['doc']['tmp_name'], '../download/Documents/'.$doc);
			}
		}
		if (!$statusError) {
			if (!($req = $con->prepare("INSERT INTO Documents (titre, srcName, lang, category) VALUES (?, ?, ?, ?)"))) {
		    	echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			if (!$req->bind_param("sssi", $docName, $doc, $lang, $category)) {
			    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
			}
			
			if (!$req->execute()) {
			    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
			}

			$req->close();

			$_SESSION['succes'] = "Votre document a bien été ajouté !";
		}
	}

?>

<script type="text/javascript">window.location.replace("../vue/adminDocBoard.php")</script>