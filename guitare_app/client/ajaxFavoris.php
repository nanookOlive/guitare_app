<?php


include(__DIR__.'/../includes/page.inc.php');

$reponse=[];

switch ($_POST['flag']){

case 1 :
    
    if(isset($_POST['nomGuitare'])){ //ajout d'une guitare dans une collection via son nom id serait mieux

        $guitare = GuitareRepo::getGuitareByName($_POST['nomGuitare']);
        if(FavorisRepo::addGuitare($guitare,$_POST['idFavoris'])){

            $reponse[0]='ok';
        }
    }
    break;

case 2:


    //insert d'une nouvelle collection

    $user=UtilisateurRepo::getUtilisateur($_POST['userId']);

    //////////on regarde si une colelction porte déjà ce nom
    $allFavoris=FavorisRepo::getNomFavoris($user);
    

      if(!in_array($_POST['nomFavoris'],$allFavoris)){
         FavorisRepo::addFavoris($user,$_POST['nomFavoris']);
         $reponse[0]='Collection créée ! ';

      }

      else{

         $reponse[0]='Une collection porte déjà ce nom !';
      }
    

    break;


case 0:

if(isset($_POST['idFavoris'])){//création d'un taleau des guitares d'une collection pour affichage

    $user = UtilisateurRepo::getUtilisateur($_POST['userId']);
    $favoris = FavorisRepo::getFavori($_POST['idFavoris'],$user->getIdUtilisateur());
    $guitares = FavorisRepo::getGuitaresFavoris($user,$favoris);
    

    foreach($guitares as $guitare){
        $guitareArray=[];
        ///////////////toutes les infos de la table guitare
        $guitareArray['idGuitare']=$guitare->getIdGuitare();
        $guitareArray['nom']=$guitare->getNomGuitare();
        $guitareArray['prix']=$guitare->getPrix();
        $guitareArray['description']=$guitare->getDescription();
        $guitareArray['nbCordes']=$guitare->getNbCordes();
        $guitareArray['photo']=$guitare->getCheminPhoto();
        $guitareArray['dateFab']=$guitare->getDateFab();
        if($guitare->getEtui()==1){
           $guitareArray['etui']='sans étui.';
        }
        else{
            $guitareArray['etui']='avec étui.';}
     
        //////////////les relations 
     
     /////uniques 
     
     ////marque
     
     
        if(!empty(GuitareRepo::getMarqueGuitare($guitare))){
     
           $guitareArray['marque']=GuitareRepo::getMarqueGuitare($guitare);
        }
        else{
           $guitareArray['marque']='N.C';
        }
     ////modele
     
        if(!empty(GuitareRepo::getModeleGuitare($guitare))){
     
           $guitareArray['modele']=GuitareRepo::getModeleGuitare($guitare);
        }
        else{
           $guitareArray['modele']='N.C';
        }
     
     ////multiples
     
     ///finition
     
     
        if(!empty(GuitareRepo::getFinitionGuitare($guitare))){
     
           $finitionStr='';
           foreach(GuitareRepo::getFinitionGuitare($guitare) as $finition){
     
              $finitionStr = $finitionStr.$finition.' | ';
           } 
           $guitareArray['finition']=$finitionStr;
        }
        else{
           $guitareArray['finition']='N.C';
        }
     
     ///genre
     
        if(!empty(GuitareRepo::getGenreGuitare($guitare))){
     
           $genreStr='';
           foreach(GuitareRepo::getGenreGuitare($guitare) as $genre){
     
              $genreStr = $genreStr.$genre.' | ';
           } 
           $guitareArray['genre']=$genreStr;
        }
        else{
           $guitareArray['genre']='N.C';
        }
        array_push($reponse,$guitareArray);

    }

}

    break;

case 3 :

    $user=UtilisateurRepo::getUtilisateur($_POST['userId']);
    $favoris =FavorisRepo::getFavoris($user);
    $reponse=[];
    foreach($favoris as $favori){

        $fav=[];

        $fav['id']=$favori->getIdFavoris();
        $fav['nom']=$favori->getNomFavoris();
        array_push($reponse,$fav);

    }
    break;

    case 4:

        FavorisRepo::retireGuitare($_POST['idGuitare'],$_POST['idFavoris']);
        $reponse=[];
        $reponse['idFavoris']=$_POST['idFavoris'];
        break;

   case 5:

      $favoris=FavorisRepo::getFavori($_POST['idFavoris'],$_POST['userId']);
      FavorisRepo::dropFavoris($favoris,$_POST['userId']);

}
echo json_encode($reponse);