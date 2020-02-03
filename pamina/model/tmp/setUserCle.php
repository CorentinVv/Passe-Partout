<?php

	// update scores
	require_once("../../connexion/SQLconnect.php");


	$tabUsers = $_POST['UsersId'];

	foreach ($tabUsers as $key => $value) {
		$cle = md5(rand()*100000);
		$id = intval($value['id']);

		if (!($req = $con->prepare("UPDATE Utilisateur SET cle=? WHERE id=?"))) {
			echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
		}

		if (!$req->bind_param("si", $cle,$id)) {
			echo "Echec lors du liage des paramètres : (" . $req->errno . ") " . $req->error;
		}
				
		if (!$req->execute()) {
			echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
		}
	}

	mysqli_close($con);

?> 