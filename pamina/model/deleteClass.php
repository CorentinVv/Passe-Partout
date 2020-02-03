
<?php

	include("../connexion/logs.php");
	require_once("../connexion/SQLconnect.php");

	//id de la classe à supprimer
	$classId = htmlspecialchars($_POST['idDefi']);
	$result = array();

	// on récupère les ID des utilisateurs à supprimer
	if (!($req3 = $con->prepare("SELECT id_user FROM Groupe WHERE id_classe = ?"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req3->bind_param("i", $classId)) {
	    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
	}
	
	if (!$req3->execute()) {
	    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
	}

	// on récupére les données
	$meta = $req3->result_metadata(); 
    while ($field = $meta->fetch_field()) 
    { 
        $params[] = &$row[$field->name]; 
    } 

    call_user_func_array(array($req3, 'bind_result'), $params); 

    while ($req3->fetch()) { 
        foreach($row as $key => $val) 
        { 
            $c[$key] = $val; 
        } 
        $result[] = $c; 
    }
    $req3->close();

    if (sizeof($result) != 0) {
	    for ($i=0; $i < sizeof($result); $i++) { 
	    	// Suppression de tous les groupes de la classe
			if (!($req4 = $con->prepare("DELETE FROM Utilisateur WHERE id = ?"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}

			if (!$req4->bind_param("i", $result[$i]['id_user'])) {
			    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
			}
			
			if (!$req4->execute()) {
			    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
			}
	    }
	    $req4->close();

		// Suppression de tous les groupes de la classe
		if (!($req = $con->prepare("DELETE FROM Groupe WHERE id_classe = ?"))) {
			echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
		}

		if (!$req->bind_param("i", $classId)) {
		    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
		}
		
		if (!$req->execute()) {
		    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
		}
		$req->close();
		//--------------------1--------------------------//
    }

	// Suppression de la classe
	if (!($req1 = $con->prepare("DELETE FROM Classe WHERE id = ?"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req1->bind_param("i", $classId)) {
	    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
	}
	
	if (!$req1->execute()) {
	    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
	}
	$req1->close();
	//--------------------2--------------------------//
?>

<script type="text/javascript">window.location.replace("../vue/profBoard.php")</script>