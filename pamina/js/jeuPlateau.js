$(document).ready(function() {

	// console.error('WARNING !');
	// console.warn('Cheating results in a ban from your account.');
	// console.error('ATTENTION !');
	// console.warn('Toute personne utilisant cette console pour tricher verra son compte supprimé.');

	dice_initialize(document.getElementById("plateauDe"));

	// Cache de chargement au lancement de la page
	loadingPage = setTimeout(showMap, 1500);
	function showMap() {
		$('.loading-BG').fadeOut("slow");
	}
	
	// Initialisation des éléments
	$('.yellowPoints').mouseover(function() {
		showNom($(this)[0].id);
		showLogo($(this)[0].id+'Logo');
	});	
	$('.yellowPoints').mouseout(function() {
		hideNom($(this)[0].id);
		hideLogo($(this)[0].id+'Logo');
	});

	// ----------------------------------
	// ----------------------------------
	// ----------------------------------
	// -----------INIT Dé----------------
	// ----------------------------------
	// ----------------------------------
	// ----------------------------------

	function dice_initialize(container) {
	    $t.remove($t.id('loading_text'));

	    var canvas = $t.id('canvas');
	    // canvas.style.width = window.innerWidth - 1 + 'px';
	    // canvas.style.height = window.innerHeight - 1 + 'px';
	    // canvas.style.width = window.innerWidth + 'px';
	    // canvas.style.height = window.innerHeight + 'px';
	    canvas.style.width = "20%";
	    canvas.style.height = "20%";
	    // var label = $t.id('label');
	    var set = $t.id('set');
	    var selector_div = $t.id('selector_div');
	    var info_div = $t.id('info_div');
	    on_set_change();

	    /*
	        Possibilité de déplacer la position du dé
	    */

	    if (navigator.userAgent.match(/(android|iphone|blackberry|symbian|symbianos|symbos|netfront|model-orange|javaplatform|iemobile|windows phone|samsung|htc|opera mobile|opera mobi|opera mini|presto|huawei|blazer|bolt|doris|fennec|gobrowser|iris|maemo browser|mib|cldc|minimo|semc-browser|skyfire|teashark|teleca|uzard|uzardweb|meego|nokia|bb10|playbook|mobile|ipad)/gi)) {
	        // alert('mobile');
	        // alert(navigator.userAgent);
	        // alert(navigator.userAgent.match(/(android|iphone|blackberry|symbian|symbianos|symbos|netfront|model-orange|javaplatform|iemobile|windows phone|samsung|htc|opera mobile|opera mobi|opera mini|presto|huawei|blazer|bolt|doris|fennec|gobrowser|iris|maemo browser|mib|cldc|minimo|semc-browser|skyfire|teashark|teleca|uzard|uzardweb|meego|nokia|bb10|playbook|mobile|ipad)/gi));
	    } else {
	        // alert('pc');
	        var etat = false;
	        $(document).keydown(function(e) {
	            if (e.which === 113 && !etat) {
	                $('#canvas').draggable({
	                    containment : "#CanvasCarte"
	                });
	                $('#canvas').draggable("enable");
	                $( document ).on( "mousemove", function( event ) {
	                    $('#canvas').css("left", event.pageX);
	                    $('#canvas').css("top", event.pageY);
	                });
	                etat = true;
	            }else if (e.which === 113 && etat) {
	                $('#canvas').draggable("disable");
	                $(document).off("mousemove");
	                etat = false;
	                // // On sauvegarde la nouvelle position du dé
	                // var session;
	                setPosDe();
	                // function getSession() {
	                //     $.get('../model/getSession.php', function(data) {
	                //         session = JSON.parse(data);
	                //         setPosDe();
	                //     });
	                // }
	                // getSession();
	            }
	        });
	    }

	    // $('#canvas').mouseup(function() {
	    //     $(this).draggable("disable");
	    // });

	    $t.dice.use_true_random = false;

	    function on_set_change(ev) { set.style.width = set.value.length + 3 + 'ex'; }
	    $t.bind(set, 'keyup', on_set_change);
	    $t.bind(set, 'mousedown', function(ev) { ev.stopPropagation(); });
	    $t.bind(set, 'mouseup', function(ev) { ev.stopPropagation(); });
	    $t.bind(set, 'focus', function(ev) { $t.set(container, { class: '' }); });
	    $t.bind(set, 'blur', function(ev) { $t.set(container, { class: 'noselect' }); });

	    // $t.bind($t.id('clear'), ['mouseup', 'touchend'], function(ev) {
	    //     ev.stopPropagation();
	    //     set.value = '0';
	    //     on_set_change();
	    // });

	    var box = new $t.dice.dice_box(canvas, { w: 500, h: 300 });
	    box.animate_selector = false;

	    $t.bind(window, 'resize', function() {
	        // canvas.style.width = window.innerWidth - 1 + 'px';
	        // canvas.style.height = window.innerHeight - 1 + 'px';
	        canvas.style.width = "20%";
	        canvas.style.height = "20%";
	        box.reinit(canvas, { w: 500, h: 300 });
	    });

	    function show_selector() {
	        info_div.style.display = 'none';
	        selector_div.style.display = 'inline-block';
	        box.draw_selector();
	    }

	    function before_roll(vectors, notation, callback) {
	        info_div.style.display = 'none';
	        selector_div.style.display = 'none';

	        // bruit du dé
			readSong('PP_dice.mp3');
	        
	        // do here rpc call or whatever to get your own result of throw.
	        // then callback with array of your result, example:
	        // callback([2, 2, 2, 2]); // for 4d6 where all dice values are 2.
	        // Insérer dans le callback un tableau des résultats souhaités, exemple [2, 2, 2, 2]
	        callback();
	    }

	    function notation_getter() {
	        return $t.dice.parse_notation(set.value);
	    }

	    function after_roll(notation, result) {
	        var res = result.join(' ');
	        if (notation.constant) res += ' +' + notation.constant;
	        if (result.length > 1) res += ' = ' + 
	                (result.reduce(function(s, a) { return s + a; }) + notation.constant);
	        // label.innerHTML = res;
	        info_div.style.display = 'inline-block';
	        // avance le pion
	        TournerDes(result);
	    }

	    box.bind_mouse(container, notation_getter, before_roll, after_roll);
	    box.bind_throw($t.id('canvas'), notation_getter, before_roll, after_roll);

	    $t.bind(container, ['mouseup'], function(ev) {
	        ev.stopPropagation();
	        if (selector_div.style.display == 'none') {
	            if (!box.rolling) show_selector();
	            box.rolling = false;
	            return;
	        }
	        var name = box.search_dice_by_mouse(ev);
	        if (name != undefined) {
	            var notation = $t.dice.parse_notation(set.value);
	            notation.set.push(name);
	            set.value = $t.dice.stringify_notation(notation);
	            on_set_change();
	        }
	    });

	    var params = $t.get_url_params();
	    if (params.notation) {
	        set.value = params.notation;
	    }
	    if (params.roll) {
	        $t.raise_event($t.id('throw'), 'mouseup');
	    }
	    else {
	        show_selector();
	    }

	    // On positionne le dé où l'utilisateur à choisit
		function setPosDe() {
			var posDeLeft = $('#canvas').css("left");
			var posDeTop = $('#canvas').css("top");
			$.ajax({
				url : "../model/setPosDe.php",
				type : "POST",
				data : {idUser : session.id, posDeLeft : posDeLeft, posDeTop : posDeTop},
				success : function(data) {

				}
			});
		}
	}

	// ----------------------------------
	// ----------------------------------
	// ----------------------------------
	// ------------FIN Dé----------------
	// ----------------------------------
	// ----------------------------------
	// ----------------------------------

	// ----------------------------------
	// ----------------------------------
	// ----------------------------------
	// -------------Frise----------------
	// ----------------------------------
	// ----------------------------------
	// ----------------------------------

// $(function(){
	function defiFrise(defi) {
		$('.etiquette').draggable({
	    	containment : ".modal",
	    	stack : ".etiquette",
	    }); 

	    $('.boite').droppable({
	    	accept: '.etiquette',
	    	hoverClass: 'boiteHover',
	    	drop : verifDropLabel,
	    	out : resetCss
	    });

	    // agrandit l'etiquette au click
	    $('.etiquette').click(function() {
	    	$(this).css({
			  '-webkit-transform' : 'scale(3)',
			  '-moz-transform'    : 'scale(3)',
			  '-ms-transform'     : 'scale(3)',
			  '-o-transform'      : 'scale(3)',
			  'transform'         : 'scale(3)',
			  '-webkit-transition' : 'transform 0.5s',
			  '-moz-transition'    : 'transform 0.5s',
			  '-ms-transition'     : 'transform 0.5s',
			  '-o-transition'      : 'transform 0.5s',
			  'transition'         : 'transform 0.5s'
			});
			$(this).draggable("disable");
	    });

	    // remise à zéro de la taille mouseleave
	    $('.etiquette').mouseleave(function() {
			$(this).css({
			  '-webkit-transform' : 'scale(1)',
			  '-moz-transform'    : 'scale(1)',
			  '-ms-transform'     : 'scale(1)',
			  '-o-transform'      : 'scale(1)',
			  'transform'         : 'scale(1)',
			  '-webkit-transition' : 'transform 0.5s',
			  '-moz-transition'    : 'transform 0.5s',
			  '-ms-transition'     : 'transform 0.5s',
			  '-o-transition'      : 'transform 0.5s',
			  'transition'         : 'transform 0.5s'
			});
			$(this).draggable("enable");
	    });


	    // agrandit l'etiquette au click
	  //   $('.etiquette').click(function() {
	  //   	$(this).css({
			//   '-webkit-transform' : 'scale(2)',
			//   '-moz-transform'    : 'scale(2)',
			//   '-ms-transform'     : 'scale(2)',
			//   '-o-transform'      : 'scale(2)',
			//   'transform'         : 'scale(2)',
			//   '-webkit-transition' : 'transform 0.5s',
			//   '-moz-transition'    : 'transform 0.5s',
			//   '-ms-transition'     : 'transform 0.5s',
			//   '-o-transition'      : 'transform 0.5s',
			//   'transition'         : 'transform 0.5s'
			// });
	  //       if ($(this).is('.ui-draggable')) {
	  //           $(this).draggable("disable");
	  //       }
	  //   });
		//  A VERIFIER
	 //    $('.etiquette').on('click touchstart', function (event) {
	 //        $(this).css({
	 //          'height' : 'auto',
	 //          '-webkit-transform' : 'scale(3)',
	 //          '-moz-transform'    : 'scale(3)',
	 //          '-ms-transform'     : 'scale(3)',
	 //          '-o-transform'      : 'scale(3)',
	 //          'transform'         : 'scale(3)',
	 //          '-webkit-transition' : 'transform 0.5s',
	 //          '-moz-transition'    : 'transform 0.5s',
	 //          '-ms-transition'     : 'transform 0.5s',
	 //          '-o-transition'      : 'transform 0.5s',
	 //          'transition'         : 'transform 0.5s'
	 //        });
	 //        if ($(this).is('.ui-draggable')) {
	 //            $(this).draggable("disable");
	 //        }
	 //    });

	 //    // remise à zéro de la taille mouseleave
	 //    $('.etiquette').mouseleave(function() {
		// 	$(this).css({
	 //          'height' : '13.5%',
		// 	  '-webkit-transform' : 'scale(1)',
		// 	  '-moz-transform'    : 'scale(1)',
		// 	  '-ms-transform'     : 'scale(1)',
		// 	  '-o-transform'      : 'scale(1)',
		// 	  'transform'         : 'scale(1)',
		// 	  '-webkit-transition' : 'transform 0.5s',
		// 	  '-moz-transition'    : 'transform 0.5s',
		// 	  '-ms-transition'     : 'transform 0.5s',
		// 	  '-o-transition'      : 'transform 0.5s',
		// 	  'transition'         : 'transform 0.5s'
		// 	});
	 //        if ($(this).is('.ui-draggable')) {
	 //            $(this).draggable("enable");
	 //        }
	 //    });

		// //  A VERIFIER
	 //    $('.etiquette').on('touchend touchcancel', function (event) {
	 //        $(this).css({
	 //          '-webkit-transform' : 'scale(1)',
	 //          '-moz-transform'    : 'scale(1)',
	 //          '-ms-transform'     : 'scale(1)',
	 //          '-o-transform'      : 'scale(1)',
	 //          'transform'         : 'scale(1)',

	 //          '-webkit-transition' : 'transform 0.5s',
	 //          '-moz-transition'    : 'transform 0.5s',
	 //          '-ms-transition'     : 'transform 0.5s',
	 //          '-o-transition'      : 'transform 0.5s',
	 //          'transition'         : 'transform 0.5s'
	 //        });
	 //        if ($(this).is('.ui-draggable')) {
	 //            $(this).draggable("enable");
	 //        }
	 //    });

	    // verification etiquette drop into boite
	    var correctLabel = 0;
	    var erreur = 0;
	    function verifDropLabel(event, ui) {
	    	// $(ui.draggable).detach().css({top: '-3%',left: '-4%',height: '105%',width: '106%'}).appendTo(this);
	    	// on accepte qu'une etiquette a la fois
	    	$(this).droppable('option', 'accept', ui.draggable);

	    	$(ui.draggable).css({top: $(this).css("top"),left: $(this).css("left")});
	    	var boiteDate = $(this).data('dateBox');
	    	var labelDate = ui.draggable.data('dateLabel');
	    	// Si on a juste
	    	if (boiteDate == labelDate) {
	    		$(this).droppable("destroy");
	    		$(ui.draggable).draggable("destroy");
	    		// $(ui.draggable).off();
	    		$(this).children().text(boiteDate);
	    		correctLabel++;
	            checkWin();
	    	}else{
	            erreur++;
	            // on cache une image pour faire perdre une vie
	            $('#vie'+erreur).css({
	                'opacity': '0',
	                '-webkit-transition' : 'opacity 1.5s ease-out',
	                '-moz-transition'    : 'opacity 1.5s ease-out',
	                '-ms-transition'     : 'opacity 1.5s ease-out',
	                '-o-transition'      : 'opacity 1.5s ease-out',
	                'transition'         : 'opacity 1.5s ease-out'
	            });
	    		// fond rouge pour montrer que l'on a faux
	    		$(ui.draggable).css({
				  'background-color': 'red', /* For browsers that do not support gradients */
				  '-webkit-transition' : 'background-color 0.5s ease',
				  '-moz-transition'    : 'background-color 0.5s ease',
				  '-ms-transition'     : 'background-color 0.5s ease',
				  '-o-transition'      : 'background-color 0.5s ease',
				  'transition'         : 'background-color 0.5s ease'
				});
	            checkLoose();
	    	}
	    }

	    function checkWin() {
	    	if (correctLabel == 6) {
	            $('.etiquette').off();
	            closeDefi();
	    	}
	    }
	    function checkLoose() {
	        if (erreur >= 3) {
	            $('.etiquette').off();
	            closeDefi();
	        }
	    }

	    function closeDefi() {
	        // stopDraggalbeAll();
	        // A VOIR AU stopDraggalbeAll
	        setTimeout(function() {
	            checkRepFrise();
	        },500);
	        setTimeout(function() {
	            // bruit de la fenetre qui se ferme
	            readSong('PP_closeWindow.mp3');
	            var d = document.getElementById('cacheDefi');
	            $('.modal').css('transform','scale(0.7,0.7)');
	            d.style.opacity = "0";
	            setTimeout(function() {
	                d.style.display = "none";
	                // debloque le dé
	                var de = document.getElementById('canvas').style;
	                de.pointerEvents = "auto";
	            }, 1500);
	        }, 2500);
	    }

	    //affiche les popups win-loose
	    function checkRepFrise() {
	        if (erreur == 0) {
	            setTimeout(function() {
	                if (langueDefi == session.langue) {
	                    addPoints(30);
	                    $('#win').animate({ opacity: 1, top: "25%", left: '50%' });
	                    // message selon la langue
	                    if (session.langue == "FR") {
	                        $('#win').html("<p>Bravo tu as gagné 30 points !</p>");
	                    }else if (session.langue == "DE") {
	                        $('#win').html("<p>Super, du hast 30 Punkte gewonnen !</p>");
	                    }
	                    // bonne réponse +1
	                    addBonneReponse();
	                }else{
	                    // si on répond dans la langue qui n'est pas la notre
	                    addPoints(60);
	                    $('#win').animate({ opacity: 1, top: "25%", left: '50%' });
	                    // message selon la langue
	                    if (session.langue == "FR") {
	                        $('#win').html("<p>Bravo tu as gagné 60 points !</p>");
	                    }else if (session.langue == "DE") {
	                        $('#win').html("<p>Super, du hast 60 Punkte gewonnen !</p>");
	                    }
	                    // bonne réponse +1
	                    addBonneReponse();
	                    // bonne réponse langue voisin
	                    addBonneReponseVoisin();
	                }

	                setTimeout(function() {
	                    setTimeout(function() {
	                        $('#win').animate({ left: '75%', top: "3%" });
	                    }, 2500);
	                    $('#win').animate({ opacity: 0});
	                }, 3000);

	                // $('#win').html("<p>Bravo vous avez gagné 30 points!</p>");
	                // $('#win').css('top','15%');
	                // setTimeout(function() {
	                //     $('#win').css('top','-25%');
	                // }, 4000);
	            }, 1800);
	        }else if (erreur == 1) {
	            setTimeout(function() {
	                if (langueDefi == session.langue) {
	                    addPoints(20);
	                    $('#win').animate({ opacity: 1, top: "25%", left: '50%' });
	                    // message selon la langue
	                    if (session.langue == "FR") {
	                        $('#win').html("<p>Bravo tu as gagné 25 points !</p>");
	                    }else if (session.langue == "DE") {
	                        $('#win').html("<p>Super, du hast 25 Punkte gewonnen !</p>");
	                    }
	                    // bonne réponse +1
	                    addBonneReponse();
	                }else {
	                    // si on répond dans la langue qui n'est pas la notre
	                    addPoints(40);
	                    $('#win').animate({ opacity: 1, top: "25%", left: '50%' });
	                    // message selon la langue
	                    if (session.langue == "FR") {
	                        $('#win').html("<p>Bravo tu as gagné 50 points !</p>");
	                    }else if (session.langue == "DE") {
	                        $('#win').html("<p>Super, du hast 50 Punkte gewonnen !</p>");
	                    }
	                    // bonne réponse +1
	                    addBonneReponse();
	                    // bonne réponse langue voisin
	                    addBonneReponseVoisin();
	                }

	                setTimeout(function() {
	                    setTimeout(function() {
	                        $('#win').animate({ left: '75%', top: "3%" });
	                    }, 2500);
	                    $('#win').animate({ opacity: 0});
	                }, 3000);
	                // $('#win').html("<p>Bravo vous avez gagné 25 points!</p>");
	                // $('#win').css('top','15%');
	                // setTimeout(function() {
	                //     $('#win').css('top','-25%');
	                // }, 4000);
	            }, 1800);
	        }else if (erreur == 2) {
	            setTimeout(function() {
	                if (langueDefi == session.langue) {
	                    addPoints(10);
	                    $('#win').animate({ opacity: 1, top: "25%", left: '50%' });
	                    // message selon la langue
	                    if (session.langue == "FR") {
	                        $('#win').html("<p>Bravo tu as gagné 20 points !</p>");
	                    }else if (session.langue == "DE") {
	                        $('#win').html("<p>Super, du hast 20 Punkte gewonnen !</p>");
	                    }
	                    // bonne réponse +1
	                    addBonneReponse();
	                }else {
	                    // si on répond dans la langue qui n'est pas la notre
	                    addPoints(20);
	                    $('#win').animate({ opacity: 1, top: "25%", left: '50%' });
	                    // message selon la langue
	                    if (session.langue == "FR") {
	                        $('#win').html("<p>Bravo tu as gagné 40 points !</p>");
	                    }else if (session.langue == "DE") {
	                        $('#win').html("<p>Super, du hast 40 Punkte gewonnen !</p>");
	                    }
	                    // bonne réponse +1
	                    addBonneReponse();
	                    // bonne réponse langue voisin
	                    addBonneReponseVoisin();
	                }

	                setTimeout(function() {
	                    setTimeout(function() {
	                        $('#win').animate({ left: '75%', top: "3%" });
	                    }, 2500);
	                    $('#win').animate({ opacity: 0});
	                }, 3000);
	                // $('#win').html("<p>Bravo vous avez gagné 20 points!</p>");
	                // $('#win').css('top','15%');
	                // setTimeout(function() {
	                //     $('#win').css('top','-25%');
	                // }, 4000);
	            }, 1800);
	        }else{
	            setTimeout(function() {
	            $('#loose').animate({ opacity: 1, top: "25%", left: '50%' });
	            // message selon la langue
	            if (session.langue == "FR") {
	                $('#loose').html("<p>Mince tu as perdu ...</p>");
	            }else if (session.langue == "DE") {
	                $('#loose').html("<p>Schade, du hast verloren ...</p>");
	            }

	            setTimeout(function() {
	                setTimeout(function() {
	                    $('#loose').animate({ left: '75%', top: "3%" });
	                }, 2500);
	                $('#loose').animate({ opacity: 0});
	            }, 3000);
	                // $('#loose').html("<p>Mince vous avez perdu!</p>");
	                // $('#loose').css('top','15%');
	                // setTimeout(function() {
	                //     $('#loose').css('top','-25%');
	                // }, 4000);
	            }, 1800);
	        }
	    }

	    // empeche draggalble apres fin du jeu
	    function stopDraggalbeAll() {
	        $('.etiquette').draggable('destroy');
	    }

	    // reset CSS lorsque l'on sort de la boite
	    function resetCss(event, ui) {
	    	//  on accepte toutes les étiquettes
	    	$(this).droppable('option', 'accept', '.etiquette');

			$(ui.draggable).css({
				'background-color': 'white', /* For browsers that do not support gradients */
				'-webkit-transition' : 'background-color 0.5s ease',
				'-moz-transition'    : 'background-color 0.5s ease',
				'-ms-transition'     : 'background-color 0.5s ease',
				'-o-transition'      : 'background-color 0.5s ease',
				'transition'         : 'background-color 0.5s ease'
			});
	    }

	    // on mélange les étiquettes
		var myLabels = $('.etiquette');
		var nameLabel = ["etiquette1","etiquette2","etiquette3","etiquette4","etiquette5","etiquette6"];
		var defiItemDate = ["item1_date","item2_date","item3_date","item4_date","item5_date","item6_date"];
		shuffle(nameLabel);
		for(var i=0; i<6; i++){
			myLabels[i].setAttribute("id",nameLabel[i]);
		}
		// On set les data des boites
	    $('#boite1').data('dateBox', defi.item1_date);
	    $('#boite2').data('dateBox', defi.item2_date);
	    $('#boite3').data('dateBox', defi.item3_date);
	    $('#boite4').data('dateBox', defi.item4_date);
	    $('#boite5').data('dateBox', defi.item5_date);
	    $('#boite6').data('dateBox', defi.item6_date);
	    // On set les data des etiquettes
	    $('#'+nameLabel[0]).data('dateLabel', defi.item1_date);
	    $('#'+nameLabel[1]).data('dateLabel', defi.item2_date);
	    $('#'+nameLabel[2]).data('dateLabel', defi.item3_date);
	    $('#'+nameLabel[3]).data('dateLabel', defi.item4_date);
	    $('#'+nameLabel[4]).data('dateLabel', defi.item5_date);
	    $('#'+nameLabel[5]).data('dateLabel', defi.item6_date);	

		// });

		// $(ui.draggable) = ETIQUETTE
		// $(this) = BOITE
	}

	// ----------------------------------
	// ----------------------------------
	// ----------------------------------
	// -----------FIN Frise--------------
	// ----------------------------------
	// ----------------------------------
	// ----------------------------------


	// ----------------------------------
	// ----------------------------------
	// ----------------------------------
	// -----------Classement-------------
	// ----------------------------------
	// ----------------------------------
	// ----------------------------------
	function defiClassement(defi) {
		$('.etiquetteClassement').draggable({
	    	containment : ".modal",
	    	stack : ".etiquetteClassement",
	    });

	    $(':regex(id,valise[0-9]) img').droppable({
	    	accept: '.etiquetteClassement',
	    	hoverClass: 'valiseHover',
	    	drop : verifDropLabel,
	    	out : resetCss
	    });


	    // agrandit l'etiquette au click
	    $('.etiquetteClassement').click(function() {
	    	$(this).css({
			  '-webkit-transform' : 'scale(2)',
			  '-moz-transform'    : 'scale(2)',
			  '-ms-transform'     : 'scale(2)',
			  '-o-transform'      : 'scale(2)',
			  'transform'         : 'scale(2)',
			  '-webkit-transition' : 'transform 0.5s',
			  '-moz-transition'    : 'transform 0.5s',
			  '-ms-transition'     : 'transform 0.5s',
			  '-o-transition'      : 'transform 0.5s',
			  'transition'         : 'transform 0.5s'
			});
			$(this).draggable("disable");
	    });

	    // remise à zéro de la taille mouseleave
	    $('.etiquetteClassement').mouseleave(function() {
			$(this).css({
			  '-webkit-transform' : 'scale(1)',
			  '-moz-transform'    : 'scale(1)',
			  '-ms-transform'     : 'scale(1)',
			  '-o-transform'      : 'scale(1)',
			  'transform'         : 'scale(1)',
			  '-webkit-transition' : 'transform 0.5s',
			  '-moz-transition'    : 'transform 0.5s',
			  '-ms-transition'     : 'transform 0.5s',
			  '-o-transition'      : 'transform 0.5s',
			  'transition'         : 'transform 0.5s'
			});
			$(this).draggable("enable");
	    });

	    // verification etiquette drop into boite
	    var correctLabel = 0;
	    var erreur = 0;
	    function verifDropLabel(event, ui) {

	    	var valiseCat = $(this).data('catValise');
	    	var labelCat = ui.draggable.data('catLabel');
	    	// Si on a juste
	    	if (valiseCat == labelCat) {
	            $(ui.draggable).toggle("scale");
	    		correctLabel++;
	            checkWin();
	    	}else{
	            erreur++;
	            // on cache une image pour faire perdre une vie
	            $('#vie'+erreur).css({
	                'opacity': '0',
	                '-webkit-transition' : 'opacity 1.5s ease-out',
	                '-moz-transition'    : 'opacity 1.5s ease-out',
	                '-ms-transition'     : 'opacity 1.5s ease-out',
	                '-o-transition'      : 'opacity 1.5s ease-out',
	                'transition'         : 'opacity 1.5s ease-out'
	            });
	    		// fond rouge pour montrer que l'on a faux
	    		$(ui.draggable).css({
				  'background-color': 'red', /* For browsers that do not support gradients */
				  '-webkit-transition' : 'background-color 0.5s ease',
				  '-moz-transition'    : 'background-color 0.5s ease',
				  '-ms-transition'     : 'background-color 0.5s ease',
				  '-o-transition'      : 'background-color 0.5s ease',
				  'transition'         : 'background-color 0.5s ease'
				});
	            checkLoose();
	    	}
	    }

	    function checkWin() {
	    	if ( ($(':regex(id,valise[0-9]) img').length*5) == correctLabel) {
	            $('.etiquetteClassement').off();
	            closeDefi();
	    	}
	    }
	    function checkLoose() {
	        if (erreur >= 3) {
	            $('.etiquetteClassement').off();
	            closeDefi();
	        }
	    }

	    function closeDefi() {
	        // stopDraggalbeAll();
	        // A VOIR AU stopDraggalbeAll
	        setTimeout(function() {
	            checkRepClassement();
	        },500);
	        setTimeout(function() {
	            // bruit de la fenetre qui se ferme
	            readSong('PP_closeWindow.mp3');
	            var d = document.getElementById('cacheDefi');
	            $('.modal').css('transform','scale(0.7,0.7)');
	            d.style.opacity = "0";
	            setTimeout(function() {
	                d.style.display = "none";
	                // debloque le dé
	                var de = document.getElementById('canvas').style;
	                de.pointerEvents = "auto";
	            }, 1500);
	        }, 2500);
	    }

	    //affiche les popups win-loose
	    function checkRepClassement() {
	        if (erreur == 0) {
	            setTimeout(function() {
	                if (langueDefi == session.langue) {
	                    addPoints(30);
	                    $('#win').animate({ opacity: 1, top: "25%", left: '50%' });
	                    // message selon la langue
	                    if (session.langue == "FR") {
	                        $('#win').html("<p>Bravo tu as gagné 30 points !</p>");
	                    }else if (session.langue == "DE") {
	                        $('#win').html("<p>Super, du hast 30 Punkte gewonnen !</p>");
	                    }
	                    // bonne réponse +1
	                    addBonneReponse();
	                }else{
	                    // si on répond dans la langue qui n'est pas la notre
	                    addPoints(60);
	                    $('#win').animate({ opacity: 1, top: "25%", left: '50%' });
	                    // message selon la langue
	                    if (session.langue == "FR") {
	                        $('#win').html("<p>Bravo tu as gagné 60 points !</p>");
	                    }else if (session.langue == "DE") {
	                        $('#win').html("<p>Super, du hast 60 Punkte gewonnen !</p>");
	                    }
	                    // bonne réponse +1
	                    addBonneReponse();
	                    // bonne réponse langue voisin
	                    addBonneReponseVoisin();
	                }

	                setTimeout(function() {
	                    setTimeout(function() {
	                        $('#win').animate({ left: '75%', top: "3%" });
	                    }, 2500);
	                    $('#win').animate({ opacity: 0});
	                }, 3000);

	                // $('#win').html("<p>Bravo vous avez gagné 30 points!</p>");
	                // $('#win').css('top','15%');
	                // setTimeout(function() {
	                //     $('#win').css('top','-25%');
	                // }, 4000);
	            }, 1800);
	        }else if (erreur == 1) {
	            setTimeout(function() {
	                if (langueDefi == session.langue) {
	                    addPoints(20);
	                    $('#win').animate({ opacity: 1, top: "25%", left: '50%' });
	                    // message selon la langue
	                    if (session.langue == "FR") {
	                        $('#win').html("<p>Bravo tu as gagné 25 points !</p>");
	                    }else if (session.langue == "DE") {
	                        $('#win').html("<p>Super, du hast 25 Punkte gewonnen !</p>");
	                    }
	                    // bonne réponse +1
	                    addBonneReponse();
	                }else {
	                    // si on répond dans la langue qui n'est pas la notre
	                    addPoints(40);
	                    $('#win').animate({ opacity: 1, top: "25%", left: '50%' });
	                    // message selon la langue
	                    if (session.langue == "FR") {
	                        $('#win').html("<p>Bravo tu as gagné 50 points !</p>");
	                    }else if (session.langue == "DE") {
	                        $('#win').html("<p>Super, du hast 50 Punkte gewonnen !</p>");
	                    }
	                    // bonne réponse +1
	                    addBonneReponse();
	                    // bonne réponse langue voisin
	                    addBonneReponseVoisin();
	                }

	                setTimeout(function() {
	                    setTimeout(function() {
	                        $('#win').animate({ left: '75%', top: "3%" });
	                    }, 2500);
	                    $('#win').animate({ opacity: 0});
	                }, 3000);
	                // $('#win').html("<p>Bravo vous avez gagné 25 points!</p>");
	                // $('#win').css('top','15%');
	                // setTimeout(function() {
	                //     $('#win').css('top','-25%');
	                // }, 4000);
	            }, 1800);
	        }else if (erreur == 2) {
	            setTimeout(function() {
	                if (langueDefi == session.langue) {
	                    addPoints(10);
	                    $('#win').animate({ opacity: 1, top: "25%", left: '50%' });
	                    // message selon la langue
	                    if (session.langue == "FR") {
	                        $('#win').html("<p>Bravo tu as gagné 20 points !</p>");
	                    }else if (session.langue == "DE") {
	                        $('#win').html("<p>Super, du hast 20 Punkte gewonnen !</p>");
	                    }
	                    // bonne réponse +1
	                    addBonneReponse();
	                }else {
	                    // si on répond dans la langue qui n'est pas la notre
	                    addPoints(20);
	                    $('#win').animate({ opacity: 1, top: "25%", left: '50%' });
	                    // message selon la langue
	                    if (session.langue == "FR") {
	                        $('#win').html("<p>Bravo tu as gagné 40 points !</p>");
	                    }else if (session.langue == "DE") {
	                        $('#win').html("<p>Super, du hast 40 Punkte gewonnen !</p>");
	                    }
	                    // bonne réponse +1
	                    addBonneReponse();
	                    // bonne réponse langue voisin
	                    addBonneReponseVoisin();
	                }

	                setTimeout(function() {
	                    setTimeout(function() {
	                        $('#win').animate({ left: '75%', top: "3%" });
	                    }, 2500);
	                    $('#win').animate({ opacity: 0});
	                }, 3000);
	                // $('#win').html("<p>Bravo vous avez gagné 20 points!</p>");
	                // $('#win').css('top','15%');
	                // setTimeout(function() {
	                //     $('#win').css('top','-25%');
	                // }, 4000);
	            }, 1800);
	        }else{
	            setTimeout(function() {
	            $('#loose').animate({ opacity: 1, top: "25%", left: '50%' });
	            // message selon la langue
	            if (session.langue == "FR") {
	                $('#loose').html("<p>Mince tu as perdu ...</p>");
	            }else if (session.langue == "DE") {
	                $('#loose').html("<p>Schade, du hast verloren ...</p>");
	            }

	            setTimeout(function() {
	                setTimeout(function() {
	                    $('#loose').animate({ left: '75%', top: "3%" });
	                }, 2500);
	                $('#loose').animate({ opacity: 0});
	            }, 3000);
	                // $('#loose').html("<p>Mince vous avez perdu!</p>");
	                // $('#loose').css('top','15%');
	                // setTimeout(function() {
	                //     $('#loose').css('top','-25%');
	                // }, 4000);
	            }, 1800);
	        }
	    }

	    // empeche draggalble apres fin du jeu
	    function stopDraggalbeAll() {
	        $('.etiquetteClassement').draggable('destroy');
	    }

	    // reset CSS lorsque l'on sort de la boite
	    function resetCss(event, ui) {
	    	//  on accepte toutes les étiquettes
	    	// $(this).droppable('option', 'accept', '.etiquetteClassement');

			$(ui.draggable).css({
				'background-color': 'white', /* For browsers that do not support gradients */
				'-webkit-transition' : 'background-color 0.5s ease',
				'-moz-transition'    : 'background-color 0.5s ease',
				'-ms-transition'     : 'background-color 0.5s ease',
				'-o-transition'      : 'background-color 0.5s ease',
				'transition'         : 'background-color 0.5s ease'
			});
	    }

	    // on mélange les étiquettes
		var myLabels = $('.etiquetteClassement');
		var nameLabel = [];
		for (var i = 0; i < myLabels.length; i++) {
			nameLabel[i] = "etiquetteClmt"+(i+1);
		}
		var defiItemElement = [];
		var counterTabEtiquette = 1;
		for (var j = 1; j <= (myLabels.length/5); j++) {
			for (var k = 1; k <= 5; k++) {
				defiItemElement[counterTabEtiquette] = defi['nom_valise_'+j];
				counterTabEtiquette++;
			}
		}
		shuffle(nameLabel);
		for(var l=0; l<nameLabel.length; l++){		
			myLabels[l].setAttribute("id",nameLabel[l]);
		}
		// On set les data des valises
		for (var m = 0; m < (myLabels.length/5); m++) {
			$("#valise"+(m+1)+" img").data("catValise", defi['nom_valise_'+(m+1)]);
		}

	    // On set les data des etiquettes
	    for (var n = 0; n < myLabels.length; n++) {
	    	$("#"+nameLabel[n]).data("catLabel", defiItemElement[n+1]);
	    }
	}

	// ----------------------------------
	// ----------------------------------
	// ----------------------------------
	// ---------Fin Classement-----------
	// ----------------------------------
	// ----------------------------------
	// ----------------------------------

	// Chargement de la carte
	var carte1 = $('#ed1_view');
	var carte2 = $('#ed2_view');
	var carte3 = $('#ed3_view');
	var carte4 = $('#ed4_view');

	var RotateDes = 360;
	var langue = "";	
	var PositionPion = 0;


jQuery.expr[':'].regex = function(elem, index, match) {
    var matchParams = match[3].split(','),
        validLabels = /^(data|css):/,
        attr = {
            method: matchParams[0].match(validLabels) ? 
                        matchParams[0].split(':')[0] : 'attr',
            property: matchParams.shift().replace(validLabels,'')
        },
        regexFlags = 'ig',
        regex = new RegExp(matchParams.join('').replace(/^s+|s+$/g,''), regexFlags);
    return regex.test(jQuery(elem)[attr.method](attr.property));
}
function SetTransform(e,t){
	e.webkitTransform = t;
	e.MozTransform = t;
	e.msTransform = t;
	e.transform = t;
}
function ZoomOutCarte(){
	var e = document.getElementById("Carte_FR-DE").style;
	e.opacity = "0";
	e.pointerEvents = "none";
	SetTransform(e,"scale(13)");
}
ZoomOutCarte();
var DesAttente;


//Affichage nom onhover point jaune
function showNom(nameLieu) {
	document.getElementById(nameLieu).style.visibility = "visible";
}
// affichage des logos pour chaque lieux
function showLogo(nameLieu){
	document.getElementById(nameLieu).style.visibility = "visible";
}
function hideLogo(nameLieu){
	document.getElementById(nameLieu).style.visibility = "hidden";
}
//On cache le nom onmouseout point jaune
function hideNom(nameLieu) {
	document.getElementById(nameLieu).style.visibility = "hidden";
}

// GESTION INACTIVITE
// // On déclare et initialise les variables utilisée
var activite_detectee = false;
var intervalle = 100;
var temps_inactivite = 0;
var inactivite_persistante = true;
var rdm;
var realTimeInactive = 0;
// On crée la fonction qui teste toutes les x secondes l'activité du visiteur via activite_detectee
function testerActivite() {
  // On teste la variable activite_detectee
     // Si une activité a été détectée [On réinitialise activite_detectee, temps_inactivite et inactivite_persistante]
     if(activite_detectee) {
      // bruit lors du retour du joueur
      if (realTimeInactive > 22500) {
          // bruit du pion au retour du joueur
          rdm = Math.floor((Math.random()*2)+1);
          if (rdm == 1) {
            readSong('PP_etonnement1.mp3');
          }else{
            readSong('PP_interrogation1.mp3');
          }
          realTimeInactive = 0;
      }
       activite_detectee = false;
       temps_inactivite = 0;
       realTimeInactive = 0;
       inactivite_persistante = false;
     }
     // Si aucune activité n'a été détectée [on actualise le statut du visiteur et on teste/met à jour la valeur du temps d'inactivité]
     else {
       // Si l'inactivite est persistante [on met à jour temps_inactivite]
       if(inactivite_persistante) {
         temps_inactivite += intervalle;
         realTimeInactive += intervalle;
         // Si le temps d'inactivite dépasse les 30 secondes
         if(temps_inactivite >= 20000){
            // bruit du pion qui s'ennuye
            rdm = Math.floor((Math.random()*5)+1);
            switch(rdm){
              case 1:
                readSong('PP_ennui.mp3');
                break;
              case 2:
                readSong('PP_ennui2.mp3');
                break;
              case 3:
                readSong('PP_attente1.mp3');
                break;
              case 4:
                readSong('PP_attente2.mp3');
                break;
              case 5:
                readSong('PP_attente3.mp3');
                break;
            }
            temps_inactivite = 0;
         }
       }
       // Si l'inactivite est nouvelle [on met à jour inactivite_persistante]
       else {
         inactivite_persistante = true;
       }
     }
  // On relance la fonction ce qui crée une boucle
  if (typeof testActivite !== 'undefined') {
  	clearTimeout(testActivite);
  }
  // testActivite = setTimeout('testerActivite();', intervalle);
}

// On lance la fonction testerActivite() pour la première fois, au chargement de la page
// testActivite2 = setTimeout('testerActivite();', intervalle);

// On coupe le test d'activité pour ne plus avoir les sons
function stopActivite() {
  // clearTimeout(testActivite2);
  // clearTimeout(testActivite);
}

function setIntervalX(callback, delay, repetitions) {
    var x = 0;
    var intervalID = setInterval(function () {

       callback();

       if (++x === repetitions) {
           clearInterval(intervalID);
       }
    }, delay);
}

var caseRestante = 0;
var etatCarrefour = true;
var avance;
function TournerDes(resultat) {
	testerActivite();
	// bruit du dé
	// readSong('PP_dice.mp3');

	// var num = Math.floor((Math.random() * 6)+1);
	// document.getElementById('des').onclick = "";
	var s = document.getElementById('canvas').style;
	s.pointerEvents = "none";

	var i = 0;
	var txtNextED = "Voulez vous aller à l'ED suivant ?";

	// INIT DIALOG
	// Boite de dialogue personnalisé JqueryUI
	$( "#dialog-confirm" ).dialog({
	  resizable: false,
	  height: "auto",
	  draggable: false,
	  width: 600,
	  modal: true,
	  autoOpen: false,
	  dialogClass: 'mydialog',
	  open: function( event, ui ) {
	  	// on retire 'Close' dans le bouton pour fermer le modal
	  	// tmpModal = event.target.previousElementSibling.children[1];
	  	// $(tmpModal).html($(tmpModal).html().slice(0,-5));
	  	// on retire le bouton close
	  	$('.mydialog > div > button').remove();
	  },
	  buttons: {
	    "Aller à la carte suivante": function() {
	    	$( this ).dialog( "close" );
	    	// OK----------
			goToEd(PosiPoints[PositionPion].goTo);

			// etatCarrefour = false;
			clearInterval(avance);
			var de = document.getElementById('canvas').style;
			de.pointerEvents = "auto";
			// ------------
	    },
	    "Je reste sur cette carte": function() {
	    	clearInterval(avance);
	    	// On ferme dialog
	    	$(this).dialog( "close" );
	    	// $(this).dialog( "destroy" ).remove();

	    	// Animation du vélo 
	    	switch(EDtmp) {
	    		case 1:
	    			myAnim('velo1');
	    			break;
	    		case 2:
	    			myAnim('velo2');
	    			break;
	    		case 3:
	    			myAnim('velo3');
	    			break;
	    		case 4:
	    			myAnim('velo4');
	    			break;
	    	}
	    		        	
	    	setTimeout(function() {

	        	// PAS OK
				// etatCarrefour = false;
				// clearInterval(avance);
				caseRestante = resultat - i;
				setIntervalX(function(){
					i++;
					avancerDe();
					etatCarrefour = true;
					if (i>=resultat) {
						// on sauvegarde la position du pion
						savePionPos(PositionPion,session.id);
						if(PosiPoints[PositionPion].action == "defi") {
							setTimeout(function() {
								lancerDefi();
							},800);
							addLieuVisite();
						}else if (PosiPoints[PositionPion].action == "chance") {
							//case chance
							setTimeout(function() {
								rdmChance();
							},600);
						}
					}
				}, 500, caseRestante);
			// ---------------------------
    		}, 4000);
    	}
  	  }
	});

	// Vérification pour éviter les bugs
	if (PositionPion > PosiPoints.length) {
		PositionPion = 0;
	}

	avance = setInterval(function() {
		// Vérification affichage case carrefour
		checkConditionOk(session);

		// SI L'ON PASSE PAR LA CASE CARREFOUR
		if (PosiPoints[PositionPion].action == "carrefour" && etatCarrefour && conditionCarrefour) {
			// console.log(PosiPoints[PositionPion].goTo);
			// console.log(EDtmp);
			switch(PosiPoints[PositionPion].goTo) {
				case "ED1":
					if (session.langue == "FR") {
						txtNextED = "Bravo !\nTu connais désormais très bien l’Eurodistrict Strasbourg-Ortenau.\nVeux-tu passer à l’Eurodistrict suivant, l’Eurodistrict PAMINA ?\nTu pourras revenir sur cette carte plus tard.";
					} else if (session.langue == "DE") {
						txtNextED = "Super !\nDu kennst den Eurodistrict Strasbourg-Ortenau nun schon sehr gut.\nMöchtest du im nächsten Eurodistrikt weiterspielen, dem Eurodistrikt PAMINA?\nDu kannst später in diese Karte zurückkehren.";
					}
					break;
				case "ED2":
					if (EDtmp == 1) {
						if (session.langue == "FR") {
							txtNextED = "Bravo !\nTu connais désormais très bien l’Eurodistrict PAMINA.\nVeux-tu passer à l’Eurodistrict suivant, l’Eurodistrict Strasbourg-Ortenau ?\nTu pourras revenir sur cette carte plus tard.";
						} else if (session.langue == "DE") {
							txtNextED = "Super !\nDu kennst den Eurodistrikt PAMINA nun schon sehr gut.\nMöchtest du im nächsten Eurodistrikt weiterspielen, dem Eurodistrict Strasbourg-Ortenau?\nDu kannst später in diese Karte zurückkehren.";
						}
					}else if (EDtmp == 3) {
						if (session.langue == "FR") {
							txtNextED = "Bravo !\nTu connais désormais très bien l’Eurodistrict Freiburg / Centre Sud Alsace.\nVeux-tu passer à l’Eurodistrict suivant, l’Eurodistrict Strasbourg-Ortenau ?\nTu pourras revenir sur cette carte plus tard.";
						} else if (session.langue == "DE") {
							txtNextED = "Super !\nDu kennst den Eurodistrikt Region Freiburg / Centre et Sud Alsace nun schon sehr gut.\nMöchtest du im nächsten Eurodistrikt weiterspielen, dem Eurodistrict Strasbourg-Ortenau?\nDu kannst später in diese Karte zurückkehren.";
						}	
					}
					break;
				case "ED3":
					if (EDtmp == 2) {
						if (session.langue == "FR") {
							txtNextED = "Bravo !\nTu connais désormais très bien l’Eurodistrict Strasbourg-Ortenau.\nVeux-tu passer à l’Eurodistrict suivant, l’Eurodistrict Freiburg / Centre Sud Alsace ?\nTu pourras revenir sur cette carte plus tard.";
						} else if (session.langue == "DE") {
							txtNextED = "Super !\nDu kennst den Eurodistrict Strasbourg-Ortenau nun schon sehr gut.\nMöchtest du im nächsten Eurodistrikt weiterspielen, dem Eurodistrikt Region Freiburg / Centre et Sud Alsace?\nDu kannst später in diese Karte zurückkehren.";
						}	
					}else if (EDtmp == 4) {
						if (session.langue == "FR") {
							txtNextED = "Bravo !\nTu connais désormais très bien l’Eurodistrict Trinational de Bâle.\nVeux-tu passer à l’Eurodistrict suivant, l’Eurodistrict Strasbourg-Ortenau ?\nTu pourras revenir sur cette carte plus tard.";
						} else if (session.langue == "DE") {
							txtNextED = "Super !\nDu kennst den trinationalen Eurodistrict Basel nun schon sehr gut.\nMöchtest du im nächsten Eurodistrikt weiterspielen, dem Eurodistrict Strasbourg-Ortenau?\nDu kannst später in diese Karte zurückkehren.";
						}
					}
					break;
				case "ED4":
					if (session.langue == "FR") {
						txtNextED = "Bravo !\nTu connais désormais très bien l’Eurodistrict Freiburg / Centre Sud Alsace.\nVeux-tu passer à l’Eurodistrict suivant, l’Eurodistrict Trinational de Bâle ?\nTu pourras revenir sur cette carte plus tard.";
					} else if (session.langue == "DE") {
						txtNextED = "Super !\nDu kennst den Eurodistrikt Region Freiburg / Centre et Sud Alsace nun schon sehr gut.\nMöchtest du im nächsten Eurodistrikt weiterspielen, dem trinationalen Eurodistrict Basel?\nDu kannst später in diese Karte zurückkehren.";
					}
					break;
			}

			// on ajoute la bonne phrase suivant l'ED dans le modal
			$('#edModalText')[0].innerText = txtNextED;
			$( "#dialog-confirm" ).dialog( "open" );
			
		}else {
			i++;
			avancerDe();
			etatCarrefour = true;
			if (i>=resultat) {
				clearInterval(avance);
				// on sauvegarde la position du pion
				savePionPos(PositionPion,session.id);
				if(PosiPoints[PositionPion].action == "defi") {
					setTimeout(function() {
						lancerDefi();
					},800);
					addLieuVisite();
				}else if (PosiPoints[PositionPion].action == "chance") {
					//case chance
					setTimeout(function() {
						rdmChance();
					},600);
				}else if (PosiPoints[PositionPion].action == "carrefour") {
					// SI ON TOMBE PILE SUR LA CASE CARREFOUR
					// if (confirm("Voulez vous aller à l'ED suivant ?")) {
					// 	goToEd(PosiPoints[PositionPion].goTo);
					// 	clearInterval(avance);
					// 	var de = document.getElementById('canvas').style;
					// 	de.pointerEvents = "auto";
					// }else{
					// 	clearInterval(avance);
					// 	var de = document.getElementById('canvas').style;
					// 	de.pointerEvents = "auto";
					// }
					clearInterval(avance);
					var de = document.getElementById('canvas').style;
					de.pointerEvents = "auto";
				}
			}
		}
	},600);
	//pointer-events : none; http://stackoverflow.com/questions/30364849/run-next-function-after-settimeout-done
}

var switchClass = false;

// fait avancer le pion de X cases
function avancerDe() {
	// bruit du saut du pion
	readSong('PP_bounce.mp3');
	
	// document.getElementById('des').onclick = TournerDes;
	if(++PositionPion >= PosiPoints.length){
		PositionPion = 0;
		// +1 tour
		addTour();
	}

	switch(PosiPoints[PositionPion].direction) {
		case "haut":
			customAnim('haut');
			break;
		case "bas":
			customAnim('bas');
			break;
		case "droite":
			customAnim('droite');
			break;
		case "gauche":
			customAnim('gauche');
			break;
		case "hautGauche":
			customAnim('hautGauche');
			break;
		case "hautDroit":
			customAnim('hautDroit');
			break;
		case "basGauche":
			customAnim('basGauche');
			break;
		case "basDroit":
			customAnim('basDroit');
			break;
		default:
			customAnim('bas');
	}

	// var s=document.getElementById('pion');
	$('.Pions').animate({top: PosiPoints[PositionPion].top + "%", left: PosiPoints[PositionPion].left + "%"}, 550, "swing");
	// s.top = PosiPoints[PositionPion].top + "%";
	// s.left = PosiPoints[PositionPion].left + "%";
}

var session;
var currentED;
function getSession() {
	$.get('../model/getSession.php', function(data) {
		session = JSON.parse(data);

		setEDplayer(session.ed);
		currentED = session.ed;
		
		getScore();
		if (navigator.userAgent.match(/(android|iphone|blackberry|symbian|symbianos|symbos|netfront|model-orange|javaplatform|iemobile|windows phone|samsung|htc|opera mobile|opera mobi|opera mini|presto|huawei|blazer|bolt|doris|fennec|gobrowser|iris|maemo browser|mib|cldc|minimo|semc-browser|skyfire|teashark|teleca|uzard|uzardweb|meego|nokia|bb10|playbook|mobile)/gi)) {
		    // alert('mobile');
		    // alert(navigator.userAgent);
		} else {
		    getPosDe();
		}

		// badges
		nbRepJuste(session.nb_bonne_reponse,[5,10,25,50,100,150,200,250,350,500]);
		nbDefVoisinRep(session.nb_reponse_langue_voisin,[1,5,10,25,50,75,100]);
		nbPoints(session.score,[5,25,50,100,250,500,1000,2500,5000,7500]);
		nbTours(session.nb_tour,[5,10,25,50,75,100,150,200,250,500]);
		nbVisitLieu(session.nb_lieu_visite,[22,44,66,88,111]);
		nbVisitCarte([session.carte1_visite,session.carte2_visite,session.carte3_visite,session.carte4_visite]);

	});
}
getSession();


// 
// 
// 
// 
// 
// 
// DEFI----------------------
// 
// 
// 
// 
// 
// 


function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}

function resetDefiTab() {
	randomDefiTab = [1,2,3,4,5];
}


// charge un défi
var reponseJuste;
var uniqueRep = false;
var langueDefi;
var CounterDefi = 0;
var adresseMap;
var avatar;
var intAttente;

var randomDefiTab = [1,2,3,4,5];
function lancerDefi() {

	var randomDefi = randomDefiTab[Math.floor(Math.random() * randomDefiTab.length)];
	console.log(randomDefiTab);
	console.log(randomDefi);
	
	// var randomDefi = 1;

	switch(randomDefi) {
	    case 1:
	    // ------QCM------
		// on récupère les données du défi à afficher
		$.ajax({
			url : "../model/getDefi.php",
			type : "POST",
			data : {lieu : PosiPoints[PositionPion].lieu, langueJeu : session.langue_jeu},
			success : function(result) {
				stopActivite();
				var defi = JSON.parse(result);
				if (defi.length != 0) {
					// On remet le tableau à zéro
					resetDefiTab();
					// On lance le défi
					launchDefi();
					rdmDefi = Math.floor((Math.random() * defi.length) + 1);
					defi = defi[rdmDefi-1];
					// console.log(defi);
					reponseJuste = defi.nb_reponse_juste;
					langueDefi = defi.langue_defi;
					//chargement du template qcm + envoi des paramètres
					$('#cacheDefi').load("../templateDefi/qcm.php", 
					{'lieu': defi.lieu,'ed': defi.ed,'image': defi.image,'couleur': defi.region,'titre': defi.titre_question,'question': defi.question,'reponse1': defi.reponse1,'reponse2': defi.reponse2,'reponse3': defi.reponse3,'reponse4': defi.reponse4,'reponse5': defi.reponse5,'helpImg': defi.helpImg,'helpTxt': defi.helpTxt,'helpAudio': defi.helpAudio,'helpVideo': defi.helpVideo,'imgQcmOwner': defi.imgQcmOwner,'imgQcmCR': defi.imgQcmCR,'imgHelpOwner': defi.imgHelpOwner,'imgHelpCR': defi.imgHelpCR,'videoHelpOwner': defi.videoHelpOwner,'videoHelpCR': defi.videoHelpCR,'audioHelpOwner': defi.audioHelpOwner,'audioHelpCR': defi.audioHelpCR},
					function() {
						$('#avatar').attr('src', '/pamina/img/Avatar/'+avatar);
						setExprPions(session.avatar);
						// Set events
						$('.pionExpression').mouseover(function() {
							checkStatePion();
						});
						$('.rotation').click(function() {
							openHelp();
						});
						$('.reportDefi').click(function() {
							signalerDefi();
						});
						$('.reportDefi').mouseover(function() {
							hoverSignalerDefi();
						});
						$('.reportDefi').mouseout(function() {
							outSignalerDefi();
						});
						$('#validationImg').click(function() {
							var s = document.getElementById('validationImg').style;
							s.pointerEvents = "none";
							valDefi();
						});
						$('#closeHelp').click(function() {
							closeHelp();
						});
						$('.btnClose').click(function() {
							closeCustomModalSignal();
						});

						// Condition pour qu'une image ne soit pas trop grande
						if ($('#avatar')[0].naturalWidth == "601" && $('#avatar')[0].naturalHeight == "174") {
							$('#avatar').css('width', '100%');
							$('#avatar').css('height', 'initial');
							$('#avatar').css('marginTop', '15%');
						}	

						// Couleur de l'img valider qcm
						setCheckColorQCM(defi.ed,defi.region);

						$('.modal').css("background-image","url(/pamina/img/Defi/"+defi.ed+"/"+defi.region+"/fenetre.png)");
						setTimeout(function() {
							$('.modal').css('opacity','1');
							$('.modal').css('transform','scale(1,1)');
						}, 300);
						setPionExpression();
						adresseMap = defi.adresse;
						initMap();
						// zip 
						dwloadHelpDefi("QCM",defi);
						// Signalement defi
						$('#btnValidSignal').on('click', function() {
							reportDefiProblem(session, defi, "QCM");
						});
						// Expression GRAND
						$(".pionExpression").animateSprite({
						    fps: 5,
						    animations: {
						        win: [0, 1, 2, 3, 4, 5, 6],
						        attente: [11, 12, 13, 14, 15, 16, 17],
						        disparition: [22, 23, 24, 25, 26, 27, 28],
						        apparition: [33, 34, 35, 36, 37, 38, 39],
						        loose: [44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54]
						    },
						    loop: false,
						    complete: function(){
						    }
						});
						setTimeout(function() {
							pionAttente();
							var i = 0;
							intAttente = setInterval(function() {
								if (i == 3) {
									clearInterval(intAttente);
									etatPion="dors";
								}else{
									pionAttente();
									i++;
								}
							}, 5000);
						},500);
						// Clear interval si on répond à la question
						$('#validationImg').on('click', function() {
							clearInterval(intAttente);
						});

						// On récupère le nom de la classe
						$.ajax({
							url : "../model/getUserGroup.php",
							type : "POST",
							data : {id_user : defi.createur_id},
							success : function(groupe) {
								groupe = JSON.parse(groupe);
								if (groupe.length != 0) {
									groupe = groupe[0];
									$.ajax({
										url : "../model/getUserClass.php",
										type : "POST",
										data : {id_class : groupe.id_classe},
										success : function(classe) {
											classe = JSON.parse(classe);
											classe = classe[0];
											var dateDefi = new Date(defi.date_defi);
											annee = dateDefi.getFullYear();
											$('#classOwner').append('<div>'+classe.nom_classe+' - '+annee+'</div>')
										}
									});
								}
							}
						});
					});
				}else{
					if (randomDefiTab.length >=1) {
						removeA(randomDefiTab, 1);
						lancerDefi(randomDefiTab);
					}else{
						// message selon la langue
						if (session.langue == "FR") {
							showMessage("Il n'y a pas assez de défis ici ... À toi de créer de nouveaux défis avec ta classe !");
						}else if (session.langue == "DE") {
							showMessage("Für diesen Ort hast du schon alle Aufgaben gelöst. Nun bist du dran – erstelle neue Aufgaben mit deiner Klasse!");
						}
						var de = document.getElementById('canvas').style;
						de.pointerEvents = "auto";
						// rdmChance();
						CounterDefi = 0;
					}
				}
			},
			error : function(resultat, statut, erreur) {
				// alert(resultat.responseText);
				// alert(statut);
				// alert(erreur);
			}
		});
	        break;
	    case 2:
	    // ------VocaTexte------
		// on récupère les données du défi à afficher
		if (navigator.userAgent.match(/(android|iphone|blackberry|symbian|symbianos|symbos|netfront|model-orange|javaplatform|iemobile|windows phone|samsung|htc|opera mobile|opera mobi|opera mini|presto|huawei|blazer|bolt|doris|fennec|gobrowser|iris|maemo browser|mib|cldc|minimo|semc-browser|skyfire|teashark|teleca|uzard|uzardweb|meego|nokia|bb10|playbook|mobile|ipad)/gi)) {
		    // alert('mobile');
		    lancerDefi();
		} else {
			// alert('pc');
			$.ajax({
				url : "../model/getDefiVocal.php",
				type : "POST",
				data : {lieu : PosiPoints[PositionPion].lieu, langueJeu : session.langue_jeu},
				success : function(result) {
					stopActivite();
					var defi = JSON.parse(result);
					if (defi.length != 0) {
						// On remet le tableau à zéro
						resetDefiTab();
						// On lance le défi
						launchDefi();
						rdmDefi = Math.floor((Math.random() * defi.length) + 1);
						defi = defi[rdmDefi-1];
						// console.log(defi);
						langueDefi = defi.langue_defi;
						
						//chargement du template vocal + envoi des paramètres
						$('#cacheDefi').load("../templateDefi/vocaTxt.php", 
						{'lieu': defi.lieu,'ed': defi.ed,'couleur': defi.region,'titre': defi.titre_question,'question': defi.question,'reponse': defi.reponse,'motCles': defi.mot_cles,'helpImg': defi.helpImg,'helpTxt': defi.helpTxt,'helpAudio': defi.helpAudio,'helpVideo': defi.helpVideo,'imgHelpOwner': defi.imgHelpOwner,'imgHelpCR': defi.imgHelpCR,'videoHelpOwner': defi.videoHelpOwner,'videoHelpCR': defi.videoHelpCR,'audioHelpOwner': defi.audioHelpOwner,'audioHelpCR': defi.audioHelpCR},
						function() {
							$('#avatar').attr('src', '/pamina/img/Avatar/'+avatar);
							setExprPions(session.avatar);
							// Set events
							$('.pionExpression').mouseover(function() {
								checkStatePion();
							});
							$('.rotation').click(function() {
								openHelp();
							});
							$('.reportDefi').click(function() {
								signalerDefi();
							});
							$('.reportDefi').mouseover(function() {
								hoverSignalerDefi();
							});
							$('.reportDefi').mouseout(function() {
								outSignalerDefi();
							});
							$('#validationImg').click(function() {
								valDefi();
							});
							$('#closeHelp').click(function() {
								closeHelp();
							});
							$('.btnClose').click(function() {
								closeCustomModalSignal();
							});

							// Condition pour qu'une image ne soit pas trop grande
							if ($('#avatar')[0].naturalWidth == "601" && $('#avatar')[0].naturalHeight == "174") {
								$('#avatar').css('width', '100%');
								$('#avatar').css('height', 'initial');
								$('#avatar').css('marginTop', '15%');
							}	

							$('.modal').css("background-image","url(/pamina/img/Defi/"+defi.ed+"/"+defi.region+"/fenetre.png)");
							setTimeout(function() {
								$('.modal').css('opacity','1');
								$('.modal').css('transform','scale(1,1)');
							}, 300);	
							callDefiVocaTxt(defi.reponse,defi.mot_cles,defi.langue_defi);
							uniqueRep = false;
							setPionExpression();
							adresseMap = defi.adresse;
							initMap();
							// zip
							dwloadHelpDefi("VocaTxt",defi);
							// Signalement defi
							$('#btnValidSignal').on('click', function() {
								reportDefiProblem(session, defi, "VocaTxt");
							});
							// Expression GRAND
							$(".pionExpression").animateSprite({
							    fps: 5,
							    animations: {
							        win: [0, 1, 2, 3, 4, 5, 6],
							        attente: [11, 12, 13, 14, 15, 16, 17],
							        disparition: [22, 23, 24, 25, 26, 27, 28],
							        apparition: [33, 34, 35, 36, 37, 38, 39],
							        loose: [44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54]
							    },
							    loop: false,
							    complete: function(){
							    }
							});
							setTimeout(function() {
								pionAttente();
								var i = 0;
								intAttente = setInterval(function() {
									if (i == 3) {
										clearInterval(intAttente);
										etatPion="dors";
									}else{
										pionAttente();
										i++;
									}
								}, 5000);
							},500);

							// On récupère le nom de la classe
							$.ajax({
								url : "../model/getUserGroup.php",
								type : "POST",
								data : {id_user : defi.createur_id},
								success : function(groupe) {
									groupe = JSON.parse(groupe);
									if (groupe.length != 0) {
										groupe = groupe[0];
										$.ajax({
											url : "../model/getUserClass.php",
											type : "POST",
											data : {id_class : groupe.id_classe},
											success : function(classe) {
												classe = JSON.parse(classe);
												classe = classe[0];
												var dateDefi = new Date(defi.date_defi);
												annee = dateDefi.getFullYear();
												$('#classOwner').append('<div>'+classe.nom_classe+' - '+annee+'</div>')
											}
										});
									}
								}
							});
						});

					}else{
						if (randomDefiTab.length >=1) {
							removeA(randomDefiTab, 2);
							lancerDefi(randomDefiTab);
						}else{
							// message selon la langue
							if (session.langue == "FR") {
								showMessage("Il n'y a pas assez de défis ici ... À toi de créer de nouveaux défis avec ta classe !");
							}else if (session.langue == "DE") {
								showMessage("Für diesen Ort hast du schon alle Aufgaben gelöst. Nun bist du dran – erstelle neue Aufgaben mit deiner Klasse!");
							}
							var de = document.getElementById('canvas').style;
							de.pointerEvents = "auto";
							// rdmChance();
							CounterDefi = 0;
						}
					}
				},
				error : function(resultat, statut, erreur) {
					// alert(resultat.responseText);
					// alert(statut);
					// alert(erreur);
				}
			});
		}
		
			break;
	    case 3:
	    // ------Frise Chronologique------
		// on récupère les données du défi à afficher
		$.ajax({
			url : "../model/getDefiFrise.php",
			type : "POST",
			data : {lieu : PosiPoints[PositionPion].lieu, langueJeu : session.langue_jeu},
			success : function(result) {
				stopActivite();
				var defi = JSON.parse(result);
				if (defi.length != 0) {
					// On remet le tableau à zéro
					resetDefiTab();
					// On lance le défi
					launchDefi();
					rdmDefi = Math.floor((Math.random() * defi.length) + 1);
					defi = defi[rdmDefi-1];
					// console.log(defi);
					langueDefi = defi.langue_defi;
					
					//chargement du template frise + envoi des paramètres
					$('#cacheDefi').load("../templateDefi/friseChrono.php",
					{'lieu': defi.lieu,'ed': defi.ed,'couleur': defi.region,'titreFrise': defi.titre_frise,'dateDebut': defi.date_debut,'dateFin': defi.date_fin,'item1Date': defi.item1_date,'item1Titre': defi.item1_title,'item1Img': defi.item1_img,'item2Date': defi.item2_date,'item2Titre': defi.item2_title,'item2Img': defi.item2_img,'item3Date': defi.item3_date,'item3Titre': defi.item3_title,'item3Img': defi.item3_img,'item4Date': defi.item4_date,'item4Titre': defi.item4_title,'item4Img': defi.item4_img,'item5Date': defi.item5_date,'item5Titre': defi.item5_title,'item5Img': defi.item5_img,'item6Date': defi.item6_date,'item6Titre': defi.item6_title,'item6Img': defi.item6_img,'helpImg': defi.helpImg,'helpTxt': defi.helpTxt,'helpAudio': defi.helpAudio,'helpVideo': defi.helpVideo,'imgHelpOwner': defi.imgHelpOwner,'imgHelpCR': defi.imgHelpCR,'videoHelpOwner': defi.videoHelpOwner,'videoHelpCR': defi.videoHelpCR,'audioHelpOwner': defi.audioHelpOwner,'audioHelpCR': defi.audioHelpCR,
					'item1Owner': defi.item1Owner,'item1CR': defi.item1CR,'item2Owner': defi.item2Owner,'item2CR': defi.item2CR,'item3Owner': defi.item3Owner,'item3CR': defi.item3CR,'item4Owner': defi.item4Owner,'item4CR': defi.item4CR,'item5Owner': defi.item5Owner,'item5CR': defi.item5CR,'item6Owner': defi.item6Owner,'item6CR': defi.item6CR},
					function() {
						$('#avatar').attr('src', '/pamina/img/Avatar/'+avatar);
						setViePions(session.avatar);
						// Set events
						$('.rotation').click(function() {
							openHelp();
						});
						$('.reportDefi').click(function() {
							signalerDefi();
						});
						$('.reportDefi').mouseover(function() {
							hoverSignalerDefi();
						});
						$('.reportDefi').mouseout(function() {
							outSignalerDefi();
						});
						$('#validationImg').click(function() {
							valDefi();
						});
						$('#closeHelp').click(function() {
							closeHelp();
						});
						$('.btnClose').click(function() {
							closeCustomModalSignal();
						});

						// Condition pour qu'une image ne soit pas trop grande
						if ($('#avatar')[0].naturalWidth == "601" && $('#avatar')[0].naturalHeight == "174") {
							$('#avatar').css('width', '100%');
							$('#avatar').css('height', 'initial');
							$('#avatar').css('marginTop', '15%');
						}

						$('.modal').css("background-image","url(/pamina/img/Defi/"+defi.ed+"/"+defi.region+"/fenetre.png)");
						setTimeout(function() {
							$('.modal').css('opacity','1');
							$('.modal').css('transform','scale(1,1)');
						}, 300);	

						defiFrise(defi);					   

						adresseMap = defi.adresse;
						initMap();
						// zip
						dwloadHelpDefi("Frise",defi);
						// Signalement defi
						$('#btnValidSignal').on('click', function() {
							reportDefiProblem(session, defi, "Frise");
						});

						// On récupère le nom de la classe
						$.ajax({
							url : "../model/getUserGroup.php",
							type : "POST",
							data : {id_user : defi.createur_id},
							success : function(groupe) {
								groupe = JSON.parse(groupe);
								if (groupe.length != 0) {
									groupe = groupe[0];
									$.ajax({
										url : "../model/getUserClass.php",
										type : "POST",
										data : {id_class : groupe.id_classe},
										success : function(classe) {
											classe = JSON.parse(classe);
											classe = classe[0];
											var dateDefi = new Date(defi.date_defi);
											annee = dateDefi.getFullYear();
											$('#classOwner').append('<div>'+classe.nom_classe+' - '+annee+'</div>')
										}
									});
								}
							}
						});
					});

				}else{
					if (randomDefiTab.length >=1) {
						removeA(randomDefiTab, 3);
						lancerDefi(randomDefiTab);
					}else{
						// message selon la langue
						if (session.langue == "FR") {
							showMessage("Il n'y a pas assez de défis ici ... À toi de créer de nouveaux défis avec ta classe !");
						}else if (session.langue == "DE") {
							showMessage("Für diesen Ort hast du schon alle Aufgaben gelöst. Nun bist du dran – erstelle neue Aufgaben mit deiner Klasse!");
						}
						var de = document.getElementById('canvas').style;
						de.pointerEvents = "auto";
						// rdmChance();
						CounterDefi = 0;
					}
				}
			},
			error : function(resultat, statut, erreur) {
				// alert(resultat.responseText);
				// alert(statut);
				// alert(erreur);
			}
		});
	       break;
	    case 4:
	    // ------Texte à trous------
		// on récupère les données du défi à afficher
		$.ajax({
			url : "../model/getDefiTrous.php",
			type : "POST",
			data : {lieu : PosiPoints[PositionPion].lieu, langueJeu : session.langue_jeu},
			success : function(result) {
				stopActivite();
				var defi = JSON.parse(result);
				if (defi.length != 0) {
					// On remet le tableau à zéro
					resetDefiTab();
					// On lance le défi
					launchDefi();
					rdmDefi = Math.floor((Math.random() * defi.length) + 1);
					defi = defi[rdmDefi-1];
					// console.log(defi);
					langueDefi = defi.langue_defi;
					
					//chargement du template Texte à trou + envoi des paramètres
					$('#cacheDefi').load("../templateDefi/txtTrous.php", 
					{'lieu': defi.lieu,'ed': defi.ed,'couleur': defi.region,'titre': defi.titre_question,'question': defi.question,'TAT': defi.texteAtrou,'mots1Trou': defi.mot1,'mots2Trou': defi.mot2,'mots3Trou': defi.mot3,'mots4Trou': defi.mot4,'mots5Trou': defi.mot5,'mots6Trou': defi.mot6,'mots7Trou': defi.mot7,'mots8Trou': defi.mot8,'mots9Trou': defi.mot9,'mots10Trou': defi.mot10,'nbMots': defi.nbMots,'helpImg': defi.helpImg,'helpTxt': defi.helpTxt,'helpAudio': defi.helpAudio,'helpVideo': defi.helpVideo,'imgHelpOwner': defi.imgHelpOwner,'imgHelpCR': defi.imgHelpCR,'videoHelpOwner': defi.videoHelpOwner,'videoHelpCR': defi.videoHelpCR,'audioHelpOwner': defi.audioHelpOwner,'audioHelpCR': defi.audioHelpCR},
					function() {
						$('#avatar').attr('src', '/pamina/img/Avatar/'+avatar);
						setViePions(session.avatar);
						// Set events
						$('.rotation').click(function() {
							openHelp();
						});
						$('.reportDefi').click(function() {
							signalerDefi();
						});
						$('.reportDefi').mouseover(function() {
							hoverSignalerDefi();
						});
						$('.reportDefi').mouseout(function() {
							outSignalerDefi();
						});
						$('#validationImg').click(function() {
							valDefi();
						});
						$('#closeHelp').click(function() {
							closeHelp();
						});
						$('.btnClose').click(function() {
							closeCustomModalSignal();
						});

						// Condition pour qu'une image ne soit pas trop grande
						if ($('#avatar')[0].naturalWidth == "601" && $('#avatar')[0].naturalHeight == "174") {
							$('#avatar').css('width', '100%');
							$('#avatar').css('height', 'initial');
							$('#avatar').css('marginTop', '15%');
						}

						// Couleur de l'img valider trou
						setCheckColorTrou(defi.ed,defi.region);

						$('.modal').css("background-image","url(/pamina/img/Defi/"+defi.ed+"/"+defi.region+"/fenetre.png)");
						setTimeout(function() {
							$('.modal').css('opacity','1');
							$('.modal').css('transform','scale(1,1)');
						}, 300);

						// fonction pour vérifier le texte à trou
						$('#checkTrous').on("click", function() {
					        checkTrous();
					    });

					    // verification des réponses dans les inputs
					    // champs justes
					    var correctInput = 0;
					    // champs faux
					    var erreur = 0;
					    // nombre de vie restante
					    var vie = 3;
					    // nombre de points à gagner
					    var points = 10;

					    // Retire accents + pas de majuscule
					    accentsTidy = function(s){ 
		                    var r=s.toLowerCase(); 
		                    r = r.replace(new RegExp("\\s", 'g'),""); 
		                    r = r.replace(new RegExp("[àáâãäå]", 'g'),"a"); 
		                    r = r.replace(new RegExp("æ", 'g'),"ae"); 
		                    r = r.replace(new RegExp("ç", 'g'),"c"); 
		                    r = r.replace(new RegExp("[èéêë]", 'g'),"e"); 
		                    r = r.replace(new RegExp("[ìíîï]", 'g'),"i"); 
		                    r = r.replace(new RegExp("ñ", 'g'),"n");                             
		                    r = r.replace(new RegExp("[òóôõö]", 'g'),"o"); 
		                    r = r.replace(new RegExp("œ", 'g'),"oe"); 
		                    r = r.replace(new RegExp("[ùúûü]", 'g'),"u"); 
		                    r = r.replace(new RegExp("[ýÿ]", 'g'),"y"); 
		                    r = r.replace(new RegExp("\\W", 'g'),""); 
		                    return r; 
		            	}; 
		            	
					    function checkTrous() {
					    	var reponseTrou = "";
					    	var vraiReponse = "";

					        for (var i = 1; i < defi.nbMots+1; i++) {
					        	reponseTrou = $('#inputTrou'+i).val();
					        	// reponseTrou = reponseTrou.toLowerCase();
					        	reponseTrou = accentsTidy(reponseTrou);
					        	// console.log(reponseTrou);
					        	vraiReponse = defi['mot'+i];
					        	// vraiReponse = vraiReponse.toLowerCase();
					        	vraiReponse = accentsTidy(vraiReponse);
					        	// console.log(vraiReponse);
					        	// si l'on a juste
					        	if (reponseTrou == vraiReponse) {
					        		correctInput++;
					        		$('#inputTrou'+i).css({
										'border-color'		 : 'black',
				                		'background-color'	 : 'lightgreen',
				                		'font-size'	 		 : 'medium'
					        		});
					        		if (correctInput == defi.nbMots) {
					        			WinTrous();
					        		}
					        	}else{
					        		erreur++;
					        		$('#inputTrou'+i).css({
										'border-color'		 : 'black',
				                		'background-color'	 : 'lightcoral',
				                		'font-size'	 		 : 'medium'
					        		});
					        	}
					        }
					        if (erreur>0) {
					        	checkLooseTrous(vie);
					        }
					    }

					    function WinTrous() {
					    	closeDefiTrous();
					        setTimeout(function() {
						        if (langueDefi == session.langue) {
						            addPoints(points*vie);
						            // message selon la langue
									if (session.langue == "FR") {
										showMessagePoints("win", points*vie);
									}else if (session.langue == "DE") {
										showMessagePoints("winDe", points*vie);
									}
						            // bonne réponse +1
									addBonneReponse();
				                }else{
				                	// si on répond dans la langue qui n'est pas la notre
						            addPoints((points*vie)*2);
						            // message selon la langue
									if (session.langue == "FR") {
										showMessagePoints("win", (points*vie)*2);
									}else if (session.langue == "DE") {
										showMessagePoints("winDe", (points*vie)*2);
									}
						            // bonne réponse +1
									addBonneReponse();
									// bonne réponse langue voisin
                    				addBonneReponseVoisin();
				                }
					        },1000);
					    }

					    function checkLooseTrous() {
					    	vie--;
					    	correctInput = 0;
							erreur = 0;
							// on cache une image pour faire perdre une vie
				    		$("#vie"+(vie+1)).css({
				                'opacity': '0',
				                '-webkit-transition' : 'opacity 1.5s ease-out',
				                '-moz-transition'    : 'opacity 1.5s ease-out',
				                '-ms-transition'     : 'opacity 1.5s ease-out',
				                '-o-transition'      : 'opacity 1.5s ease-out',
				                'transition'         : 'opacity 1.5s ease-out'
				            });
					    	if (vie==0) {
						    	closeDefiTrous();
						        setTimeout(function() {
						            // message selon la langue
									if (session.langue == "FR") {
										showMessagePoints("loose");
									}else if (session.langue == "DE") {
										showMessagePoints("looseDe");
									}
						        },1000);
					    	}
					    }

						adresseMap = defi.adresse;
						initMap();
						// zip
						dwloadHelpDefi("TexteTrou",defi);
						// Signalement defi
						$('#btnValidSignal').on('click', function() {
							reportDefiProblem(session, defi, "TexteTrou");
						});

						// On récupère le nom de la classe
						$.ajax({
							url : "../model/getUserGroup.php",
							type : "POST",
							data : {id_user : defi.createur_id},
							success : function(groupe) {
								groupe = JSON.parse(groupe);
								if (groupe.length != 0) {
									groupe = groupe[0];
									$.ajax({
										url : "../model/getUserClass.php",
										type : "POST",
										data : {id_class : groupe.id_classe},
										success : function(classe) {
											classe = JSON.parse(classe);
											classe = classe[0];
											var dateDefi = new Date(defi.date_defi);
											annee = dateDefi.getFullYear();
											$('#classOwner').append('<div>'+classe.nom_classe+' - '+annee+'</div>')
										}
									});
								}
							}
						});
					});

				}else{
					if (randomDefiTab.length >=1) {
						removeA(randomDefiTab, 4);
						lancerDefi(randomDefiTab);
					}else{
						// message selon la langue
						if (session.langue == "FR") {
							showMessage("Il n'y a pas assez de défis ici ... À toi de créer de nouveaux défis avec ta classe !");
						}else if (session.langue == "DE") {
							showMessage("Für diesen Ort hast du schon alle Aufgaben gelöst. Nun bist du dran – erstelle neue Aufgaben mit deiner Klasse!");
						}
						var de = document.getElementById('canvas').style;
						de.pointerEvents = "auto";
						// rdmChance();
						CounterDefi = 0;
					}
				}
			},
			error : function(resultat, statut, erreur) {
				// alert(resultat.responseText);
				// alert(statut);
				// alert(erreur);
			}
		});
	        break;
	    case 5:
	    // ------CLASSEMENT------
		$.ajax({
			url : "../model/getDefiClassement.php",
			type : "POST",
			data : {lieu : PosiPoints[PositionPion].lieu, langueJeu : session.langue_jeu},
			success : function(result) {
				stopActivite();
				var defi = JSON.parse(result);
				if (defi.length != 0) {
					// On remet le tableau à zéro
					resetDefiTab();
					// On lance le défi
					launchDefi();
					rdmDefi = Math.floor((Math.random() * defi.length) + 1);
					defi = defi[rdmDefi-1];
					// console.log(defi);
					langueDefi = defi.langue_defi;
					
					//chargement du template classement + envoi des paramètres
					$('#cacheDefi').load("../templateDefi/classement.php", 
					{'lieu': defi.lieu,'ed': defi.ed,'couleur': defi.region,'titre': defi.titre_question,'question': defi.question,'nbValisette': defi.nbValisette,'nomValise1': defi.nom_valise_1,'nomValise2': defi.nom_valise_2,'nomValise3': defi.nom_valise_3,'nomValise4': defi.nom_valise_4,'nomValise5': defi.nom_valise_5,'typeEtiquette': defi.type_etiquette,
					'valise1etiquette1': defi.valise_1_etiquette_1,'valise1etiquette2': defi.valise_1_etiquette_2,'valise1etiquette3': defi.valise_1_etiquette_3,'valise1etiquette4': defi.valise_1_etiquette_4,'valise1etiquette5': defi.valise_1_etiquette_5,
					'valise2etiquette1': defi.valise_2_etiquette_1,'valise2etiquette2': defi.valise_2_etiquette_2,'valise2etiquette3': defi.valise_2_etiquette_3,'valise2etiquette4': defi.valise_2_etiquette_4,'valise2etiquette5': defi.valise_2_etiquette_5,
					'valise3etiquette1': defi.valise_3_etiquette_1,'valise3etiquette2': defi.valise_3_etiquette_2,'valise3etiquette3': defi.valise_3_etiquette_3,'valise3etiquette4': defi.valise_3_etiquette_4,'valise3etiquette5': defi.valise_3_etiquette_5,
					'valise4etiquette1': defi.valise_4_etiquette_1,'valise4etiquette2': defi.valise_4_etiquette_2,'valise4etiquette3': defi.valise_4_etiquette_3,'valise4etiquette4': defi.valise_4_etiquette_4,'valise4etiquette5': defi.valise_4_etiquette_5,
					'valise5etiquette1': defi.valise_5_etiquette_1,'valise5etiquette2': defi.valise_5_etiquette_2,'valise5etiquette3': defi.valise_5_etiquette_3,'valise5etiquette4': defi.valise_5_etiquette_4,'valise5etiquette5': defi.valise_5_etiquette_5,
					'helpImg': defi.helpImg,'helpTxt': defi.helpTxt,'helpAudio': defi.helpAudio,'helpVideo': defi.helpVideo,'imgHelpOwner': defi.imgHelpOwner,'imgHelpCR': defi.imgHelpCR,'videoHelpOwner': defi.videoHelpOwner,'videoHelpCR': defi.videoHelpCR,'audioHelpOwner': defi.audioHelpOwner,'audioHelpCR': defi.audioHelpCR},
					function() {
						$('#avatar').attr('src', '/pamina/img/Avatar/'+avatar);
						setViePions(session.avatar);

						// Set events
						$('.rotation').click(function() {
							openHelp();
						});
						$('.reportDefi').click(function() {
							signalerDefi();
						});
						$('.reportDefi').mouseover(function() {
							hoverSignalerDefi();
						});
						$('.reportDefi').mouseout(function() {
							outSignalerDefi();
						});
						$('#validationImg').click(function() {
							valDefi();
						});
						$('#closeHelp').click(function() {
							closeHelp();
						});
						$('.btnClose').click(function() {
							closeCustomModalSignal();
						});

						// Condition pour qu'une image ne soit pas trop grande
						if ($('#avatar')[0].naturalWidth == "601" && $('#avatar')[0].naturalHeight == "174") {
							$('#avatar').css('width', '100%');
							$('#avatar').css('height', 'initial');
							$('#avatar').css('marginTop', '15%');
						}	
						
						$('.modal').css("background-image","url(/pamina/img/Defi/"+defi.ed+"/"+defi.region+"/fenetre.png)");
						setTimeout(function() {
							$('.modal').css('opacity','1');
							$('.modal').css('transform','scale(1,1)');
						}, 300);	

						defiClassement(defi);

						adresseMap = defi.adresse;
						initMap();
						// zip
						dwloadHelpDefi("Classement",defi);
						// Signalement defi
						$('#btnValidSignal').on('click', function() {
							reportDefiProblem(session, defi, "Classement");
						});
						
						// On récupère le nom de la classe
						$.ajax({
							url : "../model/getUserGroup.php",
							type : "POST",
							data : {id_user : defi.createur_id},
							success : function(groupe) {
								groupe = JSON.parse(groupe);
								if (groupe.length != 0) {
									groupe = groupe[0];
									$.ajax({
										url : "../model/getUserClass.php",
										type : "POST",
										data : {id_class : groupe.id_classe},
										success : function(classe) {
											classe = JSON.parse(classe);
											classe = classe[0];
											var dateDefi = new Date(defi.date_defi);
											annee = dateDefi.getFullYear();
											$('#classOwner').append('<div>'+classe.nom_classe+' - '+annee+'</div>')
										}
									});
								}
							}
						});
					});

				}else{
					if (randomDefiTab.length >=1) {
						removeA(randomDefiTab, 5);
						lancerDefi(randomDefiTab);
					}else{
						// message selon la langue
						if (session.langue == "FR") {
							showMessage("Il n'y a pas assez de défis ici ... À toi de créer de nouveaux défis avec ta classe !");
						}else if (session.langue == "DE") {
							showMessage("Für diesen Ort hast du schon alle Aufgaben gelöst. Nun bist du dran – erstelle neue Aufgaben mit deiner Klasse!");
						}
						var de = document.getElementById('canvas').style;
						de.pointerEvents = "auto";
						// rdmChance();
						CounterDefi = 0;
					}
				}
			},
			error : function(resultat, statut, erreur) {
				// alert(resultat.responseText);
				// alert(statut);
				// alert(erreur);
			}
		});
			break;
	    // case 5:
	    //     // ------TEXTE A TROU------
	    //     $('#cacheDefi').html("<div class='imgDefi'><img src='/pamina/img/image_memory_classique.png'><div onclick='valDefi();' class='validation'></div></div>");
	    //     break;
	}
	setTimeout(function() {
		// $('.Pions').css('marginLeft','-0.9%');
		$('.Pions').css('backgroundPosition','0% 0%');
	},1500);
}

var etatPion="bouge";
var count=0;
// animation d'attente du pion
function pionAttente() {
	customExprGrand('attente');
}

// regarde si pion dors
function checkStatePion() {
	if (etatPion=="dors") {
		var r = monRandom(1,2);
		switch(r){
			case 1:
				readSong('PP_etonnement2.mp3');
				break;
			case 2:
				readSong('PP_interrogation2.mp3');
				break;
		}
		etatPion="bouge";
		customExprGrand('attente');
		pionAttente();
	}
}

// ferme un defi avec la validation
function valDefi() {
	// Unbind mouse over funtion
	$('.pionExpression').off();
	// clearInterval(interAttente);
	setTimeout(function() {
		validationRep();
	},500);
	
	setTimeout(function() {
		// bruit de la fenetre qui se ferme
		readSong('PP_closeWindow.mp3');

		var d = document.getElementById('cacheDefi');
		$('.modal').css('transform','scale(0.7,0.7)');
		d.style.opacity = "0";
		setTimeout(function() {
			d.style.display = "none";
			// debloque le dé
			var de = document.getElementById('canvas').style;
			de.pointerEvents = "auto";
			var v = document.getElementById('validationImg').style;
			v.pointerEvents = "auto";
		}, 1500);
	}, 2500);
}

// animation réussite
function pionReussite() {
	// clearTimeout(debAttente);
	// clearInterval(interAttente);
	$(".pionExpression").data('animateSprite').settings.fps = 12;
	customExprGrand('win');
}
// animation échec
function pionEchec() {
	// clearTimeout(debAttente);
	// clearInterval(interAttente);
	$(".pionExpression").data('animateSprite').settings.fps = 12;
	customExprGrand('loose');
}

//affiche les popups win-loose
function validationRep() {
	count=3;
	reponse = $("input[name=reponse]:checked", ".reponse").val();
	if (reponse == reponseJuste) {
		pionReussite(); 
		var r = monRandom(1,3);
		switch(r){
			case 1:
				readSong('PP_content1.mp3');
				break;
			case 2:
				readSong('PP_content2.mp3');
				break;
			case 3:
				readSong('PP_content3.mp3');
				break;
		}
		setTimeout(function() {
			if (langueDefi == session.langue) {
				addPoints(10);
				// message selon la langue
				if (session.langue == "FR") {
					showMessagePoints("win", 10);
				}else if (session.langue == "DE") {
					showMessagePoints("winDe", 10);
				}
				// bonne réponse +1
				addBonneReponse();
			}else {
				// si on répond dans la langue qui n'est pas la notre
				addPoints(20);
				// message selon la langue
				if (session.langue == "FR") {
					showMessagePoints("win", 20);
				}else if (session.langue == "DE") {
					showMessagePoints("winDe", 20);
				}
				// bonne réponse +1
				addBonneReponse();
				// bonne réponse langue voisin
				addBonneReponseVoisin();
			}
			// $('#win').html("<p>Bravo vous avez gagné 10 points!</p>");
			// $('#win').css('top','15%');
			// setTimeout(function() {
			// 	$('#win').css('top','-25%');
			// }, 4000);
		}, 1800);
	}else{
		pionEchec();
		var r = monRandom(1,2);
		switch(r){
			case 1:
				readSong('PP_pasContent1.mp3');
				break;
			case 2:
				readSong('PP_pasContent2.mp3');
				break;
		}
		setTimeout(function() {
			// message selon la langue
			if (session.langue == "FR") {
				showMessagePoints("loose",0);
			}else if (session.langue == "DE") {
				showMessagePoints("looseDe",0);
			}
			// $('#loose').html("<p>Mince vous avez perdu!</p>");
			// $('#loose').css('top','15%');
			// setTimeout(function() {
			// 	$('#loose').css('top','-25%');
			// }, 4000);
		}, 1800);
	}
}

//affiche le score
function getScore() {
	$.ajax({
		url : "../model/getScore.php",
		type : "POST",
		data : {idUser : session.id},
		success : function(score) {
			$('#score').fadeOut(100);
			$('#score').html(score);
			$('#score').fadeIn("slow");
			// $('#score').html(score+" Pts");
		}
	});
}

//case chance
function rdmChance() {
	var rdm = Math.random();
	// console.log(rdm);
	switch(true) {
    case rdm>=0 && rdm<=0.35:
        // on gagne 5 points
        addPoints(5);
        // message selon la langue
		if (session.langue == "FR") {
			showMessagePoints('win',5);
		}else if (session.langue == "DE") {
			showMessagePoints('winDe',5);
		}
        // showMessagePoints('loose',5);
        // debloque le dé
		var de = document.getElementById('canvas').style;
		de.pointerEvents = "auto";
        break;
    case rdm>0.35 && rdm<=0.70:
        // on avance jusqu'au prochain défi
    	if(++PositionPion >= PosiPoints.length){
			PositionPion = 0;
		}
		// message selon la langue
		if (session.langue == "FR") {
			showMessage('Oh, un raccourci !');
		}else if (session.langue == "DE") {
			showMessage('Oh, eine Abkürzung !');
		}
		teleportationDefi();
        break;
    case rdm>0.70 && rdm<=1:
    	// message selon la langue
		if (session.langue == "FR") {
			showMessage('Tu peux rejouer !');
		}else if (session.langue == "DE") {
			showMessage('Du darfst noch einmal würfeln.');
		}
    	var de = document.getElementById('canvas').style;
		de.pointerEvents = "auto";
        break;
    default :
        var de = document.getElementById('canvas').style;
			de.pointerEvents = "auto";
	}
}

// Animation de téléportation + lancement défi suivant
function teleportationDefi() {
	// Save position
	savePionPos(PositionPion,session.id);
	// animation de la disparition
	setTimeout(function() {
		readSong('PP_teleportation.mp3');
		// $('.Pions').css('marginLeft','-0.8%');
		customAnim('disparition');
	},500);
	// position
	setTimeout(function() {
		// $('.Pions').css('visibility', 'hidden');
		// readSong('PP_reapparition1.wav');
		readSong('PP_reapparition2.wav');
		goToNextDefi();
	},1500);
	// apparition
	setTimeout(function() {
		// $('.Pions').css('marginLeft','-0.7%');
		// $('.Pions').css('visibility', 'visible');
		customAnim('apparition');
		setTimeout(function() {
			lancerDefi();
			addLieuVisite();
		},1500);
	},2000);

	
}
// Va au prochain défi
function goToNextDefi() {

	while(PosiPoints[PositionPion].action != "defi") {
		PositionPion++;
		if(PositionPion >= PosiPoints.length){
			PositionPion = 0;
		}
	}
	var s=document.getElementById('pion').style;
    s.top = PosiPoints[PositionPion].top + "%";
	s.left = PosiPoints[PositionPion].left + "%";
}

// fonction pour ajouter des points
function addPoints(p) {
	$.ajax({
		url : "../model/addPoints.php",
		type : "POST",
		data : {idUser : session.id,points : p},
		success : function() {
			getScore();
			// $('#Calque_Badge').css('overflow', '');
			// $('#Calque_Badge').css('overflow', 'visible');
		}
	});
}

// affiche un popup descendant
function showMessagePoints(etat,points) {
	// VERSION FRANCAISE
	if (etat == "win") {
		$('#win').animate({ opacity: 1, top: "20%", left: '45%' });
		$('#win').html("<p>Bravo tu as gagné "+points+" points !</p>");

		setTimeout(function() {
			setTimeout(function() {
				$('#win').animate({ left: '75%', top: "3%" });
			}, 2500);
			$('#win').animate({ opacity: 0});
		}, 3000);
	}	
	// VERSION ALLEMANDE
	if (etat == "winDe") {
		$('#win').animate({ opacity: 1, top: "20%", left: '45%' });
		$('#win').html("<p>Super, du hast "+points+" Punkte gewonnen !</p>");

		setTimeout(function() {
			setTimeout(function() {
				$('#win').animate({ left: '75%', top: "3%" });
			}, 2500);
			$('#win').animate({ opacity: 0});
		}, 3000);
	}

	if (etat == "loose") {
		$('#loose').animate({ opacity: 1, top: "20%", left: '45%' });
		$('#loose').html("<p>Mince tu as perdu ...</p>");

		setTimeout(function() {
			setTimeout(function() {
				$('#loose').animate({ left: '75%', top: "3%" });
			}, 2500);
			$('#loose').animate({ opacity: 0});
		}, 3000);
	}
	if (etat == "looseDe") {
		$('#loose').animate({ opacity: 1, top: "20%", left: '45%' });
		$('#loose').html("<p>Schade, du hast verloren ...</p>");

		setTimeout(function() {
			setTimeout(function() {
				$('#loose').animate({ left: '75%', top: "3%" });
			}, 2500);
			$('#loose').animate({ opacity: 0});
		}, 3000);
	}
	// if (couleur == "green") {
	// 	$('#win').html("<p>Bravo tu as gagné "+points+" points !</p>");
	// 	$('#win').css('top','15%');
	// 	setTimeout(function() {
	// 		$('#win').css('top','-25%');
	// 	}, 4000);
	// }
	// if (couleur == "red") {
	// 	$('#loose').html("<p>Mince tu as perdu "+points+" points ...</p>");
	// 	$('#loose').css('top','15%');
	// 	setTimeout(function() {
	// 		$('#loose').css('top','-25%');
	// 	}, 4000);
	// }
}
// affiche un popup descendant
function showMessage(message) {	
	// $('#win').animate({ opacity: 1, top: "20%", left: '45%' });
	// $('#win').html("<p>"+message+"</p>");

	// setTimeout(function() {
	// 	setTimeout(function() {
	// 		$('#win').animate({ left: '75%', top: "3%" });
	// 	}, 2500);
	// 	$('#win').animate({ opacity: 0});
	// }, 3000);

	// $('#loose').html("<p>"+message+"</p>");
	// $('#loose').css('top', '25%');
	// $('#loose').css('left', '50%');
	// setTimeout(function() {
	// 	$('#loose').css('top', '3%');
	// 	$('#loose').css('left', '75%');
	// }, 4000);

				// .queue(function() {
			 //      console.log("END2");
			 //      $(this).dequeue();
			 //   })


	$('#win').animate({top: "25%", left: '35%' }, {
					duration: 300,
					done: function() {
						$(this)[0].style.opacity = 1;
					},
					complete: function() {
						$(this).html("<p>"+message+"</p>")
					}
				})
				.delay(5000)
				.animate({ opacity: 0, left: '75%', top: "3%" }, {
					duration: 300,
					done: function() {

					},
					complete: function() {

					}
				})
	;

}

function hoverSignalerDefi() {
	$('#hoverSignalerDefi').show();
}
function outSignalerDefi() {
	$('#hoverSignalerDefi').hide();
}
// affiche le modal
function signalerDefi() {
	$("#customModalSignal").show();
}
// cache le modal
function closeCustomModalSignal() {
	$("#customModalSignal").hide();
}
// report BDD defi
function reportDefiProblem(session, defi, type) {
	// id de la personne qui fait le signalement
	reporterId = session.id;
	// nom de la personne qui fait le signalement
	reporterFullName = session.prenom+" "+session.nom;
	// email de la personne qui fait le signalement
	reporterEmail = session.email;
	// id du defi signalé
	reportDefiId = defi.id;
	// lieu du défi signalé
	reportLieu = defi.lieu;
	// type du défi signalé
	reportDefiType = type;
	// titre du défi signalé
	// reportTitre = defi.titre_question;
	// SI defi.titre_question est undefined alors reportTitre vaut defi.titre_frise sinon defi.titre_question
	reportTitre = defi.titre_question === undefined ? defi.titre_frise : defi.titre_question;
	// console.log(reportTitre);
	// type de l'erreur
	reportType = $('#reportType').val();
	// Description de l'erreur
	reportDesc = $('#reportDesc').val();
	// créateur du défi
	reportOwnerId = defi.createur_id;

	// console.log(session);
	// console.log(defi);
	// requete ajax
	$.ajax({
		url : "../model/signalerDefi.php",
		type : "POST",
		data : {reporterId : reporterId, fullName : reporterFullName, email : reporterEmail, defiId : reportDefiId, lieu : reportLieu, typeDefi : reportDefiType, titre : reportTitre, errorType : reportType, description : reportDesc, creatorId : reportOwnerId},
		success : function(data) {
			$('#successMessage').show();
		},
		error : function(data) {
			$('#errorMessage').show();
		}
	});
}


// affiche aide à la réponse
function openHelp() {
	$('#cacheAide').css('display','block');
}

// ferme l'aide à la réponse
function closeHelp() {
	$('#cacheAide').css('display','none');
	// Arret des médias lorsque l'on ferme le modal d'aide au défi
	$(".mediaStop").each(function() {

	    $(this)[0].pause();

	}); 
}

// gère le defi Vocal et texte
function callDefiVocaTxt(repCorrect,motCles,langue) {
	$('#mic').hide();
    $('#noMic').show();

	var $btn = $('#btn');
	var words = null;

	if (navigator.userAgent.match(/(android|iphone|blackberry|symbian|symbianos|symbos|netfront|model-orange|javaplatform|iemobile|windows phone|samsung|htc|opera mobile|opera mobi|opera mini|presto|huawei|blazer|bolt|doris|fennec|gobrowser|iris|maemo browser|mib|cldc|minimo|semc-browser|skyfire|teashark|teleca|uzard|uzardweb|meego|nokia|bb10|playbook|mobile|firefox)/gi)) {
	    // console.log(navigator.userAgent);
	} else {
		var constraints = window.constraints = {
		    audio: true
		};
	    $('#noMic').hide();
		$('#mic').show();
	}

	// Si la personne clique sur le bouton "je n'ai pas de micro"
	$('#iHaveNoMic').click(function() {
		$('#mic').hide();
    	$('#noMic').show();
	});

	navigator.mediaDevices.getUserMedia(constraints)
    .then(function(res) {
    	
		// This API is currently prefixed in Chrome
		var SpeechRecognition = (
		  window.SpeechRecognition ||
		  window.webkitSpeechRecognition
		);

		// Create a new recognizer
		var recognizer = new SpeechRecognition();
		// Set the language of the recognizer
		if (langue == "DE") {
			// console.log("DE");
			recognizer.lang = 'de-DE';
		}else if (langue == "FR") {
			// console.log("FR");
			recognizer.lang = 'fr-FR';
		}else{
			// console.log("MIXTE");
		}
		recognizer.continuous = false;
		// Start producing results before the person has finished speaking
		recognizer.interimResults = true;

		$btn.click(function(e) {
			e.preventDefault();
			recognizer.start();
		});

		// Define a callback to process results
		recognizer.onresult = function (event) {
	        $('#resVoice').text('');
	        for (var i = event.resultIndex; i < event.results.length; i++) {
	          var phrase = event.results[i][0].transcript;
	          if (event.results[i].isFinal) {
	            $('#resVoice').text(phrase);
	            recognizer.stop();
	            words = phrase.split(' ');
	            if (!uniqueRep) {
	              isCorrect(phrase,words);
	            }
	            // console.log(words);
	            return true;
	          }
	          $('#resVoice').text($('#resVoice').text() + phrase);
	        }
		}
		// Si il n'y a pas de microphone
	})
    .catch(function(error) {
      $('#mic').hide();
      $('#noMic').show();
	});

	$('#inputNoMic').keypress(function(e) {
        if(e.which == 13) {
          e.preventDefault();
          phrase = $('#inputNoMic').val();
          words = phrase.split(' ');
          if (!uniqueRep) {
            isCorrect(phrase,words);
          }
          $('#resText').text($('#inputNoMic').val());
        }
      });

	// ajout event bouton répondre
	  $('#btnNoMic').on('click touchstart', function(e) {
	    e.preventDefault();
	      phrase = $('#inputNoMic').val();
	      words = phrase.split(' ');
	      if (!uniqueRep) {
	        isCorrect(phrase,words);
	      }
	      $('#resText').text($('#inputNoMic').val());
	  });

	isCorrect = function(repPhrase,repMots) {
		// Unbind mouse over funtion
		$('.pionExpression').off();
		// Clear interval si on répond à la question
		clearInterval(intAttente);

		if (repPhrase == repCorrect) {
			pionReussite();
			closeDefiVocaTxt(2);
		}else {
			var juste = true;
			motClesCorrect = motCles.split(' ');
			while(juste == true) {
				repMots.forEach(function(mots) {
					var index = motClesCorrect.indexOf(mots);
					if (index == -1) {
						
					}else{
						pionReussite();
						closeDefiVocaTxt(1);
						juste = false;
					}
				});
				if (juste) {
					pionEchec();
					juste = false;
					closeDefiVocaTxt(0);
				}
			}
		}
		uniqueRep = true;
	}
	// console.log(uniqueRep);
}

// Ferme le défi vocale/texte
function closeDefiVocaTxt(score) {
    // stopDraggalbeAll();
    // A VOIR AU stopDraggalbeAll

    // clearInterval(interAttente); A AJOUTER AU CAS OU ANOMATION VOCAL BUG

    setTimeout(function() {
        checkRepVocaTxt(score);
    },500);
    setTimeout(function() {
        // bruit de la fenetre qui se ferme
        readSong('PP_closeWindow.mp3');
        var d = document.getElementById('cacheDefi');
        $('.modal').css('transform','scale(0.7,0.7)');
        d.style.opacity = "0";
        setTimeout(function() {
            d.style.display = "none";
            // debloque le dé
            var de = document.getElementById('canvas').style;
            de.pointerEvents = "auto";
        }, 1500);
    }, 2500);
}
// affiche les popups win-loose VocaTxt
function checkRepVocaTxt(points) {
    if (points == 2) {
        setTimeout(function() {
        	if (langueDefi == session.langue) {
        		addPoints(25);
        		// message selon la langue
				if (session.langue == "FR") {
					showMessagePoints("win",25);
				}else if (session.langue == "DE") {
					showMessagePoints('winDe',25);
				}
	            // bonne réponse +1
				addBonneReponse();
        	}else {
        		// si on répond dans la langue qui n'est pas la notre
	            addPoints(50);
	            // message selon la langue
				if (session.langue == "FR") {
					showMessagePoints("win",50);
				}else if (session.langue == "DE") {
					showMessagePoints('winDe',50);
				}
	            // bonne réponse +1
				addBonneReponse();
				// bonne réponse langue voisin
				addBonneReponseVoisin();
        	}
            // $('#win').html("<p>Bravo vous avez gagné 30 points!</p>");
            // $('#win').css('top','15%');
            // setTimeout(function() {
            //     $('#win').css('top','-25%');
            // }, 4000);
        }, 1800);
    }else if (points == 1) {
        setTimeout(function() {
        	if (langueDefi == session.langue) {
            	addPoints(20);
            	// message selon la langue
				if (session.langue == "FR") {
					showMessagePoints("win",20);
				}else if (session.langue == "DE") {
					showMessagePoints('winDe',20);
				}
            	// bonne réponse +1
				addBonneReponse();
        	}else{
        		// si on répond dans la langue qui n'est pas la notre
            	addPoints(40);
            	// message selon la langue
				if (session.langue == "FR") {
					showMessagePoints("win",40);
				}else if (session.langue == "DE") {
					showMessagePoints('winDe',40);
				}
            	// bonne réponse +1
				addBonneReponse();
				// bonne réponse langue voisin
				addBonneReponseVoisin();
        	}

            // $('#win').html("<p>Bravo vous avez gagné 20 points!</p>");
            // $('#win').css('top','15%');
            // setTimeout(function() {
            //     $('#win').css('top','-25%');
            // }, 4000);
        }, 1800);
    }else if (points == 0) {
        setTimeout(function() {
        	// message selon la langue
			if (session.langue == "FR") {
				showMessagePoints("loose",0);
			}else if (session.langue == "DE") {
				showMessagePoints("looseDe",0);
			}
            // $('#loose').html("<p>Mince vous avez perdu!</p>");
            // $('#loose').css('top','15%');
            // setTimeout(function() {
            //     $('#loose').css('top','-25%');
            // }, 4000);
        }, 1800);
    }
}
// **************** FIN VOCA TXT **************** 
/*
************************************************
************************************************
*/

/**
 * Shuffles array in place.
 * @param {Array} a items The array containing the items.
 */
function shuffle(a) {
    var j, x, i;
    for (i = a.length; i; i--) {
        j = Math.floor(Math.random() * i);
        x = a[i - 1];
        a[i - 1] = a[j];
        a[j] = x;
    }
}

// Lance un son
function readSong(name) {
	var audio = new Audio('/pamina/son/'+name);
	audio.play();
	// audio.onended = function() {
	// 	return true;
	// }
}

function setPionExpression() {
	$('#pionPos').dblclick(function() {
		readSong('PP_laugh.mp3');
	});
}

// Ma focntion random avec range
function monRandom(a,b) {
	var res = Math.floor((Math.random()*b)+a);
	return res;
}

// son lorsque l'on clique sur le pion 
function pionSon() {
	var rs = monRandom(1,3);
	switch(rs){
      case 1:
        readSong('PP_content1.mp3');
        break;
      case 2:
        readSong('PP_content2.mp3');
        break;
      case 3:
        readSong('PP_content3.mp3');
        break;
    }
}
// bouton de retour hover effect
// $(document).ready(function() {
	$('#btnHover').hover(function() {
		$('#btnRetourHover1').css('stroke', 'orange');
		$('#btnRetourHover2').css('fill', 'orange');
		$('#btnRetourHover3').css('fill', 'orange');
	},function() {
		$('#btnRetourHover1').css('stroke', 'white');
		$('#btnRetourHover2').css('fill', '#a82980');
		$('#btnRetourHover3').css('fill', '#a82980');
	});
	$('#Calque_1_1_').hover(function() {
		$('#btnRetourHover1').css('stroke', 'orange');
		$('#btnRetourHover2').css('fill', 'orange');
		$('#btnRetourHover3').css('fill', 'orange');
	},function() {
		$('#btnRetourHover1').css('stroke', 'white');
		$('#btnRetourHover2').css('fill', '#a82980');
		$('#btnRetourHover3').css('fill', '#a82980');
	});
	$('#btnHover').click(function() {
		window.location.replace("jeuAccueil.php");
	});
	$('#Calque_1_1_').click(function() {
		window.location.replace("jeuAccueil.php");
	});
	
// });

// bouton des badges hover effect
// $(document).ready(function() {
	$('#btnBadge').hover(function() {
		$('#btnBadgeHover1').css('stroke', 'orange');
		$('#btnBadgeHover2').css('fill', 'orange');
		$('#btnBadgeHover3').css('fill', 'orange');
		$('#btnBadgeHover4').css('fill', 'orange');
		$('#btnBadgeHover5').css('fill', 'orange');
		$('#btnBadgeHover6').css('fill', 'orange');
	},function() {
		$('#btnBadgeHover1').css('stroke', 'white');
		$('#btnBadgeHover2').css('fill', '#a82980');
		$('#btnBadgeHover3').css('fill', '#a82980');
		$('#btnBadgeHover4').css('fill', '#a82980');
		$('#btnBadgeHover5').css('fill', '#a82980');
		$('#btnBadgeHover6').css('fill', '#a82980');
	});
	$('#Calque_1_2_ > *').hover(function() {
		$('#btnBadgeHover1').css('stroke', 'orange');
		$('#btnBadgeHover2').css('fill', 'orange');
		$('#btnBadgeHover3').css('fill', 'orange');
		$('#btnBadgeHover4').css('fill', 'orange');
		$('#btnBadgeHover5').css('fill', 'orange');
		$('#btnBadgeHover6').css('fill', 'orange');
	},function() {
		$('#btnBadgeHover1').css('stroke', 'white');
		$('#btnBadgeHover2').css('fill', '#a82980');
		$('#btnBadgeHover3').css('fill', '#a82980');
		$('#btnBadgeHover4').css('fill', '#a82980');
		$('#btnBadgeHover5').css('fill', '#a82980');
		$('#btnBadgeHover6').css('fill', '#a82980');
	});

	// Affichage des badges
	$('#btnBadge').click(function() {
		$('#cacheBadges').css('position', 'absolute');
		$('#cacheBadges').css('opacity', '1');
	});
	$('#Calque_1_2_ > *').click(function() {
		$('#cacheBadges').css('position', 'absolute');
		$('#cacheBadges').css('opacity', '1');
	});

	// ----------------Fonction affichage des badges---------------
	// Nombre de bonnes réponses
	function nbRepJuste(inputPlayer,palier) {
		$.each(palier, function(index, value){
			if (inputPlayer>=value) {
				// on affiche les badges
				$("#img1_"+(index+1)).css('visibility', 'visible');
			}
		});
	}
	// Nombre de défis répondus dans la langue voisine
	function nbDefVoisinRep(inputPlayer,palier) {
		$.each(palier, function(index, value){
			if (inputPlayer>=value) {
				// on affiche les badges
				$("#img2_"+(index+1)).css('visibility', 'visible');
			}
		});
	}
	// Nombre de points
	function nbPoints(inputPlayer,palier) {
		$.each(palier, function(index, value){
			if (inputPlayer>=value) {
				// on affiche les badges
				$("#img3_"+(index+1)).css('visibility', 'visible');
			}
		});
	}
	// Nombre de tours
	function nbTours(inputPlayer,palier) {
		$.each(palier, function(index, value){
			if (inputPlayer>=value) {
				// on affiche les badges
				$("#img4_"+(index+1)).css('visibility', 'visible');
			}
		});
	}
	// Nombre de Lieux visités
	function nbVisitLieu(inputPlayer,palier) {
		$.each(palier, function(index, value){
			if (inputPlayer>=value) {
				// on affiche les badges
				$("#img5_"+(index+1)).css('visibility', 'visible');
			}
		});
	}
	// Nombre de cartes visitées
	function nbVisitCarte(inputPlayer) {
		$.each(inputPlayer, function(index, value) {
			if (Number(value)) {
				// on affiche les badges
				$("#img6_"+(index+1)).css('visibility', 'visible');
			}
		});
	}
	
// });

// SIDE MAP
$('#Calque_Map path').hover(function() {
	$(this).css('fill', 'yellow');
	if ($(this).next()[0].id == "carte2") {
		$(this).nextAll().stop().fadeIn();
	}else if ($(this).next()[0].id == "carte3") {
		$('#carte3').stop().fadeIn();
		$('#carte3bis').stop().fadeIn();
		$('#carte3tris').stop().fadeIn();
	}else if ($(this).next()[0].id == "carte4") {
		$('#carte4').stop().fadeIn();
		$('#carte4bis').stop().fadeIn();
	}else{
		$(this).next().stop().fadeIn();
	}
},function() {
	$(this).css('fill', '');
	if ($(this).next()[0].id == "carte2") {
		$(this).nextAll().stop().fadeOut();
	}else if ($(this).next()[0].id == "carte3") {
		$('#carte3').stop().fadeOut();
		$('#carte3bis').stop().fadeOut();
		$('#carte3tris').stop().fadeOut();		
	}else if ($(this).next()[0].id == "carte4") {
		$('#carte4').stop().fadeOut();
		$('#carte4bis').stop().fadeOut();		
	}else{
		$(this).next().stop().fadeOut();
	}
});


// Téléchargement de l'aide au défi
function dwloadHelpDefi(type,defi) {
	$('#DwloadHelp').click(function(e) {

		// e.preventDefault();  //stop the browser from following
  		//   	window.location.href = '../download/test.txt';
        $('a#DwloadHelp').attr({target: '_blank',href  : '../download/'+type+'/'+type+defi.id+'.zip'});


	});	
}

// TEXTE A TROU
// Fermeture de la fenetre défi
function closeDefiTrous() {
    // on ferme la fenetre
    setTimeout(function() {
        // bruit de la fenetre qui se ferme
        readSong('PP_closeWindow.mp3');
        var d = document.getElementById('cacheDefi');
        $('.modal').css('transform','scale(0.7,0.7)');
        d.style.opacity = "0";
        setTimeout(function() {
            d.style.display = "none";
            // debloque le dé
            var de = document.getElementById('canvas').style;
            de.pointerEvents = "auto";
        }, 1500);
    }, 2000);
}

// ---------------------GOOGLE MAP---------------------
function initMap(){
	var map = new google.maps.Map(document.getElementById('map_canvas'), {
      zoom: 13,
      center: {lat: -34.397, lng: 150.644}
    });
	var geocoder = new google.maps.Geocoder();

	var adresse = adresseMap;

	geocodeAddress(geocoder, map, adresse);

	$('#cacheDefi > div > div.footDefi > div.helpDoc > img').click(function() {
		google.maps.event.trigger(map, 'resize');
	});
	
	// geocoder.getLatLng(address, function(point) {
	//          var latitude = point.y;
	//          var longitude = point.x;  

	//          alert("latitude : ".latitude+"longitude : "+longitude);
	// });
}

function geocodeAddress(geocoder, resultsMap, adresse) {
	// 	var myOptions = {
// 		zoom:14,center:new google.maps.LatLng(50,6),mapTypeId: google.maps.MapTypeId.ROADMAP
// 	};
    var address = adresse;
    geocoder.geocode({'address': address}, function(results, status) {
      if (status === 'OK') {


        var lat = results[0].geometry.location.lat();
        var lng = results[0].geometry.location.lng();

        

        var marker = new google.maps.Marker({
          map: resultsMap,
          position: results[0].geometry.location
        });
		
		resultsMap.setCenter(new google.maps.LatLng(lat+0.00955, lng-0.01255));        


      } else {
      	$('#map_canvas').empty();
        // console.log('Geocode was not successful for the following reason: ' + status);
      }
    });
}

// ------------------------------------------------
// ---------------Gestion des badges---------------
// ------------------------------------------------

// nombre de tour +1
function addTour() {
	$.ajax({
		url : "../model/badge/addTours.php",
		type : "POST",
		data : {idUser : session.id, ed : currentED},
		success : function(data) {
			
		}
	});
}
// nombre de bonne réponse +1
function addBonneReponse() {
	$.ajax({
		url : "../model/badge/addBonneRep.php",
		type : "POST",
		data : {idUser : session.id, ed : currentED},
		success : function(data) {

		}
	});
}
// nombre de bonne réponse dans l'autre langue +1
function addBonneReponseVoisin() {
	$.ajax({
		url : "../model/badge/addBonneRepVoisin.php",
		type : "POST",
		data : {idUser : session.id, ed : currentED},
		success : function(data) {
		// console.log("repvoisin +1");
		}
	});
}
// nombre de lieu visité +1
function addLieuVisite() {
	$.ajax({
		url : "../model/badge/addVisitLieu.php",
		type : "POST",
		data : {idUser : session.id, ed : currentED},
		success : function(data) {
		
		}
	});
}
// nombre de lieu visité +1
function addCarteVisite(carteNum) {
	$.ajax({
		url : "../model/badge/addVisitCarte.php",
		type : "POST",
		data : {idUser : session.id, carteNum : carteNum},
		success : function(data) {

		}
	});
}

// On positionne le dé où l'utilisateur à choisit
function getPosDe() {
	var positionDe;
	$.ajax({
		url : "../model/getPosDe.php",
		type : "POST",
		data : {idUser : session.id},
		success : function(data) {
			positionDe = JSON.parse(data);
			positionDe = positionDe[0];
			if (positionDe.de_left != 0 && positionDe.de_top != 0) {
				$('#canvas').css("left", positionDe.de_left+"px");
                $('#canvas').css("top", positionDe.de_top+"px");
			}
		}
	});
}

// On positionne le pion au dernier endroit sauvegarder
function setPosPion(position) {
  	PositionPion = position;

  	// Vérification pour éviter les bugs
	if (PositionPion > PosiPoints.length) {
		PositionPion = 0;
	}
	// var startPion=document.getElementById('pion').style;
	// var startPion= $('.Pions')[(EDtmp-1)].style === undefined ? $('.Pions')[(EDtmp-1)].style : $('.Pions')[0].style;
	var startPion= $('.Pions')[0].style;
	startPion.top = PosiPoints[PositionPion].top + "%";
	startPion.left = PosiPoints[PositionPion].left + "%";

	setPionsPlayer(session.avatar);
}

// Sauvegarde de la position du pion 
function savePionPos(posPion, id) {
	var savePosPion = posPion;
	var id = id;
	$.ajax({
		url : "../model/savePosPion.php",
		type : "POST",
		data : {posPion : savePosPion, idUser : id},
		success : function(data) {

		}
	});
}

// visualisation des avatars de site sur les poitns jaunes pour les mobile/talbette
$('.yellowPoints').on('touchstart', function (e) {
	// console.log(this.id);
	e.stopPropagation();
	showNom(this.id)
	showLogo(this.id+"Logo");
});

$('.yellowPoints').on('touchend', function (e) {
	// console.log(this.id);
	e.stopPropagation();
	hideNom(this.id)
	hideLogo(this.id+"Logo");
});

// lancement d'un défi
function launchDefi() {
	// avatar de site image
	avatar = PosiPoints[PositionPion].avatar;
	
	var d = document.getElementById('cacheDefi');
	d.style.position = "fixed";
	d.style.display = "block";
	// effet fade in
	setTimeout(function() {
		// bruit de la fenetre qui s'ouvre
		readSong('PP_openWindow.mp3');

		d.style.opacity = "1";
	}, 400);
}

var EDtmp,divED1,divED2,divED3;

// Changement d'Eurodistrict
function goToEd(ed) {
	if (ed == "ED1") {

		EDtmp = 1;
		etatCarrefour = true;

		// Update de l'eurodistrict
		currentED = "ED1";
		saveED("ED1", session.id);

		if (divED1 !== undefined) {
			// On restaure l'ED1
			divED1.prependTo('body');
		}
		
		// on supprime la carte précédente
		divED2 = $('#ed2_view').detach();
		// $('#ed1_view').hide();

		// Animation 
		myAnim('boatUp1');

		PosiPoints = PosiPoints1;
		setPosPion(58);

	}else if (ed == "ED2") {
		etatCarrefour = true;

		// Update de l'eurodistrict
		currentED = "ED2";
		saveED("ED2", session.id);

		if (divED2 !== undefined) {
			// On restaure l'ED2
			divED2.prependTo('body');
		}

		// $('#ed1_view').hide();

		PosiPoints = PosiPoints2;
		// on place le pion suivant l'eurodistrict d'où il vient
		if (EDtmp == 1) {
			// On vient de l'ED1
			myAnim('boatDown2');

			// on supprime la carte précédente
			divED1 = $('#ed1_view').detach();
			setPosPion(54);
			EDtmp = 2;
		}else if (EDtmp == 3) {
			// On vient de l'ED3
			myAnim('boatUp2');
			// on supprime la carte précédente
			divED3 = $('#ed3_view').detach();
			setPosPion(35);
			EDtmp = 2;
		}

	}else if (ed == "ED3") {
		etatCarrefour = true;

		// Update de l'eurodistrict
		currentED = "ED3";
		saveED("ED3", session.id);

		if (divED3 !== undefined) {
			// On restaure l'ED3
			divED3.prependTo('body');
		}

		PosiPoints = PosiPoints3;
		// on place le pion suivant l'eurodistrict d'où il vient
		if (EDtmp == 2) {
			// On vient de l'ED2
			myAnim('boatDown3');

			// on supprime la carte précédente
			divED2 = $('#ed2_view').detach();
			setPosPion(41);
			EDtmp = 3;
		}else if (EDtmp == 4) {
			// On vient de l'ED4
			myAnim('boatUp3');

			// on supprime la carte précédente
			divED4 = $('#ed4_view').detach();
			setPosPion(9);
			EDtmp = 3;
		}

	}else if (ed == "ED4") {
		// On vient de l'ED3
		myAnim('boatDown4');

		EDtmp = 4;
		etatCarrefour = true;

		// Update de l'eurodistrict
		currentED = "ED4";
		saveED("ED4", session.id);

		if (divED4 !== undefined) {
			// On restaure l'ED1
			divED4.prependTo('body');
		}
		
		// on supprime la carte précédente
		divED3 = $('#ed3_view').detach();
		// $('#ed1_view').hide();

		PosiPoints = PosiPoints4;
		setPosPion(18);
		
	}
}

// save eurodistrict
function saveED(ed, idUser) {
	$.ajax({
		url : "../model/updateED.php",
		type : "POST",
		data : {eurodistrict : ed, idUser : idUser},
		success : function(data) {

		}
	});
}

// Affiche le pion du joueur
function setPionsPlayer(p) {
	switch(p) {
		case 'pions-01.png':
			// pion BRUN
			$('.Pions').css('background', 'url("../img/Sprite/pionbrun.png")');
			$('.pionExpression').css('background', 'url("../img/Sprite/pionbrunexpressiongrand.png")');
			break;
		case 'pions-02.png':
			// pion VERT
			$('.Pions').css('background', 'url("../img/Sprite/pionvert.png")');
			$('.pionExpression').css('background', 'url("../img/Sprite/pionvertexpressiongrand.png")');
			break;
		case 'pions-03.png':
			// pion BLEU
			$('.Pions').css('background', 'url("../img/Sprite/pionbleu.png")');
			$('.pionExpression').css('background', 'url("../img/Sprite/pionbleuexpressiongrand.png")');
			break;
		case 'pions-04.png':
			// pion JAUNE
			$('.Pions').css('background', 'url("../img/Sprite/pionjaune.png")');
			$('.pionExpression').css('background', 'url("../img/Sprite/pionjauneexpressiongrand.png")');
			break;
		default:
			// pion BRUN
			$('.Pions').css('background', 'url("../img/Sprite/pionbrun.png")');
			$('.pionExpression').css('background', 'url("../img/Sprite/pionbrunexpressiongrand.png")');
			break;
	}
}
// Affiche le pion du joueur
function setExprPions(p) {
	switch(p) {
		case 'pions-01.png':
			// pion BRUN
			$('.pionExpression').css('background', 'url("../img/Sprite/pionbrunexpressiongrand.png")');
			break;
		case 'pions-02.png':
			// pion VERT
			$('.pionExpression').css('background', 'url("../img/Sprite/pionvertexpressiongrand.png")');
			break;
		case 'pions-03.png':
			// pion BLEU
			$('.pionExpression').css('background', 'url("../img/Sprite/pionbleuexpressiongrand.png")');
			break;
		case 'pions-04.png':
			// pion JAUNE
			$('.pionExpression').css('background', 'url("../img/Sprite/pionjauneexpressiongrand.png")');
			break;
		default:
			// pion BRUN
			$('.pionExpression').css('background', 'url("../img/Sprite/pionbrunexpressiongrand.png")');
			break;
	}
}
// Affiche les vies avec le bon pion
function setViePions(p) {
	switch(p) {
		case 'pions-01.png':
			// pion BRUN
			$('#vie1').attr('src', '../img/Pions/pions-01.png');
			$('#vie2').attr('src', '../img/Pions/pions-01.png');
			$('#vie3').attr('src', '../img/Pions/pions-01.png');
			break;
		case 'pions-02.png':
			// pion VERT
			$('#vie1').attr('src', '../img/Pions/pions-02.png');
			$('#vie2').attr('src', '../img/Pions/pions-02.png');
			$('#vie3').attr('src', '../img/Pions/pions-02.png');
			break;
		case 'pions-03.png':
			// pion BLEU
			$('#vie1').attr('src', '../img/Pions/pions-03.png');
			$('#vie2').attr('src', '../img/Pions/pions-03.png');
			$('#vie3').attr('src', '../img/Pions/pions-03.png');
			break;
		case 'pions-04.png':
			// pion JAUNE
			$('#vie1').attr('src', '../img/Pions/pions-04.png');
			$('#vie2').attr('src', '../img/Pions/pions-04.png');
			$('#vie3').attr('src', '../img/Pions/pions-04.png');
			break;
		default:
			// pion BRUN
			break;
	}
}

// charge le bon Eurodistrict du joueur quand il arrive sur le jeu
function setEDplayer(ed) {
	switch(ed) {
		case 'ED1': 
			PosiPoints = PosiPoints1;
			EDtmp=1;
			divED2 = $('#ed2_view').detach();
			divED3 = $('#ed3_view').detach();
			divED4 = $('#ed4_view').detach();
			setTimeout(function(){
				setPionsPlayer(session.avatar);
				setPosPion(parseInt(session.position));
			}, 200);
			break;
		case 'ED2':
			PosiPoints = PosiPoints2;
			EDtmp=2;
			divED1 = $('#ed1_view').detach();
			divED3 = $('#ed3_view').detach();
			divED4 = $('#ed4_view').detach();
			setTimeout(function(){
				setPionsPlayer(session.avatar);
				setPosPion(parseInt(session.position));
			}, 200);
			break;
		case 'ED3':
			PosiPoints = PosiPoints3;
			EDtmp=3;
			divED1 = $('#ed1_view').detach();
			divED2 = $('#ed2_view').detach();
			divED4 = $('#ed4_view').detach();
			setTimeout(function(){
				setPionsPlayer(session.avatar);
				setPosPion(parseInt(session.position));
			}, 200);
			break;
		case 'ED4':
			PosiPoints = PosiPoints4;
			EDtmp=4;
			divED1 = $('#ed1_view').detach();
			divED2 = $('#ed2_view').detach();
			divED3 = $('#ed3_view').detach();
			setTimeout(function(){
				setPionsPlayer(session.avatar);
				setPosPion(parseInt(session.position));
			}, 200);
			break;
		default:
	}
}


// Vérification des conditions pour activer les cases carrefours
var conditionCarrefour = false;

function checkConditionOk(session) {
	// Si toutes les cartes n'ont pas été visitées
	if (!parseInt(session.all_carte_visited)) {
		switch(currentED) {
			case "ED1":
				if ((session.nb_tour_ed1 >= 13) && (session.nb_bonne_reponse_ed1 >= 25)) {
					conditionCarrefour = true;
					addCarteVisite(1);
				}else{
					conditionCarrefour = false;
				}
				break;
			case "ED2":
				if ((session.nb_tour_ed2 >= 13) && (session.nb_bonne_reponse_ed2 >= 25)) {
					conditionCarrefour = true;
					addCarteVisite(2);
				}else{
					conditionCarrefour = false;
				}
				break;
			case "ED3":
				if ((session.nb_tour_ed3 >= 13) && (session.nb_bonne_reponse_ed3 >= 25)) {
					conditionCarrefour = true;
					addCarteVisite(3);
				}else{
					conditionCarrefour = false;
				}
				break;
			case "ED4":
				if ((session.nb_tour_ed4 >= 13) && (session.nb_bonne_reponse_ed4 >= 25)) {
					conditionCarrefour = true;
					addCarteVisite(4);
				}else{
					conditionCarrefour = false;
				}
				break;
		}
		if (session.carte1_visite && session.carte2_visite && session.carte3_visite && session.carte4_visite) {
			addCarteVisite(200);
		}
	// Si toutes les cartes ont été visitées
	}else{
		switch(currentED) {
			case "ED1":
				if ((session.nb_tour_ed1 >= 13) && (session.nb_bonne_reponse_ed1 >= 25)) {
					conditionCarrefour = true;
				}else{
					conditionCarrefour = false;
				}
				break;
			case "ED2":
				if ((session.nb_tour_ed2 >= 13) && (session.nb_bonne_reponse_ed2 >= 25)) {
					conditionCarrefour = true;
				}else{
					conditionCarrefour = false;
				}
				break;
			case "ED3":
				if ((session.nb_tour_ed3 >= 13) && (session.nb_bonne_reponse_ed3 >= 25)) {
					conditionCarrefour = true;
				}else{
					conditionCarrefour = false;
				}
				break;
			case "ED4":
				if ((session.nb_tour_ed4 >= 13) && (session.nb_bonne_reponse_ed4 >= 25)) {
					conditionCarrefour = true;
				}else{
					conditionCarrefour = false;
				}
				break;
		}
	}

}

// Couleur de l'img valider qcm
function setCheckColorQCM(edNumber,region) {
 switch (edNumber) {
      case 'ED1':
        switch (region) {
          case 'alsace':
            $('#validationImg').attr("src", "/pamina/img/Defi/ED1/alsace/validoff.png");
            $('#validationImg').mouseover(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED1/alsace/validon.png");
            });
            $('#validationImg').mouseout(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED1/alsace/validoff.png");
            });
            break;
          case 'mittlerer':
            $('#validationImg').attr("src", "/pamina/img/Defi/ED1/mittlerer/validoff.png");
            $('#validationImg').mouseover(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED1/mittlerer/validon.png");
            });
            $('#validationImg').mouseout(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED1/mittlerer/validoff.png");
            });
            break;
          case 'sudpfalz':
            $('#validationImg').attr("src", "/pamina/img/Defi/ED1/sudpfalz/validoff.png");
            $('#validationImg').mouseover(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED1/sudpfalz/validon.png");
            });
            $('#validationImg').mouseout(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED1/sudpfalz/validoff.png");
            });
            break;
        }
        break;
      case 'ED2':
        switch ($('#couleur').val()) {
          case 'erstein':
            $('#validationImg').attr("src", "/pamina/img/Defi/ED2/erstein/validoff.png");
            $('#validationImg').mouseover(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED2/erstein/validon.png");
            });
            $('#validationImg').mouseout(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED2/erstein/validoff.png");
            });
            break;
          case 'molsheim':
            $('#validationImg').attr("src", "/pamina/img/Defi/ED2/molsheim/validoff.png");
            $('#validationImg').mouseover(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED2/molsheim/validon.png");
            });
            $('#validationImg').mouseout(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED2/molsheim/validoff.png");
            });
            break;
          case 'ortenau':
            $('#validationImg').attr("src", "/pamina/img/Defi/ED2/ortenau/validoff.png");
            $('#validationImg').mouseover(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED2/ortenau/validon.png");
            });
            $('#validationImg').mouseout(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED2/ortenau/validoff.png");
            });
            break;
          case 'strasbourg':
            $('#validationImg').attr("src", "/pamina/img/Defi/ED2/strasbourg/validoff.png");
            $('#validationImg').mouseover(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED2/strasbourg/validon.png");
            });
            $('#validationImg').mouseout(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED2/strasbourg/validoff.png");
            });
            break;
        }
        break;
      case 'ED3':
        switch ($('#couleur').val()) {
          case 'all_fcsa':
            $('#validationImg').attr("src", "/pamina/img/Defi/ED3/all_fcsa/validoff.png");
            $('#validationImg').mouseover(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED3/all_fcsa/validon.png");
            });
            $('#validationImg').mouseout(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED3/all_fcsa/validoff.png");
            });
            break;
          case 'fr_fcsa':
            $('#validationImg').attr("src", "/pamina/img/Defi/ED3/fr_fcsa/validoff.png");
            $('#validationImg').mouseover(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED3/fr_fcsa/validon.png");
            });
            $('#validationImg').mouseout(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED3/fr_fcsa/validoff.png");
            });
            break;
        }
        break;
      case 'ED4':
        switch ($('#couleur').val()) {
          case 'all_ETB':
            $('#validationImg').attr("src", "/pamina/img/Defi/ED3/fr_fcsa/validoff.png");
            $('#validationImg').mouseover(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED4/all_ETB/validon.png");
            });
            $('#validationImg').mouseout(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED4/all_ETB/validoff.png");
            });
            break;
          case 'ch_ETB':
            $('#validationImg').attr("src", "/pamina/img/Defi/ED4/ch_ETB/validoff.png");
            $('#validationImg').mouseover(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED4/ch_ETB/validon.png");
            });
            $('#validationImg').mouseout(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED4/ch_ETB/validoff.png");
            });
            break;
          case 'fr_ETB':
            $('#validationImg').attr("src", "/pamina/img/Defi/ED4/fr_ETB/validoff.png");
            $('#validationImg').mouseover(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED4/fr_ETB/validon.png");
            });
            $('#validationImg').mouseout(function() {
              $('#validationImg').attr("src", "/pamina/img/Defi/ED4/fr_ETB/validoff.png");
            });
            break;
        }
        break;
      
      default:

        break;
    }
}
// Couleur de l'img valider trou
function setCheckColorTrou(edNumber,region) {
 switch (edNumber) {
      case 'ED1':
        switch (region) {
          case 'alsace':
            $('#checkTrous').attr("src", "/pamina/img/Defi/ED1/alsace/validoff.png");
            $('#checkTrous').mouseover(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED1/alsace/validon.png");
            });
            $('#checkTrous').mouseout(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED1/alsace/validoff.png");
            });
            break;
          case 'mittlerer':
            $('#checkTrous').attr("src", "/pamina/img/Defi/ED1/mittlerer/validoff.png");
            $('#checkTrous').mouseover(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED1/mittlerer/validon.png");
            });
            $('#checkTrous').mouseout(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED1/mittlerer/validoff.png");
            });
            break;
          case 'sudpfalz':
            $('#checkTrous').attr("src", "/pamina/img/Defi/ED1/sudpfalz/validoff.png");
            $('#checkTrous').mouseover(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED1/sudpfalz/validon.png");
            });
            $('#checkTrous').mouseout(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED1/sudpfalz/validoff.png");
            });
            break;
        }
        break;
      case 'ED2':
        switch ($('#couleur').val()) {
          case 'erstein':
            $('#checkTrous').attr("src", "/pamina/img/Defi/ED2/erstein/validoff.png");
            $('#checkTrous').mouseover(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED2/erstein/validon.png");
            });
            $('#checkTrous').mouseout(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED2/erstein/validoff.png");
            });
            break;
          case 'molsheim':
            $('#checkTrous').attr("src", "/pamina/img/Defi/ED2/molsheim/validoff.png");
            $('#checkTrous').mouseover(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED2/molsheim/validon.png");
            });
            $('#checkTrous').mouseout(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED2/molsheim/validoff.png");
            });
            break;
          case 'ortenau':
            $('#checkTrous').attr("src", "/pamina/img/Defi/ED2/ortenau/validoff.png");
            $('#checkTrous').mouseover(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED2/ortenau/validon.png");
            });
            $('#checkTrous').mouseout(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED2/ortenau/validoff.png");
            });
            break;
          case 'strasbourg':
            $('#checkTrous').attr("src", "/pamina/img/Defi/ED2/strasbourg/validoff.png");
            $('#checkTrous').mouseover(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED2/strasbourg/validon.png");
            });
            $('#checkTrous').mouseout(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED2/strasbourg/validoff.png");
            });
            break;
        }
        break;
      case 'ED3':
        switch ($('#couleur').val()) {
          case 'all_fcsa':
            $('#checkTrous').attr("src", "/pamina/img/Defi/ED3/all_fcsa/validoff.png");
            $('#checkTrous').mouseover(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED3/all_fcsa/validon.png");
            });
            $('#checkTrous').mouseout(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED3/all_fcsa/validoff.png");
            });
            break;
          case 'fr_fcsa':
            $('#checkTrous').attr("src", "/pamina/img/Defi/ED3/fr_fcsa/validoff.png");
            $('#checkTrous').mouseover(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED3/fr_fcsa/validon.png");
            });
            $('#checkTrous').mouseout(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED3/fr_fcsa/validoff.png");
            });
            break;
        }
        break;
      case 'ED4':
        switch ($('#couleur').val()) {
          case 'all_ETB':
            $('#checkTrous').attr("src", "/pamina/img/Defi/ED3/fr_fcsa/validoff.png");
            $('#checkTrous').mouseover(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED4/all_ETB/validon.png");
            });
            $('#checkTrous').mouseout(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED4/all_ETB/validoff.png");
            });
            break;
          case 'ch_ETB':
            $('#checkTrous').attr("src", "/pamina/img/Defi/ED4/ch_ETB/validoff.png");
            $('#checkTrous').mouseover(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED4/ch_ETB/validon.png");
            });
            $('#checkTrous').mouseout(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED4/ch_ETB/validoff.png");
            });
            break;
          case 'fr_ETB':
            $('#checkTrous').attr("src", "/pamina/img/Defi/ED4/fr_ETB/validoff.png");
            $('#checkTrous').mouseover(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED4/fr_ETB/validon.png");
            });
            $('#checkTrous').mouseout(function() {
              $('#checkTrous').attr("src", "/pamina/img/Defi/ED4/fr_ETB/validoff.png");
            });
            break;
        }
        break;
      
      default:

        break;
    }
}


