<?php

include('../includes/page.inc.php');

//on recupere le user inscrit mais pas validé

if(isset($_GET['id'])){
    $user=UtilisateurRepo::getUtilisateur($_GET['id']);
    //on renvoie un mail avec le jeton / appel de la fonction sendmail
    if($user !== null){

        
        echo (int)sendMail($user->getMail(),$user->getNomUtilisateur(),$user->getJeton());
        //on renvoie sur la page index avec flag message

        header("location:../index.php?flag=1");

    }
}
else{

    
}
