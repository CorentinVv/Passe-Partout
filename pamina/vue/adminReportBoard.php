<?php 

	require('../connexion/securite.php');
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
	<title>Gérer les signalements</title>
	<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
	<style type="text/css">
		.getIdOwner{
			background-color: red;
		}
	</style>
		
</head>
<body>
	<div>
		<a href="jeuAccueil.php" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Retour</a>
	</div>
	<div class="container">

		<div class="page-header">
 			<h2>Liste des défis signalés</h2>
 		</div>

 		<div class="table-responsive">
		  <table class="table table-hover">
		   	<thead>
		      <tr>
		        <th>Nom Prénom</th>
		        <th>Email</th>
		        <th>ID défi</th>
		        <th>Lieu</th>
		        <th>Type du défi</th>
		        <th>Titre du défi</th>
		        <th>Type du problème</th>
		        <th>Description</th>
		        <th>Créateur du défi</th>
		      </tr>
		    </thead>
		    <tbody id="reportTable"></tbody>
		  </table>
		</div>

		<div class="row">
			<div class="page-header">
	 			<h2>Informations créateur du défi</h2>
	 		</div>
	 		<div class="table-responsive">
			  <table class="table table-hover">
			   	<thead>
			      <tr>
			        <th>ID</th>
			        <th>Email</th>
			      </tr>
			    </thead>
			    <tbody id="ownerTable"></tbody>
			  </table>
			</div>
		</div>
 		 
	</div>

</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {

		jQuery.expr[':'].regex = function(elem, index, match) {
	        var matchParams = match[3].split(','),
	            validLabels = /^(data|css):/,
	            attr = {
	                method: matchParams[0].match(validLabels) ? 
	                            matchParams[0].split(':')[0] : 'attr',
	                property: matchParams.shift().replace(validLabels,'')
	            },
	            regexFlags = 'ig',
	            regex = new RegExp(matchParams.join('').replace(/^s+|s+$/g,''), regexFlags);
	        return regex.test(jQuery(elem)[attr.method](attr.property));
	    }

		// Affiche les défis signalés
		$.get("../model/getReportDefi.php", function(data) {
			// console.log(data);
			var report = jQuery.parseJSON(data);
			// console.log(report);
			$.each(report, function(i, item){
	 			$('#reportTable').append("<tr><td>"+item.full_name_reporter+"</td><td>"+item.email_reporter+"</td><td>"+item.defi_id+"</td><td>"+item.defi_lieu+"</td><td>"+item.defi_type+"</td><td>"+item.defi_titre+"</td><td>"+item.report_type+"</td><td>"+item.report_desc+"</td><td class='getIdOwner'>"+item.owner_defi_id+"</td><td><button type='button' id='deleteReport"+item.id+"' class='btn btn-default'><span class='glyphicon glyphicon-trash'></span></button></td></tr>");
			});
		}).done(function() {

			// Affiche les détails du créateur du défi
			$(".getIdOwner").on('click', function() {
				$.post("../model/getOwnerInfo.php", {idOwner: $(this).text()}, function(result){
					var owner = jQuery.parseJSON(result);
			        $("#ownerTable").html("<tr><td>"+owner[0].id+"</td><td>"+owner[0].email+"</td></tr>");
			    });
			});

			// suppression d'un signalement
			$(':regex(id,deleteReport[0-9])').click(function(e) {
                e.stopPropagation();
                var id = $(this)[0].id;
                id = id.replace("deleteReport", "");
                // suppression du defi
                $.ajax({                                      
                    url: '../model/deleteReport.php', 
                    type : "POST",        
                    data: {idReport : id},
                    success: function() {
                        // on actualise l'affichage
                        window.location.replace("../vue/adminReportBoard.php");
                    }
                });
            });

		});

	});
</script>