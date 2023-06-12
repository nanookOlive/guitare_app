<?php
require_once(__DIR__.'/../bdd/connexion.php');


class GuitareRepo{

	public static function getGuitare(int $idGuitare){
	
		$PDO=connexion_bdd();
		$guitare=null;

		$query='SELECT nomGuitare, prix, nbCordes, description, cheminPhoto, dateFab, etui FROM guitare where idGuitare = :id';
		if($requete=$PDO->prepare($query)){
			
			if($requete->execute(array(':id'=>$idGuitare))){
				if($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
				
					$guitare = new Guitare($idGuitare, $resultat['nomGuitare'],$resultat['prix'],$resultat['nbCordes'],$resultat['description'],
					$resultat['cheminPhoto'],$resultat['dateFab'],$resultat['etui']);
				
				
				}
			
			
			
			}
			
			else{
			
				echo PDO->errorInfo();
			
			}
		
		}
	
		return $guitare;
	
	}

	public static function getGuitareByName(string $nom){
	
		$PDO=connexion_bdd();
		$guitare=null;

		$query='SELECT idGuitare,nomGuitare, prix, nbCordes, description, cheminPhoto, dateFab, etui FROM guitare where nomGuitare = :nom';
		if($requete=$PDO->prepare($query)){
			
			if($requete->execute(array(':nom'=>$nom))){
				if($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
				
					$guitare = new Guitare($resultat['idGuitare'], $resultat['nomGuitare'],$resultat['prix'],$resultat['nbCordes'],$resultat['description'],
					$resultat['cheminPhoto'],$resultat['dateFab'],$resultat['etui']);
				
				
				}
			
			
			
			}
			
			else{
			
				echo PDO->errorInfo();
			
			}
		
		}
	
		return $guitare;
	
	}






	public static function getGuitares():array {
		
		$PDO=connexion_bdd();
		$guitare=null;
		$array=[];
		$query='SELECT idGuitare, nomGuitare,prix,nbCordes,description,cheminPhoto,dateFab,etui from guitare';
		
		if($requete = $PDO->query($query)){
		
			while($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
			
				$guitare = new Guitare($resultat['idGuitare'], $resultat['nomGuitare'],$resultat['prix'],$resultat['nbCordes'],$resultat['description'],
					$resultat['cheminPhoto'],$resultat['dateFab'],$resultat['etui']);
					
					array_push($array,$guitare);
			
			}
		
		}
		
		else{
			
			echo $PDO->errorInfo();
		
		}
		
		return $array;
	
	}
	
	/////get modele

	public static function getGenreGuitare(Guitare $guitare):array
	{
		$PDO=connexion_bdd();
		$array_genre=[];
		$query='SELECT genre from guitare JOIN guitare_genre ON guitare.idGuitare=guitare_genre.fkIdGuitare JOIN genre ON guitare_genre.fkIdGenre=genre.idGenre WHERE idGuitare = :id';
		if($requete=$PDO->prepare($query)){
			if($requete->execute(array(':id'=>$guitare->getIdGuitare()))){
				while($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
						array_push($array_genre,$resultat['genre']);
					
				}
			}
		}

		return $array_genre;

	}
	public static function getFinitionGuitare(Guitare $guitare) : array
	{
		$PDO=connexion_bdd();
		$array_finition=[];
		$query='SELECT finition from guitare JOIN guitare_finition ON guitare.idGuitare=guitare_finition.fkIdGuitare JOIN finition ON guitare_finition.fkIdFinition=finition.idFinition WHERE idGuitare = :id';
		if($requete=$PDO->prepare($query)){
			if($requete->execute(array(':id'=>$guitare->getIdGuitare()))){
				while($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
					array_push($array_finition,$resultat['finition']);
				}
			}
		}
		return $array_finition;

	}

	public static function getMarqueGuitare(Guitare $guitare)
	{
		$PDO=connexion_bdd();
		$query='SELECT nom_marque from guitare JOIN guitare_marque ON guitare.idGuitare=guitare_marque.fkIdGuitare JOIN marque ON guitare_marque.fkIdMarque=marque.idMarque WHERE idGuitare = :id';
		if($requete=$PDO->prepare($query)){
			if($requete->execute(array(':id'=>$guitare->getIdGuitare()))){
				if($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
					return $resultat['nom_marque'];
				}

				else{

					return null;
				}
			}
		}
		

	}

	public static function getModeleGuitare(Guitare $guitare)
	{
		$PDO=connexion_bdd();
		$query='SELECT modele from guitare JOIN guitare_modele ON guitare.idGuitare=guitare_modele.fkIdGuitare JOIN modele ON guitare_modele.fkIdModele=modele.idmodele WHERE idGuitare = :id';
		if($requete=$PDO->prepare($query)){
			if($requete->execute(array(':id'=>$guitare->getIdGuitare()))){
				if($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
					return $resultat['modele'];
				}

				else{
					return null;
				}


			}
		}

	}



