 <?php
 require('../connexion/securite.php');
 if ($_SESSION['user']['cat_user'] != 3 && $_SESSION['user']['cat_user'] != 2) {
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
 	<title><?php echo $translation['gestion_defis'][$lang]; ?></title>
 	<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
		
 </head>
 <body>

 	<?php 
 		if (isset($_SESSION['etat'])) {
 		 	unset($_SESSION['etat']);
 		}
 		if (isset($_SESSION['error'])) {
 		 	unset($_SESSION['error']);
 		}
 		
 	?>

 	<div>
 		<a href="jeuAccueil.php" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <?php echo $translation['accueil'][$lang]; ?></a>
 	</div>
 <div class="container">
 	<div class="page-header text-center">
 		<h1><?php echo $translation['gestion_defis'][$lang]; ?></h1>
 	</div>

 	<div class="row">
		<div style="display: none;font-size: 15px;" id="notifMsgGroup" class="col-sm-6">
			<span style="color: red;" class="glyphicon glyphicon-alert" aria-hidden="true"></span>
			<span style="color: red;"><?php echo $translation['groupModifDefi'][$lang]; ?></span>
		</div>
	</div>
	<div class="row">
		<div style="display: none;font-size: 15px;" id="notifMsgProf" class="col-sm-6">
			<span style="color: red;" class="glyphicon glyphicon-alert" aria-hidden="true"></span>
			<span style="color: red;"><?php echo $translation['profValDefi'][$lang]; ?> !</span>
		</div>
	</div>
	<br>

	<?php 
		if ($_SESSION['user']['cat_user'] == 2) {
			?>
			<div class="btn-group btn-group-justified" role="group" aria-label="...">
			  <div class="btn-group" role="group">
			    <button type="button" class="btn btn-default btn-lg" onclick="window.location.href='moderationDefiProf.php'">
				  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <?php echo $translation['moderer_defi'][$lang]; ?>
				</button>
			  </div>
			  <div class="btn-group" role="group">
			    <button type="button" class="btn btn-default btn-lg" onclick="window.location.href='listDefi.php'">
				  <span class="glyphicon glyphicon-list" aria-hidden="true"></span> <?php echo $translation['liste_defi'][$lang]; ?>
				</button>
			  </div>
			</div>
			<?php 
		}else{
			?>
			<div class="btn-group btn-group-justified" role="group" aria-label="...">
			  <div class="btn-group" role="group">
			    <button type="button" class="btn btn-default btn-lg" onclick="window.location.href='ajoutDefi.php'">
				  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <?php echo $translation['ajouter_defi'][$lang]; ?>
				</button>
			  </div>
			  <div class="btn-group" role="group">
			    <button type="button" class="btn btn-default btn-lg" onclick="window.location.href='modifDefi.php'">
				  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <?php echo $translation['defi_a_revoir'][$lang]; ?>
				</button>
			  </div>
			  <div class="btn-group" role="group">
			    <button type="button" class="btn btn-default btn-lg" onclick="window.location.href='listDefi.php'">
				  <span class="glyphicon glyphicon-list" aria-hidden="true"></span> <?php echo $translation['liste_defi'][$lang]; ?>
				</button>
			  </div>
			</div>

			<div class="row" style="position: absolute;bottom: 0;">
				<h4 style="color: red;font-weight: bold;"><?php echo $translation['infoMediaDefiTitre'][$lang]; ?></h4>
				<ul style="font-weight: bold;">
					<li><?php echo $translation['infoMediaDefiLi1'][$lang]; ?></li>
					<li><?php echo $translation['infoMediaDefiLi2'][$lang]; ?></li>
					<li><?php echo $translation['infoMediaDefiLi3'][$lang]; ?></li>
					<li><?php echo $translation['infoMediaDefiFileName'][$lang]; ?></li>
				</ul>
				<p style="color: red;font-weight: bold;"><?php echo $translation['infoMediaDefiMax'][$lang]; ?></p>
			</div>
			<?php
		}
	?>
		
 </div>
 
 </body>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
 <script type="text/javascript">
 	$(document).ready(function() {
	 	// Session courante
	 	var user = '<?php echo json_encode($_SESSION['user']);?>';
	 	user = JSON.parse(user);

	 	if (user.cat_user == 3) {
	 		// Affiche un message d'alerte lorsque l'élève à des défis à modifier
			function alertNewModif() {
				var userId = user.id;
				$.ajax({
					url : "../model/alertDefiModif.php",
					type : "POST",
					data : {id_user : userId},
					success : function(data) {
						res = JSON.parse(data);
						if (res) {
							$('#notifMsgGroup').show();
						}
					}
				});
			}
			alertNewModif();
	 	}else if (user.cat_user == 2) {
	 		// Affiche un message d'alerte lorsque le prof à des défis à valider
			function alertNewDefi() {
				var userId = user.id;
				$.ajax({
					url : "../model/alertDefiNew.php",
					type : "POST",
					data : {id_prof : userId},
					success : function(data) {
						var totalDefi = 0;
						res2 = JSON.parse(data);
						// console.log(res2);
						$.each(res2, function(key, val) {
							totalDefi = totalDefi + val.tot;
							// console.log(val);
							// console.log(key);
						});
						// console.log(totalDefi);
						if (totalDefi > 0) {
							$('#notifMsgProf').show();
						}
					}
				});
			}
			alertNewDefi();
	 	}
	});
 </script>
 </html>