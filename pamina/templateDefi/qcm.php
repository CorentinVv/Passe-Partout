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
	<div class="contentDefi">
		<?php if (!empty($_POST['image'])) { 
			$name = "../uploadDefi/defi/".$_POST['image'];
			list($width, $height) = getimagesize($name);
			if ($height>380 && $height>$width) {
				?><div class="imgQuestion"> 
				<?php echo "<img style=height:110%; src=/pamina/uploadDefi/defi/".$_POST['image'].">";
				?>
				</div> <?php
			}else {
				?><div class="imgQuestion"> 
				<?php echo "<img style=width:100%; src=/pamina/uploadDefi/defi/".$_POST['image'].">";
				if ($_POST['imgQcmCR'] != null) {
					if ($_POST['imgQcmCR'] == "cr1") {
					echo "<div class='captionMain'><img src='../img/Copyright/public_domain.png'>".$_POST['imgQcmOwner']."</div>";
					}else if($_POST['imgQcmCR'] == "cr2") {
						echo "<div class='captionMain'><img src='../img/Copyright/by.png'>".$_POST['imgQcmOwner']."</div>";
					}else if($_POST['imgQcmCR'] == "cr3") {
						echo "<div class='captionMain'><img src='../img/Copyright/by-sa.png'>".$_POST['imgQcmOwner']."</div>";
					}else if($_POST['imgQcmCR'] == "cr4") {
						echo "<div class='captionMain'><img src='../img/Copyright/by-nc-sa.png'>".$_POST['imgQcmOwner']."</div>";
					}
				}
				?>
				</div> <?php
			}
		} ?>

		<div class="contentQuestion">
			<h4 class="titleQuestion"><?php echo $_POST['titre']; ?></h4>
			<p class="question"><?php echo $_POST['question']; ?></p>
			<form class="reponse">
				<input id="rep1" type="radio" name="reponse" value="1" checked="checked">
				<label for="rep1"><?php echo $_POST['reponse1']; ?></label><br>
				
				<input id="rep2" type="radio" name="reponse" value="2">
				<label for="rep2"><?php echo $_POST['reponse2']; ?></label><br>
				
				<input id="rep3" type="radio" name="reponse" value="3">
				<label for="rep3"><?php echo $_POST['reponse3']; ?></label><br>
				
				<input id="rep4" type="radio" name="reponse" value="4">
				<label for="rep4"><?php echo $_POST['reponse4']; ?></label><br>
				
				<input id="rep5" type="radio" name="reponse" value="5">
				<label for="rep5"><?php echo $_POST['reponse5']; ?></label><br>
			</form>		
		</div>

	</div>
	<div class="footDefi">
		<div class="helpDoc"><img class="rotation" src="/pamina/img/Defi/bleu/loupe.png"><img class="reportDefi"  src="/pamina/img/Defi/signaler-erreur.png" style="margin-left: 30px;margin-bottom: 25px;"><div id="hoverSignalerDefi" style="margin-top: -60px;margin-left: 175px;display: none;"><b><?php echo $translation['signaler_une_erreur'][$lang]; ?></b></div></div>
		<!-- DIV ANIMATION PION -->
		<div id="pionPos" class="pionExpression" onmouseup="event.stopPropagation()" onmousedown="event.stopPropagation()" ontouchstart="event.stopPropagation()" ontouchend="event.stopPropagation()">
			
		</div>
		<!-- DIV POUR FERMER DEFI <div onclick="closeDefi()"></div> -->
		<div class="validation">
			<img id="validationImg" onmouseover="this.src='/pamina/img/Defi/bleu/valideonnordals.png'" onmouseout="this.src='/pamina/img/Defi/bleu/validoffnordals.png'" src="/pamina/img/Defi/bleu/validoffnordals.png">
		</div>
	</div>

	<!-- Modal Signalement -->
	<div id="customModalSignal">
		<div id="titleCustomModalSignal">
			<h1><?php echo $translation['signaler_une_erreur'][$lang]; ?></h1>
		</div>
		<div id="containerCustomModalSignal">
			<h2 id="titleDefiSignal"><?php echo $_POST['titre']; ?></h2>

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
				<div id="questionHelp"><?php echo $_POST['titre']; ?></div>
				<div id="imgsHelp">
					<?php if ($_POST['helpImg'] != null) {
						if (pathinfo($_POST['helpImg'], PATHINFO_EXTENSION) == "pdf") {
							echo "<object width='100%' data='/pamina/uploadDefi/aide/img/".$_POST['helpImg']."' type='application/pdf'></object>";
						}else{
							// echo "<img style='width: 220px;height: 160px;background-color: red;margin-right: 10%;' src='/pamina/uploadDefi/aide/img/".$_POST['helpImg']."'></img>";
							echo "<div class='thumbnail'>";
							echo "<img style='width: 220px;height: 160px;margin-right: 10%;' src='/pamina/uploadDefi/aide/img/".$_POST['helpImg']."'></img>";
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
					<!-- <div style='width: 160px;height: 160px;background-color: green;'></div> -->
					<div id='map_canvas' style='width: 160px;height: 160px;'></div>
				</div>
				<div id="txtHelp">
					<?php if ($_POST['helpTxt'] != null) {
						echo $_POST['helpTxt'];
					} ?>
				</div>
				<div id="mediaHelp">
					<?php if ($_POST['helpVideo'] != null) {
						echo "<video class='mediaStop' width='50%' src='/pamina/uploadDefi/aide/video/".$_POST['helpVideo']."' controls>Veuillez mettre à jour votre navigateur !</video>";
					} ?>
					<?php if ($_POST['helpAudio'] != null) {
						echo "<audio class='mediaStop' style='width:45%;' src='/pamina/uploadDefi/aide/son/".$_POST['helpAudio']."' controls>Veuillez mettre à jour votre navigateur !</audio>";
					} ?>
					<!-- <video style="background-color: blue;width: 200px;height: 150px;"></video> -->
					<!-- <div style="width: 47px;height: 50px;background-color: yellow;display: inline-block;margin-left: 20%;margin-top: 10%;vertical-align: top;">SON</div> -->
				</div>
			</div>
			<div id="footerHelp">
				<div style="float: right;width: 50%;margin-right: 17%;text-align: right;font-size: 13px;height: 100%;padding-top: 1%;"><?php echo $translation['dwl_html'][$lang]; ?></div><a id="DwloadHelp" href="" download><img src="../img/Defi/aide/bt_telechargement.png" style="position: absolute;right: 6%;width: auto;height: 6%;"></img></a>

				<!-- <img id="DwloadHelp" src="../img/Defi/aide/bt_telechargement.png" style="position: absolute;right: 6%;width: auto;height: 6%;"></img> -->
			</div>
			<div id="classOwner"></div>
		</div>
	</div>

</div>