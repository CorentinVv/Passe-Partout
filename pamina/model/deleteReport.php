
<?php

	include("../connexion/logs.php");
	require_once("../connexion/SQLconnect.php");
	require("../connexion/securite.php");

	//id du report à supprimer
	$reportId = htmlspecialchars($_POST['idReport']);

	if (!($req = $con->prepare("DELETE FROM Reporting WHERE id = ?"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req->bind_param("i", $reportId)) {
	    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
	}
	
	if (!$req->execute()) {
	    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
	}
	$req->close();
	mysqli_close($con);

	//--------------------1--------------------------//

?>