	//// dropGuitare


	public static function dropGuitare(Guitare $guitare) :bool  
	{
		$PDO=connexion_bdd();
		$data=array(':id'=>$guitare->getIdGuitare());
		$query='DELETE FROM guitare WHERE idGuitare =:id';

		if(GuitareRepo::getMarqueGuitare($guitare) !== null){
			// on vide guitare_marque
			$queryMarque='DELETE FROM guitare_marque WHERE fkIdGuitare = :id';
			$requeteMarque=$PDO->prepare($queryMarque);
			$requeteMarque->execute($data);
		}

		if(GuitareRepo::getModeleGuitare($guitare) !== null){

			//on vide guitare_modele
			$queryModele='DELETE FROM guitare_modele WHERE fkIdGuitare = :id';
			$requeteModele=$PDO->prepare($queryModele);
			$requeteModele->execute($data);
		}

		if(!empty(GuitareRepo::getFinitionGuitare($guitare))){

			//on vide guitare_finition
			$queryFinition='DELETE FROM guitare_finition WHERE fkIdGuitare = :id';
			$requeteFinition=$PDO->prepare($queryFinition);
			$requeteFinition->execute($data);

		}

		if(!empty(GuitareRepo::getGenreGuitare($guitare))){

			//on vide guitare_genre
			$queryGenre='DELETE FROM guitare_genre WHERE fkIdGuitare = :id';
			$requeteGenre=$PDO->prepare($queryGenre);
			$requeteGenre->execute($data);
		}

		if(FavorisRepo::inFavorisGuitare($guitare)){

			// on vide la favoris_guitare
			$queryFavoris='DELETE FROM favoris_guitare WHERE fkIdGuitare = :id';
			$requeteFavoris=$PDO->prepare($queryFavoris);
			$requeteFavoris->execute($data);

		}

		if($requete=$PDO->prepare($query)){
			if($requete->execute($data)){
				return TRUE;
			}
		}
		
		else{
			return FALSE;
		}


	}

	////addGuitare


	public static function addGuitare(Guitare $guitare){

		$PDO=connexion_bdd();
		$data=array(
			':nomGuitare'=>$guitare->getNomGuitare(),
			':prix'=>$guitare->getPrix(),
			':nbCordes'=>$guitare->getNbCordes(),
			':description'=>$guitare->getDescription(),
			':cheminPhoto'=>$guitare->getCheminPhoto(),
			':dateFab'=>$guitare->getDateFab(),
			':etui'=>$guitare->getEtui()
		);

		$query='INSERT INTO guitare (nomGuitare,prix,nbCordes,description,cheminPhoto,dateFab, etui)VALUES
		(:nomGuitare,:prix,:nbCordes,:description,:cheminPhoto,:dateFab,:etui)';

		if($requete=$PDO->prepare($query)){
			if($requete->execute($data)){
				return TRUE;
			}
		}
	}

	///updateGuitare

	public static function updateGuitare(Guitare $guitare){

		$PDO=connexion_bdd();
		
		$data=array(
			':idGuitare'=>$guitare->getIdGuitare(),
			':nomGuitare'=>$guitare->getNomGuitare(),
			':prix'=>$guitare->getPrix(),
			':nbCordes'=>$guitare->getNbCordes(),
			':description'=>$guitare->getDescription(),
			':cheminPhoto'=>$guitare->getCheminPhoto(),
			':dateFab'=>$guitare->getDateFab(),
			':etui'=>$guitare->getEtui()
		);

		$query='UPDATE guitare SET

		nomGuitare=:nomGuitare,
		prix=:prix,
		nbCordes=:nbCordes,
		description=:description,
		cheminPhoto=:cheminPhoto,
		dateFab=:dateFab,
		etui=:etui

		WHERE idGuitare=:idGuitare;';

		if($requete=$PDO->prepare($query)){
			if($requete->execute($data)){
				return TRUE;
			}
			
		}
	}

	public static function addMarque(Guitare $guitare, Marque $marque){

			$PDO=connexion_bdd();
			$guitareId=$guitare->getIdGuitare();
			$marqueId=$marque->getIdMarque();
			$query='INSERT INTO guitare_marque (fkIdGuitare,fkIdMarque)VALUES(:guitareId,:marqueId)';
			if($requete=$PDO->prepare($query)){
				if($requete->execute(array('guitareId'=>$guitareId,'marqueId'=>$marqueId))){
					return TRUE;
				}
			}
	}