// Les animations de changement d'ED
function myAnim(name) {
	// On cache le pion et le dé
	$('#canvas').hide();
	$('.Pions').hide();

	switch(name) {
		case 'boatUp1':
			var div = $('.animBoatUp');
			$(div).css('top', '100%');
			$(div).css('left', '43%');
			$(div).css('display', 'unset');
			div.animate({top: '100%', left: '43%'}, 1000, "linear");
			div.animate({top: '95%', left: '43%'}, 1000, "linear", function() {
				$(div).css({
			        '-webkit-transform': 'rotate(30deg)',
			        '-moz-transform': 'rotate(30deg)',
			        '-ms-transform': 'rotate(30deg)',
			        '-o-transform': 'rotate(30deg)',
			        'transform': 'rotate(30deg)',
			        '-webkit-transition': '1s', /* Safari */
	    			'transition': '1s',
	    			'top': '90%',
	    			'left': '43%'
	    		});
				setTimeout(function() {
					$(div).css({
				        '-webkit-transition': 'unset', /* Safari */
		    			'transition': 'unset',
					});
					// div.animate({top: '83%', left: '45%'}, 1000);
					// div.animate({top: '79%', left: '46%'}, 1000);
					div.animate({top: '69%', left: '51%'}, 2500, "linear");
					div.animate({top: '66%', left: '52%', opacity: '0'}, 1000, "linear", function() {
						$(div).attr('style', '');
						$(div).css({
							'position': 'absolute',
							'display': 'none',
							'width': '4.5%'
						});
						// Apparition du pion et du dé
						$('.Pions').show();
						$('#canvas').show();
					});
				}, 700);
			});
			break;
		case 'boatDown2':
			var div = $('.animBoatDown');
			$(div).css('top', '-7%');
			$(div).css('left', '58%');
			$(div).css('display', 'unset');
			div.animate({top: '2%', left: '58%'}, 1000, "linear", function() {
				$(div).css({
			        '-webkit-transform': 'rotate(30deg)',
			        '-moz-transform': 'rotate(30deg)',
			        '-ms-transform': 'rotate(30deg)',
			        '-o-transform': 'rotate(30deg)',
			        'transform': 'rotate(30deg)',
			        '-webkit-transition': '1s', /* Safari */
	    			'transition': '1s',
	    			'top': '4%',
	    			'left': '57%'
	    		});
	    		setTimeout(function() {
		    		$(div).css({
				        '-webkit-transition': 'unset', /* Safari */
		    			'transition': 'unset',
					});
					div.animate({top: '13%', left: '53%'}, 2000, "linear");
					div.animate({top: '15%', left: '52%', opacity: '0'}, 1000, "linear", function() {
						$(div).attr('style', '');
						$(div).css({
							'position': 'absolute',
							'display': 'none',
							'width': '4.5%'
						});
						// Apparition du pion et du dé
						$('.Pions').show();
						$('#canvas').show();
					});
	    		}, 500);
			});
			
			break;
		case 'boatUp2':
			var div = $('.animBoatUp');
			$(div).css('top', '100%');
			$(div).css('left', '37%');
			$(div).css('display', 'unset');
			$(div).css({
		        '-webkit-transform': 'rotate(25deg)',
		        '-moz-transform': 'rotate(25deg)',
		        '-ms-transform': 'rotate(25deg)',
		        '-o-transform': 'rotate(25deg)',
		        'transform': 'rotate(25deg)'
    		});
    		// étape 1
    		div.animate({top: '78%', left: '44%'}, 2000, "linear", function() {
    			// étape 2
    			$(div).css({
			        '-webkit-transform': 'rotate(0deg)',
			        '-moz-transform': 'rotate(0deg)',
			        '-ms-transform': 'rotate(0deg)',
			        '-o-transform': 'rotate(0deg)',
			        'transform': 'rotate(0deg)',
			        '-webkit-transition': '1s', /* Safari */
	    			'transition': '1s',
	    			'top': '75%',
	    			'left': '44%'
	    		});
	    		setTimeout(function() {
		    		$(div).css({
				        '-webkit-transition': 'unset', /* Safari */
		    			'transition': 'unset',
					});
					div.stop();
					// étape 3
					div.animate({top: '64%', left: '44%'}, 1000, "linear", function() {
						$(div).css({
					        '-webkit-transform': 'rotate(50deg)',
					        '-moz-transform': 'rotate(50deg)',
					        '-ms-transform': 'rotate(50deg)',
					        '-o-transform': 'rotate(50deg)',
					        'transform': 'rotate(50deg)',
					        '-webkit-transition': '1s', /* Safari */
			    			'transition': '1s',
			    			'top': '61%',
			    			'left': '45%'
			    		});
			    		setTimeout(function() {
				    		$(div).css({
						        '-webkit-transition': 'unset', /* Safari */
				    			'transition': 'unset',
							});
							div.stop();
							div.animate({top: '58%', left: '47%'}, 500, "linear", function() {
								$(div).css({
							        '-webkit-transform': 'rotate(-10deg)',
							        '-moz-transform': 'rotate(-10deg)',
							        '-ms-transform': 'rotate(-10deg)',
							        '-o-transform': 'rotate(-10deg)',
							        'transform': 'rotate(-10deg)',
							        '-webkit-transition': '1s', /* Safari */
					    			'transition': '1s',
					    			'top': '55%',
					    			'left': '47%'
					    		});
					    		setTimeout(function() {
						    		$(div).css({
								        '-webkit-transition': 'unset', /* Safari */
						    			'transition': 'unset',
									});
									div.animate({top: '47%', left: '46%'}, 1500, "linear");
									div.animate({top: '44%', left: '46%', opacity: '0'}, 1000, "linear", function() {
										$(div).attr('style', '');
										$(div).css({
											'position': 'absolute',
											'display': 'none',
											'width': '4.5%'
										});
										// Apparition du pion et du dé
										$('.Pions').show();
										$('#canvas').show();
									});
						    	}, 500);
							});
				    	}, 500);
					});
	    		}, 500);
    		});
			break;
		case 'boatDown3':
			var div = $('.animBoatDown');
			$(div).css('top', '-7%');
			$(div).css('left', '44%');
			$(div).css('display', 'unset');
			div.animate({top: '5%', left: '44%'}, 1500, "linear", function() {
				$(div).css({
			        '-webkit-transform': 'rotate(45deg)',
			        '-moz-transform': 'rotate(45deg)',
			        '-ms-transform': 'rotate(45deg)',
			        '-o-transform': 'rotate(45deg)',
			        'transform': 'rotate(45deg)',
			        '-webkit-transition': '1s', /* Safari */
	    			'transition': '1s',
	    			'top': '9%',
	    			'left': '42%'
	    		});
	    		setTimeout(function() {
	    			$(div).css({
				        '-webkit-transform': 'rotate(-5deg)',
				        '-moz-transform': 'rotate(-5deg)',
				        '-ms-transform': 'rotate(-5deg)',
				        '-o-transform': 'rotate(-5deg)',
				        'transform': 'rotate(-5deg)',
				        '-webkit-transition': '1s', /* Safari */
		    			'transition': '1s',
		    			'top': '12%',
		    			'left': '41%'
		    		});
		    		setTimeout(function() {
						$(div).css({
					        '-webkit-transition': 'unset', /* Safari */
			    			'transition': 'unset',
						});
						div.animate({top: '21%', left: '41%'}, 1500, "linear");
						div.animate({top: '25%', left: '42%', opacity: '0'}, 1000, "linear", function() {
							$(div).attr('style', '');
							$(div).css({
								'position': 'absolute',
								'display': 'none',
								'width': '4.5%'
							});
							// Apparition du pion et du dé
							$('.Pions').show();
							$('#canvas').show();
						});
		    		}, 500);
	    		}, 500);
			});
			break;
		case 'boatUp3':
			var div = $('.animBoatUp');
			$(div).css('top', '100%');
			$(div).css('left', '36%');
			$(div).css('display', 'unset');
			div.animate({top: '92%', left: '36%'}, 1500, "linear", function() {
				$(div).css({
			        '-webkit-transform': 'rotate(30deg)',
			        '-moz-transform': 'rotate(30deg)',
			        '-ms-transform': 'rotate(30deg)',
			        '-o-transform': 'rotate(30deg)',
			        'transform': 'rotate(30deg)',
			        '-webkit-transition': '1.5s', /* Safari */
	    			'transition': '1.5s',
	    			'top': '88%',
	    			'left': '37%'
	    		});
	    		setTimeout(function() {
	    			$(div).css({
				        '-webkit-transform': 'rotate(-30deg)',
				        '-moz-transform': 'rotate(-30deg)',
				        '-ms-transform': 'rotate(-30deg)',
				        '-o-transform': 'rotate(-30deg)',
				        'transform': 'rotate(-30deg)',
				        '-webkit-transition': '1.5s', /* Safari */
		    			'transition': '1.5s',
		    			'top': '83%',
		    			'left': '37%'
		    		});
		    		setTimeout(function() {
		    			$(div).css({
					        '-webkit-transform': 'rotate(20deg)',
					        '-moz-transform': 'rotate(20deg)',
					        '-ms-transform': 'rotate(20deg)',
					        '-o-transform': 'rotate(20deg)',
					        'transform': 'rotate(20deg)',
					        '-webkit-transition': '1.5s', /* Safari */
			    			'transition': '1.5s',
			    			'top': '77%',
			    			'left': '36.5%'
			    		});
			    		setTimeout(function() {
							$(div).css({
						        '-webkit-transition': 'unset', /* Safari */
				    			'transition': 'unset',
							});
				    		div.animate({top: '73%', left: '37.5%', opacity: '0'}, 1000, "linear", function() {
								$(div).attr('style', '');
								$(div).css({
									'position': 'absolute',
									'display': 'none',
									'width': '4.5%'
								});
								// Apparition du pion et du dé
								$('.Pions').show();
								$('#canvas').show();
							});
			    		}, 500);
		    		}, 1000);
	    		}, 500);
			});
			break;
		case 'boatDown4':
			var div = $('.animBoatDown');
			$(div).css('top', '-7%');
			$(div).css('left', '40%');
			$(div).css('display', 'unset');
			div.animate({top: '0%', left: '40%'}, 1000, "linear", function() {
				$(div).css({
			        '-webkit-transform': 'rotate(10deg)',
			        '-moz-transform': 'rotate(10deg)',
			        '-ms-transform': 'rotate(10deg)',
			        '-o-transform': 'rotate(10deg)',
			        'transform': 'rotate(10deg)',
			        '-webkit-transition': '2s', /* Safari */
	    			'transition': '2s',
	    			'top': '5%',
	    			'left': '39%'
	    		});
	    		setTimeout(function() {
	    			$(div).css({
				        '-webkit-transition': 'unset', /* Safari */
		    			'transition': 'unset',
					});
					div.animate({top: '19%', left: '37%'}, 2000, "linear", function() {
						$(div).css({
					        '-webkit-transform': 'rotate(-20deg)',
					        '-moz-transform': 'rotate(-20deg)',
					        '-ms-transform': 'rotate(-20deg)',
					        '-o-transform': 'rotate(-20deg)',
					        'transform': 'rotate(-20deg)',
					        '-webkit-transition': '2s', /* Safari */
			    			'transition': '2s',
			    			'top': '22%',
			    			'left': '38%'
			    		});
			    		setTimeout(function() {
				    		$(div).css({
						        '-webkit-transform': 'rotate(20deg)',
						        '-moz-transform': 'rotate(20deg)',
						        '-ms-transform': 'rotate(20deg)',
						        '-o-transform': 'rotate(20deg)',
						        'transform': 'rotate(20deg)',
						        '-webkit-transition': '2s', /* Safari */
				    			'transition': '2s',
				    			'top': '25%',
				    			'left': '38%'
				    		});
				    		setTimeout(function() {
								$(div).css({
							        '-webkit-transition': 'unset', /* Safari */
					    			'transition': 'unset'
								});
								div.animate({top: '27%', left: '37%', opacity: '0'}, 1000, "linear", function() {
									$(div).attr('style', '');
									$(div).css({
										'position': 'absolute',
										'display': 'none',
										'width': '4.5%'
									});
									// Apparition du pion et du dé
									$('.Pions').show();
									$('#canvas').show();
								});
				    		}, 500);
			    		}, 500);
					});
	    		}, 1000);
			});
			break;
		case 'velo1':
			var div = $('.animVelo');
			$(div).css({
		        '-webkit-transform': 'rotate(35deg)',
		        '-moz-transform': 'rotate(35deg)',
		        '-ms-transform': 'rotate(35deg)',
		        '-o-transform': 'rotate(35deg)',
		        'transform': 'rotate(35deg)',
    			'display': 'unset',
    			'top': '67%',
    			'left': '53%'
    		});
			div.animate({top: '62%', left: '50%'}, 1000, "linear");
			div.animate({top: '59%', left: '48%', opacity: '0'}, 500, "linear", function() {
				$(div).attr('style', '');
				$(div).css({
					'position': 'absolute',
					'display': 'none',
					'width': '4.5%'
				});
				// Apparition du pion et du dé
				$('.Pions').show();
				$('#canvas').show();
			});
			break;
		case 'velo2':
			if (PositionPion == 54) {
				var div = $('.animVelo');
				$(div).css({
					'-webkit-transform': 'scaleX(-1)',
    				'transform': 'scaleX(-1)',
    				'top': '19%',
    				'left': '50%',
    				'display': 'unset'
				});
				div.animate({top: '16%', left: '55%'}, 1000, "linear", function() {
					$(div).css({
				        '-webkit-transform': 'rotate(-55deg) scaleX(-1)',
				        '-moz-transform': 'rotate(-55deg) scaleX(-1)',
				        '-ms-transform': 'rotate(-55deg) scaleX(-1)',
				        '-o-transform': 'rotate(-55deg) scaleX(-1)',
				        'transform': 'rotate(-55deg) scaleX(-1)',
		    		});
					div.animate({top: '14%', left: '56%', opacity: '0'}, 500, "linear", function() {
						$(div).attr('style', '');
						$(div).css({
							'position': 'absolute',
							'display': 'none',
							'width': '4.5%'
						});
						// Apparition du pion et du dé
						$('.Pions').show();
						$('#canvas').show();
					});
				});
			}else if (PositionPion == 35) {
				var div = $('.animVelo');
				$(div).css({
			        '-webkit-transform': 'rotate(85deg)',
			        '-moz-transform': 'rotate(85deg)',
			        '-ms-transform': 'rotate(85deg)',
			        '-o-transform': 'rotate(85deg)',
			        'transform': 'rotate(85deg)',
    				'top': '42%',
    				'left': '47%',
    				'display': 'unset'
				});
				div.animate({top: '33%', left: '47%'}, 1500, "linear");
				div.animate({top: '31%', left: '47%', opacity: '0'}, 500, "linear", function() {
					$(div).attr('style', '');
					$(div).css({
						'position': 'absolute',
						'display': 'none',
						'width': '4.5%'
					});
					// Apparition du pion et du dé
					$('.Pions').show();
					$('#canvas').show();
				});
			}
			break;
		case 'velo3':
			if (PositionPion == 41) {
				var div = $('.animVelo');
				$(div).css({
					'-webkit-transform': 'rotate(20deg) scaleX(-1)',
			        '-moz-transform': 'rotate(20deg) scaleX(-1)',
			        '-ms-transform': 'rotate(20deg) scaleX(-1)',
			        '-o-transform': 'rotate(20deg) scaleX(-1)',
			        'transform': 'rotate(20deg) scaleX(-1)',
    				'top': '28%',
    				'left': '42%',
    				'display': 'unset'
				});
				div.animate({top: '33%', left: '48%'}, 1000, "linear");
				div.animate({top: '36%', left: '51%', opacity: '0'}, 500, "linear", function() {
					$(div).attr('style', '');
					$(div).css({
						'position': 'absolute',
						'display': 'none',
						'width': '4.5%'
					});
					// Apparition du pion et du dé
					$('.Pions').show();
					$('#canvas').show();
				});
			}else if (PositionPion == 9) {
				var div = $('.animVelo');
				$(div).css({
					'-webkit-transform': 'rotate(25deg) scaleX(-1)',
			        '-moz-transform': 'rotate(25deg) scaleX(-1)',
			        '-ms-transform': 'rotate(25deg) scaleX(-1)',
			        '-o-transform': 'rotate(25deg) scaleX(-1)',
			        'transform': 'rotate(25deg) scaleX(-1)',
    				'top': '71%',
    				'left': '39%',
    				'display': 'unset'
				});
				div.animate({top: '77%', left: '44%'}, 1000, "linear", function() {
					$(div).css({
					'-webkit-transform': 'rotate(0deg) scaleX(1)',
			        '-moz-transform': 'rotate(0deg) scaleX(1)',
			        '-ms-transform': 'rotate(0deg) scaleX(1)',
			        '-o-transform': 'rotate(0deg) scaleX(1)',
			        'transform': 'rotate(0deg) scaleX(1)'
					});
					div.animate({top: '77%', left: '41%'}, 500, "linear");
					div.animate({top: '77%', left: '38%', opacity: '0'}, 500, "linear", function() {
						$(div).attr('style', '');
						$(div).css({
							'position': 'absolute',
							'display': 'none',
							'width': '4.5%'
						});
						// Apparition du pion et du dé
						$('.Pions').show();
						$('#canvas').show();
					});
				});
			}
			break;
		case 'velo4':
			var div = $('.animVelo');
			$(div).css({
				'-webkit-transform': 'rotate(-40deg) scaleX(-1)',
		        '-moz-transform': 'rotate(-40deg) scaleX(-1)',
		        '-ms-transform': 'rotate(-40deg) scaleX(-1)',
		        '-o-transform': 'rotate(-40deg) scaleX(-1)',
		        'transform': 'rotate(-40deg) scaleX(-1)',
				'top': '29%',
				'left': '37%',
				'display': 'unset'
			});
			div.animate({top: '22%', left: '40%'}, 1000, "linear", function() {
				$(div).css({
					'-webkit-transform': 'rotate(-10deg) scaleX(-1)',
			        '-moz-transform': 'rotate(-10deg) scaleX(-1)',
			        '-ms-transform': 'rotate(-10deg) scaleX(-1)',
			        '-o-transform': 'rotate(-10deg) scaleX(-1)',
			        'transform': 'rotate(-10deg) scaleX(-1)',
				});
			});
			div.animate({top: '20%', left: '43%', opacity: '0'}, 500, "linear", function() {
				$(div).attr('style', '');
				$(div).css({
					'position': 'absolute',
					'display': 'none',
					'width': '4.5%'
				});
				// Apparition du pion et du dé
				$('.Pions').show();
				$('#canvas').show();
			});
			break;
		default:
			break;
	}
}

