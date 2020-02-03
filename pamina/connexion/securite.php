<?php
	session_start();
	
	// On teste si la variable de session existe et contient une valeur
	if(empty($_SESSION['user'])) 
	{
	  // Si inexistante ou nulle, on redirige vers le formulaire de login
	  header('Location: https://www.mon-passepartout.eu/');
	  exit();
	}
?>