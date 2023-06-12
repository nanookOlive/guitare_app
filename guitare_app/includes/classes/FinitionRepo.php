<?php
include_once(__DIR__.'/../bdd/connexion.php');


class FinitionRepo{


	public static function getFinition(int $idFinition)
	{
		$finition= null;
		$data=['idFinition'=>$idFinition];
		$query='SELECT finition FROM finition where idFinition=:idFinition';
		$PDO=connexion_bdd();
		if($requete=$PDO->prepare($query)){
			if($requete->execute($data)){
				if($resultat=$requete->fetch(PDO::FETCH_ASSOC))
				{
					$finition=new Finition($idFinition,$resultat['finition']);
					
				}
				
			
			}
			else{
				echo $PDO->errorInfo();
			}
		}
	
		return $finition;
	}

	public static function getFinitions() : array
	{
		$array=[];
		$PDO=connexion_bdd();
		$query='SELECT idFinition, finition FROM finition';
		if($requete=$PDO->prepare($query)){
			if($requete->execute()){
				while($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
					$newFinition= new Finition($resultat['idFinition'],$resultat['finition']);
					array_push($array,$newFinition);
				
				}
			}
			
			else{
				echo $PDO->errorInfo();
			}
			
		}
		
		return $array;
	}

	public static function setFinition(Finition $finition):bool
{
	$PDO=connexion_bdd();
	$data=[':idFinition'=>$finition->getIdFinition(),':finition'=>$finition->getFinition()];
	$query='UPDATE finition SET finition= :finition WHERE idFinition= :idFinition';
	
	if($requete=$PDO->prepare($query)){
		if(!empty($finition)){
			if($requete->execute($data)){
				return TRUE; 
			}
			
			return $PDO->errorInfo();
		}
		
	}
	
	else return FALSE;

}

public static function dropFinition(Finition $finition):bool 
{
	$PDO=connexion_bdd();
	$data=['idFinition'=>$finition->getIdFinition()];
	$query='DELETE FROM guitare_finition WHERE fkIdFinition=(SELECT idFinition FROM finition WHERE idFinition=:idFinition)';
	$query_2='DELETE FROM finition WHERE idFinition =:idFinition';
	if($requete=$PDO->prepare($query)){
		if($requete->execute($data)){
			if($req=$PDO->prepare($query_2)){
				if($req->execute($data)){
					return TRUE;
				}
				
				return $PDO->errorInfo();
			}
			
			return $PDO->errorInfo();
			
		}

		else{

			return false;
		}

		

	}

	else{

		return FALSE;
	}

}
public static function addFinition(Finition $finition):bool 
{
	$PDO=connexion_bdd();
	$data=[':finition'=>$finition->getFinition()];
	$query='INSERT INTO finition(finition)VALUES(:finition)';
	if($requete=$PDO->prepare($query)){
		if($requete->execute($data)){
			return TRUE;
		}

		else{

			return FALSE;
		}

	}
	else{
		return FALSE;
	}

	
}
}



?>
