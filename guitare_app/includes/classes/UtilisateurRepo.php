<?php



// appel connection


require_once(__DIR__.'/../bdd/connexion.php');


class UtilisateurRepo{
// récupérattion d'un utilisateur 


	public static function getUtilisateur(int $idUtilisateur)
	{
		$PDO = connexion_bdd();
		$data=array(':id'=>$idUtilisateur);
		$query = 'SELECT idUtilisateur, nomUtilisateur, prenom, mail,password, administrateur,valide,jeton from utilisateur where idUtilisateur= :id;';
		$user=null;
		
		if($requete=$PDO->prepare($query)){
		
			if($requete->execute($data)){
				
				if($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
				
					$user=new Utilisateur($resultat['idUtilisateur'],
					$resultat['nomUtilisateur'],
					$resultat['prenom'],
					$resultat['mail'],
					$resultat['password'],
					$resultat['administrateur'],
					$resultat['valide'],
					$resultat['jeton']);
				}
			
			}
			
			else
			{
				echo $PDO->errorInfo();
			}
		}
		
		
		
		
		
		
		
		
		return $user;
		 
	
	
	}
	///tous les objets utilisateur
	
	public static function getUtilisateurs() : array
	{
	
		$PDO=connexion_bdd();
		$array=[];
		$query='SELECT idUtilisateur, nomUtilisateur, prenom, mail, password,administrateur,valide,jeton FROM utilisateur';
		
		if($requete=$PDO->query($query)){
			while($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
			
				$user=new Utilisateur($resultat['idUtilisateur'],
				$resultat['nomUtilisateur'],
				$resultat['prenom'],
				$resultat['mail'],
				$resultat['password'],
				$resultat['administrateur'],
				$resultat['valide'],
				$resultat['jeton']);
				array_push($array,$user);
			
			}
			
		
		}
		
		return $array;
	
	
	}

	public static function getUtilisateursNotGranted() : array
	{
	
		$PDO=connexion_bdd();
		$array=[];
		$query='SELECT idUtilisateur, nomUtilisateur, prenom, mail, password,administrateur,valide,jeton FROM utilisateur';
		
		if($requete=$PDO->query($query)){
			while($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
			
				$user=new Utilisateur($resultat['idUtilisateur'],
				$resultat['nomUtilisateur'],
				$resultat['prenom'],
				$resultat['mail'],
				$resultat['password'],
				$resultat['administrateur'],
				$resultat['valide'],
				$resultat['jeton']);

				if(!$user->getAdministrateur())
				{array_push($array,$user);}
			
			}
			
		
		}
		
		return $array;
	
	
	}
	
	
	public static function authentification($mail){ //retourner un user à partir d'un mail et d'un pass 
	
		

		$PDO=connexion_bdd();
		$user=null;
		$query='SELECT idUtilisateur, nomUtilisateur,prenom, mail, password, administrateur, valide, jeton FROM utilisateur where mail = :mail';
		
		if($requete=$PDO->prepare($query)){
		
			if($requete->execute(array(':mail'=>$mail))){
			
				if($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
				
				$user=new Utilisateur($resultat['idUtilisateur'],
					$resultat['nomUtilisateur'],
					$resultat['prenom'],
					$resultat['mail'],
					$resultat['password'],
					$resultat['administrateur'],
					$resultat['valide'],
					$jeton['jeton']);

				
				}
				
				return $user;
	
		}
		
		else
		{
			echo $PDO->errorInfo();
		}
	}
	
	
	
}

public static function userExists($mail):bool{ //retourner un user à partir d'un mail et d'un pass 
	
		

	$PDO=connexion_bdd();
	$user=null;
	$query='SELECT idUtilisateur, nomUtilisateur,prenom, mail, password, administrateur, valide, jeton FROM utilisateur where mail = :mail';
	
	if($requete=$PDO->prepare($query)){
	
		if($requete->execute(array(':mail'=>$mail))){
		
			if($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
			
			return true;

			
			}
			
			else{

				return false;
			}

	}
	
	else
	{
		echo $PDO->errorInfo();
	}
}



}

/////insert user

