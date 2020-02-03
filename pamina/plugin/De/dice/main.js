"use strict";

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