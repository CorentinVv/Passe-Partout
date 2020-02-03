
<?php

	include("../connexion/logs.php");
	require_once("../connexion/SQLconnect.php");

	//id du groupe à supprimer
	$groupId = htmlspecialchars($_POST['idDefi']);

	if (!($req = $con->prepare("DELETE FROM Groupe WHERE id = ?"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req->bind_param("i", $groupId)) {
	    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
	}
	
	if (!$req->execute()) {
	    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
	}
	$req->close();
	// --------------------1--------------------------//

?>

<script type="text/javascript">window.location.replace("../vue/profBoard.php")</script>