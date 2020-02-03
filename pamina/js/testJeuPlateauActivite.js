// On déclare et initialise les variables utilisée
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
            // if (rdm == 1) {
            //   readSong('PP_ennui.mp3');
            // }else{
            //   readSong('PP_ennui2.mp3');
            // }
            temps_inactivite = 0;
         }
       }
       // Si l'inactivite est nouvelle [on met à jour inactivite_persistante]
       else
         inactivite_persistante = true;
     }
  // On relance la fonction ce qui crée une boucle
  setTimeout('testerActivite();', intervalle);
}

// On lance la fonction testerActivite() pour la première fois, au chargement de la page
setTimeout('testerActivite();', intervalle);