<?php

include("../connexion/logs.php");
require_once("../connexion/SQLconnect.php");

  // 2) Query database for data
  //--------------------------------------------------------------------------
  $string = $_POST['lieu'];
  $lieu = strtok($string, " ");
  $result= array();
  $langueJeu = $_POST['langueJeu'];

  if ($langueJeu == "multi") {
    if (!($req = $con->prepare("SELECT * FROM QCM WHERE lieu = ? AND etat = 'publier'"))) {
      echo "Echec de la prÃ©paration : (" . $con->errno . ") " . $con->error;
    }
      if (!$req->bind_param("s", $lieu)) {
      echo "Echec lors du liage des paramÃ¨tres : (" . $req->errno . ") " . $req->error;
    }
  }else{
    if (!($req = $con->prepare("SELECT * FROM QCM WHERE lieu = ? AND langue_defi = ? AND etat = 'publier'"))) {
      echo "Echec de la prÃ©paration : (" . $con->errno . ") " . $con->error;
    }
      if (!$req->bind_param("ss", $lieu,$langueJeu)) {
      echo "Echec lors du liage des paramÃ¨tres : (" . $req->errno . ") " . $req->error;
    }
  }
      
  if (!$req->execute()) {
    echo "Echec lors de l'exÃ©cution de la requÃªte : (" . $req->errno . ") " . $req->error;
  }            


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

  //--------------------------------------------------------------------------
  // 3) echo result as json 
  //--------------------------------------------------------------------------
  echo json_encode($result);


  mysqli_close($con);

  ?>  