<?php 
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link rel="icon" type="image/png" href="/pamina/img/favicon.png" />
	<title>Passwort vergessen</title>
	<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>

	<style type="text/css">
		body{
			background-color: #BBDEFB;
		}
	</style>
</head>
<body>
	<div>
		<a href="../../../" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Zurück</a>
	</div>
	<div class="container">
		<div class="page-header">
			<h2>Passwort vergessen</h2>
		</div>
		<form method="post" action="../../model/newPassword.php?lang=DE">
			<div class="form-group">
				<label>Nutzername :</label>
				<input type="text" id="login" class="form-control" name="login" required>
			</div>
			<div>
				<?php 
					if (isset($_GET['reset'])) {
						if ($_GET['reset'] == "yes") {
							echo "<div class='alert alert-success'><strong>Votre mot de passe à bien été réinitialisé !</strong> Votre nouveau mot de passe vous a été envoyé par mail. </div>";
						}elseif ($_GET['reset'] == "no") {
							echo "<div class='alert alert-danger'><strong>Erreur !</strong> Identifiant non valide !</div>";
						}
					}
				?>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<button style="margin-bottom: 2%;" type="submit" class="btn btn-primary">Abschicken</button>
				</div>
			</div>
		</form>
	</div>

</body>
</html>