
<?php

	require('../connexion/securite.php');
	include("../connexion/logs.php");
	require_once("../connexion/SQLconnect.php");

	if ( $_SESSION['user']['cat_user'] != 4 ) {
		header('Location: https://www.mon-passepartout.eu/');
		exit();
	}

	//nom du fichier a supprimer
	$docSrc = htmlspecialchars($_POST['srcDoc']);
	//id du document à supprimer
	$docId = htmlspecialchars($_POST['idDoc']);

	var_dump($docSrc);
	var_dump($docId);

	if (is_file("../download/Documents/".$docSrc)) {
		unlink("../download/Documents/".$docSrc);
	}

	if (!($req = $con->prepare("DELETE FROM Documents WHERE id = ?"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req->bind_param("i", $docId)) {
	    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
	}
	
	if (!$req->execute()) {
	    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
	}
	$req->close();
	mysqli_close($con);

	//--------------------1--------------------------//

?>