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


    // Mise à jour de la moyenne des classes
    var i = 0;
	var myRankingObj = [];
	var groupsAff = [];
	var userAff = [];
	var totalScore = 0;
	var tabScore = [];

	// On récupére l'id de toutes les classes
	refreshRankingGroup = function() {
		$.ajax({
			url : "../model/getAllClass.php",
			type : "GET",
			success : function(classes) {
				var allClass = JSON.parse(classes);
				allClass.forEach(function(classe) {
					myRankingObj.push(classe);
				});
				affGroups(myRankingObj);
			}
		});
	}
	// pour chaques classes on récupère les groupes associés
	affGroups = function(classes) {
		$.ajax({
			url : "../model/getMyGroup.php",
			type : "GET",
			success : function(groupes) {
				var allGroups = JSON.parse(groupes);
				classes.forEach(function(classe) {
					// On parcours tous les groupes
					allGroups.forEach(function(groupe) {
						// pour chaques classe on récupère les groupes associés
						if (classe.id == groupe.id_classe) {
							groupsAff.push(groupe);
							classe['Groupes'] = groupsAff;
						}
					});
					groupsAff = [];
				});
				// On récupère tous les utilisateurs
				affUsers(classes);
			}
		});
	}
	// Pour chaques groupes on récupère tous les utilisateurs associés au groupes
	affUsers = function(classes) {
		$.ajax({
			url : "../model/getCustomUsers.php",
			type : "GET",
			success : function(users) {
				var allUsers = JSON.parse(users);
				classes.forEach(function(classe) {
					if (classe.Groupes != undefined) {
						classe.Groupes.forEach(function(groupe) {
							allUsers.forEach(function(user) {
								if (groupe.id_user == user.id) {
									userAff.push(user);
									groupe['user'] = userAff;
								}
							});
							userAff = [];
						});
					}
				});
				// on calcule le score des classes
				setMoyenneClasse(classes);
			}
		});
	}
	// Pour chaques classes on calcule le score des groupes
	setMoyenneClasse = function(classes) {
		// console.log(classes);
		classes.forEach(function(classe) {
			// console.log(classe);
			if (classe.Groupes != undefined) {
				classe.Groupes.forEach(function(groupe) {
					if (groupe.user) {
						totalScore += groupe.user[0].score;
					}else{
						// console.log("erreur");
					}
				});
				tabScore.push({'id':classe.id, 'total':totalScore});
				totalScore = 0;
			}
		});
		updateMoyenneClasse(tabScore);
	}
	// on update la moyenne dans la table classe
	updateMoyenneClasse = function(tabScore) {
		var size = tabScore.length;
		var j = 0;
		tabScore.forEach(function(scoreClasse) {
			$.ajax({
				url : "../model/updateMoyenneClasse.php",
				type : "POST",
				data : {idClass : scoreClasse.id, total : scoreClasse.total},
				success : function(data) {

				}
			});
		});
		getSession();
	}

	// On met à jour les moyennes des classes
	refreshRankingGroup();

    // --------------------------------------
    // --------------------------------------
    // --------------------------------------


	var myClass;
	var myTabClass=[];
	var session;
	function getSession() {
		$.get('../model/getSession.php', function(data) {

			try {
				session = JSON.parse(data);
				// Set myClass
				$.ajax({                                      
					url: '../model/getMyClass.php', 
					type : "POST",        
					data: {idUser : session.id},
					success: function(data){
						try {
							myClass = JSON.parse(data);
							// on stock les id des classes
							$.each(myClass, function(i, item) {
					      		myTabClass.push(item.id);
					      	});
						} catch(e) {
							// console.log(e);
						}
					}
				});
			} catch(e) {
				// console.log(e);
			}
		});
	}

	$('#btnAjoutCG').click(function() {
		window.location.replace("../vue/gestionProfAjout.php");
	});
	
	// CLASSE
	var id;
	$('#myModal').on('shown.bs.modal', function (e) {
        $('#validDelete').click(function(){
        	// suppression du defi
            $.ajax({                                      
                url: '../model/deleteClass.php', 
                type : "POST",        
                data: {idDefi : id},
                success: function(data) {
                    // on actualise l'affichage
                    window.location.reload();
                }
            });
    	});
	});

	$('#btnVisuC').click(function() {
		// Création de la table de données des classes
      	var output = '<table class="table table-hover"><thead><tr><th>ID</th><th>'+nom+'</th><th>'+nombre_enfants+'</th><th>'+moyenne+'</th></tr></thead><tbody>';
		$.each(myClass, function(i, item) {
      		output += "<tr><td>"+myClass[i].id+"</td><td>"+myClass[i].nom_classe+"</td><td>"+myClass[i].nb_enfant+"</td><td>"+myClass[i].moyenne+"</td><td><button type='button' data-toggle='modal' data-target='#myModal' id='deleteClass"+myClass[i].id+"' class='btn btn-default'><span class='glyphicon glyphicon-trash'></span></button></td></tr>";
      	});
      	output += '</tbody></table>';
      	$('#myClassGroup').html(output);

      	// suppression de la classe si l'on click sur le bouton de suppression
        $(':regex(id,deleteClass[0-9])').click(function(e) {
            e.stopPropagation();
            id = $(this)[0].id;
            id = id.replace("deleteClass", "");
            $('#myModal').modal('show');
        });

	});
	// GROUPE
	$('#btnVisuG').click(function() {
		$.ajax({                                      
			url: '../model/getMyGroup.php', 
			type : "POST",        
			data: {idUser : session.id},
			success: function(data){
				myGroup = JSON.parse(data);
				// foreach group
				var output;
				$('#myClassGroup').html('<table class="table table-hover"><thead><tr><th>ID</th><th>'+nom_groupe+'</th><th>'+nombre_enfants_groupe+'</th><th>'+score+'</th></tr></thead><tbody id="resProfGroups"></tbody></table>');
				$.each(myGroup, function(index, item) {
		      		// if id_class == class id
		      		for (var i = 0; i < myTabClass.length; i++) {
			      		if (item.id_classe == myTabClass[i]) {
			      			// Requete pour trouver l'user id_user et afficher son score
			      			$.ajax({                                      
				                url: '../model/getUserScore.php', 
				                type : "POST",        
				                data: {idUser : item.id_user},
				                success: function(data) {
				                	userScore = JSON.parse(data);
				                	userScore = userScore[0].score;
				                	// alors on stock le groupe dans un tableau
									// Création de la table de données des groupes
			              			output = "<tr><td>"+item.id+"</td><td>"+item.nom_groupe+"</td><td>"+item.nb_enfant_groupe+"</td><td>"+userScore+"</td><td><button type='button' id='deleteGroup"+item.id+"' class='btn btn-default'><span class='glyphicon glyphicon-trash'></span></button></td></tr>";
				                	$('#resProfGroups').append(output);
				                }
				            });
			      		}
		      		}
		      	});

			    // suppression de la classe si l'on click sur le bouton de suppression
		        $(':regex(id,deleteGroup[0-9])').click(function(e) {
		            e.stopPropagation();
		            var id = $(this)[0].id;
		            id = id.replace("deleteGroup", "");
		            // suppression du defi
		            $.ajax({                                      
		                url: '../model/deleteGroupUser.php', 
		                type : "POST",        
		                data: {idDefi : id},
		                success: function() {
		                	$.ajax({                                      
				                url: '../model/deleteGroup.php', 
				                type : "POST",        
				                data: {idDefi : id},
				                success: function(data) {
				                    // on actualise l'affichage
				                    window.location.reload();
				                }
				            });
		                }
		            });
		        });
			}
		});
	});


});