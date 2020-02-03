<?php

	include("../connexion/logs.php");
	require_once("../connexion/SQLconnect.php");

	$code = htmlspecialchars($_GET['q']);

	if (!($req = $con->prepare("SELECT code_prof FROM Config WHERE id=?"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	$i = 1;
	if (!$req->bind_param("i", $i)) {
		echo "Echec lors du liage des paramètres : (" . $req->errno . ") " . $req->error;
	}
			
	if (!$req->execute()) {
		echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
	}

	// compare les code secret prof
	$req->bind_result($codeSecr);
	$req->fetch();

	if ($codeSecr == $code) {
		//code bon
		echo 1;
	}else {
		//code faux
		echo 0;
	}

	mysqli_close($con);

?>