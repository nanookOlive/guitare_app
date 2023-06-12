<?php
session_name('sessionAdmin');
session_start();
if(!isset($_SESSION['userAdmin']) || ($_SESSION['userAdmin'] == null)){//////////////////////ici

	header('location:'.__DIR__.'/../erreur/error_login.php');
	
}

$user=$_SESSION['userAdmin'];////////////////////////ici

if(!($user->getAdministrateur())){

header('location:'.__DIR__.'/../erreur/error_login.php');
	

}
