<!-- Modal QCM-->
<div id="myModalFrise" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg" style="width: 1050px;">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><?php echo $translation['preview_defi'][$lang]; ?></h4>
			</div>
			<div style="height: 800px;" class="modal-body">


			<!-- TEMPLATE Frise PREVIEW -->
			<div onclick="event.stopPropagation()" class="tempDefi" style="background-image: url(&quot;/pamina/img/Defi/bleu/fenetrenordals.png&quot;);transform: scale(1, 1);">
				<div class="headDefi">
					<div class="lieu">Saverne</div>
					<img class="region" src="/pamina/img/Defi/bleu/titrenordals.png">
					<!-- <div class="imgAvatar"><img style="width: 100%;" src="/pamina/img/Avatar/wissembourg.png"></div> -->
				</div>

				<!-- DEFI FRISE -->
				<div style="display: block;height: 55%;">
					<img style="height: 100%;margin-left: 6%;margin-top: 1%;" src="/pamina/img/Defi/friseChrono/flechefrise.png">
				</div>
				<div style="position: absolute;">
					<h3 id="debFrise" style="top: 45%;position: fixed;left: 5%;">1450</h3>
					<h3 id="finFrise" style="top: 45%;position: fixed;left: 84%;">1600</h3>
					<h2 id="titleFrise" style="top: 71%;position: fixed;left: 13%;font-weight: 900;">Frise 3</h2>
				</div>
				<!-- boite de depot -->
				<div id="boite1" class="boite ui-droppable"><span class="dateBoite"></span></div>
				<div id="boite2" class="boite ui-droppable"><span class="dateBoite"></span></div>
				<div id="boite3" class="boite ui-droppable"><span class="dateBoite"></span></div>
				<div id="boite4" class="boite ui-droppable"><span class="dateBoite"></span></div>
				<div id="boite5" class="boite ui-droppable"><span class="dateBoite"></span></div>
				<div id="boite6" class="boite ui-droppable"><span class="dateBoite"></span></div>
				<!-- END FRISE -->
				<!-- etiquette à déplacer -->
				<div class="etiquette ui-draggable ui-draggable-handle" id="etiquette3"><img src="/pamina/uploadDefi/FriseChrono/43dfc4027fe62f52cb57254188bf2218.jpg"><span>event1</span></div>
				<div class="etiquette ui-draggable ui-draggable-handle" id="etiquette4"><img src="/pamina/uploadDefi/FriseChrono/29bb54e6ddd6f43fe338384d2305f577.jpg"><span>event2</span></div>
				<div class="etiquette ui-draggable ui-draggable-handle" id="etiquette1"><img src="/pamina/uploadDefi/FriseChrono/4034d6f60fd44a2623683efd913abdb6.jpg"><span>event3</span></div>
				<div class="etiquette ui-draggable ui-draggable-handle" id="etiquette2"><img src="/pamina/uploadDefi/FriseChrono/0bc6f12dd7ddd8ebfe4d502b7ba2654b.jpg"><span>event4</span></div>
				<div class="etiquette ui-draggable ui-draggable-handle" id="etiquette6"><img src="/pamina/uploadDefi/FriseChrono/1e375aa2489df3c4c3b94b7a69d866d7.jpg"><span>event5</span></div>
				<div class="etiquette ui-draggable ui-draggable-handle" id="etiquette5" style="transform: scale(1); transition: transform 0.5s;"><img src="/pamina/uploadDefi/FriseChrono/9cf359e246afb0d343e6ec335a69f5e9.jpg"><span>event6</span></div>
				<!-- END etiquette -->

				<div class="footDefi">
					<div class="helpDoc"><img onclick="openHelp()" class="rotation" src="/pamina/img/Defi/bleu/loupe.png"><!-- <h1>Document</h1> --></div>
					<!-- DIV POUR FERMER DEFI <div onclick="closeDefi()"></div> -->
					<div style="width: 35%;margin-left: 18%;padding-top: 1%;">
						<img id="vie1" width="100px" height="auto" src="/pamina/img/Pions/pions-01.png"><img id="vie2" width="100px" height="auto" src="/pamina/img/Pions/pions-01.png"><img id="vie3" width="100px" height="auto" src="/pamina/img/Pions/pions-01.png">
					</div>
				</div>
			</div>
						
			<div class="cacheAide" style="display: none;">
				<div id="aidePopup">
					<img onclick="closeHelp()" style="position: absolute;left: 94%;width: 6%;" src="../img/Defi/aide/iconesdocuments-05.png">
					<div id="headHelp">
						<div class="lieuHelp" id="lieuHelpFrise">
							<img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">
						</div>
						<div id="edHelp">Pamina</div>
					</div>
					<div id="bodyHelp">
						<div class="questionHelp" id="questionHelpFrise"></div>
						<div id="imgsHelp">
							<img id="imgHelpFrise" style="width: 220px;height: 160px;margin-right: 10%;" src="">
						</div>
						<div class="txtHelp" id="txtHelpFrise">
							Text
						</div>
						<div id="mediaHelp">
							<video class="mediaStop" style="width: 50%;height: 100%;" controls><source src="" id="videoHelpFrise">Your browser does not support HTML5 video.</video>
							<audio class="mediaStop" style="width: 40%;height: 100%;" controls><source src="" id="sonHelpFrise">Your browser does not support HTML5 video.</audio>
						</div>
					</div>
					<div id="footerHelp">
						<div style="float: right;width: 50%;margin-right: 15%;text-align: right;font-size: 13px;height: 100%;padding-top: 1%;">Télécharger en html 5 pour une consultation hors-ligne</div><img src="../img/Defi/aide/bt_telechargement.png" style="position: absolute;right: 6%;width: auto;height: 6%;">
					</div>
				</div>
			</div>
			<!-- END Frise -->


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $translation['fermer'][$lang]; ?></button>
			</div>
		</div>

	</div>
</div>