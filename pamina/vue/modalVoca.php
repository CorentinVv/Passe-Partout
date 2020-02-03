	<!-- Modal QCM-->
	<div id="myModalVoca" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg" style="width: 1050px;">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><?php echo $translation['preview_defi'][$lang]; ?></h4>
				</div>
				<div style="height: 800px;" class="modal-body">


					<!-- TEMPLATE Vocal PREVIEW -->
					<div onclick="event.stopPropagation()" class="tempDefi" style="background-image: url(&quot;/pamina/img/Defi/bleu/fenetrenordals.png&quot;); transform: scale(1, 1);">
						<div class="headDefi">
							<div class="lieu">Haguenau</div>
							<img class="region" src="/pamina/img/Defi/bleu/titrenordals.png">
							<!-- <div class="imgAvatar"><img style="width: 100%;" src="/pamina/img/Avatar/wissembourg.png"></div> -->
						</div>
						<div style="width: 95%;height: 30%;margin-top: 3%;margin-bottom: 8%;display: inline-flex;overflow-wrap: break-word;">
							<div style="margin-left: 3%;width: 100%;text-align: center;">
								<h4 class="titleQuestionVocal">testVoca</h4>
								<p class="questionVoca" style="font-size: large;">testVoca</p>
							</div>
						</div>
						<div style="display: block;width: 100%;text-align: center;height: 70px;">
							<div id="mic">
								<!-- <input type="text" name="textRep" disabled> --> 
								<i style="position: absolute;left: 30%;" title="Clique sur le micro pour répondre" class="fa fa-microphone fa-5x" id="btn" aria-hidden="true"></i>
								<div id="divVoice">
									<p style="font-weight: bold;">Votre réponse : </p><span id="resVoice" style="display: block;"></span>
								</div>
								<!-- <button id="btn">Répondre</button> -->
								<div id="resVoice"></div>
							</div>
							<div id="noMic" style="display: none;">
								<input type="text" name="textRep"><button id="btnText">Répondre</button>
							</div>
						</div>
						<div class="footDefi">
							<div class="helpDoc"><img onclick="openHelp()" class="rotation" src="/pamina/img/Defi/bleu/loupe.png"><!-- <h1>Document</h1> --></div>
							<!-- DIV ANIMATION PION -->
					</div>
				</div>

				<div class="cacheAide" style="display: none;">
					<div id="aidePopup">
						<img onclick="closeHelp()" style="position: absolute;left: 94%;width: 6%;" src="../img/Defi/aide/iconesdocuments-05.png">
						<div id="headHelp">
							<div class="lieuHelp" id="lieuHelpVoca"><img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png"></div>
							<div id="edHelp">Pamina</div>
						</div>
						<div id="bodyHelp">
							<div class="questionHelp" id="questionHelpVoca"></div>
							<div id="imgsHelp">
								<img id="imgHelpVoca" style="width: 220px;height: 160px;margin-right: 10%;" src="">
							</div>
							<div class="txtHelp" id="txtHelpVoca">
								Text
							</div>
							<div id="mediaHelp">
								<video class="mediaStop" style="width: 55%;height: 100%;" controls><source src="" id="videoHelpVoca">Your browser does not support HTML5 video.</video>
								<audio class="mediaStop" style="width: 40%;height: 100%;" controls><source src="" id="sonHelpVoca">Your browser does not support HTML5 video.</audio>
							</div>
						</div>
						<div id="footerHelp">
							<div style="float: right;width: 50%;margin-right: 15%;text-align: right;font-size: 13px;height: 100%;padding-top: 1%;">Télécharger en html 5 pour une consultation hors-ligne</div><img src="../img/Defi/aide/bt_telechargement.png" style="position: absolute;right: 6%;width: auto;height: 6%;">
						</div>
					</div>
				</div>
				<!-- END QCM -->


				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $translation['fermer'][$lang]; ?></button>
				</div>
			</div>

		</div>
	</div>