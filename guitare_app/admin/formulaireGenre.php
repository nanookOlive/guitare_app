<?php

include_once('../includes/page.inc.php');
include_once('headerAdmin.php');
$message='';
$idGenre=0;
$action='';

if(isset($_GET['idGenre'])){

    if($_GET['idGenre'] !== null)
    {
        $genre=GenreRepo::getGenre($_GET['idGenre']);
        $idGenre=getIdObject($genre);
        $message="modification de ".getNomObject($genre)." :";
        $action='Modification ';
    }

    



}
else{

    $message='nouveau genre :';
    $action='Ajout ';
}
if(isset($_POST["submit"])){

    if(isset($_POST['nomGenre']) && !empty($_POST['nomGenre'])){

        if($_POST['id'] > 0){
        $upGenre=GenreRepo::getGenre($_POST['id']);
        $upGenre->setGenre(cleanInput($_POST['nomGenre']));
        GenreRepo::updateGenre($upGenre);
        header('location:genre.php');
    }

    else{
        if(!existInBase($_POST['nomGenre'],'Genre')){

        $newGenre=new Genre(0,cleanInput($_POST['nomGenre']));
        GenreRepo::addGenre($newGenre);
        header('location:genre.php?flag=1');
        }

        else{

            $message="ce genre existe déjà";
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
                        <a href='genre.php' class='btn btn-outline-danger'>Genre</a>
                        <a href="guitare.php" class="btn btn-outline-primary">Guitare</a>
                        <a href="utilisateur.php" class="btn btn-outline-primary">Utilisateur</a>
                        <a href="newsletter.php" class="btn btn-outline-primary">Newsletter</a>

                    </span>
                    <hr>
                    <h2><?=$action?>d'un genre</h2>
                    <hr>
                    <form action='<?=$_SERVER['PHP_SELF']?>' method='POST'>
                        <div class='input-group mb-3'>
                        <span class="input-group-text" id="basic-addon1"><?=$message?></span>
                        <input type='text' class='form-control' name='nomGenre'>
                        </div>
                     

                        <div class='text-center'> 
                            <input type='submit' name='submit' class='btn btn-success btn-lg' value='valider'>
                            <input type='hidden' name='id' value='<?=$idGenre?>'> 
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
