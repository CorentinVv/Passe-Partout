<?php
require('../connexion/securite.php');
include('../lang/traduction.php');

if ($_SESSION['user']['cat_user'] != 2 && $_SESSION['user']['cat_user'] != 4) {
	header('Location: https://www.mon-passepartout.eu/');
	exit();
}
$displayDelete = false;
if ($_SESSION['user']['cat_user'] == 4) {
	$displayDelete = true;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport">
 	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
 	<link rel="icon" type="image/png" href="/pamina/img/favicon.png" />
	<title><?php echo $translation['mes_documents'][$lang]; ?></title>
	 <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 	<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
 	<style type="text/css">
 		a {
 			color: #000000;
 		}
 		a:focus, a:hover {
		     color: #000000; 
		     text-decoration: none; 
		}
		tbody > tr > td {
			width: 100%;
		}
		<?php 
			if (!$displayDelete) {
				echo ".isAdmin {display: none;}";
			}
		?>
 	</style>
		
</head>
<body>

	<?php 
		if ($_SESSION['user']['cat_user'] == 4) {
			echo '<div>		<a href="jeuAccueil.php" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> '. $translation['retour'][$lang].'</a>	</div>';
		}else{
			echo '<div>		<a href="gestionCompte.php" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> '. $translation['retour'][$lang].'</a>	</div>';
		}
	?>
	
	<div class="container">

		<div class="page-header">
 			<h2><?php echo $translation['mes_documents'][$lang]; ?></h2>
 		</div>
 		<div id="resDocs"></div>

 	</div>

<script type="text/javascript">
	var langue = '<?php echo $_SESSION['user']['langue']; ?>';
	var download = '<?php echo $translation['download'][$lang]; ?>';
	var admin = '<?php echo $_SESSION['user']['cat_user'] ?>';
	var titre1 = '<?php echo $translation['catDoc1'][$lang]; ?>';
	var titre2 = '<?php echo $translation['catDoc2'][$lang]; ?>';
	var titre3 = '<?php echo $translation['catDoc3'][$lang]; ?>';
	var titre4 = '<?php echo $translation['catDoc4'][$lang]; ?>';

	$.get( "../model/monCompte/getDocs.php", function( data ) {
		dataDocs = jQuery.parseJSON(data);
		var appendDocFR1 = '<table class="table table-hover"><thead><tr><th>'+titre1+'</th></tr></thead><tbody>';
		var appendDocFR2 = '<table class="table table-hover"><thead><tr><th>'+titre2+'</th></tr></thead><tbody>';
		var appendDocFR3 = '<table class="table table-hover"><thead><tr><th>'+titre3+'</th></tr></thead><tbody>';
		var appendDocFR4 = '<table class="table table-hover"><thead><tr><th>'+titre4+'</th></tr></thead><tbody>';

		var appendDocDE1 = '<table class="table table-hover"><thead><tr><th>'+titre1+'</th></tr></thead><tbody>';
		var appendDocDE2 = '<table class="table table-hover"><thead><tr><th>'+titre2+'</th></tr></thead><tbody>';
		var appendDocDE3 = '<table class="table table-hover"><thead><tr><th>'+titre3+'</th></tr></thead><tbody>';
		var appendDocDE4 = '<table class="table table-hover"><thead><tr><th>'+titre4+'</th></tr></thead><tbody>';
		$.each(dataDocs, function( index,value ){
			if (value.lang == "FR") {
				switch(value.category) {
					case 1:
						appendDocFR1 += '<tr><td>'+value.titre+'</td><td><button onclick="window.open(\'../download/Documents/'+value.srcName+'\');" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-download-alt"></span> '+download+'</button></td><td class="isAdmin"><button onclick="deleteDefi('+value.id+',\''+value.srcName+'\');" type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button></td></tr>';
						break;
					case 2:
						appendDocFR2 += '<tr><td>'+value.titre+'</td><td><button onclick="window.open(\'../download/Documents/'+value.srcName+'\');" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-download-alt"></span> '+download+'</button></td><td class="isAdmin"><button onclick="deleteDefi('+value.id+',\''+value.srcName+'\');" type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button></td></tr>';
						break;
					case 3:
						appendDocFR3 += '<tr><td>'+value.titre+'</td><td><button onclick="window.open(\'../download/Documents/'+value.srcName+'\');" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-download-alt"></span> '+download+'</button></td><td class="isAdmin"><button onclick="deleteDefi('+value.id+',\''+value.srcName+'\');" type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button></td></tr>';
						break;
					case 4:
						appendDocFR4 += '<tr><td>'+value.titre+'</td><td><button onclick="window.open(\'../download/Documents/'+value.srcName+'\');" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-download-alt"></span> '+download+'</button></td><td class="isAdmin"><button onclick="deleteDefi('+value.id+',\''+value.srcName+'\');" type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button></td></tr>';
						break;
				}
			}else if(value.lang == "DE"){
				switch(value.category) {
					case 1:
						appendDocDE1 += '<tr><td>'+value.titre+'</td><td><button onclick="window.open(\'../download/Documents/'+value.srcName+'\');" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-download-alt"></span> '+download+'</button></td><td class="isAdmin"><button onclick="deleteDefi('+value.id+',\''+value.srcName+'\');" type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button></td></tr>';
						break;
					case 2:
						appendDocDE2 += '<tr><td>'+value.titre+'</td><td><button onclick="window.open(\'../download/Documents/'+value.srcName+'\');" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-download-alt"></span> '+download+'</button></td><td class="isAdmin"><button onclick="deleteDefi('+value.id+',\''+value.srcName+'\');" type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button></td></tr>';
						break;
					case 3:
						appendDocDE3 += '<tr><td>'+value.titre+'</td><td><button onclick="window.open(\'../download/Documents/'+value.srcName+'\');" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-download-alt"></span> '+download+'</button></td><td class="isAdmin"><button onclick="deleteDefi('+value.id+',\''+value.srcName+'\');" type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button></td></tr>';
						break;
					case 4:
						appendDocDE4 += '<tr><td>'+value.titre+'</td><td><button onclick="window.open(\'../download/Documents/'+value.srcName+'\');" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-download-alt"></span> '+download+'</button></td><td class="isAdmin"><button onclick="deleteDefi('+value.id+',\''+value.srcName+'\');" type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button></td></tr>';
						break;
				}
			}
		});
	  	appendDocFR1 += '</tbody></table>';
	  	appendDocFR2 += '</tbody></table>';
	  	appendDocFR3 += '</tbody></table>';
	  	appendDocFR4 += '</tbody></table>';

	  	appendDocDE1 += '</tbody></table>';
	  	appendDocDE2 += '</tbody></table>';
	  	appendDocDE3 += '</tbody></table>';
	  	appendDocDE4 += '</tbody></table>';
	  	if (admin == 4) {
	  		$('#resDocs').append("<div class='page-header'><h2>Français</h2></div>");

	  		$( "#resDocs" ).append( appendDocFR1 );
	  		$( "#resDocs" ).append( appendDocFR2 );
	  		$( "#resDocs" ).append( appendDocFR3 );
	  		$( "#resDocs" ).append( appendDocFR4 );

	  		$('#resDocs').append("<div class='page-header'><h2>Allemand</h2></div>");

	  		$( "#resDocs" ).append( appendDocDE1 );
	  		$( "#resDocs" ).append( appendDocDE2 );
	  		$( "#resDocs" ).append( appendDocDE3 );
	  		$( "#resDocs" ).append( appendDocDE4 );
	  	}else{
	  		if (langue == "FR") {
		  		$( "#resDocs" ).append( appendDocFR1 );
		  		$( "#resDocs" ).append( appendDocFR2 );
		  		$( "#resDocs" ).append( appendDocFR3 );
		  		$( "#resDocs" ).append( appendDocFR4 );
		  	}else if (langue == "DE") {
		  		$( "#resDocs" ).append( appendDocDE1 );
		  		$( "#resDocs" ).append( appendDocDE2 );
		  		$( "#resDocs" ).append( appendDocDE3 );
		  		$( "#resDocs" ).append( appendDocDE4 );
		  	}
	  	}  	
	  	
	});

	function deleteDefi(id, src) {
       // 2- on supprime les données dans la base
       console.log(id);
       console.log(src);
       $.ajax({                                      
            url: '../model/deleteDocument.php', 
            type : "POST",        
            data: {idDoc : id, srcDoc : src},
            success: function(data) {
            	console.log(data);
                // on actualise l'affichage
                window.location.reload();
            }
        });
    }
</script>

</body>
</html>