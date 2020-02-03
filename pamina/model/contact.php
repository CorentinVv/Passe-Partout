<?php 

	$nomprenom = $_POST['name'];

	$to      = 'mathias.treffot@reseau-canope.fr,corentin.vuillaume@reseau-canope.fr,jeanne.claverie@reseau-canope.fr';
    $subject = $_POST['subject'];
    $message = "<html>";
    $message .= "<body><p>";
    $message .= addslashes(nl2br($_POST['message']));
    $message .= "</p><br>";
    $message .= $nomprenom;
    $message .= "</body>";
    $message .= "</html>";
    // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'From: '.$_POST['email'].'';

    mail($to, $subject, $message, $headers);

?>

<script type="text/javascript">window.location.replace("https://www.mon-passepartout.eu/");</script>