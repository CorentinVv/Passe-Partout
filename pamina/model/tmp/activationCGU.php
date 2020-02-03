<?php

require_once("../../connexion/SQLconnect.php");

	$result = [];

	$login = $_GET['log'];
	$cleURL = $_GET['cle'];

	if (!($req = $con->prepare("SELECT cle FROM Utilisateur WHERE login=?"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req->bind_param("s", $login)) {
		echo "Echec lors du liage des paramètres : (" . $req->errno . ") " . $req->error;
	}
			
	if (!$req->execute()) {
		echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
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

	$clebdd = $result[0]['cle'];

	if ($clebdd == $cleURL) {
		if (!($req = $con->prepare("UPDATE Utilisateur SET actif = 1 WHERE login=?"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
		}

		if (!$req->bind_param("s", $login)) {
			echo "Echec lors du liage des paramètres : (" . $req->errno . ") " . $req->error;
		}
				
		if (!$req->execute()) {
			echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
		}
	}

	  mysqli_close($con);

?>

<script type="text/javascript">
	window.location.href = 'https://www.mon-passepartout.eu/';
</script>