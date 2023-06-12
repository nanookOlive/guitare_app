<?php

require_once(__DIR__.'/../bdd/connexion.php');

class ModeleRepo{

	//récupération d'un objet model à partir de son id
	public static function getModele($idModele)
	{
		$PDO=connexion_bdd();
		$data=[':idModele'=>$idModele];
		$query='SELECT idModele, modele FROM modele WHERE idModele=:idModele';
		$modele=null;
		if($requete=$PDO->prepare($query)){
			if($requete->execute($data)){
				if($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
					
					$modele=new Modele($resultat['idModele'],$resultat['modele']);
				}
			
			}
		
		}
		else{
		
			$PDO->errorInfo();
		}
		
		
		return $modele;
	
	}

//tous les modeles


	public static function getModeles():array
	{
		$PDO=connexion_bdd();
		$query='SELECT idModele, modele FROM modele';
		$array=[];
		if($requete=$PDO->query($query)){
			while($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
				$modele=new Modele($resultat['idModele'],$resultat['modele']);
				array_push($array,$modele);
			
			
			}
			
			
		
		}
		return $array;
	
	}

public static function getNomModel():array 
{

	$modelArray=self::getModeles();//récupération de tous les noms de modeles
	$nomModel=[];
	
	foreach($modelArray as $obModel){

		array_push($nomModel,$obModel->getModel());

	}

	return $nomModel;

}
public static function addModele(Modele $modele):bool
{
	$PDO=connexion_bdd();
	$data=[':modele'=>$modele->getModel()];
	$query='INSERT INTO modele(modele)VALUES(:modele)';

	
		if($requete=$PDO->prepare($query)){
		
			if($requete->execute($data)){
			
				
				return true;}

			else{

				return FALSE;
			}
		

		
		
		
	}
	else{
		
		return false;

	}
}
public static function dropModele(Modele $modele):bool 
{
	$PDO=connexion_bdd();
	$data=array(':idModele'=>$modele->getIdModel());
	$query='DELETE FROM guitare_modele WHERE fkIdModele=(SELECT idModele FROM modele WHERE idModele=:idModele)';
	$query_2='DELETE FROM modele WHERE idModele =:idModele';
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

public static function setModele(Modele $modele):bool
{
	$PDO=connexion_bdd();
	$query='UPDATE modele SET modele= :newModele WHERE idModele= :idModele';
	$data=array(':newModele'=>$modele->getModel(), ':idModele'=>$modele->getIdModel());
	if($requete=$PDO->prepare($query)){
		if(!empty($modele)){
			if($requete->execute($data)){
				return TRUE; 
			}
		}
	}

}

}//fin repo



?>
