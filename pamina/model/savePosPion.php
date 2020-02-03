<?php 

	include("../connexion/logs.php");
	require_once("../connexion/SQLconnect.php");

	$posPion = $_POST['posPion'];
	$idUser = $_POST['idUser'];

	// UPDATE password de l'utilisateur par un mot de passe aléatoire

	if (!($req = $con->prepare("UPDATE Utilisateur SET position = ? WHERE id = ?"))) {
	    echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req->bind_param("ii", $posPion,$idUser)) {
	    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
	}
	
	if (!$req->execute()) {
	    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
	}

	$req->close();

	mysqli_close($con);          
	  

?>

<script type="text/javascript">window.location.replace("../vue/generique/passwort.php?reset=yes");</script>