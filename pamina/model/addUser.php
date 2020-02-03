<?php

	include("../connexion/logs.php");
	require_once("../connexion/SQLconnect.php");
	require("../connexion/PassHash.php");

	//récupération des valeurs du formulaire
	$username = htmlspecialchars($_POST['username']);
	$mdp = htmlspecialchars($_POST['pwd']);
	$mdpHash = PassHash::hash($mdp);
	$email = htmlspecialchars($_POST['email']);
	$ED = htmlspecialchars($_POST['ed']);
	$langueMat = htmlspecialchars($_POST['langueMat']);
	$langueJeu = htmlspecialchars($_POST['langueJeu']);
	$pion = htmlspecialchars(substr($_POST['imgPion'], 13));
	$checkCGU = (int)htmlspecialchars($_POST['checkCGU']);
	$date = date("Y-m-d");

	//-----------------------------------------------//
	// si champs prof + ecole sont vide
	if( empty($_POST['code']) && empty($_POST['ecole']) && $checkCGU) {
		// vérifie que tous les champs sont remplit
	    if( !empty($_POST['username']) && !empty($_POST['pwd']) && !empty($_POST['email']) && !empty($_POST['ed']) && !empty($_POST['langueMat']) && !empty($_POST['langueJeu']) ){
	      	//ajout à la base
			if (!($req = $con->prepare("INSERT INTO Utilisateur (login, password, email, ed_init, ed, langue, langue_jeu, avatar, actif, inscription_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
			    echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			if (!$req->bind_param("ssssssssis", $username, $mdpHash, $email, $ED, $ED, $langueMat, $langueJeu, $pion, $checkCGU, $date)) {
			    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
			}
			
			if (!$req->execute()) {
			    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
			}
	    	
	    }else {
	    	echo "message erreur";
	    }
	    $req->close();
	//-----------------------------------------------//
	// si champs prof + ecole + lieu sont remplis
	}
	elseif( !empty($_POST['code']) && !empty($_POST['ecole']) && !empty($_POST['lieu']) && $checkCGU) {
		// vérifie que tous les autres champs sont remplit
		if( !empty($_POST['username']) && !empty($_POST['pwd']) && !empty($_POST['email']) && !empty($_POST['ed']) && !empty($_POST['langueMat']) && !empty($_POST['langueJeu']) ){

			//vérification code prof
			$code = htmlspecialchars($_POST['code']);
			//-----------------------------------------------//
			if (!($req1 = $con->prepare("SELECT code_prof FROM Config WHERE id=?"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}

			$i = 1;
			if (!$req1->bind_param("i", $i)) {
				echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
			}
					
			if (!$req1->execute()) {
				echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
			}

			$req1->store_result();
			// compare les code secret prof
			$req1->bind_result($codeSecr);
			$req1->fetch();

			if ($codeSecr == $code) {
				//code bon
				$catUser = 2;
			}else {
				//code faux
				$catUser = 1;
			}
			$req1->close();

			//-----------------------------------------------//
			//Ajout à la base du professeur
			if ($catUser == 2) {
				if (!($req1 = $con->prepare("INSERT INTO Utilisateur (login, password, email, ed_init, ed, langue, langue_jeu, avatar, cat_user, actif, inscription_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
			    echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
				}

				if (!$req1->bind_param("ssssssssiis", $username, $mdpHash, $email, $ED, $ED, $langueMat, $langueJeu, $pion, $catUser, $checkCGU, $date)) {
				    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
				}

				if (!$req1->execute()) {
				    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
				}
				$req1->close();
				//-----------------------------------------------//
				//select id from utilisateur where login = $username
				if (!($req1 = $con->prepare("SELECT id FROM Utilisateur WHERE login=?"))) {
					echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
				}

				if (!$req1->bind_param("s", $username)) {
					echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
				}
						
				if (!$req1->execute()) {
					echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
				}

				$req1->store_result();
				// récupération id professeur
				$req1->bind_result($idProfesseur);
				$req1->fetch();
				$req1->close();

				// nom d'école
				$schoolName = htmlspecialchars($_POST['ecole']);
				// lieu
				$lieu = htmlspecialchars($_POST['lieu']);

				
				// insert into professeur nom_ecole
				if (!($req1 = $con->prepare("INSERT INTO Professeur (lieu, nom_ecole, id_user) VALUES (?, ?, ?)"))) {
					echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
				}

				if (!$req1->bind_param("ssi", $lieu, $schoolName, $idProfesseur)) {
				    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
				}
				
				if (!$req1->execute()) {
				    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
				}
				$req1->close();
				// voir lock table ?
			//------------------------------//
			}// if cat==2
	    }//if champs
	}//elseif

if (isset($_SESSION['errorLogin'])) {
	unset($_SESSION['errorLogin']);
}
mysqli_close($con);

?>

<script type="text/javascript">window.location.replace("https://www.mon-passepartout.eu/")</script>