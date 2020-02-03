<?php
require('../connexion/securite.php');
include("../lang/traduction.php");
?>
<div onclick="event.stopPropagation()" class="modal">
	<div class="headDefi">
		<div class="lieu">
			<?php 
				switch ($_POST['lieu']) {
		            case "Bad":
		                echo "Bad Bergzabern";
		                break;
		            case "Wingen":
		                echo "Wingen sur Moder";
		                break;
		            case "Niederbronn":
		                echo "Niederbronn Les Bains";
		                break;
		            case "Soufflenheim":
		                echo "Soufflenheim Betschdorf";
		                break;
		            case "Erlenbach":
		                echo "Erlenbach bei Dahn";
		                break;
		            case "Fischbach":
		                echo "Fischbach bei Dahn";
		                break;
		            case "Annweiler":
		                echo "Annweiler am Triffels";
		                break;
		            case "Landau":
		                echo "Landau in der Pfalz";
		                break;
		            case "Haslach":
		                echo "Haslach im Kinzigtal";
		                break;
		            case "Vosges":
		                echo "Vosges moyennes";
		                break;
					case "Südlicher":
		                echo "Südlicher Schwarzwald";
		                break;
		            case "Hautes":
		                echo "Hautes Vosges";
		                break;
		            case "Le":
		                echo "Le Bonhomme";
		                break;
		            case "Orschwiller":
		                echo "Orschwiller et Kintzheim";
		                break;
		            case "Saint":
		                echo "Saint Louis";
		                break;
		            case "Weil":
		                echo "Weil am Rhein";
		                break;
					default:
						echo $_POST['lieu'];
						break;
				}
			?>
		</div>
		<img class="region" <?php 
			switch ($_POST['ed']) {
				case 'ED1':
					switch ($_POST['couleur']) {
						case 'alsace':
							echo "src=/pamina/img/Defi/ED1/alsace/titre.png";
							break;
						case 'mittlerer':
							echo "src=/pamina/img/Defi/ED1/mittlerer/titre.png";
							break;
						case 'sudpfalz':
							echo "src=/pamina/img/Defi/ED1/sudpfalz/titre.png";
							break;
					}
					break;
				case 'ED2':
					switch ($_POST['couleur']) {
						case 'erstein':
							echo "src=/pamina/img/Defi/ED2/erstein/titre.png";
							break;
						case 'molsheim':
							echo "src=/pamina/img/Defi/ED2/molsheim/titre.png";
							break;
						case 'ortenau':
							echo "src=/pamina/img/Defi/ED2/ortenau/titre.png";
							break;
						case 'strasbourg':
							echo "src=/pamina/img/Defi/ED2/strasbourg/titre.png";
							break;
					}
					break;
				case 'ED3':
					switch ($_POST['couleur']) {
						case 'all_fcsa':
							echo "src=/pamina/img/Defi/ED3/all_fcsa/titre.png";
							break;
						case 'fr_fcsa':
							echo "src=/pamina/img/Defi/ED3/fr_fcsa/titre.png";
							break;
					}
					break;
				case 'ED4':
					switch ($_POST['couleur']) {
						case 'all_ETB':
							echo "src=/pamina/img/Defi/ED4/all_ETB/titre.png";
							break;
						case 'ch_ETB':
							echo "src=/pamina/img/Defi/ED4/ch_ETB/titre.png";
							break;
						case 'fr_ETB':
							echo "src=/pamina/img/Defi/ED4/fr_ETB/titre.png";
							break;
					}
					break;
				
				default:

					break;
			}
		?> >
		<div class="imgAvatar"><img id="avatar" style="height: 100%;" src=""></div>
	</div>

	<!-- DEFI FRISE -->
	<div style="display: block;height: 55%;">
		<img style="height: 100%;margin-left: 6%;margin-top: 1%;" src="/pamina/img/Defi/friseChrono/flechefrise.png">
	</div>
	<div style="position: absolute;">
		<h3 style="top: 45%;position: fixed;left: 5%;"><?php echo $_POST['dateDebut']; ?></h3>
		<h3 style="top: 45%;position: fixed;left: 84%;"><?php echo $_POST['dateFin']; ?></h3>
		<h1 style="top: 71%;position: fixed;left: 13%;font-weight: 900;"><?php echo $_POST['titreFrise']; ?></h1>
	</div>
	<!-- boite de depot -->
	<div id="boite1" class="boite"><span class="dateBoite"></span></div>
	<div id="boite2" class="boite"><span class="dateBoite"></span></div>
	<div id="boite3" class="boite"><span class="dateBoite"></span></div>
	<div id="boite4" class="boite"><span class="dateBoite"></span></div>
	<div id="boite5" class="boite"><span class="dateBoite"></span></div>
	<div id="boite6" class="boite"><span class="dateBoite"></span></div>
	<!-- END FRISE -->
	<!-- etiquette à déplacer -->
	<div class="etiquette"><?php echo '<img src="/pamina/uploadDefi/FriseChrono/'.$_POST['item1Img'].'">'; ?><span class="wWrap"><?php echo $_POST['item1Titre']; ?></span></div>
	<div class="etiquette"><?php echo '<img src="/pamina/uploadDefi/FriseChrono/'.$_POST['item2Img'].'">'; ?><span class="wWrap"><?php echo $_POST['item2Titre']; ?></span></div>
	<div class="etiquette"><?php echo '<img src="/pamina/uploadDefi/FriseChrono/'.$_POST['item3Img'].'">'; ?><span class="wWrap"><?php echo $_POST['item3Titre']; ?></span></div>
	<div class="etiquette"><?php echo '<img src="/pamina/uploadDefi/FriseChrono/'.$_POST['item4Img'].'">'; ?><span class="wWrap"><?php echo $_POST['item4Titre']; ?></span></div>
	<div class="etiquette"><?php echo '<img src="/pamina/uploadDefi/FriseChrono/'.$_POST['item5Img'].'">'; ?><span class="wWrap"><?php echo $_POST['item5Titre']; ?></span></div>
	<div class="etiquette"><?php echo '<img src="/pamina/uploadDefi/FriseChrono/'.$_POST['item6Img'].'">'; ?><span class="wWrap"><?php echo $_POST['item6Titre']; ?></span></div>
	<!-- END etiquette -->

	<div class="footDefi">
		<div class="helpDoc"><img class="rotation" src="/pamina/img/Defi/bleu/loupe.png"><img class="reportDefi" src="/pamina/img/Defi/signaler-erreur.png" style="margin-left: 30px;margin-bottom: 25px;"><div id="hoverSignalerDefi" style="margin-top: -60px;margin-left: 175px;display: none;"><b><?php echo $translation['signaler_une_erreur'][$lang]; ?></b></div></div>
		<!-- DIV POUR FERMER DEFI <div onclick="closeDefi()"></div> -->
		<div style="width: 35%;margin-left: 18%;padding-top: 1%;">
			<img id="vie1" width="100px" height="auto" src="/pamina/img/Pions/pions-01.png"><img id="vie2" width="100px" height="auto" src="/pamina/img/Pions/pions-01.png"><img id="vie3" width="100px" height="auto" src="/pamina/img/Pions/pions-01.png">
		</div>
	</div>

	<!-- Modal Signalement -->
	<div id="customModalSignal" style="z-index: 999;">
		<div id="titleCustomModalSignal">
			<h1><?php echo $translation['signaler_une_erreur'][$lang]; ?></h1>
		</div>
		<div id="containerCustomModalSignal">
			<h2 id="titleDefiSignal"><?php echo $_POST['titreFrise']; ?></h2>

			<!-- <div class="groupSignal">
				<label class="alignFormSignal">Votre nom &nbsp;: </label>
				<input class="alignFormSignal2" type="text" name="">
			</div>
			-->
			<div class="groupSignal">
				<label class="alignFormSignal">Type du problème : </label>
				<select id="reportType" class="alignFormSignal2" required>
					<option value="Image"><?php echo $translation['image'][$lang]; ?></option>
					<option value="Texte">Texte</option>
					<option value="Vidéo">Vidéo</option>
					<option value="Audio">Audio</option>
					<option value="Multiple">Multiple</option>
				</select>
			</div>
			<div class="groupSignal">
				<label class="alignFormSignal">Description du problème : </label>
				<textarea id="reportDesc" rows="6" cols="35" class="alignFormSignal2" style="vertical-align: top;" required></textarea>
			</div>
			<div id="divValidSignal">
				<div id="successMessage" style="display: none;background-color: #b5f5b5;width: 40%;margin: auto;border-radius: 10px;border: 1px solid #9cff83;color: #4b8e4b;margin-bottom: 15px;font-weight: bold;">
	 				Signalement envoyé ! 
	 			</div>
	 			<div id="errorMessage" style="display: none;background-color: #f5b5b5;width: 40%;margin: auto;border-radius: 10px;border: 1px solid #ff8383;color: #8e4b4b;margin-bottom: 15px;font-weight: bold;">
	 				Erreur de signalement ! 
	 			</div>
				<button id="btnValidSignal">Envoyer</button>
			</div>

		</div>
		<div id="footerCustomModalSignal">
			<button class="btnClose"><?php echo $translation['fermer'][$lang]; ?></button>
		</div>
	</div>

	<div id="cacheAide" style="display: none">
		<div id="aidePopup">
			<img id="closeHelp" style="position: absolute;left: 94%;width: 6%;" src="../img/Defi/aide/iconesdocuments-05.png">
			<div id="headHelp">
				<div id="lieuHelp">
					<?php 
						switch ($_POST['lieu']) {
				            case "Bad":
				                echo "Bad Bergzabern";
				                break;
				            case "Wingen":
				                echo "Wingen sur Moder";
				                break;
				            case "Niederbronn":
				                echo "Niederbronn Les Bains";
				                break;
				            case "Soufflenheim":
				                echo "Soufflenheim Betschdorf";
				                break;
				            case "Erlenbach":
				                echo "Erlenbach bei Dahn";
				                break;
				            case "Fischbach":
				                echo "Fischbach bei Dahn";
				                break;
				            case "Annweiler":
				                echo "Annweiler am Triffels";
				                break;
				            case "Landau":
				                echo "Landau in der Pfalz";
				                break;
							default:
								echo $_POST['lieu'];
								break;
						}
					?>
					<img style="position: absolute;top: 2%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">
				</div>
				<div id="edHelp">
					<?php 
						switch ($_POST['ed']) {
							case 'ED1':
								echo "PAMINA";
								break;
							case 'ED2':
								echo "Strasbourg-Ortenau";
								break;
							case 'ED3':
								echo "Freiburg Centre Sud Alsace";
								break;
							case 'ED4':
								echo "ETB";
								break;
							
							default:
								# code...
								break;
						}
					?>
				</div>
			</div>
			<div id="bodyHelp">
				<div id="questionHelp"><?php echo $_POST['titreFrise']; ?></div>
				<div id="imgsHelp">
					<?php if ($_POST['helpImg'] != null) {
						if (pathinfo($_POST['helpImg'], PATHINFO_EXTENSION) == "pdf") {
							echo "<object width='100%' data='/pamina/uploadDefi/FriseChrono/aide/img/".$_POST['helpImg']."' type='application/pdf'></object>";
						}else{
							// echo "<img style='width: 220px;height: 160px;background-color: red;margin-right: 10%;' src='/pamina/uploadDefi/FriseChrono/aide/img/".$_POST['helpImg']."'></img>";
							echo "<div class='thumbnail'>";
							echo "<img style='width: 220px;height: 160px;margin-right: 10%;' src='/pamina/uploadDefi/FriseChrono/aide/img/".$_POST['helpImg']."'></img>";
							if ($_POST['imgHelpCR'] != null) {
								if ($_POST['imgHelpCR'] == "cr1") {
								echo "<div class='caption'><img src='../img/Copyright/public_domain.png'>".$_POST['imgHelpOwner']."</div>";
								}else if($_POST['imgHelpCR'] == "cr2") {
									echo "<div class='caption'><img src='../img/Copyright/by.png'>".$_POST['imgHelpOwner']."</div>";
								}else if($_POST['imgHelpCR'] == "cr3") {
									echo "<div class='caption'><img src='../img/Copyright/by-sa.png'>".$_POST['imgHelpOwner']."</div>";
								}else if($_POST['imgHelpCR'] == "cr4") {
									echo "<div class='caption'><img src='../img/Copyright/by-nc-sa.png'>".$_POST['imgHelpOwner']."</div>";
								}
							}
							echo "</div>";
						}
					} ?>
					<!-- <img style="width: 220px;height: 160px;background-color: red;margin-right: 10%;" src=""> -->
					<div id='map_canvas' style='width: 160px;height: 160px;'></div>
				</div>
				<div id="txtHelp">
					<?php if ($_POST['helpTxt'] != null) {
						echo $_POST['helpTxt'];
					} ?>
				</div>
				<div id="mediaHelp">
					<?php if ($_POST['helpVideo'] != null) {
						echo "<video class='mediaStop' width='260px' src='/pamina/uploadDefi/FriseChrono/aide/video/".$_POST['helpVideo']."' controls>Veuillez mettre à jour votre navigateur !</video>";
					} ?>
					<?php if ($_POST['helpAudio'] != null) {
						echo "<audio class='mediaStop' style='width:35%;' src='/pamina/uploadDefi/FriseChrono/aide/son/".$_POST['helpAudio']."' controls>Veuillez mettre à jour votre navigateur !</audio>";
					} ?>
					<!-- <video style="background-color: blue;width: 200px;height: 150px;"></video> -->
					<!-- <div style="width: 47px;height: 50px;background-color: yellow;display: inline-block;margin-left: 20%;margin-top: 10%;vertical-align: top;">SON</div> -->
				</div>
			</div>
			<div id="footerHelp">
				<div style="float: right;width: 50%;margin-right: 17%;text-align: right;font-size: 13px;height: 100%;padding-top: 1%;"><?php echo $translation['dwl_html'][$lang]; ?></div><a id="DwloadHelp" href="" download><img src="../img/Defi/aide/bt_telechargement.png" style="position: absolute;right: 6%;width: auto;height: 6%;"></img></a>
			</div>
			<div id="classOwner"></div>
		</div>
	</div>
</div>