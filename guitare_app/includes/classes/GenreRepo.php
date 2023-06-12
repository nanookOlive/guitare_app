<?php

require_once(__DIR__.'/../bdd/connexion.php');



class GenreRepo{

	//récupération d'un genre
	public static function getGenre(int $idGenre)
	{
		$PDO = connexion_bdd();
		$query = 'SELECT genre FROM genre where idGenre= :id';
		$newGenre=null;
		
		if($requete=$PDO->prepare($query)){
		
			if($requete->execute(array(':id'=> $idGenre))){
			
				if($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
				
					$newGenre= new Genre($idGenre,$resultat['genre']);
				
				}
			
			}
			
			else{
			
				echo $PDO->errorInfo();
			}
			
		}
			
		return $newGenre;
	
	}
	
	
	// retourne un tableau d'objet genre
	
	
	public static function getGenres():array
	{
	
		$PDO=connexion_bdd();
		$query='SELECT idGenre, genre FROM genre';
		$array_genre=[];
		if($requete=$PDO->prepare($query)){
			if($requete->execute()){
			
				while($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
				
					$newGenre=new Genre($resultat['idGenre'],$resultat['genre']);
					array_push($array_genre,$newGenre);
				
				}
			
			}
			
			else{
			
				echo PDO->errorInfo();
			}	
		
		}
		
		return $array_genre;
	
	
	}
	
	//ajout d'un nouveau genre à la bdd
	public static function addGenre(Genre $genre):bool{
	
		$PDO=connexion_bdd();
		$data=[':genre'=>$genre->getGenre()];
		$query='INSERT INTO genre(genre)VALUES(:genre)';
		if($requete=$PDO->prepare($query)){
			$requete->execute($data);
			return TRUE;
		
		}
		else{
		
			echo PDO->errorInfo();
		}
		
		return FALSE;
	
	}
	
	public static function updateGenre(Genre $genre):bool
	{
		$PDO=connexion_bdd();
		$data=[
			':genre'=>$genre->getGenre(),
			':idGenre'=>$genre->getIdGenre()

		];
		
		$query='UPDATE genre SET genre=:genre WHERE idGenre=:idGenre';
		if($requete=$PDO->prepare($query)){
			if($requete->execute($data)){
				return TRUE;
			}
		}
		else{
			return FALSE;
		}
	
	}
	
	public static function dropGenre(Genre $genre) : bool 
	{
		$PDO=connexion_bdd();
		$data=[':idGenre'=>$genre->getIdGenre()];
		$query_1='DELETE FROM guitare_genre WHERE fkIdGenre=(SELECT idGenre FROM genre WHERE idGenre=:idGenre)';
		$query_2='DELETE FROM genre WHERE idGenre=:idGenre';
		if($requete=$PDO->prepare($query_1)){

			if($requete->execute($data)){

				if($req=$PDO->prepare($query_2)){

					if($req->execute($data)){
						return TRUE;
					}
				}
			}
		}


	}




}

?>