// Animations du pion
$(".Pions").animateSprite({
    fps: 12,
    animations: {
        jumpFront: [0, 1, 2, 3, 4, 5, 6],
        jumpFrontLeft: [8, 9, 10, 11, 12, 13, 14],
        jumpLeft: [16, 17, 18, 19, 20, 21, 22],
        jumpBackLeft: [24, 25, 26, 27, 28, 29, 30],
        jumpBack: [32, 33, 34, 35, 36, 37, 38],
        jumpBackRight: [40, 41, 42, 43, 44, 45, 46],
        jumpRight: [48, 49, 50, 51, 52, 53, 54],
        jumpFrontRight: [56, 57, 58, 59, 60, 61, 62],
        disparition: [64, 65, 66, 67, 68, 69, 70, 71],
        apparition: [72, 73, 74, 75, 76, 77, 78]
    },
    loop: false,
    autoplay: false,
    complete: function(){
        // use complete only when you set animations with 'loop: false'
    }
});

// Animations du pion
function customAnim(n) {
    switch(n) {
        case 'bas':
            $(".Pions").animateSprite('play', 'jumpFront');
            break;
        case 'basGauche':
            $(".Pions").animateSprite('play', 'jumpFrontLeft');
            break;
        case 'gauche':
            $(".Pions").animateSprite('play', 'jumpLeft');
            break;
        case 'hautGauche':
            $(".Pions").animateSprite('play', 'jumpBackLeft');
            break;
        case 'haut':
            $(".Pions").animateSprite('play', 'jumpBack');
            break;
        case 'hautDroit':
            $(".Pions").animateSprite('play', 'jumpBackRight');
            break;
        case 'droite':
            $(".Pions").animateSprite('play', 'jumpRight');
            break;
        case 'basDroit':
            $(".Pions").animateSprite('play', 'jumpFrontRight');
            break;
        case 'disparition':
            $(".Pions").animateSprite('play', 'disparition');
            break;
        case 'apparition':
            $(".Pions").animateSprite('play', 'apparition');
            break;
        case 'pause':
            $(".Pions").animateSprite('stop');
            break;
        case 'resume':
            $(".Pions").animateSprite('resume');
            break;
        case 'restart':
            $(".Pions").animateSprite('restart');
            break;
    }
}

