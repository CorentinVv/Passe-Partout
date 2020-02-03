<?php

require_once("../../connexion/SQLconnect.php");

$result = [];

  // 2) Query database for data
  //--------------------------------------------------------------------------
  if (!($req = $con->prepare("SELECT login,email,langue,cle FROM Utilisateur WHERE actif != 1"))) {
      echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
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



  foreach ($result as $key => $value) {
  	if ($value['langue'] == 'DE') {
  		// EN DE
  		$login = $value['login'];
		$cle = $value['cle'];
		// Préparation du mail contenant le lien d'activation
		$destinataire = $value['email'];
		$sujet = "Allgemeine Nutzungsbedingungen Weltenbummler" ;
		$entete = "From: kontakt@mein-weltenbummler.eu\n";
		$entete .="Content-Type: text/html; charset=utf8\n"; // ici on envoie le mail au format texte encodé en UTF-8
		$entete .='Content-Transfer-Encoding: 8bit'; // ici on précise qu'il y a des caractères accentués
		 
		// Le lien d'activation est composé du login(log) et de la clé(cle)
		$message = '<div>
			<p>Liebe Nutzer des Weltenbummlers,</p>
			<p>wir haben die Nutzungsbedingungen für das pädagogische Onlinespiel aktualisiert. Sie finden diese auf der Homepage des Spieles im Bereich Impressum. Bevor Sie den Weltenbummler weiterhin nutzen, akzeptieren Sie bitte diese Nutzungsbedingungen unter folgendem Link:</p>
			<br>
			<p><a href="https://www.mon-passepartout.eu/pamina/model/tmp/activateCGU-de.php?log='.urlencode($login).'&cle='.urlencode($cle).'">https://www.mon-passepartout.eu/pamina/model/tmp/activateCGU-de.php?log='.urlencode($login).'&cle='.urlencode($cle).'</a></p>	
			<br> 
		 	<p>Bei Rückfragen stehen wir gerne unter kontakt@mein-weltenbummler.eu zur Verfügung!</p>
		 	<div>Mit freundlichen Grüßen,</div>
		 	<div>Die Projektpartner des „Weltenbummler – Passe-Partout“</div>
		</div>';
  	}else{
  		// PAR DEFAUT EN FR
		$login = $value['login'];
		$cle = $value['cle'];
		// Préparation du mail contenant le lien d'activation
		$destinataire = $value['email'];
		$sujet = "Conditions générales d'utilisation du jeu Passe Partout" ;
		$entete = "From: contact@mon-passepartout.eu\n";
		$entete .="Content-Type: text/html; charset=utf8\n"; // ici on envoie le mail au format texte encodé en UTF-8
		$entete .='Content-Transfer-Encoding: 8bit'; // ici on précise qu'il y a des caractères accentués
		 
		// Le lien d'activation est composé du login(log) et de la clé(cle)
		$message = '<div>
			<p>Chers utilisateurs du Passe-Partout,</p>
			<p>Nous avons mis à jour les Conditions générales d’utilisation du jeu Passe-Partout. Celles-ci sont disponibles sur le site web du jeu dans la rubrique <a href="https://www.mon-passepartout.eu/pamina/vue/generique/mentions.html">Mentions légales</a>. Avant de continuer à utiliser le Passe-Partout, merci d’accepter ces Conditions générales d’utilisation sous le lien suivant :</p>
			<br>
			<p><a href="https://www.mon-passepartout.eu/pamina/model/tmp/activateCGU-fr.php?log='.urlencode($login).'&cle='.urlencode($cle).'">https://www.mon-passepartout.eu/pamina/model/tmp/activateCGU-fr.php?log='.urlencode($login).'&cle='.urlencode($cle).'</a></p>	
			<br> 
		 	<p>En cas de question, n’hésitez pas à nous contacter : contact@mon-passepartout.eu</p>
		 	<div>Bien cordialement,</div>
		 	<div>L’ensemble des partenaires du projet « Passe-Partout – Weltenbummler »</div>
		</div>';
  	}
  	mail($destinataire, $sujet, $message, $entete) ; // Envoi du mail
  }

  mysqli_close($con);

  ?>  

<script type="text/javascript">
	window.location.href = 'https://www.mon-passepartout.eu/';
</script>