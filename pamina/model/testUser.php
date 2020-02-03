<?php

	include("../connexion/logs.php");
	require_once("../connexion/SQLconnect.php");

	$username = htmlspecialchars($_GET['q']);

	if (!($req = $con->prepare("SELECT * FROM Utilisateur WHERE login = ?"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req->bind_param("s", $username)) {
		echo "Echec lors du liage des paramètres : (" . $req->errno . ") " . $req->error;
	}
			
	if (!$req->execute()) {
		echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
	}

	$count=0;
	while ($row = $req->fetch()) {
		$count++;
	}

	if ($count>0) {
		//username already use
		echo 1;
	}else {
		//username ok
		echo 0;
	}

	mysqli_close($con);

?>