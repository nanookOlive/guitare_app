<?php


require(__DIR__.'/../includes/page.inc.php');

// si le jeton est bien envoyé via le get du lien dans le mail
if(isset($_GET['jeton']))
{

    $user=UtilisateurRepo::getUserByToken($_GET['jeton']); // on récupere l'utilisateur avec le jeton dans le get
    if($user !==null){ //le user existe

        //le user est il déjà validé ?
        if($user->getValide()){ // oui alors renvoie vers page index avec flag 
            header('location:../index.php?flag=3'); // on retourne sur la page d'index avec un flag pour alert ok 
        }

        else{

            $user->setValide(TRUE);
            UtilisateurRepo::setUser($user);
            header('location:../index.php?flag=2'); // on retourne sur la page d'index avec un flag pour alert ok 
        }
    }
    else {
        //Error
    }
}

?>