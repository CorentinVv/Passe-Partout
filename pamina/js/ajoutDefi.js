$(document).ready(function() {

  var session;
  function getSession() {
    $.get('../model/getSession.php', function(data) {
      session = JSON.parse(data);
    });
  }
  getSession();

    function readURLImgPreview(input, name) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('#'+name).attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
    }

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
  // $('.rotation').click(function() {
  //   $('#cacheAide').css('display','block');
  // });

  // ferme l'aide à la réponse
  // $('.?').click(function() {

  //   $('#cacheAide').css('display','none');
  // });

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

    //trigger click ED1 de base
    $('#Calque_1 > path:nth-child(1)').trigger("click");

  function getLieuFromRegion(region,edNumber) {
    $.ajax({                                      
      url: '../json/ED'+edNumber+'/PositionsPoints'+edNumber+'.json',    //the script to call to get data          
      data: "",                        //you can insert url argumnets here to pass to api.php
                                       //for example "id=5&parent=6"
      dataType: 'json',                //data format      
      success: function(data)          //on recieve of reply
      {
        $output = "<div class='form-group'><label>"+lieuDefi+" :</label><select name='lieu' class='form-control' required><option disabled selected value></option>";
        
        $.each(data, function(i, item) {
          if (typeof(data[i].lieu) != "undefined" && data[i].region == region) {
            $output += "<option value="+data[i].lieu+">"+data[i].lieu+"</option>";
          }
        });
        $output += "</select></div>";
        // var id = data[0];              //get id
        // var vname = data[1];           //get name
        //--------------------------------------------------------------------
        // 3) Update html content
        //--------------------------------------------------------------------
        $('#LieuList').html($output); //Set output element html
        //recommend reading up on jquery selectors they are awesome 
        // http://api.jquery.com/category/selectors/
      } 
    });
  }

  var region,edNumber;
  $('#couleur').change(function() {
    region = $('#couleur option:selected').text();
    edNumber = $('#couleur option:selected').data("ed");
    getLieuFromRegion(region, edNumber);
  });

  var last;
// anti bug form
  $("#typeDef").change(function() {

    // bouton prévisualiser grisé

  if ($('#typeDef').val() != null) {
    $('#btnPreview').off('click');
    $('#btnPreview').removeClass("disabled");
    $('#btnPreview').removeAttr("disabled");
  }

    //last!=null
    // var basicDeb = '<form enctype="multipart/form-data" method="post" action="../model/addDefi.php"> <div id="edMap"> <select style="visibility: hidden;" name="ed" class="form-control"  required> <option disabled selected value></option> <option value="ED1">ED 1</option> <option value="ED2">ED 2</option> <option value="ED3">ED 3</option> <option value="ED4">ED 4</option> </select> </div> <div class="form-group"> <label>EuroDistrict :</label> </div> <div class="map"> <svg version="1.1" id="Calque_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"width="116.27px" height="167.857px" viewBox="0 0 116.27 167.857" enable-background="new 0 0 116.27 167.857"xml:space="preserve"> <path fill="#BDD245" stroke="#A74D96" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M93.238,27.119 c-0.98-1.946-2.62-0.604-2.62-0.604l-0.491-3.894c0,0-2.348-0.314-3.146-1.563c-0.802-1.25-2.005-0.202-2.005-0.202 s-6.188-0.611-8.483-3.074l-3.337,3.092l0.014-0.118c-1.238-1.97-3.56-3.404-3.56-3.404s-1.716,0.646-3.281,0.87 c-1.567,0.218-1.243-0.367-1.243-0.367s-4.716-0.597-6.185-0.541c-1.464,0.054-1.937-1.116-1.937-1.116s-3.665,2.068-6.388,5.1 c-2.725,3.031-4.351,8.516-4.351,8.516c-4.103,0.806-2.782,3.497-2.271,4.715l-3.116,7.296c0,0-2.646-1.243-3.775-1.537 s-3.922,0.916-4.737,1.31c-0.815,0.396-1.194-0.765-1.623-1.31c-0.432-0.545-6.649-1.603-6.649-1.603l-1.475-4.229l-0.976,0.356 c0,0-0.254,3.831-1.64,6.167c-1.387,2.336-2.83,3.062-2.83,3.062s0.75,1.777,3.013,2.272c2.265,0.494,1.55,2.945,1.605,3.937 c0.057,0.988,1.301,1.37,1.301,1.37s1.801-3.122,3.263-3.358c1.46-0.233,5.581,3.854,5.581,3.854 c-0.219,1.751-2.148,4.92-2.148,4.92s1.001,1.693,2.697,2.268c1.697,0.575,7.737-0.22,7.309-1.59c0,0,0.91,0.632,1.738,2.187 c0.307,0.573,1.447,2.379,2.638,2.688c0.947,0.247,1.457-0.515,2.273-1.344c0.3-0.303,1.605-0.983,1.605-1.708 c0-0.438-0.984-0.775-0.984-0.775l0.362-2.999c0.622-0.312,3.322-0.388,3.31,0.467c-0.012,0.852,5.408-0.165,5.408-0.165l1.96-2.671 l0.016-0.081l1.332,1.912c1.695,0.82,9.894,2.875,9.894,2.875s1.111,0.721,0.399,1.501c0,0,2.357,2.166,5.856-1.537 c3.502-3.703,2.896-8.744,2.896-8.744L76.5,50.574c0,0,1.553-2.651-1.42-3.487l-0.324-1.767l4.202,0.484 c0,0,1.548-9.889,2.354-10.046c0.811-0.153,5.273-0.475,5.976-0.879c0.698-0.4-0.383-2.862,1.276-3.057 c1.661-0.193,1.873,0.202,1.873,0.202S94.223,29.065,93.238,27.119z"/> <path fill="#72BB6F" stroke="#A74D96" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M81.394,104.133 c0,0-1.103,0.62-2.139,0.968c-1.034,0.345-2.688,0.345-4.067-0.07c-1.38-0.414-2.416,1.794-2.553,3.382 c-0.139,1.586,0.551,2.413-0.206,2.688c-0.76,0.275-0.691,0-1.104-0.689c-0.414-0.688-3.034-0.896-4.207-3.38 c-1.175-2.483-1.863-0.483-2.277-0.965c-0.089-0.104-0.214-0.216-0.376-0.331c-0.599-0.428-1.703-0.9-3.278-1.119 c-2-0.274-1.932,0.484-3.516,3.312c-1.586,2.828-4.62,2.828-6.897,4.002c-2.273,1.174-1.586-0.069-3.103,0.138 c-1.52,0.208-1.52,3.38-2.552,4.415c-1.035,1.034-6.485,1.793-7.521,2.274c-0.226,0.105-0.423,0.179-0.597,0.203 c-0.623,0.096-0.957-0.409-1.334-2.134c-0.482-2.209-1.793,1.309-2.966,1.034c-1.175-0.276-0.896-5.243-0.483-7.656 c0.156-0.907-2.137-1.793-3.311-2.346c-1.175-0.552-2.208-2.414-3.589-3.035c-1.379-0.621-3.239-4.691-3.033-5.864 c0.208-1.172,3.726-4.827,3.174-6.965s1.517-7.52,3.311-10.279c1.793-2.759-0.481-2.345,0-3.725c0.483-1.38,3.655-4.139,4.276-5.104 c0.622-0.967,3.726-0.826,4.967-1.104c1.242-0.275,4.277-0.827,5.104-0.413c0.827,0.413,0.689,0.345,1.24-0.482 c0.554-0.827,0.896-2.206,1.312-2.966l0.207-0.442c0.172,0.689,0.312,1.288,0.232,1.518c0,0,1.089,0.104,1.761-0.414 c0.672-0.517,1.239-0.672,1.292,0.312c0.052,0.98,0.465,1.654,1.861,2.226c1.396,0.569,0.671,0.465,0.671,0.465 s-0.931,1.5-0.618,3.154c0.31,1.657,0.981,3.208,0.153,3.932c-0.828,0.726-1.499,1.189-1.653,2.328c-0.155,1.139,0,1.655,0,1.655 s3.259,0.621,4.188,1.086c0.932,0.465,2.068-0.569,3.981,0.362c1.913,0.931,3.67,1.292,4.136,0.825 c0.465-0.465,0.155-2.531,2.378-1.396c2.223,1.138,4.242-0.207,4.5-0.31c0.259-0.104,0.961,1.67,0.703,2.289 c-1.173-0.619-1.234,0.608-1.45,1.861c-0.216,1.255,0,1.934,1.104,3.657c1.103,1.725-0.62,0.688-1.45,1.173 c-0.827,0.481,0,2.552,0.068,3.172s1.655,1.312,2.621,1.448c2.789,0.396,5.52-0.482,5.727,0.207 c0.206,0.688-1.861,2.276-1.448,2.622c0.414,0.344,1.034-0.276,3.104,0.62C79.808,101.167,81.394,104.133,81.394,104.133z"/> <path fill="#BDD245" stroke="#A74D96" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M88.487,115.28 c-2.056-0.444-2.098,1.099-3.833,1.386c-2.145,0.356-4.959-2.14-2.924-4.141c1.46-1.438,0.752-2.936,2.982-3.863 c0.311-2.116-1.058-3.101-2.465-4.087c-1.511-1.055-4.518,0.399-6.954,0.098c-2.522-0.317-2.537,2.442-2.724,4.015 c-0.673,5.578-5.57-5.499-8.354-2.545c0.691-1.162-4.381-2.269-5.609,0.038c-1.604,3.009-5.564,6.294-9.312,6.26 c-4.023-0.035-1.791,3.08-4.866,4.469c-2.194,0.99-4.733,0.924-6.916,1.885c-1.903-0.49-1.362-0.755-1.84-2.213 c-0.76-2.314-2.002,0.883-2.375,1.062c-1.689,0.812-0.745-6.16-0.745-6.906c0-2.521-3.579-3.209-4.684-4.929 c-1.711-2.678-5.487-2.886-5.487-7.146c-4.572,2.125-0.77,11.812-6.044,11.861c0.841,3.783,6.688,2.672,8.178,5.883 c1.582,3.413-1.458,5.399-0.018,8.297c2.854-0.646,2.986-0.217,4.704,2.302c2.553,3.746-1.988,2.97-3.9,2.826 c-2.531-0.188-0.541,2.604-1.598,3.877c-1.139,1.371-3.917,3.566-3.479,5.609c2.236,0.512,4.614-2.257,6.615-0.621 c1.599,1.305-1.837,3.58-2.985,3.94c-0.496,0.156-1.759,4.285-2.456,5.266c-1.151,1.621-1.926,4.062,1.26,3.124 c2.51-0.741,4.615-2.537,5.818-4.837c1.042-1.991,2.373-0.43,3.163-2.421c0.705-1.778,13.652-3.979,16.227-4.152 c-0.381,2.576-12.571,7.159-5.842,10.103c0.081,0.035,5.226-2.545,3.505,0.103c-0.614,0.946-3.062,2.525-4.227,2.6 c-0.186,1.827,2.153,1.768,3.254,2.535c0.886,0.62,1.593-2.253,2.139-2.763c1.976-1.846,0.839-2.354,4.03-2.508 c1.737-0.084,2.696-0.85,1.772-2.512c-1.079-1.939-4.856-5.417-0.398-5.533c3.562-0.098,6.493,2.076,10.009,1.954 c2.015-0.071,1.896-1.402,3.129-2.153c0.906-0.202,1.554,0.132,1.938,1.001c1.223,1.2,2.218,0.315,3.626,0.167 c1.043-0.112,4.387,1.516,4.808-0.17c0.438-1.747,2.446-3.983,3.166-0.646c0.521,2.399,5.801,9.668,4.533,3.768 c-0.914-4.27,0.339-5.363,1.02-8.916c-3.666-0.833-5.127-9.87-2.312-13.042c1.366-1.541,1.165-3.797,2.189-4.613 c2.651-2.116,2.729,1.042,4.188,0.475C89.487,119.031,89.823,115.571,88.487,115.28C88.084,115.193,89.67,115.538,88.487,115.28z"/> <path fill="#95CCAC" stroke="#A74D96" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M74.139,78.718 c1.751-0.167,0.252-3.332-0.465-3.773c-1.965-1.22-3.104-1.977-2.053-4.339c1.485-3.352-5.356-7.674-1.879-10.869 c1.753-1.315-3.344-2.373-3.521-2.419c-2.81-0.746-6.979-1.02-8.265-4.062c-0.879,0.141-1.146,2.294-1.938,2.801 c-0.839,0.53-2.94,0.449-3.83,0.49c-2.982,0.143-4.641-2.846-5.193,1.737c-0.141,1.155,2.021,0.788,0.234,2.257 c-1.13,0.931-1.216,0.753-2.756,1.063c-1.892,0.381-3.668-2.215-3.726-4.074c-2.514-0.042-4.776,1.266-7.276,1.067 c-3.448-0.284-1.979,5.027-4.099,6.858c-0.531,0.46-0.986,0.908-1.491,1.354c-1.055,0.939-1.613-0.991-2.521-0.104 c-0.488,0.479-1.734-0.566-1.75,0.439c-0.021,1.521,1.741,0.396,2.441,1.099c0.766,0.766-1.734,0.269-1.866,0.532 c0.033-0.065,1.191,3.729,0.912,4.788c-0.617,2.286,0.3,2.849-0.53,4.638c2.142,0.097,3.465,1.785,4.995-0.788 c2.07-3.479,4.438-4.202,7.962-5.512c2.27-0.84,6.058,0.517,7.188-1.485c1-1.77,1.821-0.812,3.156-1.839 c0.897-0.69,2.811,2.119,3.948,2.909c-0.415-0.288-0.771,3.099-0.742,3.246c0.686,3.664-1.084,3.204-1.5,6.259 c-0.381,2.808,9.118,4.017,11.451,4.129c1.927,0.093,0.699-2.891,3.232-1.595c1.215,0.622,6.6-1.378,5.203,1.979 c-0.371,0.886,4.072,0.782,4.688,0.139C75.635,84.098,72.32,78.892,74.139,78.718C75.225,78.615,73.054,78.821,74.139,78.718z"/> </svg> <div class="form-group"> <label>Langue du défi :</label> <select name="langueDef" class="form-control" required> <option disabled selected value></option> <option value="FR">FR</option> <option value="DE">DE</option> <!-- <option value="multi">multi</option> --> </select> </div> <div class="form-group"> <label>Question de culture générale :</label> <select name="cultureG" class="form-control" required> <option disabled selected value></option> <option value="oui">Oui</option> <option value="non">Non</option> <!-- <option value="multi">multi</option> --> </select> </div> <!--        <div class="form-group"> <label>Titre :</label> <input type="text" id="titre" class="form-control" name="title" required> </div> --> <div class="form-group"> <label>Région :</label> <select id="couleur" name="color" class="form-control" required> <option disabled selected value></option> <option value="bleu/fenetrenordals">Nord Alsace</option> <option value="vert/fenetremittlerer">Mittlerer Oberrhein</option> <option value="violet/fenetresudpfalz">Südpfalz</option> </select> </div> <div id="LieuList"> <!-- <div class="form-group"><label>Lieu :</label><select name="lieu" class="form-control" required><option disabled selected value></option></select></div> --> </div> <div class="form-group"> <label>Type du défi :</label> <select id="typeDef" name="defType" class="form-control" required> <option disabled selected value></option> <option value="QCM">Choix multiples</option> <option value="vocale">Réponse vocale/texte</option> <option value="frise">Frise chronologique</option> <option value="trou">Texte à trou</option> </select> </div>';

    var qcm = '<!-- QCM --> <div id="QCM" > <div class="form-group"> <label>'+titre_Q+' :</label> <input type="text" id="titreQuestion" class="form-control" name="titleQuest" maxlength="75" required> </div> <div class="form-group">';
    qcm += '<label>'+question+' :</label> <input type="text" id="question" class="form-control" name="question" maxlength="150" required> </div> ';
    qcm += '<div class="form-group"> <label>'+rep+' 1 :</label> <input type="text" id="rep1" class="form-control" maxlength="50" name="rep1" required> </div> ';
    qcm += '<div class="form-group"> <label>'+rep+' 2 :</label> <input type="text" id="rep2" class="form-control" maxlength="50" name="rep2" required> </div> ';
    qcm += '<div class="form-group"> <label>'+rep+' 3 :</label> <input type="text" id="rep3" class="form-control" maxlength="50" name="rep3" required> </div> ';
    qcm += '<div class="form-group"> <label>'+rep+' 4 :</label> <input type="text" id="rep4" class="form-control" maxlength="50" name="rep4" required> </div> ';
    qcm += '<div class="form-group"> <label>'+rep+' 5 :</label> <input type="text" id="rep5" class="form-control" maxlength="50" name="rep5" required> </div> ';
    qcm += '<div class="form-group"> <label>'+repCorrect+' :</label> <select id="correct" name="correct" class="form-control" required> <option disabled selected value></option> <option value="1">1</option> <option value="2">2</option> <option value="3">3</option> <option value="4">4</option> <option value="5">5</option> </select> </div> ';
    qcm += '<label>'+imgIllust+' :</label> <input type="file" id="imageDefiPrev" name="imageDefi" accept="image/*" required><br/> ';
    qcm += '<div class="input-group"><span class="input-group-addon">'+propImgIllust+' : </span><input id="ImgAuteur" type="text" class="form-control Owner" name="ImgAuteur" maxlength="25" required></div><br/> ';
    qcm += '<div class="form-group"><label>Copyright :</label><select id="copyrightImgQcm" name="copyrightImgQcm" class="form-control CR" required><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div> ';
    qcm += '<div class="page-header"> <h2>'+aide_defi+'</h2><hr> ';
    qcm += '<label for="aideTxt">'+txt_aide_defi+' : </label><br/> <p style="color: red;font-weight: bold;">'+txt_lisibe+'</p> <textarea class="editor" rows="6" cols="50" name="editor"></textarea> <br/><br/> ';
    qcm += '<div class="input-group"><span class="input-group-addon">'+adresse+' : </span><input id="aideMap" type="text" class="form-control" name="aideMap"></div><small id="mapHelp" class="form-text text-muted">'+no_map+'</small><br><br> ';
    qcm += '<label>'+img_aide_defi+' :</label> <input type="file" id="aideImg" name="aideImg" accept="image/*"><br/> ';
    qcm += '<div class="input-group"><span class="input-group-addon">'+prop_img_aide_defi+' : </span><input id="aideImgAuteur" type="text" class="form-control Owner" name="aideImgAuteur" maxlength="100"></div><br/>    ';
    qcm += '<div class="form-group"><label>Copyright :</label><select id="copyrightImg" name="copyrightImg" class="form-control CR"><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div><br/>  ';
    qcm += '<label>'+video_aide_defi+' :</label> <input type="file" id="aideVideo" name="aideVideo" accept="video/mp4,video/*"> <br/>  ';
    qcm += '<div class="input-group"><span class="input-group-addon">'+prop_video_aide_defi+' : </span><input id="aideVideoAuteur" type="text" class="form-control Owner" name="aideVideoAuteur" maxlength="100"></div><br/>    ';
    qcm += '<div class="form-group"><label>Copyright :</label><select id="copyrightVideo" name="copyrightVideo" class="form-control CR"><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div><br/>  ';
    qcm += '<label>'+audio_aide_defi+' :</label> <input type="file" id="aideSon" name="aideSon" accept="audio/*"><br/> ';
    qcm += '<div class="input-group"><span class="input-group-addon">'+prop_audio_aide_defi+' : </span><input id="aideSonAuteur" type="text" class="form-control Owner" name="aideSonAuteur" maxlength="100"></div>  <br/>';
    qcm += '<div class="form-group"><label>Copyright :</label><select id="copyrightSon" name="copyrightSon" class="form-control CR"><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div> </div> </div> <!-- fin QCM -->';
   
    var frise = '<!-- Frise --><div id="frise"> <div class="form-group"><label>'+date_debut_frise+' :</label> <input type="number" id="dateDebFrise" class="form-control" name="dateDebFrise" required> </div>';
    frise += '<div class="form-group"> <label>'+date_fin_frise+' :</label> <input type="number" id="dateFinFrise" class="form-control" name="dateFinFrise" required> </div>';
    frise += '<div class="form-group"> <label>'+titre_frise+' :</label> <input type="text" id="titreFrise" class="form-control" name="titreFrise" maxlength="40" required> </div>';
    frise += '<!-- EVENEMENT --> <div class="form-group"><h2>'+evenement_n+'1</h2><hr><label>'+nom_evenement+' :</label> <input type="text" maxlength="60" id="eventName1" class="form-control" name="eventName1" required>';
    frise += '<label>'+date_evenement+' :</label> <input type="number" id="eventDate1" class="form-control" name="eventDate1" required>';
    frise += '<label>'+vignette_evenement+' :</label> <input type="file" id="etiquette1Prev" name="eventImg1" accept="image/*">  <br/>';
    frise += '<div class="input-group"><span class="input-group-addon">'+proprietaire_image+' : </span><input id="eventImg1Auteur" type="text" class="form-control Owner" name="eventImg1Auteur"></div><br/>';
    frise += '<div class="form-group"><label>Copyright :</label><select id="copyrightEventImg1" name="copyrightEventImg1" class="form-control CR" required=""><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div>  </div>';
    frise += '<div class="form-group"><h2>'+evenement_n+'2</h2><hr><label>'+nom_evenement+' :</label> <input type="text" maxlength="60" id="eventName2" class="form-control" name="eventName2" required>';
    frise += '<label>'+date_evenement+' :</label> <input type="number" id="eventDate2" class="form-control" name="eventDate2" required>';
    frise += '<label>'+vignette_evenement+' :</label> <input type="file" id="etiquette2Prev" name="eventImg2" accept="image/*">  <br/>';
    frise += '<div class="input-group"><span class="input-group-addon">'+proprietaire_image+' : </span><input id="eventImg2Auteur" type="text" class="form-control Owner" name="eventImg2Auteur"></div><br/>';
    frise += '<div class="form-group"><label>Copyright :</label><select id="copyrightEventImg2" name="copyrightEventImg2" class="form-control CR" required=""><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div> </div>';
    frise += '<div class="form-group"><h2>'+evenement_n+'3</h2><hr><label>'+nom_evenement+' :</label> <input type="text" maxlength="60" id="eventName3" class="form-control" name="eventName3" required>';
    frise += '<label>'+date_evenement+' :</label> <input type="number" id="eventDate3" class="form-control" name="eventDate3" required>';
    frise += '<label>'+vignette_evenement+' :</label> <input type="file" id="etiquette3Prev" name="eventImg3" accept="image/*">  <br/>';
    frise += '<div class="input-group"><span class="input-group-addon">'+proprietaire_image+' : </span><input id="eventImg3Auteur" type="text" class="form-control Owner" name="eventImg3Auteur"></div><br/>';
    frise += '<div class="form-group"><label>Copyright :</label><select id="copyrightEventImg3" name="copyrightEventImg3" class="form-control CR" required=""><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div> </div>';
    frise += '<div class="form-group"><h2>'+evenement_n+'4</h2><hr><label>'+nom_evenement+' :</label> <input type="text" maxlength="60" id="eventName4" class="form-control" name="eventName4" required>';
    frise += '<label>'+date_evenement+' :</label> <input type="number" id="eventDate4" class="form-control" name="eventDate4" required> <label>Vignette de l\'événement :</label> <input type="file" id="etiquette4Prev" name="eventImg4" accept="image/*">  <br/>';
    frise += '<div class="input-group"><span class="input-group-addon">'+proprietaire_image+' : </span><input id="eventImg4Auteur" type="text" class="form-control Owner" name="eventImg4Auteur"></div><br/>';
    frise += '<div class="form-group"><label>Copyright :</label><select id="copyrightEventImg4" name="copyrightEventImg4" class="form-control CR" required=""><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div> </div>';
    frise += '<div class="form-group"><h2>'+evenement_n+'5</h2><hr><label>'+nom_evenement+' :</label> <input type="text" maxlength="60" id="eventName5" class="form-control" name="eventName5" required>';
    frise += '<label>'+date_evenement+' :</label> <input type="number" id="eventDate5" class="form-control" name="eventDate5" required>';
    frise += '<label>'+vignette_evenement+' :</label> <input type="file" id="etiquette5Prev" name="eventImg5" accept="image/*">  <br/>';
    frise += '<div class="input-group"><span class="input-group-addon">'+proprietaire_image+' : </span><input id="eventImg5Auteur" type="text" class="form-control Owner" name="eventImg5Auteur"></div><br/>';
    frise += '<div class="form-group"><label>Copyright :</label><select id="copyrightEventImg5" name="copyrightEventImg5" class="form-control CR" required=""><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div> </div>';
    frise += '<div class="form-group"><h2>'+evenement_n+'6</h2><hr><label>'+nom_evenement+' :</label> <input type="text" maxlength="60" id="eventName6" class="form-control" name="eventName6" required>';
    frise += '<label>'+date_evenement+' :</label> <input type="number" id="eventDate6" class="form-control" name="eventDate6" required>';
    frise += '<label>'+vignette_evenement+' :</label> <input type="file" id="etiquette6Prev" name="eventImg6" accept="image/*">  <br/>';
    frise += '<div class="input-group"><span class="input-group-addon">'+proprietaire_image+' : </span><input id="eventImg6Auteur" type="text" class="form-control Owner" name="eventImg6Auteur"></div><br/>';
    frise += '<div class="form-group"><label>Copyright :</label><select id="copyrightEventImg6" name="copyrightEventImg6" class="form-control CR" required=""><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div> </div>';
    frise += '<!-- EVENEMENT FIN --> <div class="page-header"> <h2>'+aide_defi+'</h2> <label for="aideTxt">'+txt_aide_defi+' : </label><br/> <p style="color: red;font-weight: bold;">'+txt_lisibe+'</p> <textarea class="editor" rows="6" cols="50" id="editorFrise" name="editorFrise"></textarea> <br/><br/>';
    frise += '<div class="input-group"><span class="input-group-addon">'+adresse+' : </span><input id="aideMap" type="text" class="form-control" name="aideMap"></div><small id="mapHelp" class="form-text text-muted">'+no_map+'</small><br><br>';
    frise += '<label>'+img_aide_defi+' :</label> <input type="file" id="aideImgFrise" name="aideImgFrise" accept="image/*"> <br/>';
    frise += '<div class="input-group"><span class="input-group-addon">'+prop_img_aide_defi+' : </span><input id="aideImgAuteur" type="text" class="form-control Owner" name="aideImgAuteur" maxlength="100"></div><br/>';
    frise += '<div class="form-group"><label>Copyright :</label><select id="copyrightImg" name="copyrightImg" class="form-control CR"><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div><br/>';
    frise += '<label>'+video_aide_defi+' :</label> <input type="file" id="aideVideoFrise" name="aideVideoFrise" accept="video/mp4,video/*"> <br/>';
    frise += '<div class="input-group"><span class="input-group-addon">'+prop_video_aide_defi+' : </span><input id="aideVideoAuteur" type="text" class="form-control Owner" name="aideVideoAuteur" maxlength="100"></div><br/>';
    frise += '<div class="form-group"><label>Copyright :</label><select id="copyrightVideo" name="copyrightVideo" class="form-control CR"><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div><br/>';
    frise += '<label>'+audio_aide_defi+' :</label> <input type="file" id="aideSonFrise" name="aideSonFrise" accept="audio/*"><br/>';
    frise += '<div class="input-group"><span class="input-group-addon">'+prop_audio_aide_defi+' : </span><input id="aideSonAuteur" type="text" class="form-control Owner" name="aideSonAuteur" maxlength="100"></div>  <br/>';
    frise += '<div class="form-group"><label>Copyright :</label><select id="copyrightSon" name="copyrightSon" class="form-control CR"><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div> </div> </div> <!-- fin Frise -->'; 
    
    var vocale = '<!-- Vocale --><div id="vocale"><div class="form-group"><label>'+titre_Q+' :</label><input type="text" id="titreQuestionVocaTxt" class="form-control" name="titleQuestVocaTxt" maxlength="75" required></div>';
    vocale += '<div class="form-group"><label>'+question+' :</label><input type="text" id="questionVocaTxt" class="form-control" name="questionVocaTxt" maxlength="150" required></div>';
    vocale += '<div class="form-group"><label>'+rep+' :</label><input type="text" id="repVocale" class="form-control" name="repVocale" placeholder="'+exemple_rep+'" maxlength="50" required><small id="repHelp" class="form-text text-muted">'+pas_de_point_virgule+'</small></div>';
    vocale += '<div class="form-group"><label>'+mots_cles+' :</label><input type="text" id="repCle" class="form-control" name="repCle" placeholder="eau argile pot" required><small id="repHelp" class="form-text text-muted">'+laissez_un_espace+'</small></div>';
    vocale += '<div class="page-header"><h2>'+aide_defi+'</h2><hr>';
    vocale += '<label for="aideTxt">'+txt_aide_defi+' : </label><br/> <p style="color: red;font-weight: bold;">'+txt_lisibe+'</p> <textarea id="editorVoca" class="editor" rows="6" cols="50" name="editorVocaTxt"></textarea> <br/><br/> ';
    vocale += '<div class="input-group"><span class="input-group-addon">'+adresse+' : </span><input id="aideMap" type="text" class="form-control" name="aideMap"></div><small id="mapHelp" class="form-text text-muted">'+no_map+'</small><br><br> ';
    vocale += '<label>'+img_aide_defi+' :</label><input type="file" id="aideImgVoca" name="aideImgVocaTxt" accept="image/*"><br/> ';
    vocale += '<div class="input-group"><span class="input-group-addon">'+prop_img_aide_defi+' : </span><input id="aideImgAuteur" type="text" class="form-control Owner" name="aideImgAuteur" maxlength="100"></div><br/>   ';
    vocale += '<div class="form-group"><label>Copyright :</label><select id="copyrightImg" name="copyrightImg" class="form-control CR"><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div><br/> ';
    vocale += '<label>'+video_aide_defi+' :</label><input type="file" id="aideVideoVoca" name="aideVideoVocaTxt" accept="video/mp4,video/*"><br/> ';
    vocale += '<div class="input-group"><span class="input-group-addon">'+prop_video_aide_defi+' : </span><input id="aideVideoAuteur" type="text" class="form-control Owner" name="aideVideoAuteur" maxlength="100"></div><br/>   ';
    vocale += '<div class="form-group"><label>Copyright :</label><select id="copyrightVideo" name="copyrightVideo" class="form-control CR"><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div><br/> ';
    vocale += '<label>'+audio_aide_defi+' :</label><input type="file" id="aideSonVoca" name="aideSonVocaTxt" accept="audio/*">  <br/>  ';
    vocale += '<div class="input-group"><span class="input-group-addon">'+prop_audio_aide_defi+' : </span><input id="aideSonAuteur" type="text" class="form-control Owner" name="aideSonAuteur" maxlength="100"></div>   <br/>';
    vocale += '<div class="form-group"><label>Copyright :</label><select id="copyrightSon" name="copyrightSon" class="form-control CR"><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div>  </div></div><!-- fin Vocale -->';
    
    var trou = '<!-- Texte à trou --><div id="trou"><div class="form-group"><label>'+titre_Q+' :</label><input type="text" id="titreQuestionTxtTrou" class="form-control" name="titleQuestTxtTrou" maxlength="75" required></div>';
    trou += '<div class="form-group"><label>'+question+' :</label><input type="text" id="questionTxtTrou" class="form-control" name="questionTxtTrou" maxlength="150" required></div>';
    trou += '<div class="form-group"><label>'+TAT+' :</label><textarea rows="4" cols="50" id="txtTrou" class="form-control" name="txtTrou" placeholder="'+exemple_input+'" required></textarea><small id="repHelpTrou" class="form-text text-muted">'+remplacer_mot_input+'</small><br><p id="HelpNbTrou" class="form-text">'+nb_mot_input+'</p></div>';
    trou += '<div class="form-group"><label>Input 1 :</label><input type="text" id="inputTxtTrou1" placeholder="un" class="form-control" name="inputTxtTrou1" maxlength="50" required></div>';
    trou += '<div class="form-group"><label>Input 2 :</label><input type="text" id="inputTxtTrou2" placeholder="trous" class="form-control" name="inputTxtTrou2" maxlength="50" required></div>';
    trou += '<div class="form-group"><label>Input 3 :</label><input type="text" id="inputTxtTrou3" class="form-control" name="inputTxtTrou3" maxlength="50" required></div>';
    trou += '<div class="form-group"><label>Input 4 :</label><input type="text" id="inputTxtTrou4" class="form-control" name="inputTxtTrou4" maxlength="50"></div>';
    trou += '<div class="form-group"><label>Input 5 :</label><input type="text" id="inputTxtTrou5" class="form-control" name="inputTxtTrou5" maxlength="50"></div>';
    trou += '<div class="form-group"><label>Input 6 :</label><input type="text" id="inputTxtTrou6" class="form-control" name="inputTxtTrou6" maxlength="50"></div>';
    // trou += '<div class="form-group"><label>Input 7 :</label><input type="text" id="inputTxtTrou7" class="form-control" name="inputTxtTrou7" maxlength="50"></div>';
    // trou += '<div class="form-group"><label>Input 8 :</label><input type="text" id="inputTxtTrou8" class="form-control" name="inputTxtTrou8" maxlength="50"></div>';
    // trou += '<div class="form-group"><label>Input 9 :</label><input type="text" id="inputTxtTrou9" class="form-control" name="inputTxtTrou9" maxlength="50"></div>';
    // trou += '<div class="form-group"><label>Input 10 :</label><input type="text" id="inputTxtTrou10" class="form-control" name="inputTxtTrou10" maxlength="50"></div>';
    trou += '<div class="page-header"><h2>'+aide_defi+'</h2><label for="aideTxt">'+txt_aide_defi+' : </label><br/> <p style="color: red;font-weight: bold;">'+txt_lisibe+'</p> <textarea class="editor" rows="6" cols="50" id="editorTrou" name="editorTxtTrou"></textarea> <br/><br/>';
    trou += '<div class="input-group"><span class="input-group-addon">'+adresse+' : </span><input id="aideMap" type="text" class="form-control" name="aideMap"></div><small id="mapHelp" class="form-text text-muted">'+no_map+'</small><br><br>';
    trou += '<label>'+img_aide_defi+' :</label><input type="file" id="aideImgTrou" name="aideImgTxtTrou" accept="image/*"><br/>';
    trou += '<div class="input-group"><span class="input-group-addon">'+prop_img_aide_defi+' : </span><input id="aideImgAuteur" type="text" class="form-control Owner" name="aideImgAuteur" maxlength="100"></div><br/>';
    trou += '<div class="form-group"><label>Copyright :</label><select id="copyrightImg" name="copyrightImg" class="form-control CR"><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div><br/>';
    trou += '<label>'+video_aide_defi+' :</label><input type="file" id="aideVideoTrou" name="aideVideoTxtTrou" accept="video/mp4,video/*"><br/>';
    trou += '<div class="input-group"><span class="input-group-addon">'+prop_video_aide_defi+' : </span><input id="aideVideoAuteur" type="text" class="form-control Owner" name="aideVideoAuteur" maxlength="100"></div><br/>';
    trou += '<div class="form-group"><label>Copyright :</label><select id="copyrightVideo" name="copyrightVideo" class="form-control CR"><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div><br/>';
    trou += '<label>'+audio_aide_defi+' :</label><input type="file" id="aideSonTrou" name="aideSonTxtTrou" accept="audio/*"><br/>';
    trou += '<div class="input-group"><span class="input-group-addon">'+prop_audio_aide_defi+' : </span><input id="aideSonAuteur" type="text" class="form-control Owner" name="aideSonAuteur" maxlength="100"></div>  <br/>';
    trou += '<div class="form-group"><label>Copyright :</label><select id="copyrightSon" name="copyrightSon" class="form-control CR"><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div>  </div></div><!-- fin Texte à trou -->';
   
    var classement = '<!-- Classement --><div id="classement"><div class="form-group"><label>'+titre_Q+' :</label><input type="text" id="titreQuestionClassement" class="form-control" name="titleQuestClassement"  maxlength="75" required></div>';
    classement += '<div class="form-group"><label>'+question+' :</label><input type="text" id="questionClassement" class="form-control" name="questionClassement" maxlength="150" required></div>';
    classement += '<div class="form-group"><label>'+nombre_de_categorie+' :</label><select id="nbCatClassement" class="form-control" name="nbCatClassement" required><option disabled selected value></option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select></div><div id="catNamesClassement"></div>';
    classement += '<div class="form-group"><label>'+type_etiquette+' :</label><select id="typeEtiqClassement" class="form-control" name="typeEtiqClassement" required><option disabled selected value></option><option value="1">'+mot+'</option><option value="2">'+groupe_de_mots+'</option><option value="3">'+image+'</option></select></div><div id="etiquettesClassement"></div>';
    classement += '<div class="page-header"><h2>'+aide_defi+'</h2><label for="aideTxt">'+txt_aide_defi+' : </label><br/> <p style="color: red;font-weight: bold;">'+txt_lisibe+'</p> <textarea class="editor" rows="6" cols="50" id="editorClassement" name="editorClassement"></textarea> <br/><br/>';
    classement += '<div class="input-group"><span class="input-group-addon">'+adresse+' : </span><input id="aideMap" type="text" class="form-control" name="aideMap"></div><small id="mapHelp" class="form-text text-muted">'+no_map+'</small><br><br>';
    classement += '<label>'+img_aide_defi+' :</label><input type="file" id="aideImgClassement" name="aideImgClassement" accept="image/*"><br/>';
    classement += '<div class="input-group"><span class="input-group-addon">'+prop_img_aide_defi+' : </span><input id="aideImgAuteur" type="text" class="form-control Owner" name="aideImgAuteur" maxlength="100"></div><br/>';
    classement += '<div class="form-group"><label>Copyright :</label><select id="copyrightImg" name="copyrightImg" class="form-control CR"><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div><br/>';
    classement += '<label>'+video_aide_defi+' :</label><input type="file" id="aideVideoClassement" name="aideVideoClassement" accept="video/mp4,video/*"><br/>';
    classement += '<div class="input-group"><span class="input-group-addon">'+prop_video_aide_defi+' : </span><input id="aideVideoAuteur" type="text" class="form-control Owner" name="aideVideoAuteur" maxlength="100"></div><br/>';
    classement += '<div class="form-group"><label>Copyright :</label><select id="copyrightVideo" name="copyrightVideo" class="form-control CR"><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div><br/>';
    classement += '<label>'+audio_aide_defi+' :</label><input type="file" id="aideSonClassement" name="aideSonClassement" accept="audio/*">  <br/>';
    classement += '<div class="input-group"><span class="input-group-addon">'+prop_audio_aide_defi+' : </span><input id="aideSonAuteur" type="text" class="form-control Owner" name="aideSonAuteur" maxlength="100"></div>   <br/>';
    classement += '<div class="form-group"><label>Copyright :</label><select id="copyrightSon" name="copyrightSon" class="form-control CR"><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div> </div></div><!-- fin Classement -->';

    // var basicEnd = '</form>';
    
    $('#'+last).hide();
    if ($("#typeDef").val() == "QCM") {
      $('#selectedDefForm').empty();
      $('#selectedDefForm').append(qcm);
      $('.CR').val('cr2');
      $('.Owner').val(session.nom);
      clearCkeditor();


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
        readURLHelpImg(this, "imgHelpQCM");
      });
      $('#aideVideo').on("change", function(){
        readURLHelpVideo(this, "videoHelpQCM");
      });
      $('#aideSon').on("change", function(){
        readURLHelpSon(this, "sonHelpQCM");
      });
      $('#imageDefiPrev').on("change", function(){
        readURL(this);
      });
      // FIN DE LA PREVIEW QCM
    }


    if ($("#typeDef").val() == "frise") {
      $('#selectedDefForm').empty();
      $('#selectedDefForm').append(frise);
      $('.CR').val('cr2');
      $('.Owner').val(session.nom);
       clearCkeditor();
      // $('#trou').show();

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

        $('#aideImgFrise').on("change", function(){
          readURLHelpImg(this, "imgHelpFrise");
          
        });
        $('#aideVideoFrise').on("change", function(){
          readURLHelpVideo(this, "videoHelpFrise");
         
        });
        $('#aideSonFrise').on("change", function(){
          readURLHelpSon(this, "sonHelpFrise");
        });

      $('#etiquette1Prev').on("change", function(){
        readURLX(this, "1");
      });
      $('#etiquette2Prev').on("change", function(){
        readURLX(this, "2");
      });
      $('#etiquette3Prev').on("change", function(){
        readURLX(this, "3");
      });
      $('#etiquette4Prev').on("change", function(){
        readURLX(this, "4");
      });
      $('#etiquette5Prev').on("change", function(){
        readURLX(this, "5");
      });
      $('#etiquette6Prev').on("change", function(){
        readURLX(this, "6");
      });
      // FIN DE LA PREVIEW Frise
    }



    if ($("#typeDef").val() == "trou") {
      $('#selectedDefForm').empty();
      $('#selectedDefForm').append(trou);
      $('.CR').val('cr2');
      $('.Owner').val(session.nom);
       clearCkeditor();

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
        TAT = ($('#txtTrou').val()).replace(/INPUT\d*/g, function() {
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

      $('#aideImgTrou').on("change", function(){
        readURLHelpImg(this, "imgHelpTrou");
      });
      $('#aideVideoTrou').on("change", function(){
        readURLHelpVideo(this, "videoHelpTrou");
      });
      $('#aideSonTrou').on("change", function(){
        readURLHelpSon(this, "sonHelpTrou");
      });

    }


    if ($("#typeDef").val() == "classement") {
      // div pour nom des catégories
      var CatsName = "";
      // div pour les étiquettes
      var EtiqContent = "";
      var nbCats = 3;
      $('#selectedDefForm').empty();
      $('#selectedDefForm').append(classement);
      // $("input").attr("required", true);
       clearCkeditor();

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
          readURLImgPreview($('#cat'+n+'Etiq'+o)[0], "imgPreview"+n+"_"+o);
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

        $('#questionHelpClassement').html($('#titreQuestionClassement').val());
        $('#txtHelpClassement').html($('#editorClassement').val());

      });

      $('#aideImgClassement').on("change", function(){
        readURLHelpImg(this, "imgHelpClassement");
      });
      $('#aideVideoClassement').on("change", function(){
        readURLHelpVideo(this, "videoHelpClassement");
      });
      $('#aideSonClassement').on("change", function(){
        readURLHelpSon(this, "sonHelpClassement");
      });

      // si l'on change la valeur du nombre de catégorie, le nombre de champs de catégorie change en fonction
      $('#nbCatClassement').on("change", function() {
        nbCats = $('#nbCatClassement').val();
        $('#catNamesClassement').empty();
        $('#etiquettesClassement').empty();
        $('#typeEtiqClassement').prop('selectedIndex',0);
        CatsName = "";
        for (var i = 1; i <= nbCats; i++) {
          CatsName += '<div class="form-group"><label>'+categorie+' '+i+' :</label><input type="text" id="nameCat'+i+'Classement" class="form-control" name="nameCat'+i+'Classement" maxlength="35" required></div>';
        }
        $('#catNamesClassement').append(CatsName);
        callTypeEtiq(nbCats);
      });

    }

    if ($("#typeDef").val() == "vocale") {
      $('#selectedDefForm').empty();
      $('#selectedDefForm').append(vocale);
      $('.CR').val('cr2');
      $('.Owner').val(session.nom);
       clearCkeditor();


      // PREVIEW DU DEFI VocaTxt
      $('#btnPreview').click(function() {
        $('#myModalVoca').modal();

        setDataModal();

        // titre question
        $('.titleQuestionVocal').html($('#titreQuestionVocaTxt').val());
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

        $('#aideImgVoca').on("change", function(){
          readURLHelpImg(this, "imgHelpVoca");
          
        });
        $('#aideVideoVoca').on("change", function(){
          readURLHelpVideo(this, "videoHelpVoca");
         
        });
        $('#aideSonVoca').on("change", function(){
          readURLHelpSon(this, "sonHelpVoca");
        });
      // FIN DE LA PREVIEW VocaTxt
    }
    last = $("#typeDef").val();
    $( 'textarea.editor' ).ckeditor();
  });


 function clearCkeditor() {
  for(name in CKEDITOR.instances)
  {
      CKEDITOR.instances[name].removeAllListeners();
      CKEDITOR.remove(CKEDITOR.instances[name]);
      // CKEDITOR.instances[name].destroy(true);
  }
 }
// console.log($('#QCM div input[id]'));

  // Categorie et sous catégorie du défi

  // selecteur
    var $cat = $('select[name=category]'),
        $items = $('select[name=items]');
        $res = $('select[name=res]');
        $sousRes = $('select[name=sousRes]');

    // si on change de catégorie
    $cat.change(function(){
        var $this = $(this).find(':selected'),
            rel = $this.attr('rel'),
            $set = $items.find('option.' + rel);

        // console.log($this);
        // console.log(rel);
       
        if ($set.length == 0) {

            $('#res').hide();
            return;
        }else{
          $res.empty();
          $res.append('<option disabled selected value></option>');
          $sousRes.empty();
          $sousRes.hide();
          $set.clone().appendTo($res).show();
          $('#res').css("display", "block");
        }
    });

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
              EtiqContent += '<label>'+vignette+' n°'+k+'</label><input type="text" name="cat'+j+'Etiq'+k+'" id="cat'+j+'Etiq'+k+'" class="form-control" maxlength="25" required>';
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
              EtiqContent += '<label>'+vignette+' n°'+k+'</label><input type="file" name="cat'+j+'Etiq'+k+'" id="cat'+j+'Etiq'+k+'" accept="image/*" required>';
              EtiqContent += '<br/><div class="input-group"><span class="input-group-addon">'+proprietaire_image+' : </span><input id="v'+j+'_e'+k+'_Owner" type="text" class="form-control" name="v'+j+'_e'+k+'_Owner"></div><br/> <div class="form-group"><label>Copyright :</label><select id="v'+j+'_e'+k+'_CR" name="v'+j+'_e'+k+'_CR" class="form-control CR" required=""><option disabled="" selected="" value=""></option><option value="cr1">CC 0 - public domain</option><option value="cr2">CC BY</option><option value="cr3">CC BY SA</option><option value="cr4">CC BY SA NC</option></select></div>';
            }
            EtiqContent += '</div>';
          }
        }

        $('#etiquettesClassement').append(EtiqContent);
        $('.CR').val('cr2');
        $('.Owner').val(session.nom);

      });
    }


  function rand(min, max){
    return Math.floor(Math.random() * (max - min + 1)) + min;
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