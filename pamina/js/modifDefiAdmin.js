$(document).ready(function() {

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

    var session;
    function getSession() {
        $.get('../model/getSession.php', function(data) {
            session = JSON.parse(data);
        });
    }
    getSession();

    var id;
    var typeDefiSelect;
    var helpImg,helpAudio,helpVideo;
    var createurId;
    $("#btnQcm").click(function() {
        var imgQcm;
        getDefiList("QCM");
        typeDefiSelect = "Qcm";
    });
    $("#btnTrou").click(function() {
        typeDefiSelect = "Trou";
        getDefiList("trou");
    });
    $("#btnVocal").click(function() {
        typeDefiSelect = "Vocal";
        getDefiList("vocal");
    });
    $("#btnFrise").click(function() {
        var item1_img,item2_img,item3_img,item4_img,item5_img,item6_img;
        typeDefiSelect = "Frise";
        getDefiList("frise");
    });
    $("#btnClassement").click(function() {
        var valise_1_etiquette_1,valise_1_etiquette_2,valise_1_etiquette_3,valise_1_etiquette_4,valise_1_etiquette_5;
        var valise_2_etiquette_1,valise_2_etiquette_2,valise_2_etiquette_3,valise_2_etiquette_4,valise_2_etiquette_5;
        var valise_3_etiquette_1,valise_3_etiquette_2,valise_3_etiquette_3,valise_3_etiquette_4,valise_3_etiquette_5;
        var valise_4_etiquette_1,valise_4_etiquette_2,valise_4_etiquette_3,valise_4_etiquette_4,valise_4_etiquette_5;
        var valise_5_etiquette_1,valise_5_etiquette_2,valise_5_etiquette_3,valise_5_etiquette_4,valise_5_etiquette_5;
        typeDefiSelect = "Classement";
        getDefiList("classement");
    });

    function getDefiList(tDefi) {
        $.ajax({                                      
            url: '../model/getMyDefis.php', 
            type : "POST",        
            data: {idUser : session.id, type : tDefi},
            success: function(data)
            {
                try {
                    res = jQuery.parseJSON(data);
                    // console.log(res);
                    // Création de la table de données de défi
                    $output = '<table class="table table-hover"><thead><tr><th>ID</th><th>'+titre+'</th><th>'+lieuDefi+'</th><th>Créateur du défi</tr></thead><tbody>';

                    if (tDefi == "frise") {
                        $.each(res, function(i, item) {
                            $output += "<tr><td>"+res[i].id+"</td><td>"+res[i].titre_frise+"</td><td>"+res[i].lieu+"</td><td class='idOwner'>"+res[i].createur_id+"</td><td><button type='button' id='deleteDefi"+res[i].id+"' class='btn btn-default'><span class='glyphicon glyphicon-trash'></span></button></td></tr>";
                        });
                    }else{
                        $.each(res, function(i, item) {
                            $output += "<tr><td>"+res[i].id+"</td><td>"+res[i].titre_question+"</td><td>"+res[i].lieu+"</td><td class='idOwner'>"+res[i].createur_id+"</td><td><button type='button' id='deleteDefi"+res[i].id+"' class='btn btn-default'><span class='glyphicon glyphicon-trash'></span></button></td></tr>";
                        });
                    }

                    $output += '</tbody></table>';
                    $('#myDefis').html($output);
                } catch(e) {
                    $('#myDefis').html("");
                }

                $(".idOwner").css("background-color", "red");

                $(".idOwner").on('click', function(e) {
                    e.stopPropagation();
                    $.post("../model/getOwnerInfo.php", {idOwner: $(this).text()}, function(result){
                        var owner = jQuery.parseJSON(result);
                        $("#ownerTable").html("<tr><td>"+owner[0].id+"</td><td>"+owner[0].email+"</td></tr>");
                    });
                });

                // suppression des events si l'on click sur le bouton de suppression
                $(':regex(id,deleteDefi[0-9])').click(function(e) {
                    e.stopPropagation();
                    id = $(this)[0].id;
                    id = id.replace("deleteDefi", "");
                    createurId = $(this).parent()[0].previousSibling.innerText;
                    for (var d = 0, len = res.length; d < len; d++) {
                        if (res[d].id == id) {
                            switch(typeDefiSelect) {
                                case "Qcm":
                                    imgQcm = res[d].image; 
                                    helpImg = res[d].helpImg;
                                    helpAudio = res[d].helpAudio;
                                    helpVideo = res[d].helpVideo;
                                    // suppression du defi
                                    // 1- on supprime les fichiers liés au défi img/video/son/zip
                                    $.ajax({                                    
                                        url: '../model/deleteDefiFiles.php', 
                                        type : "POST",        
                                        data: {idDefi : id, imgQcm : imgQcm, helpImg : helpImg, helpAudio : helpAudio, helpVideo : helpVideo, typeDefi : typeDefiSelect},
                                        success: function() {
                                            // 2- on supprime les données dans la base
                                            deleteDefi(createurId);
                                        }
                                    });
                                    break;
                                case "Trou":
                                    helpImg = res[d].helpImg;
                                    helpAudio = res[d].helpAudio;
                                    helpVideo = res[d].helpVideo;
                                    // suppression du defi
                                    // 1- on supprime les fichiers liés au défi img/video/son/zip
                                    $.ajax({                                    
                                        url: '../model/deleteDefiFiles.php', 
                                        type : "POST",        
                                        data: {idDefi : id, helpImg : helpImg, helpAudio : helpAudio, helpVideo : helpVideo, typeDefi : typeDefiSelect},
                                        success: function() {
                                            // 2- on supprime les données dans la base
                                            deleteDefi(createurId);
                                        }
                                    });
                                    break;
                                case "Vocal":
                                    helpImg = res[d].helpImg;
                                    helpAudio = res[d].helpAudio;
                                    helpVideo = res[d].helpVideo;
                                    // suppression du defi
                                    // 1- on supprime les fichiers liés au défi img/video/son/zip
                                    $.ajax({                                    
                                        url: '../model/deleteDefiFiles.php', 
                                        type : "POST",        
                                        data: {idDefi : id, helpImg : helpImg, helpAudio : helpAudio, helpVideo : helpVideo, typeDefi : typeDefiSelect},
                                        success: function() {
                                            // 2- on supprime les données dans la base
                                            deleteDefi(createurId);
                                        }
                                    });
                                    break;
                                case "Frise":
                                    item1_img = res[d].item1_img;
                                    item2_img = res[d].item2_img;
                                    item3_img = res[d].item3_img;
                                    item4_img = res[d].item4_img;
                                    item5_img = res[d].item5_img;
                                    item6_img = res[d].item6_img;
                                    helpImg = res[d].helpImg;
                                    helpAudio = res[d].helpAudio;
                                    helpVideo = res[d].helpVideo;
                                    // suppression du defi
                                    // 1- on supprime les fichiers liés au défi img/video/son/zip
                                    $.ajax({                                    
                                        url: '../model/deleteDefiFiles.php', 
                                        type : "POST",        
                                        data: {idDefi : id, item1_img : item1_img, item2_img : item2_img, item3_img : item3_img, item4_img : item4_img, item5_img : item5_img, item6_img : item6_img, helpImg : helpImg, helpAudio : helpAudio, helpVideo : helpVideo, typeDefi : typeDefiSelect},
                                        success: function() {
                                            // 2- on supprime les données dans la base
                                            deleteDefi(createurId);
                                        }
                                    });
                                    break;
                                case "Classement":
                                    valise_1_etiquette_1 = res[d].valise_1_etiquette_1;
                                    valise_1_etiquette_2 = res[d].valise_1_etiquette_2;
                                    valise_1_etiquette_3 = res[d].valise_1_etiquette_3;
                                    valise_1_etiquette_4 = res[d].valise_1_etiquette_4;
                                    valise_1_etiquette_5 = res[d].valise_1_etiquette_5;

                                    valise_2_etiquette_1 = res[d].valise_2_etiquette_1;
                                    valise_2_etiquette_2 = res[d].valise_2_etiquette_2;
                                    valise_2_etiquette_3 = res[d].valise_2_etiquette_3;
                                    valise_2_etiquette_4 = res[d].valise_2_etiquette_4;
                                    valise_2_etiquette_5 = res[d].valise_2_etiquette_5;

                                    valise_3_etiquette_1 = res[d].valise_3_etiquette_1;
                                    valise_3_etiquette_2 = res[d].valise_3_etiquette_2;
                                    valise_3_etiquette_3 = res[d].valise_3_etiquette_3;
                                    valise_3_etiquette_4 = res[d].valise_3_etiquette_4;
                                    valise_3_etiquette_5 = res[d].valise_3_etiquette_5;

                                    valise_4_etiquette_1 = res[d].valise_4_etiquette_1;
                                    valise_4_etiquette_2 = res[d].valise_4_etiquette_2;
                                    valise_4_etiquette_3 = res[d].valise_4_etiquette_3;
                                    valise_4_etiquette_4 = res[d].valise_4_etiquette_4;
                                    valise_4_etiquette_5 = res[d].valise_4_etiquette_5;

                                    valise_5_etiquette_1 = res[d].valise_5_etiquette_1;
                                    valise_5_etiquette_2 = res[d].valise_5_etiquette_2;
                                    valise_5_etiquette_3 = res[d].valise_5_etiquette_3;
                                    valise_5_etiquette_4 = res[d].valise_5_etiquette_4;
                                    valise_5_etiquette_5 = res[d].valise_5_etiquette_5;

                                    helpImg = res[d].helpImg;
                                    helpAudio = res[d].helpAudio;
                                    helpVideo = res[d].helpVideo;
                                    // suppression du defi
                                    // 1- on supprime les fichiers liés au défi img/video/son/zip
                                    $.ajax({                                    
                                        url: '../model/deleteDefiFiles.php', 
                                        type : "POST",        
                                        data: {idDefi : id, helpImg : helpImg, helpAudio : helpAudio, helpVideo : helpVideo, typeDefi : typeDefiSelect,
                                                valise_1_etiquette_1 : valise_1_etiquette_1, valise_1_etiquette_2 : valise_1_etiquette_2, valise_1_etiquette_3 : valise_1_etiquette_3, valise_1_etiquette_4 : valise_1_etiquette_4, valise_1_etiquette_5 : valise_1_etiquette_5,
                                                valise_2_etiquette_1 : valise_2_etiquette_1, valise_2_etiquette_2 : valise_2_etiquette_2, valise_2_etiquette_3 : valise_2_etiquette_3, valise_2_etiquette_4 : valise_2_etiquette_4, valise_2_etiquette_5 : valise_2_etiquette_5,
                                                valise_3_etiquette_1 : valise_3_etiquette_1, valise_3_etiquette_2 : valise_3_etiquette_2, valise_3_etiquette_3 : valise_3_etiquette_3, valise_3_etiquette_4 : valise_3_etiquette_4, valise_3_etiquette_5 : valise_3_etiquette_5,
                                                valise_4_etiquette_1 : valise_4_etiquette_1, valise_4_etiquette_2 : valise_4_etiquette_2, valise_4_etiquette_3 : valise_4_etiquette_3, valise_4_etiquette_4 : valise_4_etiquette_4, valise_4_etiquette_5 : valise_4_etiquette_5,
                                                valise_5_etiquette_1 : valise_5_etiquette_1, valise_5_etiquette_2 : valise_5_etiquette_2, valise_5_etiquette_3 : valise_5_etiquette_3, valise_5_etiquette_4 : valise_5_etiquette_4, valise_5_etiquette_5 : valise_5_etiquette_5
                                            },
                                        success: function() {
                                            // 2- on supprime les données dans la base
                                            deleteDefi(createurId);
                                        }
                                    });
                                    break;
                            }
                        }
                    }

                });

                // mise en place de la div de modification d'un défi
                $('#myDefis > table > tbody > tr').click(function() {
                    // AFFICHAGE DU FORMULAIRE
                    idModif = $(this).find(">:first-child")[0].textContent;
                    idModif = parseInt(idModif);
                    $('#divData').slideUp();
                    $('#formDefi'+typeDefiSelect).show("slow");
                    // REQUETE AJAX DONNEES DU DEFI
                    if (typeDefiSelect == "Qcm") {
                        $('#formDefiTrou').remove();
                        $('#formDefiVocal').remove();
                        $('#formDefiFrise').remove();
                        $('#formDefiClassement').remove();
                        setEventCouleur();
                        setVarCat();
                        setEventChangeCat();
                        $.ajax({
                            url: '../model/updateDefi/getQcm.php',
                            type : "POST",
                            data: {idQcm : idModif},
                            success: function(data) {
                                dataRes = jQuery.parseJSON(data);
                                dataRes = dataRes[0];
                                // REMPLISSAGE DES CHAMPS AVEC LES DONNEES
                                $('#idQcm').val(dataRes.id);
                                setEDdata(dataRes);
                                $('#langueDef').val(dataRes.langue_defi);
                                $('#niveau').val(dataRes.niveau_defi);
                                $('#category').val(dataRes.cat1);
                                setCatFirst();
                                $('#res').val(dataRes.cat2);
                                $('#titreQuestion').val(dataRes.titre_question);
                                $('#question').val(dataRes.question);
                                $('#rep1').val(dataRes.reponse1);
                                $('#rep2').val(dataRes.reponse2);
                                $('#rep3').val(dataRes.reponse3);
                                $('#rep4').val(dataRes.reponse4);
                                $('#rep5').val(dataRes.reponse5);
                                $('#correct').val(dataRes.nb_reponse_juste);
                                $('#imageDefiOld').val(dataRes.image);
                                $('#imgShowOld').attr("src","../uploadDefi/defi/"+dataRes.image);
                                $('#ImgAuteur').val(dataRes.imgQcmOwner);
                                $('#copyrightImgQcm').val(dataRes.imgQcmCR);
                                $('#aideImgAuteur').val(dataRes.imgHelpOwner);                                
                                $('#copyrightImg').val(dataRes.imgHelpCR);
                                $('#aideVideoAuteur').val(dataRes.videoHelpOwner);                                
                                $('#copyrightVideo').val(dataRes.videoHelpCR);
                                $('#aideSonAuteur').val(dataRes.audioHelpOwner);                                
                                $('#copyrightSon').val(dataRes.audioHelpCR); 
                                $( 'textarea.editor' ).ckeditor(function(){
                                    $('textarea.editor').val(dataRes.helpTxt);
                                });                   
                                $('#aideImgOld').val(dataRes.helpImg);
                                if (dataRes.helpImg != "") {
                                    $('#imgHelpShowOld').attr("src","../uploadDefi/aide/img/"+dataRes.helpImg);
                                }else{
                                    $('#imgHelpShowOld').hide();
                                }
                                $('#aideVideoOld').val(dataRes.helpVideo);
                                $('#aideSonOld').val(dataRes.helpAudio);
                                $('#aideMap').val(dataRes.adresse);
                                // console.log(dataRes);
                                previewQcm();
                            }
                        });
                    }else if (typeDefiSelect == "Trou") {
                        $('#formDefiQcm').remove();
                        $('#formDefiVocal').remove();
                        $('#formDefiFrise').remove();
                        $('#formDefiClassement').remove();
                        setEventCouleur();
                        setVarCat();
                        setEventChangeCat();
                        $.ajax({
                            url: '../model/updateDefi/getTrou.php',
                            type : "POST",
                            data: {idTrou : idModif},
                            success: function(data) {
                                dataRes = jQuery.parseJSON(data);
                                dataRes = dataRes[0];
                                // REMPLISSAGE DES CHAMPS AVEC LES DONNEES
                                $('#idTrou').val(dataRes.id);
                                setEDdata(dataRes);
                                $('#langueDef').val(dataRes.langue_defi);
                                $('#niveau').val(dataRes.niveau_defi);
                                $('#category').val(dataRes.cat1);
                                setCatFirst();
                                $('#res').val(dataRes.cat2);
                                $('#titreQuestionTxtTrou').val(dataRes.titre_question);
                                $('#questionTxtTrou').val(dataRes.question);
                                var nbInput = 0;
                                var TAT = (dataRes.texteAtrou).replace(/(<.*?>)/g, function() {
                                    nbInput++;
                                    return 'INPUT'+nbInput;
                                });
                                $('#txtTrou').val(TAT);
                                $('#inputTxtTrou1').val(dataRes.mot1);
                                $('#inputTxtTrou2').val(dataRes.mot2);
                                $('#inputTxtTrou3').val(dataRes.mot3);
                                $('#inputTxtTrou4').val(dataRes.mot4);
                                $('#inputTxtTrou5').val(dataRes.mot5);
                                $('#inputTxtTrou6').val(dataRes.mot6);
                                $('#inputTxtTrou7').val(dataRes.mot7);
                                $('#inputTxtTrou8').val(dataRes.mot8);
                                $('#inputTxtTrou9').val(dataRes.mot9);
                                $('#inputTxtTrou10').val(dataRes.mot10);
                                $( 'textarea.editor' ).ckeditor(function(){
                                    $('textarea.editor').val(dataRes.helpTxt);
                                });
                                $('#aideImgAuteur').val(dataRes.imgHelpOwner);                                
                                $('#copyrightImg').val(dataRes.imgHelpCR);
                                $('#aideVideoAuteur').val(dataRes.videoHelpOwner);                                
                                $('#copyrightVideo').val(dataRes.videoHelpCR);
                                $('#aideSonAuteur').val(dataRes.audioHelpOwner);                                
                                $('#copyrightSon').val(dataRes.audioHelpCR);
                                $('#aideImgOld').val(dataRes.helpImg);
                                if (dataRes.helpImg != "") {
                                    $('#imgHelpShowOld').attr("src","../uploadDefi/TexteTrou/aide/img/"+dataRes.helpImg);
                                }else{
                                    $('#imgHelpShowOld').hide();
                                }
                                $('#aideVideoOld').val(dataRes.helpVideo);
                                $('#aideSonOld').val(dataRes.helpAudio);
                                $('#aideMap').val(dataRes.adresse);
                                // console.log(dataRes);
                                previewTrou();
                            }
                        });
                    }else if (typeDefiSelect == "Vocal") {
                        $('#formDefiQcm').remove();
                        $('#formDefiTrou').remove();
                        $('#formDefiFrise').remove();
                        $('#formDefiClassement').remove();
                        setEventCouleur();
                        setVarCat();
                        setEventChangeCat();
                        $.ajax({
                            url: '../model/updateDefi/getVocal.php',
                            type : "POST",
                            data: {idVocal : idModif},
                            success: function(data) {
                                dataRes = jQuery.parseJSON(data);
                                dataRes = dataRes[0];
                                // REMPLISSAGE DES CHAMPS AVEC LES DONNEES
                                $('#idVocal').val(dataRes.id);
                                setEDdata(dataRes);
                                $('#langueDef').val(dataRes.langue_defi);
                                $('#niveau').val(dataRes.niveau_defi);
                                 $('#category').val(dataRes.cat1);
                                setCatFirst();
                                $('#res').val(dataRes.cat2);
                                $('#titreQuestionVocaTxt').val(dataRes.titre_question);
                                $('#questionVocaTxt').val(dataRes.question);
                                $('#repVocale').val(dataRes.reponse);
                                $('#repCle').val(dataRes.mot_cles);
                                $( 'textarea.editor' ).ckeditor(function(){
                                    $('textarea.editor').val(dataRes.helpTxt);
                                });
                                $('#aideImgAuteur').val(dataRes.imgHelpOwner);                                
                                $('#copyrightImg').val(dataRes.imgHelpCR);
                                $('#aideVideoAuteur').val(dataRes.videoHelpOwner);                                
                                $('#copyrightVideo').val(dataRes.videoHelpCR);
                                $('#aideSonAuteur').val(dataRes.audioHelpOwner);                                
                                $('#copyrightSon').val(dataRes.audioHelpCR);
                                $('#aideImgOld').val(dataRes.helpImg);
                                if (dataRes.helpImg != "") {
                                    $('#imgHelpShowOld').attr("src","../uploadDefi/aide/img/"+dataRes.helpImg);
                                }else{
                                    $('#imgHelpShowOld').hide();
                                }
                                $('#aideVideoOld').val(dataRes.helpVideo);
                                $('#aideSonOld').val(dataRes.helpAudio);
                                $('#aideMap').val(dataRes.adresse);
                                // console.log(dataRes);
                                previewVocal();
                            }
                        });
                    }else if (typeDefiSelect == "Frise") {
                        $('#formDefiQcm').remove();
                        $('#formDefiTrou').remove();
                        $('#formDefiVocal').remove();
                        $('#formDefiClassement').remove();
                        setEventCouleur();
                        setVarCat();
                        setEventChangeCat();
                        $.ajax({
                            url: '../model/updateDefi/getFrise.php',
                            type : "POST",
                            data: {idFrise : idModif},
                            success: function(data) {
                                dataRes = jQuery.parseJSON(data);
                                dataRes = dataRes[0];
                                // REMPLISSAGE DES CHAMPS AVEC LES DONNEES
                                $('#idFrise').val(dataRes.id);
                                setEDdata(dataRes);
                                $('#langueDef').val(dataRes.langue_defi);
                                $('#niveau').val(dataRes.niveau_defi);
                                $('#category').val(dataRes.cat1);
                                setCatFirst();
                                $('#res').val(dataRes.cat2);
                                $('#titreFrise').val(dataRes.titre_frise);
                                $('#dateDebFrise').val(dataRes.date_debut);
                                $('#dateFinFrise').val(dataRes.date_fin);
                                $('#eventName1').val(dataRes.item1_title);
                                $('#eventDate1').val(dataRes.item1_date);
                                $('#eventImg1Auteur').val(dataRes.item1Owner);
                                $('#copyrightEventImg1').val(dataRes.item1CR);
                                $('#eventName2').val(dataRes.item2_title);
                                $('#eventDate2').val(dataRes.item2_date);
                                $('#eventImg2Auteur').val(dataRes.item2Owner);
                                $('#copyrightEventImg2').val(dataRes.item2CR);
                                $('#eventName3').val(dataRes.item3_title);
                                $('#eventDate3').val(dataRes.item3_date);
                                $('#eventImg3Auteur').val(dataRes.item3Owner);
                                $('#copyrightEventImg3').val(dataRes.item3CR);
                                $('#eventName4').val(dataRes.item4_title);
                                $('#eventDate4').val(dataRes.item4_date);
                                $('#eventImg4Auteur').val(dataRes.item4Owner);
                                $('#copyrightEventImg4').val(dataRes.item4CR);
                                $('#eventName5').val(dataRes.item5_title);
                                $('#eventDate5').val(dataRes.item5_date);
                                $('#eventImg5Auteur').val(dataRes.item5Owner);
                                $('#copyrightEventImg5').val(dataRes.item5CR);
                                $('#eventName6').val(dataRes.item6_title);
                                $('#eventDate6').val(dataRes.item6_date);
                                $('#eventImg6Auteur').val(dataRes.item6Owner);
                                $('#copyrightEventImg6').val(dataRes.item6CR);
                                $( 'textarea.editor' ).ckeditor(function(){
                                    $('textarea.editor').val(dataRes.helpTxt);
                                });
                                $('#aideImgOld').val(dataRes.helpImg);
                                if (dataRes.helpImg != "") {
                                    $('#imgHelpShowOld').attr("src","../uploadDefi/FriseChrono/aide/img/"+dataRes.helpImg);
                                }else{
                                    $('#imgHelpShowOld').hide();
                                }
                                $('#aideImgAuteur').val(dataRes.imgHelpOwner);
                                $('#copyrightImg').val(dataRes.imgHelpCR);
                                $('#aideVideoOld').val(dataRes.helpVideo);
                                $('#aideVideoAuteur').val(dataRes.videoHelpOwner);
                                $('#copyrightVideo').val(dataRes.videoHelpCR);
                                $('#aideSonOld').val(dataRes.helpAudio);
                                $('#aideSonAuteur').val(dataRes.audioHelpOwner);
                                $('#copyrightSon').val(dataRes.audioHelpCR);
                                $('#eventOldImg1').val(dataRes.item1_img);
                                if (dataRes.item1_img !== null) {
                                    $('#vignetteShowOld1').attr("src","../uploadDefi/FriseChrono/"+dataRes.item1_img);
                                }else{
                                    $('#vignetteShowOld1').hide();
                                }
                                $('#eventOldImg2').val(dataRes.item2_img);
                                if (dataRes.item2_img !== null) {
                                    $('#vignetteShowOld2').attr("src","../uploadDefi/FriseChrono/"+dataRes.item2_img);
                                }else{
                                    $('#vignetteShowOld2').hide();
                                }
                                $('#eventOldImg3').val(dataRes.item3_img);
                                if (dataRes.item3_img !== null) {
                                    $('#vignetteShowOld3').attr("src","../uploadDefi/FriseChrono/"+dataRes.item3_img);
                                }else{
                                    $('#vignetteShowOld3').hide();
                                }
                                $('#eventOldImg4').val(dataRes.item4_img);
                                if (dataRes.item4_img !== null) {
                                    $('#vignetteShowOld4').attr("src","../uploadDefi/FriseChrono/"+dataRes.item4_img);
                                }else{
                                    $('#vignetteShowOld4').hide();
                                }
                                $('#eventOldImg5').val(dataRes.item5_img);
                                if (dataRes.item5_img !== null) {
                                    $('#vignetteShowOld5').attr("src","../uploadDefi/FriseChrono/"+dataRes.item5_img);
                                }else{
                                    $('#vignetteShowOld5').hide();
                                }
                                $('#eventOldImg6').val(dataRes.item6_img);
                                if (dataRes.item6_img !== null) {
                                    $('#vignetteShowOld6').attr("src","../uploadDefi/FriseChrono/"+dataRes.item6_img);
                                }else{
                                    $('#vignetteShowOld6').hide();
                                }
                                $('#aideMap').val(dataRes.adresse);
                                // console.log(dataRes);
                                previewFrise();
                            }
                        });
                    }else if (typeDefiSelect == "Classement") {
                        $('#formDefiQcm').remove();
                        $('#formDefiTrou').remove();
                        $('#formDefiVocal').remove();
                        $('#formDefiFrise').remove();
                        setEventCouleur();
                        setVarCat();
                        setEventChangeCat();
                        $.ajax({
                            url: '../model/updateDefi/getClassement.php',
                            type : "POST",
                            data: {idClassement : idModif},
                            success: function(data) {
                                dataRes = jQuery.parseJSON(data);
                                dataRes = dataRes[0];
                                // REMPLISSAGE DES CHAMPS AVEC LES DONNEES
                                $('#idClassement').val(dataRes.id);
                                setEDdata(dataRes);
                                $('#langueDef').val(dataRes.langue_defi);
                                $('#niveau').val(dataRes.niveau_defi);
                                $('#category').val(dataRes.cat1);
                                setCatFirst();
                                $('#res').val(dataRes.cat2);
                                $('#titreQuestionClassement').val(dataRes.titre_question);
                                $('#questionClassement').val(dataRes.question);
                                $('#nbCatClassement').val(dataRes.nbValisette);
                                $('#typeEtiqClassement').val(dataRes.type_etiquette);
                                setNbCatClassement(dataRes.nbValisette);
                                if (dataRes.nom_valise_1 != null) {
                                    $('#nameCat1Classement').val(dataRes.nom_valise_1);
                                }
                                if (dataRes.nom_valise_2 != null) {
                                    $('#nameCat2Classement').val(dataRes.nom_valise_2);
                                }
                                if (dataRes.nom_valise_3 != null) {
                                    $('#nameCat3Classement').val(dataRes.nom_valise_3);
                                }
                                if (dataRes.nom_valise_4 != null) {
                                    $('#nameCat4Classement').val(dataRes.nom_valise_4);
                                }
                                if (dataRes.nom_valise_5 != null) {
                                    $('#nameCat5Classement').val(dataRes.nom_valise_5);
                                }
                                for (var i = 1; i <= dataRes.nbValisette; i++) {
                                    for (var j = 1; j <= 5; j++) {
                                        if (dataRes.type_etiquette != 3) {
                                            $('#cat'+i+'Etiq'+j).val(dataRes['valise_'+i+'_etiquette_'+j]);
                                        }else{
                                            $('#cat'+i+'Etiq'+j+'Old').val(dataRes['valise_'+i+'_etiquette_'+j]);
                                            $('#v'+i+'_e'+j+'_Owner').val(dataRes['v'+i+'_e'+j+'_Owner']);
                                            $('#v'+i+'_e'+j+'_CR').val(dataRes['v'+i+'_e'+j+'_CR']);
                                        }
                                    }
                                }
                                $( 'textarea.editor' ).ckeditor(function(){
                                    $('textarea.editor').val(dataRes.helpTxt);
                                });
                                $('#aideImgOld').val(dataRes.helpImg);
                                if (dataRes.helpImg != "") {
                                    $('#imgHelpShowOld').attr("src","../uploadDefi/Classement/aide/img/"+dataRes.helpImg);
                                }else{
                                    $('#imgHelpShowOld').hide();
                                }
                                $('#aideImgAuteur').val(dataRes.imgHelpOwner);
                                $('#copyrightImg').val(dataRes.imgHelpCR);
                                $('#aideVideoOld').val(dataRes.helpVideo);
                                $('#aideVideoAuteur').val(dataRes.videoHelpOwner);
                                $('#copyrightVideo').val(dataRes.videoHelpCR);
                                $('#aideSonOld').val(dataRes.helpAudio);
                                $('#aideSonAuteur').val(dataRes.audioHelpOwner);
                                $('#copyrightSon').val(dataRes.audioHelpCR);
                                $('#aideMap').val(dataRes.adresse);
                                // console.log(dataRes);
                                previewClassement();
                            }
                        });
                    }


                    // UPDATE DU DEFI
                });
            }
        });
    }




// initialisation du formulaire pour le classement
function setNbCatClassement(nbValise) {
      // div pour nom des catégories
      var CatsName = "";
      // div pour les étiquettes
      var EtiqContent = "";
      var nbCats = nbValise;
      // $('#selectedDefForm').empty();
      // $('#selectedDefForm').append(classement);
      // $("input").attr("required", true);

      // si l'on change la valeur du nombre de catégorie, le nombre de champs de catégorie change en fonction
      $('#nbCatClassement').on("change", function() {
        nbCats = $('#nbCatClassement').val();
        $('#catNamesClassement').empty();
        $('#etiquettesClassement').empty();
        CatsName = "";
        for (var i = 1; i <= nbCats; i++) {
          CatsName += '<div class="form-group"><label>'+categorie+' '+i+' :</label><input type="text" id="nameCat'+i+'Classement" class="form-control" name="nameCat'+i+'Classement" required></div>';
        }
        $('#catNamesClassement').append(CatsName);
        callTypeEtiq(nbCats);
      });
      // trigger nbCat 
      $('#nbCatClassement').trigger("change");
}

    // Pour le formulaire des etiquettes dans le défi classement
    function callTypeEtiq(nbC) {
      // div pour les étiquettes
        var EtiqContent = "";
      // Si on change le type d'étiquette, les champs à remplir change
      $('#typeEtiqClassement').on("change", function() {
        EtiqType = $('#typeEtiqClassement').val();
        EtiqContent = "";
        $('#etiquettesClassement').empty();

        if (EtiqType == 1) {
          for (var j = 1; j <= nbC; j++) {
            EtiqContent += '<div class="form-group"><h2>'+categorie+' n°'+j+'</h2><hr>';
            for (var k = 1; k <= 5; k++) {
              EtiqContent += '<label>'+vignette+' n°'+k+'</label><input type="text" name="cat'+j+'Etiq'+k+'" id="cat'+j+'Etiq'+k+'" class="form-control" maxlength="30" required>';
            }
            EtiqContent += '</div>';
          }
        }else if (EtiqType == 2) {
          for (var j = 1; j <= nbC; j++) {
            EtiqContent += '<div class="form-group"><h2>'+categorie+' n°'+j+'</h2><hr>';
            for (var k = 1; k <= 5; k++) {
              EtiqContent += '<label>'+vignette+' n°'+k+'</label><input type="text" name="cat'+j+'Etiq'+k+'" id="cat'+j+'Etiq'+k+'" class="form-control" maxlength="50" required>';
            }
            EtiqContent += '</div>';
          }
        }else if (EtiqType == 3) {
          for (var j = 1; j <= nbC; j++) {
            EtiqContent += '<div class="form-group"><h2>'+categorie+' n°'+j+'</h2><hr>';
            for (var k = 1; k <= 5; k++) {
              EtiqContent += '<label>'+vignette+' n°'+k+'</label><input type="file" name="cat'+j+'Etiq'+k+'" id="cat'+j+'Etiq'+k+'" accept="image/*">';
              EtiqContent += '<input type="text" name="cat'+j+'Etiq'+k+'Old" id="cat'+j+'Etiq'+k+'Old" style="display: none;" class="form-control">';
              EtiqContent += '<br/><div class="input-group"><span class="input-group-addon">'+proprietaire_image+' : </span><input id="v'+j+'_e'+k+'_Owner" type="text" class="form-control" name="v'+j+'_e'+k+'_Owner"></div><br/> <div class="form-group"><label>Copyright :</label><select id="v'+j+'_e'+k+'_CR" name="v'+j+'_e'+k+'_CR" class="form-control" required=""><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA ND</option><option value="cr5">CC BY SA NC</option></select></div>';
            }
            EtiqContent += '</div>';
          }
        }

        $('#etiquettesClassement').append(EtiqContent);
      });
      // trigger typeEtiqClassement 
      $('#typeEtiqClassement').trigger("change");
    }

// initialisation de la carte
function setEDdata(data) {

    if (data.ed == "ED1") {
        $("#edMap select").val("ED1");
        $('#Calque_1 > path:nth-child(1)').css("fill","yellow");
        $('#Calque_1 > path:nth-child(1)').click();
    }else if (data.ed == "ED2") {
        $("#edMap select").val("ED2");
        $('#Calque_1 > path:nth-child(4)').css("fill","yellow");
        $('#Calque_1 > path:nth-child(4)').click();
    }else if (data.ed == "ED3") {
        $("#edMap select").val("ED3");
        $('#Calque_1 > path:nth-child(2)').css("fill","yellow");
        $('#Calque_1 > path:nth-child(2)').click();
    }else if (data.ed == "ED4") {
        $("#edMap select").val("ED4");
        $('#Calque_1 > path:nth-child(3)').css("fill","yellow");
        $('#Calque_1 > path:nth-child(3)').click();
    }
    $('#couleur').val(data.region);
    edNumber = $('#couleur option:selected').data("ed");
    getLieuFromRegionFirst($('#couleur option:selected').text(),edNumber);

}


      // Minicarte Eurodistrict
    $('#Calque_1 > path:nth-child(1)').click(function() {
      $("#edMap select").val("ED1");
      $('#Calque_1 > path').css('fill','');
      $(this).css("fill","yellow");
      // .change();
      // Changement des régions
      regionForm1 = '<option disabled selected value></option>  <option data-ed="1" value="alsace">Nord Alsace</option>  <option data-ed="1" value="mittlerer">Mittlerer Oberrhein</option>  <option data-ed="1" value="sudpfalz">Südpfalz</option>';
      $('#couleur')[0].innerHTML = regionForm1;
      $('#LieuList').html("");
    });
    $('#Calque_1 > path:nth-child(4)').click(function() {
      $("#edMap select").val("ED2");
      $('#Calque_1 > path').css('fill','');
      $(this).css("fill","yellow");
      // Changement des régions
      regionForm2 = '<option disabled selected value></option>  <option data-ed="2" value="ortenau">Ortenau</option>  <option data-ed="2" value="strasbourg">Eurométropole de Strasbourg</option>  <option data-ed="2" value="erstein">Canton d\'Erstein</option>  <option data-ed="2" value="molsheim">Arrondissement de Molsheim</option>';
      $('#couleur')[0].innerHTML = regionForm2;
      $('#LieuList').html("");
    });
    $('#Calque_1 > path:nth-child(2)').click(function() {
      $("#edMap select").val("ED3");
      $('#Calque_1 > path').css('fill','');
      $(this).css("fill","yellow");
      // Changement des régions
      regionForm3 = '<option disabled selected value></option>  <option data-ed="3" value="all_fcsa">Region Freiburg</option>  <option data-ed="3" value="fr_fcsa">Centre et Sud Alsace</option>';
      $('#couleur')[0].innerHTML = regionForm3;
      $('#LieuList').html("");
    });
    $('#Calque_1 > path:nth-child(3)').click(function() {
      $("#edMap select").val("ED4");
      $('#Calque_1 > path').css('fill','');
      $(this).css("fill","yellow");
      // Changement des régions
      regionForm4 = '<option disabled selected value></option>  <option data-ed="4" value="fr_ETB">Sud Alsace</option>  <option data-ed="4" value="all_ETB">Südbaden</option>  <option data-ed="4" value="ch_ETB">Nordwestschweiz</option>';
      $('#couleur')[0].innerHTML = regionForm4;
      $('#LieuList').html("");
    });

    // premier appel pour set le lieu
    function getLieuFromRegionFirst(region,edNumber) {
        $.ajax({                                      
            url: '../json/ED'+edNumber+'/PositionsPoints'+edNumber+'.json',      
            data: "",
            dataType: 'json',   
            success: function(data)
            {
                $output = "<div class='form-group'><label>"+lieuDefi+" :</label><select name='lieu' class='form-control' required><option disabled selected value></option>";

                $.each(data, function(i, item) {
                    if (typeof(data[i].lieu) != "undefined" && data[i].region == region) {
                        $output += "<option value="+data[i].lieu+">"+data[i].lieu+"</option>";
                    }
                });
                $output += "</select></div>";
                $('#LieuList').html($output);
                $('#LieuList > div > select').val(dataRes.lieu);
            } 
        });
    }

    function getLieuFromRegion(region,edNumber) {
        $.ajax({                                      
            url: '../json/ED'+edNumber+'/PositionsPoints'+edNumber+'.json',      
            data: "",
            dataType: 'json',   
            success: function(data)
            {
                $output = "<div class='form-group'><label>Lieu :</label><select name='lieu' class='form-control' required><option disabled selected value></option>";

                $.each(data, function(i, item) {
                    if (typeof(data[i].lieu) != "undefined" && data[i].region == region) {
                        $output += "<option value="+data[i].lieu+">"+data[i].lieu+"</option>";
                    }
                });
                $output += "</select></div>";
                $('#LieuList').html($output);
            } 
        });
    }

    var region,edNumber;
    function setEventCouleur() {
        $('#couleur').change(function() {
            region = $('#couleur option:selected').text();
            edNumber = $('#couleur option:selected').data("ed");
            getLieuFromRegion(region, edNumber);
        });
    }


// ----------------------------------------------------------------
// -----------------------CATEGORIES-------------------------------
// ----------------------------------------------------------------

function setVarCat() {
    // Categorie et sous catégorie du défi

      // selecteur
      // catégories
      $cat = $('select[name=category]'),
      $items = $('select[name=items]');
      // sous catégories
      $res = $('select[name=res]');
}

  // premier appel pour set les catégories
  function setCatFirst() {
        var $this = $('#category').find(':selected'),
        rel = $this.attr('rel'),
        $set = $items.find('option.' + rel);

        $res.append('<option disabled selected value></option>');
        $set.clone().appendTo($res).show();
        $('#res').css("display", "block");

        if ($set.length == 0) {

            $('#res').hide();
            return;
        }else{
            $res.empty();
            $res.append('<option disabled selected value></option>');
            $set.clone().appendTo($res).show();
            $('#res').css("display", "block");

      }
    }

    // si on change de catégorie
    function setEventChangeCat() {
        $cat.change(function(){
            var $this = $(this).find(':selected'),
            rel = $this.attr('rel'),
            $set = $items.find('option.' + rel);

            if ($set.length == 0) {

                $('#res').hide();
                return;
            }else{
                $res.empty();
                $res.append('<option disabled selected value></option>');
                $set.clone().appendTo($res).show();
                $('#res').css("display", "block");
          }
        });  
    }

// ----------------------------------------------------------------
// -----------------------          -------------------------------
// ----------------------------------------------------------------

    function clearCkeditor() {
        for(name in CKEDITOR.instances)
        {
            CKEDITOR.instances[name].removeAllListeners();
            CKEDITOR.remove(CKEDITOR.instances[name]);
          // CKEDITOR.instances[name].destroy(true);
      }
    }


// pour afficher les médias en prévisualisation la première fois
    function readURLImgQcm(input, name) {
        if (input.value) {
            $('#'+name).attr('src', '../uploadDefi/defi/'+input.value);
        }else{
            $('#'+name).attr('src', '');
        }
    }
    function readURLAideImg(input, name, src) {
        if (input.value) {
            $('#'+name).attr('src', src+input.value);
        }else{
            $('#'+name).attr('src', '');
        }
    }
    function readURLAideVideo(input, name, src) {
        if (input.value) {
            $('#'+name).attr('src', src+input.value);
            var source = $('#'+name);
            source.parent()[0].load();
        }else{
            $('#'+name).attr('src', '');
        }
    }
    function readURLAideSon(input, name, src) {
        if (input.value) {
            $('#'+name).attr('src', src+input.value);
            var source = $('#'+name);
            source.parent()[0].load();
        }else{
            $('#'+name).attr('src', '');
        }
    }
    // pour la frise
    function readURLEtiqFrise(input, name) {
        if (input.value) {
            $('#'+name).attr('src', '../uploadDefi/FriseChrono/'+input.value);
        }else{
            $('#'+name).attr('src', '');
        }
    }
    // pour le classement
    function readURLEtiqClassement(input, name) {
        if (input.value) {
            $('#'+name).attr('src', '../uploadDefi/Classement/'+input.value);
        }else{
            $('#'+name).attr('src', '');
        }
    }
    // Change les médias quand il y a ajout d'un nouveau media dans les inputs pour la prévisualisation
    // image principale QCM
  function readURL(input) {

      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('#imgQuestionPrev').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
  }
  // affiche aide à la réponse
  // Image
    function readURLHelpImg(input, name) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('#'+name).attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
    }
    // Video
    function readURLHelpVideo(input, name) {
        if (input.files && input.files[0]) {
            var source = $('#'+name);

            source[0].src = URL.createObjectURL(input.files[0]);
            source.parent()[0].load();
        }
    }
    // Son
    function readURLHelpSon(input, name) {
        if (input.files && input.files[0]) {
            var source = $('#'+name);

            source[0].src = URL.createObjectURL(input.files[0]);
            source.parent()[0].load();
        }
    }
// etiquette pour la frise chronologique
  function readURLX(input, nb) {

      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('#etiquette'+nb+' > img').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
  }
  // classement
    function readURLImgPreview(input, name) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('#'+name).attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
    }

    // PREVISUALISATION
    function previewQcm() {

        // set media premier affichage
        readURLImgQcm($('#imageDefiOld')[0], "imgQuestionPrev");
        readURLAideImg($('#aideImgOld')[0], "imgHelpQCM", '../uploadDefi/aide/img/');
        readURLAideVideo($('#aideVideoOld')[0], "videoHelpQCM", '../uploadDefi/aide/video/');
        readURLAideSon($('#aideSonOld')[0], "sonHelpQCM", '../uploadDefi/aide/son/');
        // PREVIEW DU DEFI QCM
        $('#btnPreview').click(function() {
            $('#myModalQCM').modal();

            setDataModal();

            // Region
            switch (edNumber) {
              case 1:
                switch ($('#couleur').val()) {
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
              case 2:
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
              case 3:
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
              case 4:
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

            // titre question
            $('.titleQuestion').html($('#titreQuestion').val());
            // Question
            $('.question').html($('#question').val());
            // Les différentes réponses
            $('#rep1PrevLabel').html($('#rep1').val());
            $('#rep2PrevLabel').html($('#rep2').val());
            $('#rep3PrevLabel').html($('#rep3').val());
            $('#rep4PrevLabel').html($('#rep4').val());
            $('#rep5PrevLabel').html($('#rep5').val());

            // aide au défi
            switch($('#LieuList select').val()) {
                // ED1
                case "Bad":
                    $('.lieu').html("Bad Bergzabern");
                    $('#lieuHelp').html('Bad Bergzabern <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Wingen":
                    $('.lieu').html("Wingen sur Moder");
                    $('#lieuHelp').html('Wingen sur Moder <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Niederbronn":
                    $('.lieu').html("Niederbronn Les Bains");
                    $('#lieuHelp').html('Niederbronn Les Bains <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Soufflenheim":
                    $('.lieu').html("Soufflenheim Betschdorf");
                    $('#lieuHelp').html('Soufflenheim Betschdorf <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Erlenbach":
                    $('.lieu').html("Erlenbach bei Dahn");
                    $('#lieuHelp').html('Erlenbach bei Dahn <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Fischbach":
                    $('.lieu').html("Fischbach bei Dahn");
                    $('#lieuHelp').html('Fischbach bei Dahn <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Annweiler":
                    $('.lieu').html("Annweiler am Triffels");
                    $('#lieuHelp').html('Annweiler am Triffels <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Landau":
                    $('.lieu').html("Landau in der Pfalz");
                    $('#lieuHelp').html('Landau in der Pfalz <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                // ED2
                case "Haslach":
                    $('.lieu').html("Haslach im Kinzigtal");
                    $('#lieuHelp').html('Haslach im Kinzigtal <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Vosges":
                    $('.lieu').html("Vosges moyennes");
                    $('#lieuHelp').html('Vosges moyennes <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                // ED3
                case "Südlicher":
                    $('.lieu').html("Südlicher Schwarzwald");
                    $('#lieuHelp').html('Südlicher Schwarzwald <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Hautes":
                    $('.lieu').html("Hautes Vosges");
                    $('#lieuHelp').html('Hautes Vosges <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Le":
                    $('.lieu').html("Le Bonhomme");
                    $('#lieuHelp').html('Le Bonhomme <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Orschwiller":
                    $('.lieu').html("Orschwiller et Kintzheim");
                    $('#lieuHelp').html('Orschwiller et Kintzheim <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                // ED4
                case "Saint":
                    $('.lieu').html("Saint Louis");
                    $('#lieuHelp').html('Saint Louis <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Weil":
                    $('.lieu').html("Weil am Rhein");
                    $('#lieuHelp').html('Weil am Rhein <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;

                default:
                    $('#lieuHelp').html($('#LieuList select').val()+' <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
            }

            $('#questionHelp').html($('#titreQuestion').val());
            $('#txtHelp').html($('.editor').val());

        });
            $('#aideImg').on("change", function(){
                if ($('#aideImg')[0].value != "") {
                    readURLHelpImg(this, "imgHelpQCM");
                }else{
                    readURLAideImg($('#aideImgOld')[0], "imgHelpQCM", '../uploadDefi/aide/img/');
                }
            });
            $('#aideVideo').on("change", function(){
                if ($('#aideVideo')[0].value != "") {
                    readURLHelpVideo(this, "videoHelpQCM");
                }else{
                    readURLAideVideo($('#aideVideoOld')[0], "videoHelpQCM", '../uploadDefi/aide/video/');
                }
            });
            $('#aideSon').on("change", function(){
                if ($('#aideSon')[0].value != "") {
                    readURLHelpSon(this, "sonHelpQCM");
                }else{
                    readURLAideSon($('#aideSonOld')[0], "sonHelpQCM", '../uploadDefi/aide/son/');
                }
            });
            $('#imageDefiPrev').on("change", function(){
                if ($('#imageDefiPrev')[0].value != "") {
                    readURL(this);
                }else{
                    readURLImgQcm($('#imageDefiOld')[0], "imgQuestionPrev");
                }
            });
          // FIN DE LA PREVIEW QCM
    }

    function previewFrise() {

        // set media premier affichage
        readURLAideImg($('#aideImgOld')[0], "imgHelpFrise", '../uploadDefi/FriseChrono/aide/img/');
        readURLAideVideo($('#aideVideoOld')[0], "videoHelpFrise", '../uploadDefi/FriseChrono/aide/video/');
        readURLAideSon($('#aideSonOld')[0], "sonHelpFrise", '../uploadDefi/FriseChrono/aide/son/');
        // affichage des etiquettes actuelles (BDD)
        readURLEtiqFrise($('#eventOldImg1')[0], "etiquette1 img");
        readURLEtiqFrise($('#eventOldImg2')[0], "etiquette2 img");
        readURLEtiqFrise($('#eventOldImg3')[0], "etiquette3 img");
        readURLEtiqFrise($('#eventOldImg4')[0], "etiquette4 img");
        readURLEtiqFrise($('#eventOldImg5')[0], "etiquette5 img");
        readURLEtiqFrise($('#eventOldImg6')[0], "etiquette6 img");
         // PREVIEW DU DEFI Frise
         $('#btnPreview').click(function() {
            $('#myModalFrise').modal();

            setDataModal();

            // Date début frise
            $('#debFrise').html($('#dateDebFrise').val());
            // Date fin frise
            $('#finFrise').html($('#dateFinFrise').val());
            // Titre frise
            $('#titleFrise').html($('#titreFrise').val());
            // Etiquette de la frise
            $('#etiquette1 span').html($('#eventName1').val());
            $('#etiquette2 span').html($('#eventName2').val());
            $('#etiquette3 span').html($('#eventName3').val());
            $('#etiquette4 span').html($('#eventName4').val());
            $('#etiquette5 span').html($('#eventName5').val());
            $('#etiquette6 span').html($('#eventName6').val());

            // aide au défi
            switch($('#LieuList select').val()) {
                // ED1
                case "Bad":
                    $('.lieu').html("Bad Bergzabern");
                    $('#lieuHelpFrise').html('Bad Bergzabern <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Wingen":
                    $('.lieu').html("Wingen sur Moder");
                    $('#lieuHelpFrise').html('Wingen sur Moder <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Niederbronn":
                    $('.lieu').html("Niederbronn Les Bains");
                    $('#lieuHelpFrise').html('Niederbronn Les Bains <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Soufflenheim":
                    $('.lieu').html("Soufflenheim Betschdorf");
                    $('#lieuHelpFrise').html('Soufflenheim Betschdorf <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Erlenbach":
                    $('.lieu').html("Erlenbach bei Dahn");
                    $('#lieuHelpFrise').html('Erlenbach bei Dahn <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Fischbach":
                    $('.lieu').html("Fischbach bei Dahn");
                    $('#lieuHelpFrise').html('Fischbach bei Dahn <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Annweiler":
                    $('.lieu').html("Annweiler am Triffels");
                    $('#lieuHelpFrise').html('Annweiler am Triffels <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Landau":
                    $('.lieu').html("Landau in der Pfalz");
                    $('#lieuHelpFrise').html('Landau in der Pfalz <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                // ED2
                case "Haslach":
                    $('.lieu').html("Haslach im Kinzigtal");
                    $('#lieuHelpFrise').html('Haslach im Kinzigtal <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Vosges":
                    $('.lieu').html("Vosges moyennes");
                    $('#lieuHelpFrise').html('Vosges moyennes <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                // ED3
                case "Südlicher":
                    $('.lieu').html("Südlicher Schwarzwald");
                    $('#lieuHelpFrise').html('Südlicher Schwarzwald <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Hautes":
                    $('.lieu').html("Hautes Vosges");
                    $('#lieuHelpFrise').html('Hautes Vosges <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Le":
                    $('.lieu').html("Le Bonhomme");
                    $('#lieuHelpFrise').html('Le Bonhomme <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Orschwiller":
                    $('.lieu').html("Orschwiller et Kintzheim");
                    $('#lieuHelpFrise').html('Orschwiller et Kintzheim <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                // ED4
                case "Saint":
                    $('.lieu').html("Saint Louis");
                    $('#lieuHelpFrise').html('Saint Louis <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;
                case "Weil":
                    $('.lieu').html("Weil am Rhein");
                    $('#lieuHelpFrise').html('Weil am Rhein <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                    break;

                default:
                    $('#lieuHelpFrise').html($('#LieuList select').val()+' <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
            }

            $('#questionHelpFrise').html($('#titreFrise').val());
            $('#txtHelpFrise').html($('#editorFrise').val());

        });

         // Si on change un input prend la nouvelle valeur et affiche le novueau media ou si vide affiche l'ancien media
        $('#aideImgFrise').on("change", function(){
            if ($('#aideImgFrise')[0].value != "") {
                readURLHelpImg(this, "imgHelpFrise");
            }else{
                readURLAideImg($('#aideImgOld')[0], "imgHelpFrise", '../uploadDefi/FriseChrono/aide/img/');
            }
        });
        $('#aideVideoFrise').on("change", function(){
            if ($('#aideVideoFrise')[0].value != "") {
                readURLHelpVideo(this, "videoHelpFrise");
            }else{
                readURLAideVideo($('#aideVideoOld')[0], "videoHelpFrise", '../uploadDefi/FriseChrono/aide/video/');
            }
        });
        $('#aideSonFrise').on("change", function(){
            if ($('#aideSonFrise')[0].value != "") {
                readURLHelpSon(this, "sonHelpFrise");
            }else{
                readURLAideSon($('#aideSonOld')[0], "sonHelpFrise", '../uploadDefi/FriseChrono/aide/son/');
            }
        });

         $('#etiquette1Prev').on("change", function(){
            if ($('#etiquette1Prev')[0].value != "") {
                readURLX(this, "1");
            }else{
                readURLEtiqFrise($('#eventOldImg1')[0], "etiquette1 img");
            }
        });
         $('#etiquette2Prev').on("change", function(){
            if ($('#etiquette2Prev')[0].value != "") {
                readURLX(this, "2");
            }else{
                readURLEtiqFrise($('#eventOldImg2')[0], "etiquette2 img");
            }
        });
         $('#etiquette3Prev').on("change", function(){
            if ($('#etiquette3Prev')[0].value != "") {
                readURLX(this, "3");
            }else{
                readURLEtiqFrise($('#eventOldImg3')[0], "etiquette3 img");
            }
        });
         $('#etiquette4Prev').on("change", function(){
            if ($('#etiquette4Prev')[0].value != "") {
                readURLX(this, "4");
            }else{
                readURLEtiqFrise($('#eventOldImg4')[0], "etiquette4 img");
            }
        });
         $('#etiquette5Prev').on("change", function(){
            if ($('#etiquette5Prev')[0].value != "") {
                readURLX(this, "5");
            }else{
                readURLEtiqFrise($('#eventOldImg5')[0], "etiquette5 img");
            }
        });
         $('#etiquette6Prev').on("change", function(){
            if ($('#etiquette6Prev')[0].value != "") {
                readURLX(this, "6");
            }else{
                readURLEtiqFrise($('#eventOldImg6')[0], "etiquette6 img");
            }
        });
          // FIN DE LA PREVIEW Frise
    }

    function previewTrou() {

        readURLAideImg($('#aideImgOld')[0], "imgHelpTrou", '../uploadDefi/TexteTrou/aide/img/');
        readURLAideVideo($('#aideVideoOld')[0], "videoHelpTrou", '../uploadDefi/TexteTrou/aide/video/');
        readURLAideSon($('#aideSonOld')[0], "sonHelpTrou", '../uploadDefi/TexteTrou/aide/son/');
        // PREVIEW DU DEFI Trou
      $('#btnPreview').click(function() {
        $('#myModalTrou').modal();

        setDataModal();

        // Titre
        $('#titleQuestionTrou').html($('#titreQuestionTxtTrou').val());
        // Question
        $('.questionTrous').html($('#questionTxtTrou').val());
        // TAT
        var TAT;
        var nbInput = 0;
        TAT = ($('#txtTrou').val()).replace(/INPUT\d/g, function() {
                                  nbInput++;
                                  return '<input type="text" id="inputTrou'+nbInput+'" name="inputTrou'+nbInput+'">';
                                });
        $('#TAT').html(TAT);

        // aide au défi
        switch($('#LieuList select').val()) {
            // ED1
            case "Bad":
                $('.lieu').html("Bad Bergzabern");
                $('#lieuHelpTrou').html('Bad Bergzabern <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Wingen":
                $('.lieu').html("Wingen sur Moder");
                $('#lieuHelpTrou').html('Wingen sur Moder <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Niederbronn":
                $('.lieu').html("Niederbronn Les Bains");
                $('#lieuHelpTrou').html('Niederbronn Les Bains <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Soufflenheim":
                $('.lieu').html("Soufflenheim Betschdorf");
                $('#lieuHelpTrou').html('Soufflenheim Betschdorf <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Erlenbach":
                $('.lieu').html("Erlenbach bei Dahn");
                $('#lieuHelpTrou').html('Erlenbach bei Dahn <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Fischbach":
                $('.lieu').html("Fischbach bei Dahn");
                $('#lieuHelpTrou').html('Fischbach bei Dahn <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Annweiler":
                $('.lieu').html("Annweiler am Triffels");
                $('#lieuHelpTrou').html('Annweiler am Triffels <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Landau":
                $('.lieu').html("Landau in der Pfalz");
                $('#lieuHelpTrou').html('Landau in der Pfalz <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            // ED2
            case "Haslach":
                $('.lieu').html("Haslach im Kinzigtal");
                $('#lieuHelpTrou').html('Haslach im Kinzigtal <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Vosges":
                $('.lieu').html("Vosges moyennes");
                $('#lieuHelpTrou').html('Vosges moyennes <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            // ED3
            case "Südlicher":
                $('.lieu').html("Südlicher Schwarzwald");
                $('#lieuHelpTrou').html('Südlicher Schwarzwald <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Hautes":
                $('.lieu').html("Hautes Vosges");
                $('#lieuHelpTrou').html('Hautes Vosges <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Le":
                $('.lieu').html("Le Bonhomme");
                $('#lieuHelpTrou').html('Le Bonhomme <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Orschwiller":
                $('.lieu').html("Orschwiller et Kintzheim");
                $('#lieuHelpTrou').html('Orschwiller et Kintzheim <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            // ED4
            case "Saint":
                $('.lieu').html("Saint Louis");
                $('#lieuHelpTrou').html('Saint Louis <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Weil":
                $('.lieu').html("Weil am Rhein");
                $('#lieuHelpTrou').html('Weil am Rhein <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;

            default:
                $('#lieuHelpTrou').html($('#LieuList select').val()+' <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
        }

        $('#questionHelpTrou').html($('#titreQuestionTxtTrou').val());
        $('#txtHelpTrou').html($('#editorTrou').val());

      });

      $('#aideImgTxtTrou').on("change", function(){
        if ($('#aideImgTxtTrou')[0].value != "") {
            readURLHelpImg(this, "imgHelpTrou");
        }else{
            readURLAideImg($('#aideImgOld')[0], "imgHelpTrou", '../uploadDefi/TexteTrou/aide/img/');
        }
      });
      $('#aideVideoTxtTrou').on("change", function(){
        if ($('#aideVideoTxtTrou')[0].value != "") {
            readURLHelpVideo(this, "videoHelpTrou");
        }else{
            readURLAideVideo($('#aideVideoOld')[0], "videoHelpTrou", '../uploadDefi/TexteTrou/aide/video/');
        }
      });
      $('#aideSonTxtTrou').on("change", function(){
        if ($('#aideSonTxtTrou')[0].value != "") {
            readURLHelpSon(this, "sonHelpTrou");
        }else{
            readURLAideSon($('#aideSonOld')[0], "sonHelpTrou", '../uploadDefi/TexteTrou/aide/son/');
        }
      });
    }

    function previewVocal() {

        readURLAideImg($('#aideImgOld')[0], "imgHelpVoca", '../uploadDefi/aide/img/');
        readURLAideVideo($('#aideVideoOld')[0], "videoHelpVoca", '../uploadDefi/aide/video/');
        readURLAideSon($('#aideSonOld')[0], "sonHelpVoca", '../uploadDefi/aide/son/');
      // PREVIEW DU DEFI VocaTxt
      $('#btnPreview').click(function() {
        $('#myModalVoca').modal();

        setDataModal();

        // titre question
        $('.titleQuestion').html($('#titreQuestionVocaTxt').val());
        // Question
        $('.questionVoca').html($('#questionVocaTxt').val());
        // réponse vocale
        $('#resVoice').html($('#repVocale').val());

        // aide au défi
        switch($('#LieuList select').val()) {
            // ED1
            case "Bad":
                $('.lieu').html("Bad Bergzabern");
                $('#lieuHelpVoca').html('Bad Bergzabern <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Wingen":
                $('.lieu').html("Wingen sur Moder");
                $('#lieuHelpVoca').html('Wingen sur Moder <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Niederbronn":
                $('.lieu').html("Niederbronn Les Bains");
                $('#lieuHelpVoca').html('Niederbronn Les Bains <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Soufflenheim":
                $('.lieu').html("Soufflenheim Betschdorf");
                $('#lieuHelpVoca').html('Soufflenheim Betschdorf <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Erlenbach":
                $('.lieu').html("Erlenbach bei Dahn");
                $('#lieuHelpVoca').html('Erlenbach bei Dahn <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Fischbach":
                $('.lieu').html("Fischbach bei Dahn");
                $('#lieuHelpVoca').html('Fischbach bei Dahn <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Annweiler":
                $('.lieu').html("Annweiler am Triffels");
                $('#lieuHelpVoca').html('Annweiler am Triffels <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Landau":
                $('.lieu').html("Landau in der Pfalz");
                $('#lieuHelpVoca').html('Landau in der Pfalz <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            // ED2
            case "Haslach":
                $('.lieu').html("Haslach im Kinzigtal");
                $('#lieuHelpVoca').html('Haslach im Kinzigtal <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Vosges":
                $('.lieu').html("Vosges moyennes");
                $('#lieuHelpVoca').html('Vosges moyennes <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            // ED3
            case "Südlicher":
                $('.lieu').html("Südlicher Schwarzwald");
                $('#lieuHelpVoca').html('Südlicher Schwarzwald <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Hautes":
                $('.lieu').html("Hautes Vosges");
                $('#lieuHelpVoca').html('Hautes Vosges <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Le":
                $('.lieu').html("Le Bonhomme");
                $('#lieuHelpVoca').html('Le Bonhomme <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Orschwiller":
                $('.lieu').html("Orschwiller et Kintzheim");
                $('#lieuHelpVoca').html('Orschwiller et Kintzheim <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            // ED4
            case "Saint":
                $('.lieu').html("Saint Louis");
                $('#lieuHelpVoca').html('Saint Louis <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Weil":
                $('.lieu').html("Weil am Rhein");
                $('#lieuHelpVoca').html('Weil am Rhein <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;

            default:
                $('#lieuHelpVoca').html($('#LieuList select').val()+' <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
        }

        $('#questionHelpVoca').html($('#titreQuestionVocaTxt').val());
        $('#txtHelpVoca').html($('#editorVoca').val());

      });

        $('#aideImgVocaTxt').on("change", function(){
            if ($('#aideImgVocaTxt')[0].value != "") {
                readURLHelpImg(this, "imgHelpVoca");
            }else{
                readURLAideImg($('#aideImgOld')[0], "imgHelpVoca", '../uploadDefi/aide/img/');
            }
          
        });
        $('#aideVideoVocaTxt').on("change", function(){
            if ($('#aideVideoVocaTxt')[0].value != "") {
                readURLHelpVideo(this, "videoHelpVoca");
            }else{
                readURLAideVideo($('#aideVideoOld')[0], "videoHelpVoca", '../uploadDefi/aide/video/');
            }
         
        });
        $('#aideSonVocaTxt').on("change", function(){
            if ($('#aideSonVocaTxt')[0].value != "") {
                readURLHelpSon(this, "sonHelpVoca");
            }else{
                readURLAideSon($('#aideSonOld')[0], "sonHelpVoca", '../uploadDefi/aide/son/');
            }
        });
      // FIN DE LA PREVIEW VocaTxt
    }

    function previewClassement() {

        readURLAideImg($('#aideImgOld')[0], "imgHelpClassement", '../uploadDefi/Classement/aide/img/');
        readURLAideVideo($('#aideVideoOld')[0], "videoHelpClassement", '../uploadDefi/Classement/aide/video/');
        readURLAideSon($('#aideSonOld')[0], "sonHelpClassement", '../uploadDefi/Classement/aide/son/');
      // PREVIEW DU DEFI Classement
      $('#btnPreview').click(function() {
        $('#myModalClassement').modal();

        setDataModal();

        // titre question
        $('.titreClassement').html("<h1>"+$('#questionClassement').val()+"</h1>");

        // Création du défi
        $('.classementGame').empty();
        // toutes les étiquettes + valise
        var resClassGame = '';
        // nombre de valisette
        var nbCatClassPreview = $('#nbCatClassement').val();
        // type de l'etiquette
        var typeEtiqC = $('#typeEtiqClassement').val();
        var typeEtiqClassPreview;
        if (typeEtiqC == 1) {
          typeEtiqClassPreview = "mot";
        }else if (typeEtiqC == 2) {
          typeEtiqClassPreview = "grpMot";
        }else if (typeEtiqC == 3) {
          typeEtiqClassPreview = "imageClmt";
        }


        // dans classementGame création etiquette + valise
        // création des étiquettes
        for (var j=1; j <= nbCatClassPreview; j++) { 
          for (var k=1; k <= 5; k++) { 

            if (typeEtiqC == 1) {
              var top = rand(35,52);
              var left = rand(2,88);
            }else if (typeEtiqC == 2) {
              var top = rand(35,52);
              var left = rand(2,78);
            }else if (typeEtiqC == 3) {
              var top = rand(35,52);
              var left = rand(2,88);
            }
            
            if (typeEtiqC != 3) {
              resClassGame += "<div style='top: "+top+"%;left: "+left+"%;' class='etiquetteClassement "+typeEtiqClassPreview+"'>"+$('#cat'+j+'Etiq'+k).val()+"</div>";
            }else{
              resClassGame += "<div style='top: "+top+"%;left: "+left+"%;' class='etiquetteClassement "+typeEtiqClassPreview+"'><img id='imgPreview"+j+"_"+k+"' style='width: 100%;' src=''></div>";
            }
          }
        }

        // création des boites
        var classNbVal = '';
        if (nbCatClassPreview == 4) {
          classNbVal = 'classNbVal4';
        }else if (nbCatClassPreview == 3) {
          classNbVal = 'classNbVal3';
        }
        for (var i=1; i <= nbCatClassPreview; i++) { 
          resClassGame += "<div id='valise"+i+"'>";
          resClassGame += '<img src="../img/Defi/classement/caisseclose.png" class="'+classNbVal+' boiteClassement'+i+'">';
          resClassGame += '<div class="'+classNbVal+' nameboiteClassement'+i+'">';
          resClassGame += $('#nameCat'+i+'Classement').val()+'</div>';
          resClassGame += "</div>";
        }

        $('.classementGame').append(resClassGame);
        
      // pour les etiquettes images 
      for (var n = 1; n <= nbCatClassPreview; n++) {
        for (var o = 1; o <= 5; o++) {
            if ($('#cat'+n+'Etiq'+o)[0].value != "") {
                readURLImgPreview($('#cat'+n+'Etiq'+o)[0], "imgPreview"+n+"_"+o);
            }else{
                readURLEtiqClassement($('#cat'+n+'Etiq'+o+'Old')[0], "imgPreview"+n+"_"+o);
            }
        }
      }

        // aide au défi
        switch($('#LieuList select').val()) {
            // ED1
            case "Bad":
                $('.lieu').html("Bad Bergzabern");
                $('#lieuHelpClassement').html('Bad Bergzabern <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Wingen":
                $('.lieu').html("Wingen sur Moder");
                $('#lieuHelpClassement').html('Wingen sur Moder <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Niederbronn":
                $('.lieu').html("Niederbronn Les Bains");
                $('#lieuHelpClassement').html('Niederbronn Les Bains <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Soufflenheim":
                $('.lieu').html("Soufflenheim Betschdorf");
                $('#lieuHelpClassement').html('Soufflenheim Betschdorf <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Erlenbach":
                $('.lieu').html("Erlenbach bei Dahn");
                $('#lieuHelpClassement').html('Erlenbach bei Dahn <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Fischbach":
                $('.lieu').html("Fischbach bei Dahn");
                $('#lieuHelpClassement').html('Fischbach bei Dahn <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Annweiler":
                $('.lieu').html("Annweiler am Triffels");
                $('#lieuHelpClassement').html('Annweiler am Triffels <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Landau":
                $('.lieu').html("Landau in der Pfalz");
                $('#lieuHelpClassement').html('Landau in der Pfalz <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            // ED2
            case "Haslach":
                $('.lieu').html("Haslach im Kinzigtal");
                $('#lieuHelpClassement').html('Haslach im Kinzigtal <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Vosges":
                $('.lieu').html("Vosges moyennes");
                $('#lieuHelpClassement').html('Vosges moyennes <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            // ED3
            case "Südlicher":
                $('.lieu').html("Südlicher Schwarzwald");
                $('#lieuHelpClassement').html('Südlicher Schwarzwald <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Hautes":
                $('.lieu').html("Hautes Vosges");
                $('#lieuHelpClassement').html('Hautes Vosges <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Le":
                $('.lieu').html("Le Bonhomme");
                $('#lieuHelpClassement').html('Le Bonhomme <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Orschwiller":
                $('.lieu').html("Orschwiller et Kintzheim");
                $('#lieuHelpClassement').html('Orschwiller et Kintzheim <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            // ED4
            case "Saint":
                $('.lieu').html("Saint Louis");
                $('#lieuHelpClassement').html('Saint Louis <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;
            case "Weil":
                $('.lieu').html("Weil am Rhein");
                $('#lieuHelpClassement').html('Weil am Rhein <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
                break;

            default:
                $('#lieuHelpClassement').html($('#LieuList select').val()+' <img style="position: absolute;top: 3%;left: 68%;width: 25%;" src="/pamina/img/Defi/aide/logos-PAMINA_06.png">');
        }

        $('#questionHelpClassement').html($('#questionClassement').val());
        $('#txtHelpClassement').html($('#editorClassement').val());
      });

      $('#aideImgClassement').on("change", function(){
        if ($('#aideImgClassement')[0].value != "") {
            readURLHelpImg(this, "imgHelpClassement");
        }else{
            readURLAideImg($('#aideImgOld')[0], "imgHelpClassement", '../uploadDefi/Classement/aide/img/');
        }
      });
      $('#aideVideoClassement').on("change", function(){
        if ($('#aideVideoClassement')[0].value != "") {
            readURLHelpVideo(this, "videoHelpClassement");
        }else{
            readURLAideVideo($('#aideVideoOld')[0], "videoHelpClassement", '../uploadDefi/Classement/aide/video/');
        }
      });
      $('#aideSonClassement').on("change", function(){
        if ($('#aideSonClassement')[0].value != "") {
            readURLHelpSon(this, "sonHelpClassement");
        }else{
            readURLAideSon($('#aideSonOld')[0], "sonHelpClassement", '../uploadDefi/Classement/aide/son/');
        }
      });

      // si l'on change la valeur du nombre de catégorie, le nombre de champs de catégorie change en fonction
      $('#nbCatClassement').on("change", function() {
        nbCats = $('#nbCatClassement').val();
        $('#catNamesClassement').empty();
        $('#etiquettesClassement').empty();
        $('#typeEtiqClassement').prop('selectedIndex',0);
        CatsName = "";
        for (var i = 1; i <= nbCats; i++) {
          CatsName += '<div class="form-group"><label>Catégorie '+i+' :</label><input type="text" id="nameCat'+i+'Classement" class="form-control" name="nameCat'+i+'Classement" required></div>';
        }
        $('#catNamesClassement').append(CatsName);
        callTypeEtiq(nbCats);
      });
    }

    function rand(min, max){
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    function deleteDefi(idOwner) {
        // 2- on supprime les données dans la base
       $.ajax({                                      
            url: '../model/deleteDefi.php', 
            type : "POST",        
            data: {idDefi : id, typeDefi : typeDefiSelect, idOwner : idOwner},
            success: function() {
                // on actualise l'affichage
                // window.location.replace("../vue/modifDefi.php");
                switch(typeDefiSelect) {
                case "Qcm":
                    $("#btnQcm").trigger("click");
                    break;
                case "Trou":
                    $("#btnTrou").trigger("click");
                    break;
                case "Vocal":
                    $("#btnVocal").trigger("click");
                    break;
                case "Frise":
                    $("#btnFrise").trigger("click");
                    break;
                case "Classement":
                    $("#btnClassement").trigger("click");
                    break;
                }
            }
        });
    }

    // Pour la prévisualisation
    function setDataModal() {
    // Region
    switch (edNumber) {
      case 1:
        switch ($('#couleur').val()) {
          case 'alsace':
            $('.tempDefi').css("background-image", "url(/pamina/img/Defi/ED1/alsace/fenetre.png)"); 
            $('.region').attr("src", "/pamina/img/Defi/ED1/alsace/titre.png");
            break;
          case 'mittlerer':
            $('.tempDefi').css("background-image", "url(/pamina/img/Defi/ED1/mittlerer/fenetre.png)"); 
            $('.region').attr("src", "/pamina/img/Defi/ED1/mittlerer/titre.png");
            break;
          case 'sudpfalz':
            $('.tempDefi').css("background-image", "url(/pamina/img/Defi/ED1/sudpfalz/fenetre.png)"); 
            $('.region').attr("src", "/pamina/img/Defi/ED1/sudpfalz/titre.png");
            break;
        }
        break;
      case 2:
        switch ($('#couleur').val()) {
          case 'erstein':
            $('.tempDefi').css("background-image", "url(/pamina/img/Defi/ED2/erstein/fenetre.png)"); 
            $('.region').attr("src", "/pamina/img/Defi/ED2/erstein/titre.png");
            break;
          case 'molsheim':
            $('.tempDefi').css("background-image", "url(/pamina/img/Defi/ED2/molsheim/fenetre.png)"); 
            $('.region').attr("src", "/pamina/img/Defi/ED2/molsheim/titre.png");
            break;
          case 'ortenau':
            $('.tempDefi').css("background-image", "url(/pamina/img/Defi/ED2/ortenau/fenetre.png)"); 
            $('.region').attr("src", "/pamina/img/Defi/ED2/ortenau/titre.png");
            break;
          case 'strasbourg':
            $('.tempDefi').css("background-image", "url(/pamina/img/Defi/ED2/strasbourg/fenetre.png)"); 
            $('.region').attr("src", "/pamina/img/Defi/ED2/strasbourg/titre.png");
            break;
        }
        break;
      case 3:
        switch ($('#couleur').val()) {
          case 'all_fcsa':
            $('.tempDefi').css("background-image", "url(/pamina/img/Defi/ED3/all_fcsa/fenetre.png)"); 
            $('.region').attr("src", "/pamina/img/Defi/ED3/all_fcsa/titre.png");
            break;
          case 'fr_fcsa':
            $('.tempDefi').css("background-image", "url(/pamina/img/Defi/ED3/fr_fcsa/fenetre.png)"); 
            $('.region').attr("src", "/pamina/img/Defi/ED3/fr_fcsa/titre.png");
            break;
        }
        break;
      case 4:
        switch ($('#couleur').val()) {
          case 'all_ETB':
            $('.tempDefi').css("background-image", "url(/pamina/img/Defi/ED4/all_ETB/fenetre.png)"); 
            $('.region').attr("src", "/pamina/img/Defi/ED4/all_ETB/titre.png");
            break;
          case 'ch_ETB':
            $('.tempDefi').css("background-image", "url(/pamina/img/Defi/ED4/ch_ETB/fenetre.png)"); 
            $('.region').attr("src", "/pamina/img/Defi/ED4/ch_ETB/titre.png");
            break;
          case 'fr_ETB':
            $('.tempDefi').css("background-image", "url(/pamina/img/Defi/ED4/fr_ETB/fenetre.png)"); 
            $('.region').attr("src", "/pamina/img/Defi/ED4/fr_ETB/titre.png");
            break;
        }
        break;
      
      default:

        break;
    }
    // lieu
    switch($('#LieuList select').val()) {
        // ED1
        case "Bad":
            $('.lieu').html("Bad Bergzabern");
            break;
        case "Wingen":
            $('.lieu').html("Wingen sur Moder");
            break;
        case "Niederbronn":
            $('.lieu').html("Niederbronn Les Bains");
            break;
        case "Soufflenheim":
            $('.lieu').html("Soufflenheim Betschdorf");
            break;
        case "Erlenbach":
            $('.lieu').html("Erlenbach bei Dahn");
            break;
        case "Fischbach":
            $('.lieu').html("Fischbach bei Dahn");
            break;
        case "Annweiler":
            $('.lieu').html("Annweiler am Triffels");
            break;
        case "Landau":
            $('.lieu').html("Landau in der Pfalz");
            break;
        // ED2
        case "Haslach":
            $('.lieu').html("Haslach im Kinzigtal");
            break;
        case "Vosges":
            $('.lieu').html("Vosges moyennes");
            break;
        // ED3
        case "Südlicher":
            $('.lieu').html("Südlicher Schwarzwald");
            break;
        case "Hautes":
            $('.lieu').html("Hautes Vosges");
            break;
        case "Le":
            $('.lieu').html("Le Bonhomme");
            break;
        case "Orschwiller":
            $('.lieu').html("Orschwiller et Kintzheim");
            break;
        // ED4
        case "Saint":
            $('.lieu').html("Saint Louis");
            break;
        case "Weil":
            $('.lieu').html("Weil am Rhein");
            break;
        default:
            $('.lieu').html($('#LieuList select').val());
    }
  }

});