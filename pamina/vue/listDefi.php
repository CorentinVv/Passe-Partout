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
	<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
	<title>Liste des défis</title>
	<style type="text/css">
		.optionGroup {
		    font-weight: bold;
		    font-style: italic;
		}
		    
		.optionChild {
		    padding-left: 15px;
		}

		.none {
			display: none;
		}
	</style>

</head>
<body>

	<div><a href="gestionDefi.php" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <?php echo $translation['retour'][$lang]; ?></a></div>

	<div class="container">
		<div class="page-header">
			<h2><?php echo $translation['liste_defi'][$lang]; ?></h2>
		</div>
		<form>
		    <div class="form-group">
		      <label for="typeDef"><?php echo $translation['type_defi'][$lang]; ?> : </label>
		      <select class="form-control" id="typeDef">
		      	<option></option>
		        <option><?php echo $translation['qcm'][$lang]; ?></option>
		        <option><?php echo $translation['reconnaissance_vocale'][$lang]; ?></option>
		        <option><?php echo $translation['frise_chronologique'][$lang]; ?></option>
		        <option><?php echo $translation['texte_a_trou'][$lang]; ?></option>
		        <option><?php echo $translation['classement_thematique'][$lang]; ?></option>
		      </select>
		      <small style="color: red;font-weight: bold;"><?php echo $translation['choisissez_une_categorie'][$lang]; ?></small>
		  	</div>
		  	<div class="form-group">
		      <label for="rech"><?php echo $translation['recherche'][$lang]; ?> : </label>
		      <input onkeyup="rechByTitle()" class="form-control" type="text" name="rech" id="rech" placeholder="<?php echo $translation['recherche_titre'][$lang]; ?> ...">
		      <br>
		      <input onkeyup="rechByLieu()" class="form-control" type="text" name="rech2" id="rech2" placeholder="<?php echo $translation['recherche_lieu'][$lang]; ?> ...">
		  	</div>
		  	<div class="form-group">
		      <label for="typeDef"><?php echo $translation['categorie'][$lang]; ?> : </label>
		      <select class="form-control" id="catDef">
		      	<option></option>
	        	<option value="c1" class="optionGroup"><?php echo $thesaurus['cat1'][$lang]; ?></option>
	        	<option value="c1i1" class="optionChild">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $thesaurus['cat1item1'][$lang]; ?></option>
				<option value="c1i2" class="optionChild">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $thesaurus['cat1item2'][$lang]; ?></option>
				<option value="c1i3" class="optionChild">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $thesaurus['cat1item3'][$lang]; ?></option>
	        	<option value="c2" class="optionGroup"><?php echo $thesaurus['cat2'][$lang]; ?></option>
	        	<option value="c2i1" class="optionChild">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $thesaurus['cat2item1'][$lang]; ?></option>
				<option value="c2i2" class="optionChild">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $thesaurus['cat2item2'][$lang]; ?></option>
				<option value="c2i3" class="optionChild">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $thesaurus['cat2item3'][$lang]; ?></option>
				<option value="c2i4" class="optionChild">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $thesaurus['cat2item4'][$lang]; ?></option>
	        	<option value="c3" class="optionGroup"><?php echo $thesaurus['cat3'][$lang]; ?></option>
	        	<option value="c3i1" class="optionChild">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $thesaurus['cat3item1'][$lang]; ?></option>
				<option value="c3i2" class="optionChild">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $thesaurus['cat3item2'][$lang]; ?></option>
				<option value="c3i3" class="optionChild">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $thesaurus['cat3item3'][$lang]; ?></option>
				<option value="c3i4" class="optionChild">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $thesaurus['cat3item4'][$lang]; ?></option>
		        <option value="c4" class="optionGroup"><?php echo $thesaurus['cat4'][$lang]; ?></option>
		      </select>
		  	</div>
	  	</form>

		<div class="table-responsive">
			<table id="tableRech" class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th><?php echo $translation['titre'][$lang]; ?></th>
						<th><?php echo $translation['lieu'][$lang]; ?></th>
						<th><?php echo $translation['date'][$lang]; ?></th>
						<th class="none">cat1</th>
						<th class="none">cat2</th>
					</tr>
				</thead>
				<tbody id="resSearch">

				</tbody>
			</table>
		</div>

	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script type="text/javascript">
		$('#typeDef').change(function(){

			// On vide la table
			$('#resSearch > tr').remove();

			switch($('#typeDef').val()) {
				case "Multiple Choice Fragen" : 
				case "Choix multiples" :
					$.ajax({
				       url : '../model/listDefi/getQcm.php',
				       type : 'GET',
				       success : function(result){ // code_html contient le HTML renvoyé
				           var allQcm = JSON.parse(result);
				           // console.log(allQcm);
				           $.each(allQcm, function(index, value){
				           	$('#resSearch').append("<tr><td>"+(index+1)+"</td><td>"+allQcm[index]["titre_question"]+"</td><td>"+allQcm[index]["lieu"]+"</td><td>"+allQcm[index]["date_defi"]+"</td><td class='none'>"+allQcm[index]["cat1"]+"</td><td class='none'>"+allQcm[index]["cat2"]+"</td></tr>");
				           });
				       }
				    });
					break;
				case "Stimmerkennung" : 
				case "Reconnaissance vocale" :
					$.ajax({
				       url : '../model/listDefi/getVocal.php',
				       type : 'GET',
				       success : function(result){ // code_html contient le HTML renvoyé
				           var allVoc = JSON.parse(result);
				           // console.log(allVoc);
				           $.each(allVoc, function(index, value){
				           	$('#resSearch').append("<tr><td>"+(index+1)+"</td><td>"+allVoc[index]["titre_question"]+"</td><td>"+allVoc[index]["lieu"]+"</td><td>"+allVoc[index]["date_defi"]+"</td><td class='none'>"+allVoc[index]["cat1"]+"</td><td class='none'>"+allVoc[index]["cat2"]+"</td></tr>");
				           });
				       }
				    });
					break;
				case "Zeitstrahl" : 
				case "Frise chronologique" :
					$.ajax({
				       url : '../model/listDefi/getFrise.php',
				       type : 'GET',
				       success : function(result){ // code_html contient le HTML renvoyé
				           var allFrise = JSON.parse(result);
				           // console.log(allFrise);
				           $.each(allFrise, function(index, value){
				           	$('#resSearch').append("<tr><td>"+(index+1)+"</td><td>"+allFrise[index]["titre_frise"]+"</td><td>"+allFrise[index]["lieu"]+"</td><td>"+allFrise[index]["date_defi"]+"</td><td class='none'>"+allFrise[index]["cat1"]+"</td><td class='none'>"+allFrise[index]["cat2"]+"</td></tr>");
				           });
				       }
				    });
					break;
				case "Lückentext" : 
				case "Texte à trous" :
					$.ajax({
				       url : '../model/listDefi/getTrou.php',
				       type : 'GET',
				       success : function(result){ // code_html contient le HTML renvoyé
				           var allTrou = JSON.parse(result);
				           // console.log(allTrou);
				           $.each(allTrou, function(index, value){
				           	$('#resSearch').append("<tr><td>"+(index+1)+"</td><td>"+allTrou[index]["titre_question"]+"</td><td>"+allTrou[index]["lieu"]+"</td><td>"+allTrou[index]["date_defi"]+"</td><td class='none'>"+allTrou[index]["cat1"]+"</td><td class='none'>"+allTrou[index]["cat2"]+"</td></tr>");
				           });
				       }
				    });
					break;	
				case "thematische Einordnung" : 
				case "Classement thématique" :
					$.ajax({
				       url : '../model/listDefi/getClassement.php',
				       type : 'GET',
				       success : function(result){ // code_html contient le HTML renvoyé
				           var allClassmt = JSON.parse(result);
				           // console.log(allClassmt);
				           $.each(allClassmt, function(index, value){
				           	$('#resSearch').append("<tr><td>"+(index+1)+"</td><td>"+allClassmt[index]["titre_question"]+"</td><td>"+allClassmt[index]["lieu"]+"</td><td>"+allClassmt[index]["date_defi"]+"</td><td class='none'>"+allClassmt[index]["cat1"]+"</td><td class='none'>"+allClassmt[index]["cat2"]+"</td></tr>");
				           });
				       }
				    });
					break;	
			}

		});

		$('#catDef').change(function(){
			rechByCat();
		});

		// Recherche par titre
		function rechByTitle() {
		  // Declare variables 
		  var input, filter, table, tr, td, i;
		  input = document.getElementById("rech");
		  filter = input.value.toUpperCase();
		  table = document.getElementById("tableRech");
		  tr = table.getElementsByTagName("tr");

		  // Reset recherche par lieu
		  $('#rech2')[0].value = "";

		  // Loop through all table rows, and hide those who don't match the search query
		  for (i = 0; i < tr.length; i++) {
		    td = tr[i].getElementsByTagName("td")[1];
		    if (td) {
		      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
		        tr[i].style.display = "";
		      } else {
		        tr[i].style.display = "none";
		      }
		    } 
		  }
		}

		// Recherche par lieu
		function rechByLieu() {
		  // Declare variables 
		  var input, filter, table, tr, td, i;
		  input = document.getElementById("rech2");
		  filter = input.value.toUpperCase();
		  table = document.getElementById("tableRech");
		  tr = table.getElementsByTagName("tr");

		  // Reset recherche par titre
		  $('#rech')[0].value = "";

		  // Loop through all table rows, and hide those who don't match the search query
		  for (i = 0; i < tr.length; i++) {
		    td = tr[i].getElementsByTagName("td")[2];
		    if (td) {
		      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
		        tr[i].style.display = "";
		      } else {
		        tr[i].style.display = "none";
		      }
		    } 
		  }
		}

		// Recherche par catégorie
		function rechByCat() {
			// console.log($('#catDef').val());
			// console.log($('#resSearch')[0]);
			$filter = $('#catDef').val();
			$tr = $('#resSearch tr');
			for (var i = 0; i < $tr.length; i++) {
				$td = $tr[i];
			    if ($td) {
			      if ($td.innerHTML.indexOf($filter) > -1) {
			        $tr[i].style.display = "";
			      } else {
			        $tr[i].style.display = "none";
			      }
			    } 
			}
		}

	</script>

</body>
</html>