<?php

include("../connexion/logs.php");
require_once("../connexion/SQLconnect.php");

$result = [];

  // 2) Query database for data
  //--------------------------------------------------------------------------
  if (!($req = $con->prepare("SELECT item1_img,item1Owner,item1CR,item2_img,item2Owner,item2CR,item3_img,item3Owner,item3CR,item4_img,item4Owner,item4CR,item5_img,item5Owner,item5CR,item6_img,item6Owner,item6CR FROM FriseChrono"))) {
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
        $result['Frise'][] = $c; 
    }                 
  //fetch result    

  if (!($req2 = $con->prepare("SELECT valise_1_etiquette_1,v1_e1_Owner,v1_e1_CR,valise_1_etiquette_2,v1_e2_Owner,v1_e2_CR,valise_1_etiquette_3,v1_e3_Owner,v1_e3_CR,valise_1_etiquette_4,v1_e4_Owner,v1_e4_CR,valise_1_etiquette_5,v1_e5_Owner,v1_e5_CR,valise_2_etiquette_1,v2_e1_Owner,v2_e1_CR,valise_2_etiquette_2,v2_e2_Owner,v2_e2_CR,valise_2_etiquette_3,v2_e3_Owner,v2_e3_CR,valise_2_etiquette_4,v2_e4_Owner,v2_e4_CR,valise_2_etiquette_5,v2_e5_Owner,v2_e5_CR,valise_3_etiquette_1,v3_e1_Owner,v3_e1_CR,valise_3_etiquette_2,v3_e2_Owner,v3_e2_CR,valise_3_etiquette_3,v3_e3_Owner,v3_e3_CR,valise_3_etiquette_4,v3_e4_Owner,v3_e4_CR,valise_3_etiquette_5,v3_e5_Owner,v3_e5_CR,valise_4_etiquette_1,v4_e1_Owner,v4_e1_CR,valise_4_etiquette_2,v4_e2_Owner,v4_e2_CR,valise_4_etiquette_3,v4_e3_Owner,v4_e3_CR,valise_4_etiquette_4,v4_e4_Owner,v4_e4_CR,valise_4_etiquette_5,v4_e5_Owner,v4_e5_CR,valise_5_etiquette_1,v5_e1_Owner,v5_e1_CR,valise_5_etiquette_2,v5_e2_Owner,v5_e2_CR,valise_5_etiquette_3,v5_e3_Owner,v5_e3_CR,valise_5_etiquette_4,v5_e4_Owner,v5_e4_CR,valise_5_etiquette_5,v5_e5_Owner,v5_e5_CR FROM DefiClassement WHERE type_etiquette = 3"))) {
      echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
  }
      
  if (!$req2->execute()) {
    echo "Echec lors de l'exécution de la requête : (" . $req2->errno . ") " . $req2->error;
  }

  // on récupére les données
  $meta2 = $req2->result_metadata(); 
    while ($field2 = $meta2->fetch_field()) 
    { 
        $params2[] = &$row2[$field2->name]; 
    } 

    call_user_func_array(array($req2, 'bind_result'), $params2); 

    while ($req2->fetch()) { 
        foreach($row2 as $key2 => $val2) 
        { 
            $c2[$key2] = $val2; 
        } 
        $result['Classement'][] = $c2; 
    }               
  //fetch result   

  //--------------------------------------------------------------------------
  // 3) echo result as json 
  //--------------------------------------------------------------------------
  echo json_encode($result);


  mysqli_close($con);

  ?>  