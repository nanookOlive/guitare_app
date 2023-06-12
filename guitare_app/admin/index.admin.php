<?php
include(__DIR__.'/../includes/page.inc.php');
/////////////////////page d'administration de l'appli

include('headerAdmin.php');

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
                
                <a href="marque.php" class="btn btn-primary">Marque</a>
                <a href="modele.php" class="btn btn-primary">Modèle</a>
                <a href="finition.php" class="btn btn-primary">Finition</a>
                <a href="genre.php" class="btn btn-primary">Genre</a>
                <a href="guitare.php" class="btn btn-primary">Guitare</a>
                <a href="utilisateur.php" class="btn btn-primary">Utilisateur</a>
                <a href="newsletter.php" class="btn btn-primary">Newsletter</a>
 

            </div>

            <div class="card-footer">
                <a href="index.admin.php" class="btn btn-outline-primary">Retour à l'espace d'administration</a>
                <a href="../index.php" class="btn btn-outline-primary">Retour au site</a>
                <a href="log.out.admin.php" class="btn btn-outline-primary">Se déconnecter</a>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </body>
</html>
