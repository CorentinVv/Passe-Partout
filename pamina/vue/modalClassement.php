	<!-- Modal Classement-->
	<div id="myModalClassement" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg" style="width: 1050px;">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><?php echo $translation['preview_defi'][$lang]; ?></h4>
				</div>
				<div style="height: 800px;" class="modal-body">


					<!-- TEMPLATE Classement PREVIEW -->
					<div onclick="event.stopPropagation()" class="tempDefi" style="background-image: url(&quot;/pamina/img/Defi/bleu/fenetrenordals.png&quot;); transform: scale(1, 1);">
						<div class="headDefi">
							<div class="lieu">Saverne</div>
							<img class="region" src="/pamina/img/Defi/bleu/titrenordals.png">
							<!-- <div class="imgAvatar"><img style="width: 100%;" src="/pamina/img/Avatar/wissembourg.png"></div> -->
						</div>

						<!-- DEFI CLASSEMENT -->
						<div class="classementBody">
							<div class="titreClassement"><h2>test ZIP</h2></div>
							<div class="classementGame">
								
							</div>
						</div>

						<!-- END CLASSEMENT -->


						<div class="footDefi">
							<div class="helpDoc"><img onclick="openHelp()" class="rotation" src="/pamina/img/Defi/bleu/loupe.png"><!-- <h1>Document</h1> --></div>
							<!-- DIV POUR FERMER DEFI <div onclick="closeDefi()"></div> -->
							<div style="width: 35%;margin-left: 18%;padding-top: 1%;">
								<img id="vie1" width="100px" height="auto" src="/pamina/img/Pions/pions-01.png"><img id="vie2" width="100px" height="auto" src="/pamina/img/Pions/pions-01.png"><img id="vie3" width="100px" height="auto" src="/pamina/img/Pions/pions-01.png">
							</div>
						</div>

					<div class="cacheAide" style="display: none;">
						<div id="aidePopup">
							<img onclick="closeHelp()" style="position: absolute;left: 94%;width: 6%;" src="../img/Defi/aide/iconesdocuments-05.png">
							<div id="headHelp">
								<div class="lieuHelp" id="lieuHelpClassement"><img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png"></div>
								<div id="edHelp">Pamina</div>
							</div>
							<div id="bodyHelp">
								<div class="questionHelp" id="questionHelpClassement"></div>
								<div id="imgsHelp">
									<img id="imgHelpClassement" style="width: 220px;height: 160px;margin-right: 10%;" src="">
								</div>
								<div class="txtHelp" id="txtHelpClassement">
									Text
								</div>
								<div id="mediaHelp">
									<video class="mediaStop" style="width: 55%;height: 100%;" controls><source src="" id="videoHelpClassement">Your browser does not support HTML5 video.</video>
									<audio class="mediaStop" style="width: 40%;height: 100%;" controls><source src="" id="sonHelpClassement">Your browser does not support HTML5 video.</audio>
								</div>
							</div>
							<div id="footerHelp">
								<div style="float: right;width: 50%;margin-right: 15%;text-align: right;font-size: 13px;height: 100%;padding-top: 1%;">Télécharger en html 5 pour une consultation hors-ligne</div><img src="../img/Defi/aide/bt_telechargement.png" style="position: absolute;right: 6%;width: auto;height: 6%;">
							</div>
						</div>
					</div>
					<!-- END classement -->


				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $translation['fermer'][$lang]; ?></button>
				</div>
			</div>

		</div>
	</div>
</div>