<?php
include_once(__DIR__.'/../bdd/connexion.php');
class FavorisRepo{

    public static function getFavori(int $idFavoris,int $idUser){

        $PDO=connexion_bdd();
        $favoris = null;
        $query='SELECT idFavoris, nomFavoris, fkIdUtilisateur from favoris where idFavoris=:idFavoris AND fkIdUtilisateur=(SELECT idUtilisateur FROM utilisateur WHERE idUtilisateur = :idUser)' ;
        if($requete=$PDO->prepare($query)){
            if($requete->execute(array(':idFavoris'=>$idFavoris, ':idUser'=>$idUser))){
                if($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
                $favoris=new Favoris((int)$resultat['idFavoris'],$resultat['nomFavoris'],(int)$resultat['fkIdUtilisateur']);
                return $favoris;}
            }
            else{

            }
        }
    }

    public static function getFavoris( Utilisateur $user):array //tableau d'objet favoris
    {

        $PDO=connexion_bdd();
        $array_favoris=[];
        $data=array(':id'=>$user->getIdUtilisateur());
        $query='SELECT  idUtilisateur,idFavoris, nomFavoris FROM utilisateur  JOIN favoris ON utilisateur.idUtilisateur=favoris.fkIdUtilisateur WHERE idUtilisateur = :id';
        if($requete=$PDO->prepare($query)){
            if($requete->execute($data)){
               
                    while($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
                        $newFavoris=new Favoris($resultat['idFavoris'],$resultat['nomFavoris'],$resultat['idUtilisateur']);
                        array_push($array_favoris,$newFavoris);
                    }
                

            }
        }
        

        return $array_favoris;
    }

    public static function getNomFavoris( Utilisateur $user):array //tableau d'objet favoris
    {

        $PDO=connexion_bdd();
        $array_favoris=[];
        $data=array(':id'=>$user->getIdUtilisateur());
        $query='SELECT  nomFavoris FROM utilisateur  JOIN favoris ON utilisateur.idUtilisateur=favoris.fkIdUtilisateur WHERE idUtilisateur = :id';
        if($requete=$PDO->prepare($query)){
            if($requete->execute($data)){
               
                    while($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
                        array_push($array_favoris,$resultat['nomFavoris']);
                    }
                

            }
        }
        

        return $array_favoris;
    }

    //ajout d'un nouveau favoris


    public static function addFavoris(Utilisateur $user, string $newFavoris):bool
    {

        $PDO=connexion_bdd();
        $query='INSERT INTO favoris (`nomFavoris`, fkIdUtilisateur)VALUES(:nom, :id)';
        if(!empty($newFavoris)){
            if($requete=$PDO->prepare($query))
            {
                if($requete->execute(array(':nom'=>$newFavoris, ':id'=>$user->getIdUtilisateur())))
                {
                    return TRUE;
                }
                else{

                    return FALSE;
                }
                return FALSE;

            }
            return FALSE;
        }

        return FALSE;

        
    }

    //ajoute une guitare à une certaine collection d'un user
    public static function addGuitare(Guitare $guitare,int $favoris):bool
    {

        $PDO=connexion_bdd();
        $query='INSERT INTO favoris_guitare(fkIdFavoris,fkIdGuitare)VALUES(:idFavoris,:idGuitare)';
        if($requete=$PDO->prepare($query)){
            if($requete->execute(array(':idFavoris'=>$favoris, ':idGuitare'=>$guitare->getIdGuitare())))
            {
                return TRUE;
            }
        }
    }

    public static function getGuitaresFavoris(Utilisateur $user, Favoris $favoris):array{//renvoie les guitare d'une certaine collection d'un user
        $PDO=connexion_bdd();
        $array_guitare=[];
        $query='SELECT idGuitare FROM guitare JOIN favoris_guitare ON guitare.idGuitare=favoris_guitare.fkIdGuitare JOIN favoris ON favoris_guitare.fkIdFavoris=favoris.idFavoris JOIN utilisateur ON favoris.fkIdUtilisateur=utilisateur.idUtilisateur WHERE idUtilisateur=:id AND nomFavoris=:nom;';
        if($requete=$PDO->prepare($query)){
            if($requete->execute(array(':id'=>$user->getIdUtilisateur(), ':nom'=>$favoris->getNomFavoris())))
            {
                while($resultat=$requete->fetch(PDO::FETCH_ASSOC)){
                    $guitare=GuitareRepo::getGuitare($resultat['idGuitare']);
                    array_push($array_guitare, $guitare);
                }
               return $array_guitare;
            }
            else{
                echo 'erreur';
            }
        }

    }
    public static function retireGuitare(int $idGuitare,int $idFavoris){
        $PDO=connexion_bdd();
        $query='delete from favoris_guitare where fkIdGuitare=:idGuitare and fkIdFavoris=(select idFavoris from favoris where idFavoris=:idFavoris)';
        if($requete=$PDO->prepare($query)){
            $requete->execute(array(':idGuitare'=>$idGuitare,':idFavoris'=>$idFavoris));
        }
    }
    
    public static function dropFavoris(Favoris $favoris, int $idUser):bool
    {

        //on vide la table favoris guitare correspondante

        $PDO=connexion_bdd();
        $query_1='DELETE FROM favoris_guitare WHERE fkIdFavoris=(SELECT idFavoris FROM favoris WHERE idFavoris=:id AND fkIdUtilisateur=:idUser)';
        $query_2='DELETE FROM favoris WHERE idFavoris=:idFav';
        if($requete=$PDO->prepare($query_1)){
            if($requete->execute(array(':id'=>$favoris->getIdFavoris(),':idUser'=>$idUser))){
                if($req=$PDO->prepare($query_2)){
                    if($req->execute(array(':idFav'=>$favoris->getIdFavoris()))){
                        return TRUE;
                    }
                    else{return FALSE;}
                    

                }
                else{return FALSE;}



            }
            else{return FALSE;}
        }

    }


    public static function inFavorisGuitare(Guitare $guitare):bool 
    {
        $PDO=connexion_bdd();
        $query='SELECT idFavorisGuitare FROM  favoris_guitare WHERE fkIdGuitare= :id';
        if($requete=$PDO->prepare($query)){
            if($requete->execute(array(':id'=>$guitare->getIdGuitare()))){

                if(!empty($resultat=$requete->fetch(PDO::FETCH_ASSOC))){
                    return TRUE;
                }
                else{
                    return FALSE;
                }

            }
        }
    }

   
}
