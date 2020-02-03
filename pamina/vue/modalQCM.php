	<!-- Modal QCM-->
	<div id="myModalQCM" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg" style="width: 1050px;">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><?php echo $translation['preview_defi'][$lang]; ?></h4>
				</div>
				<div style="height: 800px;" class="modal-body">


					<!-- TEMPLATE QCM PREVIEW -->
					<div onclick="event.stopPropagation()" class="tempDefi" style="background-image: url(&quot;/pamina/img/Defi/bleu/fenetrenordals.png&quot;); transform: scale(1, 1);">
						<div class="headDefi">
							<div class="lieu">Saverne</div>
							<img class="region" src="/pamina/img/Defi/bleu/titrenordals.png">
							<!-- <div class="imgAvatar"><img style="width: 100%;" src="/pamina/img/Avatar/wissembourg.png"></div> -->
						</div>
						<div class="contentDefi">
							<div class="imgQuestion"> 
								<!-- <img id="imgQuestionPrev" style="width:100%;" src="/pamina/uploadDefi/defi/97fa4a3e7e23802dd97075eb42ffcc9c.jpg"> -->
								<img id="imgQuestionPrev" style="width:100%;height: 100%;" src="">
							</div> 
								<div class="contentQuestion">
									<h4 class="titleQuestion">Le château de Saverne</h4>
									<p class="question">En quelle année s'est achevée la construction du château de Saverne, aussi appelé château des Rohan ?</p>
									<form class="reponse">
										<input id="rep1Prev" type="radio" name="reponse" value="1" checked="checked">
										<label for="rep1Prev" id="rep1PrevLabel">1681</label><br>

										<input id="rep2Prev" type="radio" name="reponse" value="2">
										<label id="rep2PrevLabel" for="rep2Prev">1779</label><br>

										<input id="rep3Prev" type="radio" name="reponse" value="3">
										<label id="rep3PrevLabel" for="rep3Prev">1789</label><br>

										<input id="rep4Prev" type="radio" name="reponse" value="4">
										<label id="rep4PrevLabel" for="rep4Prev">1790</label><br>

										<input id="rep5Prev" type="radio" name="reponse" value="5">
										<label id="rep5PrevLabel" for="rep5Prev">1793</label><br>
									</form>		
								</div>
							</div>
							<div class="footDefi">
								<div class="helpDoc"><img onclick="openHelp()" class="rotation" src="/pamina/img/Defi/bleu/loupe.png"></div>
								<!-- DIV ANIMATION PION -->

								<div class="validation">
									<img id="validationImg" onmouseover="this.src='/pamina/img/Defi/bleu/valideonnordals.png'" onmouseout="this.src='/pamina/img/Defi/bleu/validoffnordals.png'" src="/pamina/img/Defi/bleu/validoffnordals.png">
								</div>
							</div>


							<div class="cacheAide" style="display: none;">
								<div id="aidePopup">
									<img onclick="closeHelp()" style="position: absolute;left: 94%;width: 6%;" src="../img/Defi/aide/iconesdocuments-05.png">
									<div id="headHelp">
										<div class="lieuHelp" id="lieuHelp">Soufflenheim/Betschdorff<img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png"></div>
										<div id="edHelp">Pamina</div>
									</div>
									<div id="bodyHelp">
										<div class="questionHelp" id="questionHelp">Les poteries en grès au sel, qu'est-ce que c'est ?</div>
										<div id="imgsHelp">
											<img id="imgHelpQCM" style="width: 220px;height: 160px;margin-right: 10%;" src="">
										</div>
										<div class="txtHelp" id="txtHelp">
											Text
										</div>
										<div id="mediaHelp">
											<video class="mediaStop" style="width: 50%;height: 100%;" controls><source src="" id="videoHelpQCM">Your browser does not support HTML5 video.</video>
											<audio class="mediaStop" style="width: 40%;height: 100%;" controls><source src="" id="sonHelpQCM">Your browser does not support HTML5 video.</audio>
										</div>
									</div>
									<div id="footerHelp">
										<div style="float: right;width: 50%;margin-right: 15%;text-align: right;font-size: 13px;height: 100%;padding-top: 1%;">Télécharger en html 5 pour une consultation hors-ligne</div><img src="../img/Defi/aide/bt_telechargement.png" style="position: absolute;right: 6%;width: auto;height: 6%;">
									</div>
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
