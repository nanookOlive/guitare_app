<?php

include(__DIR__.'/../includes/page.inc.php');
/////////////////////page d'administration de l'appli

include('headerAdmin.php');
//////////////////////insert du mail dans base appel fonction dans page.inc.php

saveNewsletter($_POST['subject'],$_POST['content']);

////////////////on envoie le mail avec sendNewletter

$allUsers=UtilisateurRepo::getUtilisateursNotGranted();

if(isset($_POST['submit'])){

    foreach($allUsers as $user){

        sendNewsletter($user,$_POST['content'],$_POST['subject']);
    }
}
