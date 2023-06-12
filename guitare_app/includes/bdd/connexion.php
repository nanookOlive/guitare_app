<?php

require('config.php');

function connexion_bdd(){

	try{
		$pdo = new PDO('mysql:host='.BD_HOST.';dbname='.BD_NAME.';charset=UTF8',BD_USER,BD_PASSWORD);
		return $pdo;
	}
	
	catch(PDOException $error){
		echo 'Une erreur est survenue : '.$error->getMessage();
	}
	
	
	
	
	}
?>
