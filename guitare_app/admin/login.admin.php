<?php

include(__DIR__.'/../includes/page.inc.php');
//clean données post
session_name('sessionAdmin');
session_start();
$login=(isset($_POST['login'])) ? trim(strip_tags($_POST['login'])):'';
$pass=(isset($_POST['pass'])) ? trim(strip_tags($_POST['pass'])) :'';

//création user à partir de son mail et pass

$user= UtilisateurRepo::authentification($login);

if($user !== null){
//onvérifie le pass

    if(password_verify($pass,$user->getPassword())&& $login==$user->getMail()){

            //on check la valeur de administrateur
            if($user->getAdministrateur()){

                header('location:accueil.php');
                $_SESSION['userAdmin']=$user;////////////////////////////////ici
            }

            else{

                header('location:formu.login.admin.php?flag=1');
            }

            

            
    }

    else{
        header('location:formu.login.admin.php?flag=1');

    }
    

}
else{

    header('location:formu.login.admin.php?flag=1');
    
}
