<?php

require_once(__DIR__.'/../bdd/connexion.php');

class MarqueRepo{

	//récupération d'un objet model à partir de son id
	public static function getMarque(int $idMarque)
	{
		$PDO=connexion_bdd();
		$data=[':idMarque'=>$idMarque];
		$query='SELECT idMarque, nom_marque FROM marque WHERE idMarque=:idMarque';
		$marque=null;
		if($requete=$PDO->prepare($query)){
			if($requete->execute($data)){
				if($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
					
					$marque=new Marque($resultat['idMarque'],$resultat['nom_marque']);
				}
			
			}
		
		}
		else{
		
			$PDO->errorInfo();
		}
		
		
		return $marque;
	
	}

//tous les modeles


	public static function getMarques():array
	{
		$PDO=connexion_bdd();
		$query='SELECT idMarque, nom_marque FROM marque';
		$array=[];
		if($requete=$PDO->query($query)){
			while($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
				$marque=new Marque($resultat['idMarque'],$resultat['nom_marque']);
				array_push($array,$marque);
			
			
			}
			
			
		
		}
		return $array;
	
	}

public static function getNomMarque():array 
{

	$marqueArray=self::getMarques();//récupération de tous les noms de modeles
	$nomMarques=[];
	
	foreach($marqueArray as $marque){

		array_push($nomMarques,$marque->getNomMarque());

	}

	return $nomMarques;

}
public static function addMarque(Marque $marque):bool
{
	$nomMarque=self::getMarques();
	$PDO=connexion_bdd();
	$data=['nom_marque'=>$marque->getNomMarque()];
	$query='INSERT INTO marque(nom_marque)VALUES(:nom_marque)';

	//on extrait l'ensemble des modéle et on vérifie qu'il n'existe pas déjà
	if(!in_array($marque->getNomMarque(),$nomMarque)){
		if($requete=$PDO->prepare($query)){
		
			if(!empty($marque)){
			
				$requete->execute($data);
				return true;}
		}
		
		
	}
	else{
		
		return false;

	}
}
public static function dropModele(Marque $marque):bool 
{
	$PDO=connexion_bdd();
	$data=array(':idMarque'=>$marque->getIdMarque());
	$query='DELETE FROM guitare_marque WHERE fkIdMarque=(SELECT idMarque FROM marque WHERE idMarque=:idMarque)';
	$query_2='DELETE FROM marque WHERE idMarque =:idMarque';
	if($requete=$PDO->prepare($query)){
		if($requete->execute($data)){
			if($req=$PDO->prepare($query_2)){
				if($req->execute($data)){
					return TRUE;
				}
			}
			
		}

		else{

			return false;
		}

		

	}

	else{

		return FALSE;
	}

}

public static function setMarque(Marque $marque):bool
{
	$PDO=connexion_bdd();
	$query='UPDATE marque SET nom_marque= :nom_marque WHERE idMarque= :idMarque';
	$data=array(':nom_marque'=>$marque->getNomMarque(), ':idMarque'=>$marque->getIdMarque());
	if($requete=$PDO->prepare($query)){
		if(!empty($marque)){
			if($requete->execute($data)){
				return TRUE; 
			}
		}
	}

}

}//fin repo



?>
