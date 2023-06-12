<?php
include(__DIR__.'/../includes/page.inc.php');


$data=[];
$guitareArray=[];


if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
strtoupper($_SERVER['HTTP_X_REQUESTED_WITH'])== 'XMLHTTPREQUEST'){
//on crée un premier ensemble de guitare issu du favoris passé 

if(isset($_POST['idFavoris']))
{
if($_POST['idFavoris']==''){
   $allGuitare=GuitareRepo::getGuitares();

}

else
{
   //on crée un tableau des guitares du favoris du user 
   $guitareFavoris=FavorisRepo::getGuitaresFavoris(UtilisateurRepo::getUtilisateur($_POST['userId']),FavorisRepo::getFavori($_POST['idFavoris'],$_POST['userId']));
   //pour l'affichage on veut une liste des guitares ne figurant pas dans le favoris
   $idGuitare=[];
   $allGuitare=[];
   foreach($guitareFavoris as $guitare){
      array_push($idGuitare,$guitare->getIdGuitare());

   }
   foreach(GuitareRepo::getGuitares() as $guitare){
      if(!in_array($guitare->getIdGuitare(),$idGuitare)){

         array_push($allGuitare,$guitare);
      }
   }
}
}

else{

   $allGuitare=GuitareRepo::getGuitares();
}
//on veut recuperer toutes les guitares selon un critères

$arraySort=[];
$arrayFavoris=[];


switch($_POST['id']){

case 'prix':

   if($_POST['flag']=='prix1'){
   foreach($allGuitare as $guitare){

      if((int)$guitare->getPrix()>2000){
        array_push($arraySort,$guitare);
      }
   }
}
else{
   foreach($allGuitare as $guitare){

      if((int)$guitare->getPrix()<2000){
        array_push($arraySort,$guitare);
      }
   }

}
break;

case 'tout':

   $arraySort=$allGuitare;
   break;

case 'corde' :

   foreach($allGuitare as $guitare){
      if($guitare->getNbCordes()==$_POST['flag']){

         array_push($arraySort,$guitare);
      }
   }
   break;


   case 'marque':

      foreach($allGuitare as $guitare){
         if(GuitareRepo::getMarqueGuitare($guitare)==$_POST['flag']){
   
            array_push($arraySort,$guitare);
         }
      }

      break;

   case 'modele' :

      foreach($allGuitare as $guitare){
         if(GuitareRepo::getModeleGuitare($guitare)==$_POST['flag']){
   
            array_push($arraySort,$guitare);
         }
      }

      break;

   case 'finition' :

      foreach($allGuitare as $guitare){

         if(in_array($_POST['flag'],GuitareRepo::getFinitionGuitare($guitare))){
            array_push($arraySort,$guitare);

         }
      }
      break;

      case 'genre' :

         foreach($allGuitare as $guitare){
   
            if(in_array($_POST['flag'],GuitareRepo::getGenreGuitare($guitare))){
               array_push($arraySort,$guitare);
   
            }
         }
         break;

      case 'etui' :

         foreach($allGuitare as $guitare){
   
            if($_POST['flag']==$guitare->getEtui($guitare)){
               array_push($arraySort,$guitare);
   
            }
         }
         break;


}

foreach($arraySort as $guitare){

   ///////////////toutes les infos de la table guitare
   $guitareArray['nom']=$guitare->getNomGuitare();
   $guitareArray['prix']=$guitare->getPrix();
   $guitareArray['description']=$guitare->getDescription();
   $guitareArray['nbCordes']=$guitare->getNbCordes();
   $guitareArray['photo']=$guitare->getCheminPhoto();
   $guitareArray['dateFab']=$guitare->getDateFab();
   if($guitare->getEtui()==1){
      $guitareArray['etui']='sans étui.';
   }
   else{$guitareArray['etui']='avec étui.';}

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


   /////les favoris du USER


   
   array_push($data,$guitareArray);
}

if(isset($_POST['userId'])){
   $favoris=FavorisRepo::getFavoris(UtilisateurRepo::getUtilisateur($_POST['userId']));
   
   foreach($favoris as $fav){
      $arrayFavoris[$fav->getIdFavoris()]=$fav->getNomFavoris();
   }

}


array_push($data,$arrayFavoris);


}

echo json_encode($data);

