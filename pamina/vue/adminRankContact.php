<?php 

	require('../connexion/securite.php');
	include('../lang/traduction.php');
	if ($_SESSION['user']['cat_user'] != 4) {
		header('Location: https://www.mon-passepartout.eu/');
		exit();
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport">
 	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>Classement et contact</title>
	<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<style type="text/css">
			#btnTop{
				width: 80%;
				margin: auto;
			}
			#ClassementClass, #ContactProf, #ClassementSolo, #ContactSolo{
				display: none;
			}
		</style>
</head>
<body>
	<div>
		<a href="jeuAccueil.php" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <?php echo $translation['retour'][$lang]; ?></a>
	</div>
	<br><br>
	<!-- Bouton main -->
	<div id="btnTop">
		<div class="btn-group btn-group-justified" role="group" aria-label="...">
		  <div class="btn-group" role="group">
		    <button id="btnRankGroup" type="button" class="btn btn-default btn-lg">Classement Groupe</button>
		  </div>
		  <div class="btn-group" role="group">
		    <button id="btnProf" type="button" class="btn btn-default btn-lg">Contact Professeur</button>
		  </div>
		</div>
		<div class="btn-group btn-group-justified" role="group" aria-label="...">
		  <div class="btn-group" role="group">
		    <button id="btnRankSolo" type="button" class="btn btn-default btn-lg">Classement Individuel</button>
		  </div>
		  <div class="btn-group" role="group">
		    <button id="btnSolo" type="button" class="btn btn-default btn-lg">Contact Individuel</button>
		  </div>
		</div>
	</div>
	<!-- Affichage des données -->
	<div class="container">
		<!-- POUR LES CLASSES -->
		<!-- Classement -->
		<div id="ClassementClass">
			<div class="page-header">
	 			<h2>Classement</h2>
	 		</div>
	 		<div>
	 			<table class="table table-bordered table-striped">
	 				<thead>
	 					<th>Nom classe</th>
	 					<th>Lieu</th>
		 				<th>Moyenne</th>
		 				<th>ID Professeur</th>
		 				<th>ED</th>
	 				</thead>
	 				<tbody id="rankClass"></tbody>
	 			</table>
	 		</div>
		</div>
		<!-- Contact -->
		<div id="ContactProf">
			<div class="page-header">
	 			<h2>Contact</h2>
	 		</div>
	 		<div>
	 			<table class="table table-bordered table-striped">
	 				<thead>
	 					<th>ID</th>
		 				<th>email</th>
	 				</thead>
	 				<tbody id="contactProf"></tbody>
	 			</table>
	 		</div>
		</div>
		<!-- POUR LES COMPTES SOLO -->
		<!-- Classement -->
		<div id="ClassementSolo">
			<div class="page-header">
	 			<h2>Classement</h2>
	 		</div>
	 		<div>
	 			<table class="table table-bordered table-striped">
	 				<thead>
	 					<th>ID</th>
		 				<th>Nom</th>
	 				</thead>
	 				<tbody id="rankSolo"></tbody>
	 			</table>
	 		</div>
		</div>
		<!-- Contact -->
		<div id="ContactSolo">
			<div class="page-header">
	 			<h2>Contact</h2>
	 		</div>
	 		<div>
	 			<table class="table table-bordered table-striped">
	 				<thead>
	 					<th>ID</th>
		 				<th>email</th>
	 				</thead>
	 				<tbody id="contactSolo"></tbody>
	 			</table>
	 		</div>
		</div>

	</div>

	<script type="text/javascript">
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
							console.log("erreur");
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
								url : "../model/getAllClassDesc.php",
								type : "GET",
								success : function(classes) {
									var allClass = JSON.parse(classes);
									// console.log(allClass);
									allClass.forEach(function(classe) {
										$('#rankClass').append('<tr><td>'+classe.nom_classe+'</td><td>'+classe.lieu+'</td><td>'+classe.moyenne+'</td><td>'+classe.id_prof+'</td><td>'+classe.ed+'</td></tr>');
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

		// On récupére l'id de toutes les classes
		// ranksClass = function() {
		// 	$.ajax({
		// 		url : "../model/getAllClassDesc.php",
		// 		type : "GET",
		// 		success : function(classes) {
		// 			var allClass = JSON.parse(classes);
		// 			// console.log(allClass);
		// 			allClass.forEach(function(classe) {
		// 				$('#rankClass').append('<tr><td>'+classe.nom_classe+'</td><td>'+classe.lieu+'</td><td>'+classe.moyenne+'</td><td>'+classe.id_prof+'</td></tr>');
		// 			});
		// 		}
		// 	});
		// }
		// ranksClass();

		// On récupére tous les profs
		contactProf = function() {
			$.ajax({
				url : "../model/getAllProfContact.php",
				type : "GET",
				success : function(profs) {
					var allProf = JSON.parse(profs);
					// console.log(allProf);
					allProf.forEach(function(prof) {
						$('#contactProf').append('<tr><td>'+prof.id+'</td><td>'+prof.email+'</td></tr>');
					});
				}
			});
		}
		contactProf();

		// On récupére l'id de toutes les comptes solo
		ranksSolo = function() {
			$.ajax({
				url : "../model/getAllSoloDesc.php",
				type : "GET",
				success : function(solos) {
					var allSolo = JSON.parse(solos);
					// console.log(allSolo);
					allSolo.forEach(function(solo) {
						$('#rankSolo').append('<tr><td>'+solo.id+'</td><td>'+solo.score+'</td></tr>');
					});
				}
			});
		}
		ranksSolo();

		// On récupére tous les comptes solo
		contactSolo = function() {
			$.ajax({
				url : "../model/getAllSoloContact.php",
				type : "GET",
				success : function(solos) {
					var allSolo = JSON.parse(solos);
					// console.log(allSolo);
					allSolo.forEach(function(solo) {
						$('#contactSolo').append('<tr><td>'+solo.id+'</td><td>'+solo.email+'</td></tr>');
					});
				}
			});
		}
		contactSolo();

		// Groupe
		$('#btnRankGroup').click(function() {
			// on cache les autres
			$('#ClassementSolo').hide();
			$('#ContactSolo').hide();
			$('#ContactProf').hide();
			// on affiche
			$('#ClassementClass').show();
		});
		$('#btnProf').click(function() {
			// on cache les autres
			$('#ClassementSolo').hide();
			$('#ContactSolo').hide();
			$('#ClassementClass').hide();
			// on affiche
			$('#ContactProf').show();
		});
		// Individuel
		$('#btnRankSolo').click(function() {
			// on cache les autres
			$('#ClassementClass').hide();
			$('#ContactProf').hide();
			$('#ContactSolo').hide();
			// on affiche
			$('#ClassementSolo').show();
		});
		$('#btnSolo').click(function() {
			// on cache les autres
			$('#ClassementClass').hide();
			$('#ContactProf').hide();
			$('#ClassementSolo').hide();
			// on affiche
			$('#ContactSolo').show();
		});
	</script>

</body>
</html>