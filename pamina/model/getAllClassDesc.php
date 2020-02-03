<?php

include("../connexion/logs.php");
require_once("../connexion/SQLconnect.php");

$result = [];

  // 2) Query database for data
  //--------------------------------------------------------------------------
  // if (!($req = $con->prepare("SELECT * FROM  `Classe` ORDER BY moyenne DESC"))) {
  //     echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
  //   }

  if (!($req = $con->prepare("SELECT Professeur.nom_ecole, Professeur.lieu, Professeur.id_user, Classe.nom_classe, Classe.id_prof, Classe.moyenne, Classe.ed FROM `Professeur`, `Classe` WHERE Professeur.id_user = Classe.id_prof ORDER BY moyenne DESC"))) {
      echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
    }

      
  if (!$req->execute()) {
    echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
  }

  // on récupére les données
  $meta = $req->result_metadata(); 
    while ($field = $meta->fetch_field()) 
    { 
        $params[] = &$row[$field->name]; 
    } 

    call_user_func_array(array($req, 'bind_result'), $params); 

    while ($req->fetch()) { 
        foreach($row as $key => $val) 
        { 
            $c[$key] = $val; 
        } 
        $result[] = $c; 
    }                 
  //fetch result    

  //--------------------------------------------------------------------------
  // 3) echo result as json 
  //--------------------------------------------------------------------------
  echo json_encode($result);


  mysqli_close($con);

  ?>  