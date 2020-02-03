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
	<title>Ajouter des documents</title>
	<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
		
</head>
<body>
	<div>
		<a href="jeuAccueil.php" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <?php echo $translation['retour'][$lang]; ?></a>
	</div>
	<div class="container">
		<div class="page-header">
 			<h2>Ajouter des documents</h2>
 		</div>

 		 <form enctype="multipart/form-data" method="post" action="../model/ajoutDocument.php">
 			<div class="form-group">
				<label for="docName">Titre du document</label>
				<input id="docName" type="text" class="form-control" name="docName" required>
			</div>
			<div class="form-group">
				<label for="lang">Langue</label>
				<select class="form-control" id="lang" name="lang">
					<option>FR</option>
					<option>DE</option>
				</select>
			</div>
			<div class="form-group">
				<label for="category"><?php echo $translation['categorie'][$lang]; ?></label>
				<select class="form-control" id="category" name="category">
					<option value="1"><?php echo $translation['catDoc1'][$lang]; ?></option>
					<option value="2"><?php echo $translation['catDoc2'][$lang]; ?></option>
					<option value="3"><?php echo $translation['catDoc3'][$lang]; ?></option>
					<option value="4"><?php echo $translation['catDoc4'][$lang]; ?></option>
				</select>
			</div>
 			<div class="form-group">
				<label for="doc">Document</label>
				<input id="doc" type="file" class="form-control" name="doc" required>
			</div>
			<?php 
				if (isset($_SESSION['error'])) {
					echo '<div class="row"><div class="alert alert-danger text-center">'.$_SESSION['error'].'</div></div>';
				}else if (isset($_SESSION['succes'])) {
					echo '<div class="row"><div class="alert alert-success text-center">'.$_SESSION['succes'].'</div></div>';
				}
			?>
			<div class="row">
				<div class="col-md-12 text-center">
					<button type="submit" class="btn btn-primary">Ajouter</button>
				</div>
			</div>
 		</form>
	</div>

</body>
</html>