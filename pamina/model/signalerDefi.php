<?php 

	include("../connexion/logs.php");
	require_once("../connexion/SQLconnect.php");

	$id_reporter = htmlspecialchars($_POST['reporterId']);
	$full_name_reporter = htmlspecialchars($_POST['fullName']);
	$email_reporter = htmlspecialchars($_POST['email']);
	$defi_id = htmlspecialchars($_POST['defiId']);
	$defi_lieu = htmlspecialchars($_POST['lieu']);
	$defi_type = htmlspecialchars($_POST['typeDefi']);
	$defi_titre = htmlspecialchars($_POST['titre']);
	$report_type = htmlspecialchars($_POST['errorType']);
	$report_desc = htmlspecialchars($_POST['description']);
	$owner_defi_id = htmlspecialchars($_POST['creatorId']);

	// Ajout signalement dans la table Reporting

	// vérifie que tous les champs sont remplit
    if( !empty($_POST['reporterId']) && !empty($_POST['fullName']) && !empty($_POST['email']) && !empty($_POST['defiId']) && !empty($_POST['lieu']) && !empty($_POST['typeDefi']) && !empty($_POST['titre']) && !empty($_POST['errorType']) && !empty($_POST['description']) && !empty($_POST['creatorId']) ){
      	//ajout à la base
		if (!($req = $con->prepare("INSERT INTO Reporting (id_reporter, full_name_reporter, email_reporter, defi_id, defi_lieu, defi_type, defi_titre, report_type, report_desc, owner_defi_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
		    echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
		}
		if (!$req->bind_param("ississsssi", $id_reporter, $full_name_reporter, $email_reporter, $defi_id, $defi_lieu, $defi_type, $defi_titre, $report_type, $report_desc, $owner_defi_id)) {
		    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
		}
		
		if (!$req->execute()) {
		    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
		}

		$req->close();

		mysqli_close($con); 
    	
    }else {
    	echo "message erreur";
    }

?>