// Changer la couleur du pion
function changeColor(c) {
    switch(c) {
        case 'bleu':
            $(".Pions").css('background-image', 'url(img/Sprite/pionbleu.png)');
            break;
        case 'brun':
            $(".Pions").css('background-image', 'url(img/Sprite/pionbrun.png)');
            break;
        case 'jaune':
            $(".Pions").css('background-image', 'url(img/Sprite/pionjaune.png)');
            break;
        case 'vert':
            $(".Pions").css('background-image', 'url(img/Sprite/pionvert.png)');
            break;
    }
}




// -------------------------------------
// -------------------------------------
// -------------------------------------
// -------------------------------------
// Expression
$(".Pions").animateSprite({
    fps: 12,
    animations: {
        win: [0, 1, 2, 3, 4, 5, 6],
        wait: [11, 12, 13, 14, 15, 16, 17],
        teleportation: [21, 22, 23, 24, 25, 26, 27],
        apparition: [33, 34, 35, 36, 37, 38, 39],
        loose: [44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54]
    },
    loop: false,
    autoplay: false,
    complete: function(){
        // use complete only when you set animations with 'loop: false'
    }
});

// Animations du pion
function customExpr(n) {
    switch(n) {
        case 'win':
        	changeExpr('brun');
        	// $('.Pions').data('animateSprite').settings.fps = 1;
        	$('.Pions').data('animateSprite').settings.animations['win']=[0, 1, 2, 3, 4, 5, 6];
            $(".Pions").animateSprite('play', 'win');
            break;
        case 'wait':
        	changeExpr('brun');
        	// $('.Pions').data('animateSprite').settings.fps = 1;
        	$('.Pions').data('animateSprite').settings.animations['wait']=[7, 8, 9, 10, 11, 12, 13];
            $(".Pions").animateSprite('play', 'wait');
            break;
        case 'teleportation':
        	changeExpr('brun');
        	// $('.Pions').data('animateSprite').settings.fps = 1;
        	$('.Pions').data('animateSprite').settings.animations['teleportation']=[14, 15, 16, 17, 18, 19, 20];
            $(".Pions").animateSprite('play', 'teleportation');
            break;
        case 'apparition':
        	changeExpr('brun');
        	// $('.Pions').data('animateSprite').settings.fps = 1;
        	$('.Pions').data('animateSprite').settings.animations['apparition']=[21, 22, 23, 24, 25, 26, 27];
            $(".Pions").animateSprite('play', 'apparition');
            break;
        case 'loose':
        	changeExpr('brun');
        	// $('.Pions').data('animateSprite').settings.fps = 1;
        	$('.Pions').data('animateSprite').settings.animations['loose']=[28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38];
            $(".Pions").animateSprite('play', 'loose');
            break;
        case 'pause':
            $(".Pions").animateSprite('stop');
            break;
        case 'resume':
            $(".Pions").animateSprite('resume');
            break;
    }
}

