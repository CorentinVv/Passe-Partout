<!DOCTYPE html>
<html>
<head>
	<meta name="viewport">
 	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>Mes badges</title>
	<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
 	<style type="text/css">
 		#parent{
 			position: relative;
 		}
 		.img_child{
 			position: absolute;
 		}
 		.img_badge{
 			visibility: hidden;
 		}
 	</style>
</head>
<body>

	<div>
		<a href="jeuPlateau.php" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Retour</a>
	</div>
	<div class="container">
		<div class="page-header">
 			<h2>Mes badges</h2>
 		</div>
 		<div id="parent">
 			<img class="img_child" src="../img/Badges/tableau.png" alt="Tableau de badges">
 			<img class="img_child img_badge" id="img1_1" src="../img/Badges/1.png" alt="Badges n°1">
 			<img class="img_child img_badge" id="img1_2" src="../img/Badges/2.png" alt="Badges n°2">
 			<img class="img_child img_badge" id="img1_3" src="../img/Badges/3.png" alt="Badges n°3">
 			<img class="img_child img_badge" id="img1_4" src="../img/Badges/4.png" alt="Badges n°4">
 			<img class="img_child img_badge" id="img1_5" src="../img/Badges/5.png" alt="Badges n°5">
 			<img class="img_child img_badge" id="img2_1" src="../img/Badges/6.png" alt="Badges n°6">
 			<img class="img_child img_badge" id="img2_2" src="../img/Badges/7.png" alt="Badges n°7">
 			<img class="img_child img_badge" id="img2_3" src="../img/Badges/8.png" alt="Badges n°8">
 			<img class="img_child img_badge" id="img3_1" src="../img/Badges/9.png" alt="Badges n°9">
 			<img class="img_child img_badge" id="img3_2" src="../img/Badges/10.png" alt="Badges n°10">
 			<img class="img_child img_badge" id="img3_3" src="../img/Badges/11.png" alt="Badges n°11">
 			<img class="img_child img_badge" id="img3_4" src="../img/Badges/12.png" alt="Badges n°12">
 			<img class="img_child img_badge" id="img3_5" src="../img/Badges/13.png" alt="Badges n°13">
 			<img class="img_child img_badge" id="img4_1" src="../img/Badges/14.png" alt="Badges n°14">
 			<img class="img_child img_badge" id="img4_2" src="../img/Badges/15.png" alt="Badges n°15">
 			<img class="img_child img_badge" id="img4_3" src="../img/Badges/16.png" alt="Badges n°16">
 			<img class="img_child img_badge" id="img4_4" src="../img/Badges/17.png" alt="Badges n°17">
 			<img class="img_child img_badge" id="img4_5" src="../img/Badges/18.png" alt="Badges n°18">
 			<img class="img_child img_badge" id="img5_1" src="../img/Badges/19.png" alt="Badges n°19">
 			<img class="img_child img_badge" id="img5_2" src="../img/Badges/20.png" alt="Badges n°20">
 			<img class="img_child img_badge" id="img5_3" src="../img/Badges/21.png" alt="Badges n°21">
 			<img class="img_child img_badge" id="img5_4" src="../img/Badges/22.png" alt="Badges n°22">
 			<img class="img_child" src="../img/Badges/texte-fr.png" alt="Intitulé des badges">
 		</div>
	</div>

<script type="text/javascript">

	var session;
	function getSession() {
		$.ajax({
		    url : "../model/getSession.php",
		    type : "get",
		    async: true,
		    success : function(data) {
		        session = JSON.parse(data);
		        console.log(session);
		        nbRepJuste(session.nb_bonne_reponse,[5,10,20,50,100]);
		        nbDefVoisinRep(session.nb_reponse_langue_voisin,[4,20,40]);
		        nbPoints(session.score,[500,1000,1500,2000,2500]);
		        nbTours(session.nb_tour,[5,10,20,50,100]);
		        nbVisitLieu(session.nb_lieu_visite,[25,50,75,100]);
		    },
		    error: function() {

		    }
		 });
	}
	getSession();
	// ----------------Fonction affichage des badges---------------
	// Nombre de bonnes réponses
	function nbRepJuste(inputPlayer,palier) {
		$.each(palier, function(index, value){
			if (inputPlayer>=value) {
				// on affiche les badges
				$("#img1_"+(index+1)).css('visibility', 'visible');
			}
		});
	}
	// Nombre de défis répondus dans la langue voisine
	function nbDefVoisinRep(inputPlayer,palier) {
		$.each(palier, function(index, value){
			if (inputPlayer>=value) {
				// on affiche les badges
				$("#img2_"+(index+1)).css('visibility', 'visible');
			}
		});
	}
	// Nombre de points
	function nbPoints(inputPlayer,palier) {
		$.each(palier, function(index, value){
			if (inputPlayer>=value) {
				// on affiche les badges
				$("#img3_"+(index+1)).css('visibility', 'visible');
			}
		});
	}
	// Nombre de tours
	function nbTours(inputPlayer,palier) {
		$.each(palier, function(index, value){
			if (inputPlayer>=value) {
				// on affiche les badges
				$("#img4_"+(index+1)).css('visibility', 'visible');
			}
		});
	}
	// Nombre de Lieux visités
	function nbVisitLieu(inputPlayer,palier) {
		$.each(palier, function(index, value){
			if (inputPlayer>=value) {
				// on affiche les badges
				$("#img5_"+(index+1)).css('visibility', 'visible');
			}
		});
	}
</script>
</body>
</html>