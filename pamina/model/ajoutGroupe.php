 <?php

 	include("../connexion/logs.php");
	require_once("../connexion/SQLconnect.php");
	require('../connexion/securite.php');
	require("../connexion/PassHash.php");

	//récupération des valeurs du formulaire table utilisateur
	$username = htmlspecialchars($_POST['username']);
	$mdp = htmlspecialchars($_POST['pwd']);
	$mdpHash = PassHash::hash($mdp);
	$email = $_SESSION['user']['email'];
	$ED = htmlspecialchars($_POST['ed']);
	$langueMat = htmlspecialchars($_POST['langueMat']);
	$langueJeu = htmlspecialchars($_POST['langueJeu']);
	$pion = htmlspecialchars(substr($_POST['imgPion'], 13));
	$catUser = 3;
	$checkCGU = (int)htmlspecialchars($_POST['checkCGU']);
	//table groupe
	$trancheAge = htmlspecialchars($_POST['trancheAge']);
	$nomGroupe = htmlspecialchars($_POST['groupName']);
	$idClasse = htmlspecialchars($_POST['classe']);
	$nbEnfantGroupe = htmlspecialchars($_POST['nbGroupChild']);
	$date = date("Y-m-d");

	//-----------------------------------------------//
	// vérifie que tous les champs sont remplit
    if( !empty($_POST['username']) && !empty($_POST['pwd']) && !empty($_POST['groupName']) && !empty($_POST['nbGroupChild']) && !empty($_POST['classe']) && !empty($_POST['trancheAge']) && !empty($_POST['ed']) && !empty($_POST['langueMat']) && !empty($_POST['langueJeu']) && $checkCGU ){
      	//ajout à la base Utilisateur
		if (!($req = $con->prepare("INSERT INTO Utilisateur (login, password, email, ed_init, ed, langue, langue_jeu, avatar, cat_user, actif, inscription_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
		    echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
		}
		if (!$req->bind_param("ssssssssiis", $username, $mdpHash, $email, $ED, $ED, $langueMat, $langueJeu, $pion, $catUser, $checkCGU, $date)) {
		    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
		}
		
		if (!$req->execute()) {
		    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
		}

		$req->close();

		//-----------------------2-----------------------//
		//select id from utilisateur where login = $username
		if (!($req = $con->prepare("SELECT id FROM Utilisateur WHERE login=?"))) {
			echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
		}

		if (!$req->bind_param("s", $username)) {
			echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
		}
				
		if (!$req->execute()) {
			echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
		}

		$req->store_result();
		// récupération id professeur
		$req->bind_result($idGroupe);
		$req->fetch();
		$req->close();
		//-----------------------2-----------------------//
		//ajout à la base Groupe
		if (!($req = $con->prepare("INSERT INTO Groupe (tranche_age, nom_groupe, id_classe, id_user, nb_enfant_groupe) VALUES (?, ?, ?, ?, ?)"))) {
		    echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
		}
		if (!$req->bind_param("ssiii", $trancheAge, $nomGroupe, $idClasse, $idGroupe, $nbEnfantGroupe)) {
		    echo "Echec lors du liage des paramètres : (" . $con->errno . ") " . $con->error;
		}
		
		if (!$req->execute()) {
		    echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
		}

		$req->close();

    }else {
    	echo "message erreur";
    }


mysqli_close($con);

?>

<script type="text/javascript">window.location.replace("../vue/gestionProfAjout.php")</script>