function changeExpr(e) {
    switch(e) {
        case 'bleu':
            $(".Pions").css('background-image', 'url(../img/Sprite/pionbleuexpression.png)');
            break;
        case 'brun':
            $(".Pions").css('background-image', 'url(../img/Sprite/pionbrunexpression.png)');
            break;
        case 'jaune':
            $(".Pions").css('background-image', 'url(../img/Sprite/pionjauneexpression.png)');
            break;
        case 'vert':
            $(".Pions").css('background-image', 'url(../img/Sprite/pionvertexpression.png)');
            break;
    }
}


// -------------------------------------
// -------------------------------------
// -------------------------------------
// -------------------------------------
// Expression GRAND

// Animations du pion
function customExprGrand(n) {
    switch(n) {
        case 'win':
            $(".pionExpression").animateSprite('play', 'win');
            break;
        case 'attente':
            $(".pionExpression").animateSprite('play', 'attente');
            break;
        case 'disparition':
            $(".pionExpression").animateSprite('play', 'disparition');
            break;
        case 'apparition':
            $(".pionExpression").animateSprite('play', 'apparition');
            break;
        case 'loose':
            $(".pionExpression").animateSprite('play', 'loose');
            break;
        case 'pause':
            $(".pionExpression").animateSprite('stop');
            break;
        case 'resume':
            $(".pionExpression").animateSprite('resume');
            break;
    }
}