	public static  function insertUser(Utilisateur $user) :bool 
	{
		$PDO=connexion_bdd();
		$data=array(
			':nomUtilisateur'=>$user->getNomUtilisateur(),
			':prenomUtilisateur'=>$user->getPrenom(),
			':mail'=> $user->getMail(),
			':password'=> password_hash($user->getPassword(),PASSWORD_DEFAULT),
			':administrateur'=>(int)$user->getAdministrateur(),
			':jeton'=>$user->getJeton(),
			':valide'=>$user->getValide()
		);
		$query='INSERT INTO utilisateur(nomUtilisateur,prenom,mail,password,administrateur,valide,jeton)VALUES(:nomUtilisateur,:prenomUtilisateur,:mail,:password,:administrateur,:valide,:jeton)';
		if($requete=$PDO->prepare($query)){
			if($requete->execute($data)){
				return TRUE;
			}
			
			else{			
				$PDO->errorInfo();
			}
			
		}
		
		else {return FALSE;};
	}
	
	
	public static function setUser(Utilisateur $user)
	{
	
		$PDO=connexion_bdd();
		$data=[
			':idUtilisateur'=>$user->getIdUtilisateur(),
			':nomUtilisateur'=>$user->getNomUtilisateur(),
			':prenomUtilisateur'=>$user->getPrenom(),
			':mail'=> $user->getMail(),
			':password'=>$user->getPassword(),
			':administrateur'=>(int)FALSE,
			':valide'=>$user->getValide(),
			':jeton'=>$user->getJeton()
			];
			
		$query='UPDATE utilisateur SET
			nomUtilisateur=:nomUtilisateur,
			prenom=:prenomUtilisateur,
			mail =:mail,
			administrateur=:administrateur,
			password=:password,
			valide=:valide,
			jeton=:jeton
			 WHERE idUtilisateur=:idUtilisateur'
			;
			
		if($requete=$PDO->prepare($query)){
			if($requete->execute($data)){
				return TRUE;
			}
			
			else{			
				$PDO->errorInfo();
			}
			
		}
		
		else {
			return FALSE;
		}
			
	
		
	
	}
	//////////delete nécessaire de vider la table favoris avons de delete user 
	
	public static function dropUser(Utilisateur $user):bool
	{
		$PDO=connexion_bdd();
		$data=['idUtilisateur'=>$user->getIdUtilisateur()];
		$favoris=FavorisRepo::getFavoris($user);
		$query='DELETE FROM utilisateur WHERE idUtilisateur = :idUtilisateur';
		$flag=true;

		foreach($favoris as $fav)
		{
			if(!FavorisRepo::dropFavoris($fav,$user->getIdUtilisateur())){
				$flag=FALSE;
			}
		}
		if(!$flag){
			return FALSE;
		}

		else{
			if($requete=$PDO->prepare($query)){
				if($requete->execute($data)){
					return TRUE;
				}
			}
		}

	
	}
	
	//récupérer un user grace à son jeton et faire passer valide de 0 à 1;

public static function getUserByToken($token){

	$PDO=connexion_bdd();
	$query='SELECT idUtilisateur, nomUtilisateur, prenom, mail, password, administrateur, valide, jeton FROM utilisateur where
	jeton= :jeton';
	$data=array(':jeton'=>$token);
	$user=null;

	if($requete=$PDO->prepare($query)){
		if($requete->execute($data)){
			if($resultat=$requete->fetch(PDO::FETCH_ASSOC)){

				$user=new Utilisateur(
					$resultat['idUtilisateur'],
					$resultat['nomUtilisateur'],
					$resultat['prenom'],
					$resultat['mail'],
					$resultat['password'],
					$resultat['administrateur'],
					$resultat['valide'],
					$resultat['jeton']
				);
			}
		}
	}

	return $user;

}


}


	
?>

