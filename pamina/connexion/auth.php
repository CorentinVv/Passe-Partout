<?php
	session_start();
	
	require("SQLconnect.php");
	require("PassHash.php");
	
	$login = mysqli_real_escape_string($con, $_POST["username"]);
	
	$result = $con->query("SELECT * FROM Utilisateur WHERE login='".$login."'");
	while ( $row = $result->fetch_array(MYSQLI_ASSOC) ) {
		$array[] = $row;
	}  

	if (isset($array)) {
		// unset($_SESSION['errorLogin']);
		if(!isset($array[0]['login']) || ($_POST["username"] != $array[0]['login']) || ($array[0]['actif'] == 0) ){
			if ($array[0]['actif'] == 0) {
				$_SESSION['errorCGU'] = 1;
			}else{
				$_SESSION['errorLogin'] = 1;
			}
		}else{
			if(PassHash::check_password($array[0]['password'], $_POST["pwd"])){

				$resIp = array();
				$setVisite = 1;
				// On ajoute dans la base l'ip du nouveau visiteur ou on augmente le compteur de visite de 1
	      		/************* REQUETE POUR VOIR SI LE VISITEUR EST DEJA EN BASE DE DONNEES *************/
	        	$res = $con->query("SELECT ip FROM stats_visites WHERE ip='".$_SERVER['REMOTE_ADDR']."'");
		        while ( $row = $res->fetch_array(MYSQLI_ASSOC) ) {
		          $resIp[] = $row;
		        }

		        $res->close();
		        // si l'ip est nouvelle
			      if (count($resIp) == 0) {
			        if (!($req = $con->prepare("INSERT INTO stats_visites (ip, nb_visite) VALUES (?, ?)"))) {
			            echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			        }
			        if (!$req->bind_param("si", $_SERVER['REMOTE_ADDR'], $setVisite)) {
			            echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
			        }
			        
			        if (!$req->execute()) {
			            echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
			        }
			        $req->close();
			      }else if (count($resIp) >= 1) {
			        // sinon on met à jour le nombre de visite
			        if (!($req = $con->prepare("UPDATE stats_visites SET nb_visite = nb_visite + 1 WHERE ip='".$_SERVER['REMOTE_ADDR']."'"))) {
			            echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			        }
			        
			        if (!$req->execute()) {
			            echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
			        }
			        $req->close();
			      }

				$_SESSION['user'] = $array[0];
				unset($_SESSION['errorLogin']);
				unset($_SESSION['errorCGU']);
				// header('Location: https://www.mon-passepartout.eu/pamina/vue/jeuAccueil.php');
				?>
				<script type="text/javascript">
					setTimeout(function () {    
					    window.top.location.replace("https://www.mon-passepartout.eu/pamina/vue/jeuAccueil.php");
					},1000);
				</script>
				<?php
			} else {
				$_SESSION['errorLogin'] = 1;
			}
		}
	}else{
		$_SESSION['errorLogin'] = 1;
	}

	mysqli_close($con);

	if (isset($_SESSION['errorLogin'])) {
		// header('Location: https://www.mon-passepartout.eu/');
		?>
		<script type="text/javascript">
			alert('Mot de passe incorrect, veuillez réessayer.');
			// window.top.location.replace("https://www.mon-passepartout.eu/");
		</script>
		<?php
	}else if (isset($_SESSION['errorCGU'])) {
		?>
		<script type="text/javascript">
			alert("Veuillez vérifier vos mails, vous avez dû recevoir un lien pour valider les Conditions Générales d'Utilisation du jeu.\n Il faut valider ces CGU pour pouvoir accéder à nouveau au jeu.\n Si vous n'avez pas reçu de mail n'oubliez pas de vérifier dans vos SPAM, sinon veuillez nous contacter grâce au formulaire de contact :\n (https://www.mon-passepartout.eu/pamina/vue/generique/contact.html​)\n À bientôt sur le jeu Passe Partout !\n ----------------------------------------------\n Bitte überprüfen Sie Ihr E-Mail Postfach: Sie sollten einen Link erhalten haben, mit dem Sie die Allgemeinen Nutzungsbedingungen des Spieles akzeptieren können. Um den Weltenbummler wieder nutzen zu können, müssen Sie auf diesen Link klicken und bestätigen, dass Sie die Allgemeinen Nutzungsbedingungen akzeptieren.\n Wenn Sie keine Mail erhalten haben, überprüfen Sie bitte Ihren Spam-Ordner oder kontaktieren Sie uns über das Kontaktformular (https://www.mon-passepartout.eu/pamina/vue/generique/kontakt.html)\n Bis bald im Weltenbummler!");
		</script>
		<?php
	}
?>