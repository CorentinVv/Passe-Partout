<?php

include("../connexion/logs.php");
require_once("../connexion/SQLconnect.php");

  $id = htmlspecialchars($_POST['id_user']);

  $result = array();

  // 2) Query database for data
  //--------------------------------------------------------------------------
  if (!($req = $con->prepare("SELECT * FROM Groupe WHERE id_user = ?"))) {
      echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
    }

  if (!$req->bind_param("i", $id)) {
    echo "Echec lors du liage des paramètres : (" . $req->errno . ") " . $req->error;
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