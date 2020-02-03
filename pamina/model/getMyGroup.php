<?php

include("../connexion/logs.php");
//  gestion des profs
require_once("../connexion/SQLconnect.php");


  $result = $con->query("SELECT * FROM Groupe");

  while ( $rows = $result->fetch_array(MYSQLI_ASSOC) ) {
      $res[] = $rows;
  }

  //--------------------------------------------------------------------------
  // 3) echo result as json 
  //--------------------------------------------------------------------------
  echo json_encode($res);
  $result->free();

  mysqli_close($con);

  ?>  