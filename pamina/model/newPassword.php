<?php 

	include("../connexion/logs.php");
	require_once("../connexion/SQLconnect.php");
	require("../connexion/PassHash.php");

	$login = $_POST['login'];

	// Génération d'une chaine aléatoire
	function chaine_aleatoire($nb_car, $chaine = 'azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN123456789.)?')
	{
	    $nb_lettres = strlen($chaine) - 1;
	    $generation = '';
	    for($i=0; $i < $nb_car; $i++)
	    {
	        $pos = mt_rand(0, $nb_lettres);
	        $car = $chaine[$pos];
	        $generation .= $car;
	    }
	    return $generation;
	}


	// nouveau mot de passe aléatoire
	$mdpRdm = chaine_aleatoire(8);
	$mdpHash = PassHash::hash($mdpRdm);

	// UPDATE password de l'utilisateur par un mot de passe aléatoire

	if (!($req = $con->prepare("UPDATE Utilisateur SET password = ? WHERE login = ?"))) {
	    echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req->bind_param("ss", $mdpHash,$login)) {
	    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
	}
	
	if (!$req->execute()) {
	    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
	}

	$req->close();

	// Recherche de l'email avec l'id 
	if (!($req = $con->prepare("SELECT email FROM Utilisateur WHERE login = ?"))) {
	    echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req->bind_param("s", $login)) {
	    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
	}
	
	if (!$req->execute()) {
	    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
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

		mysqli_close($con);          
	  
	  // echo "<pre>";
	  // print_r($result);
	  // echo "</pre>";

	  // récupération de l'email
	if (isset($result)) {
		$email = $result[0]['email'];

		// ENVOIS email avec le nouveau mot de passe
		$to       = $email;
		// Français
	    $subjectFR  = "Nouveau mot de passe Passe Partout";
	    $messageFR = "<html>
	    				<body>
	    					<p>Bonjour, voici votre nouveau mot de passe : </p>
	    					<p>".$mdpRdm."</p>
	    					<p>Allez dans la gestion de votre compte pour redéfinir un nouveau mot de passe.</p>
	    					<br>
	    					<p>Pour toute information complémentaire vous pouvez nous contacter avec cet email : </p>
	    					<p>mathias.treffot@reseau-canope.fr</p>
	    				</body>
	    			</html>";
	    // Allemand
	    $subjectDE  = "Neues Passwort Weltenbummler";
	   	$messageDE = "<html>
	    				<body>
	    					<p>Hallo, hier ihr neues Passwort, das Sie im Weltenbummler - Passe-Partout angefordert haben : </p>
	    					<p>".$mdpRdm."</p>
	    					<p>Um dieses Passwort zu ändern, melden Sie sich an und gehen Sie in den Bereich \"Nutzerkonto verwalten\".</p>
	    					<br>
	    					<p>Bei weiteren Fragen wenden Sie sich bitte an folgende Mailadresse : </p>
	    					<p>mathias.treffot@reseau-canope.fr</p>
	    				</body>
	    			</html>";
	    // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
	    $headers  = 'MIME-Version: 1.0' . "\r\n";
	    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	    $headers .= 'From: PassePartout@support.noreply';

	    if ($_GET['lang'] == "DE") {
	    	mail($to, $subjectDE, $messageDE, $headers);
	    }else {
	    	mail($to, $subjectFR, $messageFR, $headers);
	    }
	    

	    if ($_GET['lang'] == "FR") {
			
			?>
			<script type="text/javascript">window.location.replace("../vue/generique/mot_de_passe.php?reset=yes");</script>
			<?php

		}elseif ($_GET['lang'] == "DE") {
			
			?>
			<script type="text/javascript">window.location.replace("../vue/generique/passwort.php?reset=yes");</script>
			<?php

		}

	}else{
		if ($_GET['lang'] == "FR") {
			
			?>
			<script type="text/javascript">window.location.replace("../vue/generique/mot_de_passe.php?reset=no");</script>
			<?php

		}elseif ($_GET['lang'] == "DE") {
			
			?>
			<script type="text/javascript">window.location.replace("../vue/generique/passwort.php?reset=no");</script>
			<?php

		}
	}

?>