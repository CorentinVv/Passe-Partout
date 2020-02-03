	<!-- Modal QCM-->
	<div id="myModalTrou" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg" style="width: 1050px;">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><?php echo $translation['preview_defi'][$lang]; ?></h4>
				</div>
				<div style="height: 800px;" class="modal-body">


					<!-- TEMPLATE Trou PREVIEW -->
					<div onclick="event.stopPropagation()" class="tempDefi" style="background-image: url(&quot;/pamina/img/Defi/bleu/fenetrenordals.png&quot;); transform: scale(1, 1);">
						<div class="headDefi">
							<div class="lieu">Haguenau</div>
							<img class="region" src="/pamina/img/Defi/bleu/titrenordals.png">
							<!-- <div class="imgAvatar"><img style="width: 100%;" src="/pamina/img/Avatar/wissembourg.png"></div> -->
						</div>

						<!-- DEFI Trous -->
						<div class="contentTrous">
							<div class="titreTrous">
								<h4 style="margin-bottom: 1.33em;" id="titleQuestionTrou" class="titleQuestion">testTAT</h4>
								<p class="questionTrous">testTAT</p>
							</div>
							<div id="TAT" style="width: 90%;margin-left: 5%;overflow: overlay;height: 70%;">
								<p>testTATtestTAT <input type="text" id="inputTrou1" name="inputTrou1"> testTAT <input type="text" id="inputTrou2" name="inputTrou2"> testTATtestTAT. <input type="text" id="inputTrou3" name="inputTrou3"> testTAT <input type="text" id="inputTrou4" name="inputTrou4">.</p>
							</div>
						</div>

						<div class="footDefi">
							<div class="helpDoc"><img onclick="openHelp()" class="rotation" src="/pamina/img/Defi/bleu/loupe.png"><!-- <h1>Document</h1> --></div>
							<!-- DIV POUR FERMER DEFI <div onclick="closeDefi()"></div> -->
							<div style="width: 50%;margin-left: 2%;padding-top: 1%;">
								<img id="vie1" style="vertical-align: top;" width="100px" height="auto" src="/pamina/img/Pions/pions-01.png"><img id="vie2" style="vertical-align: top;" width="100px" height="auto" src="/pamina/img/Pions/pions-01.png"><img id="vie3" style="vertical-align: top;margin-right: 10%;" width="100px" height="auto" src="/pamina/img/Pions/pions-01.png"><img id="checkTrous" onmouseover="this.src='/pamina/img/Defi/bleu/valideonnordals.png'" onmouseout="this.src='/pamina/img/Defi/bleu/validoffnordals.png'" src="/pamina/img/Defi/bleu/validoffnordals.png">
							</div>
						</div>

					</div>

				<div class="cacheAide" style="display: none;">
					<div id="aidePopup">
						<img onclick="closeHelp()" style="position: absolute;left: 94%;width: 6%;" src="../img/Defi/aide/iconesdocuments-05.png">
						<div id="headHelp">
							<div class="lieuHelp" id="lieuHelpTrou"><img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png"></div>
							<div id="edHelp">Pamina</div>
						</div>
						<div id="bodyHelp">
							<div class="questionHelp" id="questionHelpTrou"></div>
							<div id="imgsHelp">
								<img id="imgHelpTrou" style="width: 220px;height: 160px;margin-right: 10%;" src="">
							</div>
							<div class="txtHelp" id="txtHelpTrou">
								Text
							</div>
							<div id="mediaHelp">
								<video class="mediaStop" style="width: 55%;height: 100%;" controls><source src="" id="videoHelpTrou">Your browser does not support HTML5 video.</video>
								<audio class="mediaStop" style="width: 40%;height: 100%;" controls><source src="" id="sonHelpTrou">Your browser does not support HTML5 video.</audio>
							</div>
						</div>
						<div id="footerHelp">
							<div style="float: right;width: 50%;margin-right: 15%;text-align: right;font-size: 13px;height: 100%;padding-top: 1%;">Télécharger en html 5 pour une consultation hors-ligne</div><img src="../img/Defi/aide/bt_telechargement.png" style="position: absolute;right: 6%;width: auto;height: 6%;">
						</div>
					</div>
				</div>
				<!-- END Trou -->


				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $translation['fermer'][$lang]; ?></button>
				</div>
			</div>

		</div>
	</div>