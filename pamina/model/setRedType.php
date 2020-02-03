<?php

	include("../connexion/logs.php");
	require_once("../connexion/SQLconnect.php");

	$id = htmlspecialchars($_POST['id_user']);

	/*********************/
	/********QCM**********/
	/*********************/
	if (!($req = $con->prepare("SELECT COUNT(*) FROM QCM WHERE createur_id=? AND etat = 'revoir'"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req->bind_param("i", $id)) {
		echo "Echec lors du liage des paramètres : (" . $req->errno . ") " . $req->error;
	}
			
	if (!$req->execute()) {
		echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
	}

	// Assigne les résultats
	$req->bind_result($nbQcm);
	$req->fetch();
	$req->close();

	/*********************/
	/********Vocal********/
	/*********************/
	if (!($req2 = $con->prepare("SELECT COUNT(*) FROM VocalTexte WHERE createur_id=? AND etat = 'revoir'"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req2->bind_param("i", $id)) {
		echo "Echec lors du liage des paramètres : (" . $req2->errno . ") " . $req2->error;
	}
			
	if (!$req2->execute()) {
		echo "Echec lors de l'exécution de la requête : (" . $req2->errno . ") " . $req2->error;
	}

	// Assigne les résultats
	$req2->bind_result($nbVocal);
	$req2->fetch();
	$req2->close();

	/*********************/
	/********Trou*********/
	/*********************/
	if (!($req3 = $con->prepare("SELECT COUNT(*) FROM TexteTrous WHERE createur_id=? AND etat = 'revoir'"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req3->bind_param("i", $id)) {
		echo "Echec lors du liage des paramètres : (" . $req3->errno . ") " . $req3->error;
	}
			
	if (!$req3->execute()) {
		echo "Echec lors de l'exécution de la requête : (" . $req3->errno . ") " . $req3->error;
	}

	// Assigne les résultats
	$req3->bind_result($nbTrou);
	$req3->fetch();
	$req3->close();

	/**********************/
	/********Frise*********/
	/*********************/
	if (!($req4 = $con->prepare("SELECT COUNT(*) FROM FriseChrono WHERE createur_id=? AND etat = 'revoir'"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req4->bind_param("i", $id)) {
		echo "Echec lors du liage des paramètres : (" . $req4->errno . ") " . $req4->error;
	}
			
	if (!$req4->execute()) {
		echo "Echec lors de l'exécution de la requête : (" . $req4->errno . ") " . $req4->error;
	}

	// Assigne les résultats
	$req4->bind_result($nbFrise);
	$req4->fetch();
	$req4->close();

	/**************************/
	/********Classement********/
	/**************************/
	if (!($req5 = $con->prepare("SELECT COUNT(*) FROM DefiClassement WHERE createur_id=? AND etat = 'revoir'"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req5->bind_param("i", $id)) {
		echo "Echec lors du liage des paramètres : (" . $req5->errno . ") " . $req5->error;
	}
			
	if (!$req5->execute()) {
		echo "Echec lors de l'exécution de la requête : (" . $req5->errno . ") " . $req5->error;
	}

	// Assigne les résultats
	$req5->bind_result($nbClassement);
	$req5->fetch();
	$req5->close();

	$total = array("qcm"=>$nbQcm, "vocal"=>$nbVocal, "trou"=>$nbTrou, "frise"=>$nbFrise, "classement"=>$nbClassement);

	echo json_encode($total);

	mysqli_close($con);

?> 