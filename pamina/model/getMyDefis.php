<?php

	include("../connexion/logs.php");
	require_once("../connexion/SQLconnect.php");

	$id = htmlspecialchars($_POST['idUser']);
	$type = htmlspecialchars($_POST['type']);

	if ($type == "QCM") {

		if ($id == "35") {
			if (!($req = $con->prepare("SELECT id,lieu,titre_question,image,helpImg,helpVideo,helpAudio,createur_id,date_defi FROM QCM"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
					
			if (!$req->execute()) {
				echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
			}
		}else{
			if (!($req = $con->prepare("SELECT id,lieu,titre_question,image,helpImg,helpVideo,helpAudio,createur_id FROM QCM WHERE createur_id=? AND etat='revoir'"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}

			if (!$req->bind_param("i", $id)) {
				echo "Echec lors du liage des paramètres : (" . $req->errno . ") " . $req->error;
			}
					
			if (!$req->execute()) {
				echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
			}
		}
			
	}else if ($type == "trou") {

		if ($id == "35") {
			if (!($req = $con->prepare("SELECT id,lieu,titre_question,helpImg,helpVideo,helpAudio,createur_id,date_defi FROM TexteTrous"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
					
			if (!$req->execute()) {
				echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
			}
		}else{
			if (!($req = $con->prepare("SELECT id,lieu,titre_question,helpImg,helpVideo,helpAudio,createur_id FROM TexteTrous WHERE createur_id=? AND etat='revoir'"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}

			if (!$req->bind_param("i", $id)) {
				echo "Echec lors du liage des paramètres : (" . $req->errno . ") " . $req->error;
			}
					
			if (!$req->execute()) {
				echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
			}
		}
		
	}else if ($type == "vocal") {

		if ($id == "35") {
			if (!($req = $con->prepare("SELECT id,lieu,titre_question,helpImg,helpVideo,helpAudio,createur_id,date_defi FROM VocalTexte"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
					
			if (!$req->execute()) {
				echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
			}
		}else{
			if (!($req = $con->prepare("SELECT id,lieu,titre_question,helpImg,helpVideo,helpAudio,createur_id FROM VocalTexte WHERE createur_id=? AND etat='revoir'"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}

			if (!$req->bind_param("i", $id)) {
				echo "Echec lors du liage des paramètres : (" . $req->errno . ") " . $req->error;
			}
					
			if (!$req->execute()) {
				echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
			}
		}
		
	}else if ($type == "frise") {

		if ($id == "35") {
			if (!($req = $con->prepare("SELECT id,lieu,titre_frise,item1_img,item2_img,item3_img,item4_img,item5_img,item6_img,helpImg,helpVideo,helpAudio,createur_id,date_defi FROM FriseChrono"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
					
			if (!$req->execute()) {
				echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
			}
		}else{
			if (!($req = $con->prepare("SELECT id,lieu,titre_frise,item1_img,item2_img,item3_img,item4_img,item5_img,item6_img,helpImg,helpVideo,helpAudio,createur_id FROM FriseChrono WHERE createur_id=? AND etat='revoir'"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}

			if (!$req->bind_param("i", $id)) {
				echo "Echec lors du liage des paramètres : (" . $req->errno . ") " . $req->error;
			}
					
			if (!$req->execute()) {
				echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
			}
		}
		
	}else if ($type == "classement") {

		if ($id == "35") {
			if (!($req = $con->prepare("SELECT * FROM DefiClassement"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
					
			if (!$req->execute()) {
				echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
			}
		}else{
			if (!($req = $con->prepare("SELECT * FROM DefiClassement WHERE createur_id=? AND etat='revoir'"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}

			if (!$req->bind_param("i", $id)) {
				echo "Echec lors du liage des paramètres : (" . $req->errno . ") " . $req->error;
			}
					
			if (!$req->execute()) {
				echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
			}
		}	
		
	}


	// on récupére les données
	$meta = $req->result_metadata(); 
    while ($field = $meta->fetch_field()) 
    { 
        $params[] = &$row[$field->name]; 
    } 

    call_user_func_array(array($req, 'bind_result'), $params); 

    while ($req->fetch()) { 
        foreach($row as $key => $val) 
        { 
            $c[$key] = $val; 
        } 
        $result[] = $c; 
    }

	echo json_encode($result);
	mysqli_close($con);

?>