<?php

include("../connexion/logs.php");
require_once("../connexion/SQLconnect.php");

  $id = htmlspecialchars($_POST['id_prof']);

  $result = array();

  // QCM
  //--------------------------------------------------------------------------
  if (!($req1 = $con->prepare("SELECT * FROM Professeur INNER JOIN Classe ON Professeur.id_user = Classe.id_prof INNER JOIN Groupe ON Classe.id = Groupe.id_classe INNER JOIN QCM ON QCM.createur_id = Groupe.id_user WHERE Professeur.id_user = ? AND QCM.etat = 'moderer'"))) {
      echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
    }

  if (!$req1->bind_param("i", $id)) {
    echo "Echec lors du liage des paramètres : (" . $req1->errno . ") " . $req1->error;
  }
      
  if (!$req1->execute()) {
    echo "Echec lors de l'exécution de la requête : (" . $req1->errno . ") " . $req1->error;
  }

  // on récupére les données
  $meta1 = $req1->result_metadata(); 
    while ($field1 = $meta1->fetch_field()) 
    { 
        $params1[] = &$row1[$field1->name]; 
    } 

    call_user_func_array(array($req1, 'bind_result'), $params1); 

    while ($req1->fetch()) { 
        foreach($row1 as $key1 => $val1) 
        { 
            $c1[$key1] = $val1; 
        } 
        $result[] = $c1; 
    }                 
  //fetch result    
  $req1->close();

  // Texte à trou
  //--------------------------------------------------------------------------
  if (!($req2 = $con->prepare("SELECT * FROM Professeur INNER JOIN Classe ON Professeur.id_user = Classe.id_prof INNER JOIN Groupe ON Classe.id = Groupe.id_classe INNER JOIN TexteTrous ON TexteTrous.createur_id = Groupe.id_user WHERE Professeur.id_user = ? AND TexteTrous.etat = 'moderer'"))) {
      echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
    }

  if (!$req2->bind_param("i", $id)) {
    echo "Echec lors du liage des paramètres : (" . $req2->errno . ") " . $req2->error;
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
        $result[] = $c2; 
    }                 
  //fetch result    
  $req2->close();

  // Vocal Texte
  //--------------------------------------------------------------------------
  if (!($req3 = $con->prepare("SELECT * FROM Professeur INNER JOIN Classe ON Professeur.id_user = Classe.id_prof INNER JOIN Groupe ON Classe.id = Groupe.id_classe INNER JOIN VocalTexte ON VocalTexte.createur_id = Groupe.id_user WHERE Professeur.id_user = ? AND VocalTexte.etat = 'moderer'"))) {
      echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
    }

  if (!$req3->bind_param("i", $id)) {
    echo "Echec lors du liage des paramètres : (" . $req3->errno . ") " . $req3->error;
  }
      
  if (!$req3->execute()) {
    echo "Echec lors de l'exécution de la requête : (" . $req3->errno . ") " . $req3->error;
  }

  // on récupére les données
  $meta3 = $req3->result_metadata(); 
    while ($field3 = $meta3->fetch_field()) 
    { 
        $params3[] = &$row3[$field3->name]; 
    } 

    call_user_func_array(array($req3, 'bind_result'), $params3); 

    while ($req3->fetch()) { 
        foreach($row3 as $key3 => $val3) 
        { 
            $c3[$key3] = $val3; 
        } 
        $result[] = $c3; 
    }                 
  //fetch result    
  $req3->close();

  // Défi Classement
  //--------------------------------------------------------------------------
  if (!($req5 = $con->prepare("SELECT * FROM Professeur INNER JOIN Classe ON Professeur.id_user = Classe.id_prof INNER JOIN Groupe ON Classe.id = Groupe.id_classe INNER JOIN DefiClassement ON DefiClassement.createur_id = Groupe.id_user WHERE Professeur.id_user = ? AND DefiClassement.etat = 'moderer'"))) {
      echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
    }

  if (!$req5->bind_param("i", $id)) {
    echo "Echec lors du liage des paramètres : (" . $req5->errno . ") " . $req5->error;
  }
      
  if (!$req5->execute()) {
    echo "Echec lors de l'exécution de la requête : (" . $req5->errno . ") " . $req5->error;
  }

  // on récupére les données
  $meta5 = $req5->result_metadata(); 
    while ($field5 = $meta5->fetch_field()) 
    { 
        $params5[] = &$row5[$field5->name]; 
    } 

    call_user_func_array(array($req5, 'bind_result'), $params5); 

    while ($req5->fetch()) { 
        foreach($row5 as $key5 => $val5) 
        { 
            $c5[$key5] = $val5; 
        } 
        $result[] = $c5; 
    }                 
  //fetch result    
  $req5->close();

  // Frise Chrono
  //--------------------------------------------------------------------------
  if (!($req4 = $con->prepare("SELECT * FROM Professeur INNER JOIN Classe ON Professeur.id_user = Classe.id_prof INNER JOIN Groupe ON Classe.id = Groupe.id_classe INNER JOIN FriseChrono ON FriseChrono.createur_id = Groupe.id_user WHERE Professeur.id_user = ? AND FriseChrono.etat = 'moderer'"))) {
      echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
    }

  if (!$req4->bind_param("i", $id)) {
    echo "Echec lors du liage des paramètres : (" . $req4->errno . ") " . $req4->error;
  }
      
  if (!$req4->execute()) {
    echo "Echec lors de l'exécution de la requête : (" . $req4->errno . ") " . $req4->error;
  }

  // on récupére les données
  $meta4 = $req4->result_metadata(); 
    while ($field4 = $meta4->fetch_field()) 
    { 
        $params4[] = &$row4[$field4->name]; 
    } 

    call_user_func_array(array($req4, 'bind_result'), $params4); 

    while ($req4->fetch()) { 
        foreach($row4 as $key4 => $val4) 
        { 
            $c4[$key4] = $val4; 
        } 
        $result[] = $c4; 
    }                 
  //fetch result    
  $req4->close();


  //--------------------------------------------------------------------------
  // 3) echo result as json 
  //--------------------------------------------------------------------------
  echo json_encode($result);


  mysqli_close($con);

  ?>  