function changeExprGrand(e) {
    switch(e) {
        case 'bleu':
            $(".pionExpression").css('background-image', 'url(../img/pionbleuexpressiongrand.png)');
            break;
        case 'brun':
            $(".pionExpression").css('background-image', 'url(../img/pionbrunexpressiongrand.png)');
            break;
        case 'jaune':
            $(".pionExpression").css('background-image', 'url(../img/pionjauneexpressiongrand.png)');
            break;
        case 'vert':
            $(".pionExpression").css('background-image', 'url(../img/pionvertexpressiongrand.png)');
            break;
    }
}

});


// set cle user
// function setCle() {
// 	// on récupère tous les ID
// 	$.ajax({
// 		url : "../model/tmp/getAllUserid.php",
// 		type : "GET",
// 		success : function(data) {
// 			// On crée une clé aléatoire pour chaque utilisateur
// 			$.ajax({
// 				url : "../model/tmp/setUserCle.php",
// 				type : "POST",
// 				data : { UsersId : JSON.parse(data) },
// 				success : function(data) {
// 					console.log(data);
// 				}
// 			});
// 		}
// 	});
// }

// send email CGU to all users
// function sendEmailCGU() {
// 	// on récupère tous les ID
// 	$.ajax({
// 		url : "../model/tmp/sendEmailCGU.php",
// 		type : "GET",
// 		success : function(data) {

// 		}
// 	});
// }
// sendEmailCGU();

// send email CGU to a specific user by id
// function sendCustomEmailCGU(id) {
// 	// on récupère tous les ID
// 	$.ajax({
// 		url : "../model/tmp/sendCustomEmailCGU.php",
// 		type : "POST",
// 		data : { UsersId : id },
// 		success : function(data) {
// 			console.log(data);
// 		}
// 	});
// }
// sendEmailCGU(57);
// sendEmailCGU(396);