	public static function addModele(Guitare $guitare, Modele $modele){

		$PDO=connexion_bdd();
		$guitareId=$guitare->getIdGuitare();
		$modeleId=$modele->getIdModel();
		$query='INSERT INTO guitare_modele (fkIdGuitare,fkIdModele)VALUES(:guitareId,:modeleId)';
		if($requete=$PDO->prepare($query)){
			if($requete->execute(array(':guitareId'=>$guitareId,':modeleId'=>$modeleId))){
				return TRUE;
			}
		}
}


	public static function addGenre(Guitare $guitare, array $genres){

		$PDO=connexion_bdd();
		$query='INSERT INTO guitare_genre (fkIdGuitare,fkIdGenre)VALUES(:idGuitare,:idGenre)';

		foreach($genres as $genre){
			
			$requete=$PDO->prepare($query);
			$requete->execute(array(':idGuitare'=>$guitare->getIdGuitare(),':idGenre'=>$genre));
		}

	}

	public static function addFinition(Guitare $guitare, array $finitions){

		$PDO=connexion_bdd();
		$query='INSERT INTO guitare_finition (fkIdGuitare,fkIdFinition)VALUES(:idGuitare,:idFinition)';

		foreach($finitions as $finition){
			
			$requete=$PDO->prepare($query);
			$requete->execute(array(':idGuitare'=>$guitare->getIdGuitare(),':idFinition'=>$finition));
		}

	}

	public static function dropFinitionGuitare(Guitare $guitare){

		$PDO=connexion_bdd();
		$query='DELETE FROM guitare_finition WHERE fkIDGuitare=:idGuitare';
		
			if($requete=$PDO->prepare($query)){

			if($requete->execute(array(':idGuitare'=>$guitare->getIdGuitare()))){
				return TRUE;
		}
	}
	}

	public static function dropGenreGuitare(Guitare $guitare){

		$PDO=connexion_bdd();
		$query='DELETE FROM guitare_genre WHERE fkIDGuitare=:idGuitare';
		if($requete=$PDO->prepare($query)){

			if($requete->execute(array(':idGuitare'=>$guitare->getIdGuitare()))){

				return TRUE;
			}
		}

	}

	public static function setModeleGuitare(Guitare $guitare, Modele $modele){

		$PDO=connexion_bdd();
		$data=array(
			':idModele'=>$modele->getIdModel(),
			':idGuitare'=>$guitare->getIdGuitare()
		);

		$query1='SELECT fkIdModele FROM guitare_modele WHERE fkIdGuitare ='.$guitare->getIdGuitare();
		$query2='UPDATE guitare_modele SET fkIdModele = :idModele WHERE fkIdGuitare = :idGuitare;';

		if($requete1=$PDO->query($query1)){

			if($requete1->fetch(PDO::FETCH_ASSOC)){
				if($requete=$PDO->prepare($query2)){
					if($requete->execute($data)){
						return TRUE; 
					}
					else{

						$PDO->errorInfo();
					}
				}
			}
			else{

				self::addModele($guitare,$modele);
			}
		}
	}
	public static function setMarqueGuitare(Guitare $guitare, Marque $marque){

		$PDO=connexion_bdd();
		$data=array(
			':idMarque'=>$marque->getIdMarque(),
			':idGuitare'=>$guitare->getIdGuitare()
		);

		$query1='SELECT fkIdMarque FROM guitare_marque WHERE fkIdGuitare ='.$guitare->getIdGuitare();
		$query2='UPDATE guitare_marque SET fkIdMarque = :idMarque WHERE fkIdGuitare = :idGuitare;';

		if($requete1=$PDO->query($query1)){

			if($requete1->fetch(PDO::FETCH_ASSOC)){
				if($requete=$PDO->prepare($query2)){
					if($requete->execute($data)){
						return TRUE; 
					}
					else{

						$PDO->errorInfo();
					}
				}
			}
			else{

				self::addMarque($guitare,$marque);
			}
		}
			
	}

	public static function getGuitareByTag( $classe,int $id)
	{
		$array=[];
		$PDO=connexion_bdd();
		$query="SELECT nomGuitare from guitare JOIN guitare_".$classe." ON guitare.idGuitare=guitare_".$classe.".fkIdGuitare JOIN ".$classe." ON guitare_".$classe.".fkId".$classe."=".$classe.".id".$classe." WHERE id".$classe." = :id";
		if($requete=$PDO->prepare($query)){
			if($requete->execute(array(':id'=>$id))){
				while($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
					array_push($array,$resultat["nomGuitare"]);
				}

				return $array;
				}
				else{

					return null;
				}
			}
		}
		

	}


?>
