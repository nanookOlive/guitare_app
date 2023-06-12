<?php
session_start();

    //on vérifie que la session a bien été initialisée
    if(isset($_SESSION['user'])){

        //on réninitiaise la session

        $_SESSION=[];
        //destruction du cookie de session

        if(ini_get('session.use_cookies')){
            $para=session_get_cookie_params();
            setCookie(
                session_name(),
                '',
                time()-4000,
                $para['path'],
                $para['domain'],
                $para['secure'],
                $para['httponly']
            );
            //destruction de la session

            session_destroy();
        }
    }

    else{
        //gestion erreur
    }

    header('location:../index.php');

?>
