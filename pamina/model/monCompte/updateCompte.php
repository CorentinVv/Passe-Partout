<?php

	include("../../connexion/logs.php");
	require_once("../../connexion/SQLconnect.php");
	require("../../connexion/PassHash.php");
	require("../../connexion/securite.php");

	$username = htmlspecialchars($_POST['username']);
	$newPassword = htmlspecialchars($_POST['newPassword']);
	$mdpHash = PassHash::hash($newPassword);
	$id = htmlspecialchars($_POST['idUser']);
	$langueJeu = htmlspecialchars($_POST['langueJeu']);

	$requestState = false;

	if ($_POST['newPassword'] != "") {
		// Pas vide
		$requestState = true;
	}

	if ($requestState) {
		// Mot de passe + Username UPDATE
		if (!($req = $con->prepare("UPDATE Utilisateur SET login = ?, password = ?, langue_jeu = ? WHERE id = ?"))) {
			echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
		}

		if (!$req->bind_param("sssi", $username,$mdpHash,$langueJeu,$id)) {
			echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
		}

		if (!$req->execute()) {
			echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
		}

		$req->close();
	}else{
		// Username UPDATE
		if (!($req = $con->prepare("UPDATE Utilisateur SET login = ?, langue_jeu = ? WHERE id = ?"))) {
			echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
		}

		if (!$req->bind_param("ssi", $username,$langueJeu,$id)) {
			echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
		}

		if (!$req->execute()) {
			echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
		}

		$req->close();	
	}

?>

<!-- <script type="text/javascript">window.location.replace("../../vue/gestionCompte.php")</script> -->