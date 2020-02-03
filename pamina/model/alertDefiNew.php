<?php

include("../connexion/logs.php");
require_once("../connexion/SQLconnect.php");

  $id = htmlspecialchars($_POST['id_prof']);

  $result = array();

  // QCM
  //--------------------------------------------------------------------------
  if (!($req1 = $con->prepare("SELECT COUNT(*) as tot FROM Professeur INNER JOIN Classe ON Professeur.id_user = Classe.id_prof INNER JOIN Groupe ON Classe.id = Groupe.id_classe INNER JOIN QCM ON QCM.createur_id = Groupe.id_user WHERE Professeur.id_user = ? AND QCM.etat = 'moderer'"))) {
      echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
    }

  if (!$req1->bind_param("i", $id)) {
    echo "Echec lors du liage des paramètres : (" . $req1->errno . ") " . $req1->error;
  }
      
  if (!$req1->execute()) {
    echo "Echec lors de l'exécution de la requête : (" . $req1->errno . ") " . $req1->error;
  }

  // on récupére les données
  $meta = $req1->result_metadata(); 
    while ($field = $meta->fetch_field()) 
    { 
        $params1[] = &$row[$field->name]; 
    } 

    call_user_func_array(array($req1, 'bind_result'), $params1); 

    while ($req1->fetch()) { 
        foreach($row as $key => $val) 
        { 
            $c[$key] = $val; 
        } 
        $result[] = $c; 
    }                 
  //fetch result    
  $req1->close();

  // Texte à trou
  //--------------------------------------------------------------------------
  if (!($req2 = $con->prepare("SELECT COUNT(*) as tot FROM Professeur INNER JOIN Classe ON Professeur.id_user = Classe.id_prof INNER JOIN Groupe ON Classe.id = Groupe.id_classe INNER JOIN TexteTrous ON TexteTrous.createur_id = Groupe.id_user WHERE Professeur.id_user = ? AND TexteTrous.etat = 'moderer'"))) {
      echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
    }

  if (!$req2->bind_param("i", $id)) {
    echo "Echec lors du liage des paramètres : (" . $req2->errno . ") " . $req2->error;
  }
      
  if (!$req2->execute()) {
    echo "Echec lors de l'exécution de la requête : (" . $req2->errno . ") " . $req2->error;
  }

  // on récupére les données
  $meta = $req2->result_metadata(); 
    while ($field = $meta->fetch_field()) 
    { 
        $params2[] = &$row[$field->name]; 
    } 

    call_user_func_array(array($req2, 'bind_result'), $params2); 

    while ($req2->fetch()) { 
        foreach($row as $key => $val) 
        { 
            $c[$key] = $val; 
        } 
        $result[] = $c; 
    }                 
  //fetch result    
  $req2->close();

  // Vocal Texte
  //--------------------------------------------------------------------------
  if (!($req3 = $con->prepare("SELECT COUNT(*) as tot FROM Professeur INNER JOIN Classe ON Professeur.id_user = Classe.id_prof INNER JOIN Groupe ON Classe.id = Groupe.id_classe INNER JOIN VocalTexte ON VocalTexte.createur_id = Groupe.id_user WHERE Professeur.id_user = ? AND VocalTexte.etat = 'moderer'"))) {
      echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
    }

  if (!$req3->bind_param("i", $id)) {
    echo "Echec lors du liage des paramètres : (" . $req3->errno . ") " . $req3->error;
  }
      
  if (!$req3->execute()) {
    echo "Echec lors de l'exécution de la requête : (" . $req3->errno . ") " . $req3->error;
  }

  // on récupére les données
  $meta = $req3->result_metadata(); 
    while ($field = $meta->fetch_field()) 
    { 
        $params3[] = &$row[$field->name]; 
    } 

    call_user_func_array(array($req3, 'bind_result'), $params3); 

    while ($req3->fetch()) { 
        foreach($row as $key => $val) 
        { 
            $c[$key] = $val; 
        } 
        $result[] = $c; 
    }                 
  //fetch result    
  $req3->close();

  // Défi Classement
  //--------------------------------------------------------------------------
  if (!($req5 = $con->prepare("SELECT COUNT(*) as tot FROM Professeur INNER JOIN Classe ON Professeur.id_user = Classe.id_prof INNER JOIN Groupe ON Classe.id = Groupe.id_classe INNER JOIN DefiClassement ON DefiClassement.createur_id = Groupe.id_user WHERE Professeur.id_user = ? AND DefiClassement.etat = 'moderer'"))) {
      echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
    }

  if (!$req5->bind_param("i", $id)) {
    echo "Echec lors du liage des paramètres : (" . $req5->errno . ") " . $req5->error;
  }
      
  if (!$req5->execute()) {
    echo "Echec lors de l'exécution de la requête : (" . $req5->errno . ") " . $req5->error;
  }

  // on récupére les données
  $meta = $req5->result_metadata(); 
    while ($field = $meta->fetch_field()) 
    { 
        $params5[] = &$row[$field->name]; 
    } 

    call_user_func_array(array($req5, 'bind_result'), $params5); 

    while ($req5->fetch()) { 
        foreach($row as $key => $val) 
        { 
            $c[$key] = $val; 
        } 
        $result[] = $c; 
    }                 
  //fetch result    
  $req5->close();

  // Frise Chrono
  //--------------------------------------------------------------------------
  if (!($req4 = $con->prepare("SELECT COUNT(*) as tot FROM Professeur INNER JOIN Classe ON Professeur.id_user = Classe.id_prof INNER JOIN Groupe ON Classe.id = Groupe.id_classe INNER JOIN FriseChrono ON FriseChrono.createur_id = Groupe.id_user WHERE Professeur.id_user = ? AND FriseChrono.etat = 'moderer'"))) {
      echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
    }

  if (!$req4->bind_param("i", $id)) {
    echo "Echec lors du liage des paramètres : (" . $req4->errno . ") " . $req4->error;
  }
      
  if (!$req4->execute()) {
    echo "Echec lors de l'exécution de la requête : (" . $req4->errno . ") " . $req4->error;
  }

  // on récupére les données
  $meta = $req4->result_metadata(); 
    while ($field = $meta->fetch_field()) 
    { 
        $params4[] = &$row[$field->name]; 
    } 

    call_user_func_array(array($req4, 'bind_result'), $params4); 

    while ($req4->fetch()) { 
        foreach($row as $key => $val) 
        { 
            $c[$key] = $val; 
        } 
        $result[] = $c; 
    }                 
  //fetch result    
  $req4->close();


  //--------------------------------------------------------------------------
  // 3) echo result as json 
  //--------------------------------------------------------------------------
  echo json_encode($result);


  mysqli_close($con);

  ?>  