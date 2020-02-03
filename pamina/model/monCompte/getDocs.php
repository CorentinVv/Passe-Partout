<?php

include("../../connexion/logs.php");
//  gestion des profs
require_once("../../connexion/SQLconnect.php");

  $result = null;
  // 2) Query database for data
  //--------------------------------------------------------------------------
  if (!($req = $con->prepare("SELECT * FROM Documents"))) {
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