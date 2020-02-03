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
		        <th style="width: 50%;"><?php echo $translation['classe'][$lang]; ?></th>
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
 			var i = 0;
 			var myRankingObj = [];
 			var groupsAff = [];
 			var userAff = [];
 			var totalScore = 0;
 			var tabScore = [];

 			// On récupére l'id de toutes les classes
 			refreshRankingGroup = function() {
 				$.ajax({
					url : "../model/getAllClass.php",
					type : "GET",
					success : function(classes) {
						var allClass = JSON.parse(classes);
						allClass.forEach(function(classe) {
							myRankingObj.push(classe);
						});
						affGroups(myRankingObj);
					}
				});
 			}
			// pour chaques classes on récupère les groupes associés
			affGroups = function(classes) {
				$.ajax({
					url : "../model/getMyGroup.php",
					type : "GET",
					success : function(groupes) {
						var allGroups = JSON.parse(groupes);
						classes.forEach(function(classe) {
							// On parcours tous les groupes
							allGroups.forEach(function(groupe) {
								// pour chaques classe on récupère les groupes associés
								if (classe.id == groupe.id_classe) {
									groupsAff.push(groupe);
									classe['Groupes'] = groupsAff;
								}
							});
							groupsAff = [];
						});
						// On récupère tous les utilisateurs
						affUsers(classes);
					}
				});
			}
			// Pour chaques groupes on récupère tous les utilisateurs associés au groupes
			affUsers = function(classes) {
				$.ajax({
					url : "../model/getCustomUsers.php",
					type : "GET",
					success : function(users) {
						var allUsers = JSON.parse(users);
						classes.forEach(function(classe) {
							if (classe.Groupes != undefined) {
								classe.Groupes.forEach(function(groupe) {
									allUsers.forEach(function(user) {
										if (groupe.id_user == user.id) {
											userAff.push(user);
											groupe['user'] = userAff;
										}
									});
									userAff = [];
								});
							}
						});
						// on calcule le score des classes
						setMoyenneClasse(classes);
					}
				});
			}
			// Pour chaques classes on calcule le score des groupes
			setMoyenneClasse = function(classes) {
				// console.log(classes);
				classes.forEach(function(classe) {
					// console.log(classe);
					if (classe.Groupes != undefined) {
						classe.Groupes.forEach(function(groupe) {
							if (groupe.user) {
								totalScore += groupe.user[0].score;
							}else{
								// console.log("erreur");
							}
						});
						tabScore.push({'id':classe.id, 'total':totalScore});
						totalScore = 0;
					}
				});
				updateMoyenneClasse(tabScore);
			}

			// on update la moyenne dans la table classe
			updateMoyenneClasse = function(tabScore) {
				var size = tabScore.length;
				var j = 0;
				tabScore.forEach(function(scoreClasse) {
					$.ajax({
						url : "../model/updateMoyenneClasse.php",
						type : "POST",
						data : {idClass : scoreClasse.id, total : scoreClasse.total},
						success : function(data) {
							j++;
							if (j == size) {
								// on récupère les données mises à jour
								$.ajax({
									url : "../model/getWinnerClasses.php",
									type : "GET",
									success : function(classes) {
										var rankClassFinal = JSON.parse(classes);
										rankClassFinal.forEach(function(classe) {
											// on affiche les données
											$('#rankGroup').append("<tr><td>"+classe.nom_classe+"</td><td>"+classe.moyenne+"</td></tr>");
										});
									}
								});
							}
						}
					});
				});
			}

			// On met à jour les moyennes des classes
 			refreshRankingGroup();
			
		});
 	</script>
 </body>
 </html>