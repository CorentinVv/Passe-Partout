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
	<title><?php echo $translation['gestion_compte'][$lang]; ?></title>
	 <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 	<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

</head>
<body>
	<div>
		<a href="jeuAccueil.php" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <?php echo $translation['retour'][$lang]; ?></a>
	</div>
	<br><br>
	<div class="container">
		 <div class="btn-group btn-group-justified" role="group" aria-label="...">
		  <div class="btn-group" role="group">
		    <button type="button" class="btn btn-default btn-lg" onclick="window.location.href='monCompte.php'">
			  <span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $translation['gerer_mes_parametres'][$lang]; ?>
			</button>
		  </div>
		  <div class="btn-group" role="group">
		  	<?php 
		  		if ($_SESSION['user']['cat_user'] != 2) {
		  			?>
		  			<button type="button" class="btn btn-default btn-lg disabled">
					  <span class="glyphicon glyphicon-file" aria-hidden="true"></span> <?php echo $translation['mes_documents'][$lang]; ?>
					</button>
					<?php
		  		}else{
		  			?>
		  			<button type="button" class="btn btn-default btn-lg" onclick="window.location.href='documents.php'">
					  <span class="glyphicon glyphicon-file" aria-hidden="true"></span> <?php echo $translation['mes_documents'][$lang]; ?>
					</button>
					<?php
		  		}
			?>
		  </div>
		</div>	
	</div>

</body>
</html>