 <?php
 require('../connexion/securite.php');
 if ($_SESSION['user']['cat_user'] != 3 && $_SESSION['user']['cat_user'] != 2 && $_SESSION['user']['cat_user'] != 1 && $_SESSION['user']['cat_user'] != 4) {
 	header('Location: ../');
 	exit();
 }
 include("../lang/traduction.php");
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
 	<link rel="icon" type="image/png" href="/pamina/img/favicon.png" />
 	<title><?php echo $translation['classement'][$lang]; ?></title>
 	<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		
 </head>
 <body>

 	<div>
 		<a href="jeuAccueil.php" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <?php echo $translation['retour'][$lang]; ?></a>
 	</div>
 <div class="container">
 	<div class="page-header">
 		<h1><?php echo $translation['classement'][$lang]; ?></h1>
 	</div>	

 	<div class="table-responsive">
 		<table class="table table-striped table-bordered">
		    <thead>
		      <tr>
		        <th><?php echo $translation['utilisateur'][$lang]; ?></th>
		        <th><?php echo $translation['score'][$lang]; ?></th>
		      </tr>
		    </thead>
		    <tbody id="rankGroup">
		    </tbody>
		</table>
 	</div>

 </div>
 
 	<script type="text/javascript">
 		$( document ).ready(function() {
 			$.ajax({
				url : "../model/getWinnerUsers.php",
				type : "GET",
				success : function(users) {
					var rankUserFinal = JSON.parse(users);
					rankUserFinal.forEach(function(user) {
						// on affiche les données
						$('#rankGroup').append("<tr><td>"+user.login+"</td><td>"+user.score+"</td></tr>");
					});
				}
			});
		});
 	</script>
 </body>
 </html>