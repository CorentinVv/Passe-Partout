// checkbox professeur cache/affiche champs
$('#codeProf').hide();

$('#checkCode').click(function() {
	$('#codeProf').toggle();
});

// vérification des champs

var password = document.getElementById("password"), confirm_password = document.getElementById("conf_password"), username = document.getElementById("username");
if (document.getElementById("codeSecret") != null) {
	var codeSecret = document.getElementById("codeSecret");
}

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Mots de passe différents !");
  } else {
    confirm_password.setCustomValidity('');
  }
}

function validateUsername(){
	  if (username.value=="") {
	  	username.setCustomValidity("");
	    document.getElementById("usernameHint").innerHTML="";
	    return;
	  } 
	  if (window.XMLHttpRequest) {
	    // code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp=new XMLHttpRequest();
	  } else { // code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp.onreadystatechange=function() {
	    if (this.readyState==4 && this.status==200){
	    	if (parseInt(this.responseText)) {
	    		document.getElementById("usernameHint").innerHTML='<div class="alert alert-danger"><strong>Nom d\'utilisateur déjà utilisé !</strong></div>';
	    		username.setCustomValidity("Veuillez trouver un autre pseudo.");
	    	}else{
	    		document.getElementById("usernameHint").innerHTML='<div class="alert alert-success"><strong>Nom d\'utilisateur ok.</strong></div>';
	    		username.setCustomValidity("");
	    	}
	    }
	  }
	  xmlhttp.open("GET","../model/testUser.php?q="+username.value,true);
	  xmlhttp.send();
}

function validateCodeSecret(){
	  if (codeSecret.value=="") {
	  	codeSecret.setCustomValidity("");
	    document.getElementById("codeHint").innerHTML="";
	    return;
	  } 
	  if (window.XMLHttpRequest) {
	    // code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp=new XMLHttpRequest();
	  } else { // code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  // ajouter champs nom ecole vide erreur 
	  xmlhttp.onreadystatechange=function() {
	    if (this.readyState==4 && this.status==200){
	    	if (parseInt(this.responseText)) {
	    		document.getElementById("codeHint").innerHTML='<div class="alert alert-success"><strong>Code bon.</strong></div>';
	    		codeSecret.setCustomValidity("");
	    	}else{
	    		document.getElementById("codeHint").innerHTML='<div class="alert alert-danger"><strong>Code incorrect !</strong></div>';
	    		codeSecret.setCustomValidity("Incorrect.");
	    	}
	    }
	  }
	  xmlhttp.open("GET","../model/testCode.php?q="+codeSecret.value,true);
	  xmlhttp.send();
}

if (typeof(codeSecret) != 'undefined') {
	codeSecret.onkeyup = validateCodeSecret;
}

username.onkeyup = validateUsername;
password.onkeyup = validatePassword;
confirm_password.onkeyup = validatePassword;


  $(function () 
  {

	var session;
	function getSession() {
		$.get('../model/getSession.php', function(data) {
			try {
				session = JSON.parse(data);
				var classe = "Classe";
				if (session.langue == "DE") {
					classe = "Klasse";
				}

				// Set myClass
				$.ajax({                                      
					url: '../model/getMyClass.php', 
					type : "POST",        
					data: {idUser : session.id},
					success: function(data){
						try {
							// console.log(data);
							var myClass = JSON.parse(data);
							console.log(myClass);
							$output = "<div class='form-group'><label>"+classe+" :</label><select name='classe' class='form-control' required><option disabled selected value></option>";
					      	$.each(myClass, function(i, item) {
					      		$output += "<option value="+myClass[i].id+">"+myClass[i].nom_classe+"</option>";
					      	});
					      	$output += "</select></div>";
			        		$('#classList').html($output);
						} catch(e) {
							$('.msgInfo').removeClass('hide');
						}
					}
				});
			} catch(e) {
				// console.log(e);
			}
		});
	}
	getSession();

  });