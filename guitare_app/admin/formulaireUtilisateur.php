<?php

include_once('../includes/page.inc.php');
include_once('headerAdmin.php');
$message='';
$idUser=0;
$action='';
$nom='';
$prenom='';
$mail='';
$password='';
$valide='';
$inscrit='';

if(isset($_GET['idUser'])){

    if($_GET['idUser'] !== null)
    {

        $userToUpdate=UtilisateurRepo::getUtilisateur($_GET['idUser']);
        $idUser=(int)getIdObject($userToUpdate);
        $nom=$userToUpdate->getNomUtilisateur();
        $prenom=$userToUpdate->getPrenom();
        $mail=$userToUpdate->getMail();
        $password=$userToUpdate->getPassword();
        $message="modification de ".getNomObject($user)." :";
        $action='Modification ';
        if($userToUpdate->getValide()){

            $valide='oui';

        }
        else{

            $valide="non";
        }
        if($userToUpdate->getJeton() !== null){
            $inscrit='oui';
        }
        else{

            $inscrit='non';
        }
    }

    



}
else{

    $action='Ajout ';

}
if(isset($_POST["submit"])){

    if(isset($_POST['nom']) && !empty($_POST['nom'])){//////update du user

        if($_POST['id'] > 0){
        $upUser=UtilisateurRepo::getUtilisateur($_POST['id']);
        $upUser->setNomUtilisateur(cleanInput($_POST['nom']));
        $upUser->setPrenom(cleanInput($_POST['prenom']));
        $upUser->setMail($_POST['mail']);
        $upUser->setPassword(password_hash($_POST['password'],PASSWORD_DEFAULT));


        UtilisateurRepo::setUser($upUser);
        header('location:utilisateur.php');
    }

    else{
        if(!UtilisateurRepo::userExists($_POST['mail'],)){//faire avec le mail 

        $newUser=new Utilisateur(0,cleanInput($_POST['nom']),cleanInput($_POST['prenom']),$_POST['mail'],$_POST['password'],FALSE);
        UtilisateurRepo::insertUser($newUser);
        header('location:utilisateur.php');
        }

        else{

            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Cet utilisateur existe déjà !</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }

    }
}
   

}

?>


<!DOCTYPE html>

<html>
    <head>
        <meta charset='utf-8'>
        <title>Administration</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    </head>

    <body>


        <div class='container' >
            <div class="card" style='margin-top:10vh;'>
                <div class="card-header">
                    <h2>Espace d'administration</h2>
                    <p>administrateur : <?= $user->getPrenom()?> <?=$user->getNomUtilisateur()?></p>
                    
                </div>
                
                <div class="card-body">
                    <span>            
                        <a href="marque.php" class="btn btn-outline-primary">Marque</a>
                        <a href="modele.php" class="btn btn-outline-primary">Modèle</a>
                        <a href="finition.php" class="btn btn-outline-primary">Finition</a>
                        <a href='genre.php' class='btn btn-outline-primary'>Genre</a>
                        <a href="guitare.php" class="btn btn-outline-primary">Guitare</a>
                        <a href="utilisateur.php" class="btn btn-outline-danger">Utilisateur</a>
                        <a href="newsletter.php" class="btn btn-outline-primary">Newsletter</a>

                    </span>
                    <hr>
                    <h2><?=$action?>d'un utilisateur</h2>
                    <hr>
                    <form action='<?=$_SERVER['PHP_SELF']?>' method='POST'>
                        <div class='input-group mb-3'>
                        <span class="input-group-text" id="basic-addon1">Nom</span>
                        <input type='text' class='form-control' name='nom' value='<?=$nom?>' >
                        </div>
                        <div class='input-group mb-3'>
                        <span class="input-group-text" id="basic-addon1">Prénom</span>
                        <input type='text' class='form-control' name='prenom' value='<?=$prenom?>'>
                        </div>
                        <div class='input-group mb-3'>
                        <span class="input-group-text" id="basic-addon1">Email</span>
                        <input type='text' class='form-control' name='mail' value='<?=$mail?>'>
                        </div>
                        <div class='input-group mb-3'>
                        <span class="input-group-text" id="basic-addon1">Password</span>
                        <input type='text' class='form-control' name='password' required>
                        </div>
                        <div class='input-group mb-3'>
                        <span class="input-group-text" id="basic-addon1">Inscrit</span>
                        <input type='text' class='form-control' name='inscrit' placeholder='<?=$inscrit?>' readonly>
                        </div>
                        <div class='input-group mb-3'>
                        <span class="input-group-text" id="basic-addon1">a validé son inscription</span>
                        <input type='text' class='form-control' name='valide' placeholder='<?=$valide?>' readonly>
                        </div>


                        <div class='text-center'> 
                            <input type='submit' name='submit' class='btn btn-success btn-lg' value='valider'>
                            <input type='hidden' name='id' value='<?=$idUser?>'> 
                         </div>
                    </form>
                </div>
            

                <div class="card-footer">
                    <a href="index.admin.php" class="btn btn-outline-primary">Retour à l'espace d'administration</a>
                    <a href="../index.php" class="btn btn-outline-primary">Retour au site</a>
                    <a href="log.out.admin.php" class="btn btn-outline-primary">Se déconnecter</a>

                </div>
            </div>

        <div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    </body>
</html>
