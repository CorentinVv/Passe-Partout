<?php

include("../connexion/logs.php");
require_once("../connexion/SQLconnect.php");

  // 2) Query database for data
  //--------------------------------------------------------------------------
  $result = $con->query("SELECT * FROM Classe");          //query

  while ( $row = $result->fetch_array(MYSQLI_ASSOC) ) {
    $array[] = $row;
  }                          
  //fetch result    

  //--------------------------------------------------------------------------
  // 3) echo result as json 
  //--------------------------------------------------------------------------
  echo json_encode($array);


  mysqli_close($con);

  ?>  