
<?php

	include("../connexion/logs.php");
	require_once("../connexion/SQLconnect.php");

	//id du groupe à supprimer
	$groupId = htmlspecialchars($_POST['idDefi']);

	if (!($req = $con->prepare("SELECT id_user FROM Groupe WHERE id = ?"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req->bind_param("i", $groupId)) {
	    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
	}
	
	if (!$req->execute()) {
	    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
	}

	$req->store_result();
	// on récupère l'id utilisateur
	$req->bind_result($idUser);
	$req->fetch();
	$req->close();

	if (!($req2 = $con->prepare("DELETE FROM Utilisateur WHERE id = ?"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req2->bind_param("i", $idUser)) {
	    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
	}
	
	if (!$req2->execute()) {
	    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
	}
	$req2->close();

?>

<script type="text/javascript">window.location.replace("../vue/profBoard.php")</script>