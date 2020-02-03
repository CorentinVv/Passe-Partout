<?php
require('../connexion/securite.php');
include('../lang/traduction.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport">
 	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
 	<link rel="icon" type="image/png" href="/pamina/img/favicon.png" />
 	<title><?php echo $translation['mon_compte'][$lang]; ?></title>
 	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 	<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		
</head>
<body>

	<div>
		<a href="gestionCompte.php" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <?php echo $translation['retour'][$lang]; ?></a>
	</div>
	<div class="container">

		<div class="page-header">
 			<h2><?php echo $translation['mon_compte'][$lang]; ?></h2>
 		</div>

 		<form method="post" action="../model/monCompte/updateCompte.php">
 			<!--  -->
 			<div class="form-group">
				<label><?php echo $translation['nom_utilisateur'][$lang]; ?></label>
				<input id="username" type="text" class="form-control" name="username">
				<div id="usernameHint"></div>
			</div>
			<div class="form-group">
				<label><?php echo $translation['ancien_mot_de_passe'][$lang]; ?></label>
				<input id="oldPassword" type="text" class="form-control" name="oldPassword">
				<div id="oldPasswordHint"></div>
			</div>
			<div class="form-group">
				<label><?php echo $translation['nouveau_mot_de_passe'][$lang]; ?></label>
				<input type="text" class="form-control" id="newPassword" name="newPassword">
			</div>
			<div class="form-group">
				<label><?php echo $translation['confirmer_mot_de_passe'][$lang]; ?></label>
				<input type="text" class="form-control" id="checkPassword" name="checkPassword">
				<div id="checkPasswordHint"></div>
			</div>
			<div class="form-group">
				<label><?php echo $translation['langue_jeu'][$lang]; ?></label>
				<select id="langueJeu" name="langueJeu" class="form-control">
					<option disabled selected value></option>
					<option value="FR">FR</option>
					<option value="DE">DE</option>
					<option value="multi">FR/DE</option>
				</select>
			</div>
 		</form>

 		<div class="row">
 			<div class="alert alert-success" id="successMessage" style="display: none;">
 				Modifications bien enregistrées ! 
 			</div>
 			<div class="alert alert-danger" id="errorMessage" style="display: none;">
 				Erreur de modifications ! 
 			</div>
 		</div>

		<div class="row">
			<div class="col-md-12 text-center">
				<button id="validation" type="submit" class="btn btn-primary"><?php echo $translation['valider'][$lang]; ?></button>
			</div>
		</div>

	</div>

</body>
<script type="text/javascript">

	function getSession() {
		$.ajax({
		    url : "../model/getSession.php",
		    type : "get",
		    async: false,
		    success : function(data) {
		        session = JSON.parse(data);
				// on rempli l'utilisateur
				$('#username').val(session.login);
				$('#langueJeu').val(session.langue_jeu);
				oldMdp = session.password;
		    },
		    error: function() {
		       connectionError();
		    }
		 });
	}
	getSession();

	var EtatUser = true;
	var EtatOldPwd = true;
	var EtatNewPwd = true;
	username = document.getElementById("username");

	// USERNAME

	function validateUsername(){
	  if (username.value=="") {
	  	username.setCustomValidity("");
	    document.getElementById("usernameHint").innerHTML="";
	    return;
	  } 
	  if (window.XMLHttpRequest) {
	    // code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp=new XMLHttpRequest();
	  } else { // code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp.onreadystatechange=function() {
	    if (this.readyState==4 && this.status==200){
	    	if (parseInt(this.responseText)) {
	    		EtatUser = false;
	    		document.getElementById("usernameHint").innerHTML='<div class="alert alert-danger"><strong>Nom d\'utilisateur déjà utilisé !</strong></div>';
	    		username.setCustomValidity("Veuillez trouver un autre pseudo.");
	    	}else{
	    		EtatUser = true;
	    		document.getElementById("usernameHint").innerHTML='<div class="alert alert-success"><strong>Nom d\'utilisateur ok.</strong></div>';
	    		username.setCustomValidity("");
	    	}
	    }
	    checkValid(EtatUser,EtatOldPwd,EtatNewPwd);
	  }
	  xmlhttp.open("GET","../model/testUser.php?q="+username.value,true);
	  xmlhttp.send();
	}

	username.onkeyup = function() {
		if(username.value == session.login) {
			document.getElementById("usernameHint").innerHTML="";
		}else{
			validateUsername();
		}
	}
	// ANCIEN MOT DE PASSE
	$('#oldPassword').on("change", function() {

		if ($('#oldPassword').val()=="") {
		  document.getElementById("oldPasswordHint").innerHTML="";
		  return;
		} 
		var checkOld = $('#oldPassword').val();
		$.ajax({
			url : "../connexion/checkPass.php",
			type : "POST",
			data : {oldPass: oldMdp, checkOld: checkOld},
			success : function(result) {
				var etatOldPass = JSON.parse(result);
				if (etatOldPass) {
					// Le mot de passe est le bon
					$('#oldPasswordHint').html('<div class="alert alert-success"><strong>Ancien mot de passe ok.</strong></div>');
					EtatOldPwd = true;
				}else{
					// Erreur mot de passe
					$('#oldPasswordHint').html('<div class="alert alert-danger"><strong>Erreur ancien mot de passe !</strong></div>');
					EtatOldPwd = false;
				}
				checkValid(EtatUser,EtatOldPwd,EtatNewPwd);
			}
		});
	});

	// NEW MOT DE PASSE
	$('#newPassword').keyup(function() {
		newPassword = $('#newPassword').val();
		checkPassword = $('#checkPassword').val();

		if (newPassword=="" && checkPassword=="") {
		  document.getElementById("checkPasswordHint").innerHTML="";
		  return;
		}

		if (newPassword == checkPassword) {
			// Le mot de passe est le bon
			$('#checkPasswordHint').html('<div class="alert alert-success"><strong>Mot de passe ok.</strong></div>');
			EtatNewPwd = true;
		}else{
			// Erreur mot de passe
			$('#checkPasswordHint').html('<div class="alert alert-danger"><strong>Erreur mot de passe !</strong></div>');
			EtatNewPwd = false;
		}
		checkValid(EtatUser,EtatOldPwd,EtatNewPwd);
	});
	$('#checkPassword').keyup(function() {
		newPassword = $('#newPassword').val();
		checkPassword = $('#checkPassword').val();

		if (newPassword=="" && checkPassword=="") {
		  document.getElementById("checkPasswordHint").innerHTML="";
		  return;
		}

		if (newPassword == checkPassword) {
			// Le mot de passe est le bon
			$('#checkPasswordHint').html('<div class="alert alert-success"><strong>Mot de passe ok.</strong></div>');
			EtatNewPwd = true;
		}else{
			// Erreur mot de passe
			$('#checkPasswordHint').html('<div class="alert alert-danger"><strong>Erreur mot de passe !</strong></div>');
			EtatNewPwd = false;
		}
		checkValid(EtatUser,EtatOldPwd,EtatNewPwd);
	});

	// disable or not validation button
	checkValid = function(e1,e2,e3) {
		if (e1 && e2 && e3) {
			// ENABLE
			$('#validation').removeClass("disabled");
			$("#validation").prop('disabled', false);
		}else{
			// DISABLED
			$('#validation').addClass("disabled");
			$("#validation").prop('disabled', true);
		}
	}

	// UPDATE COMPTE
	$('#validation:not(disabled)').click(function() {
		$.ajax({
			url : "../model/monCompte/updateCompte.php",
			type : "POST",
			data : {idUser: session.id,username: $('#username').val(), newPassword : $('#newPassword').val(), langueJeu : $('#langueJeu').val()},
			success : function(result) {
				$('#successMessage').show();
			},
			error : function(result) {
				$('#errorMessage').show();
			}
		});
	});

</script>
</html>