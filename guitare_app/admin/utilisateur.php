<?php
include(__DIR__.'/../includes/page.inc.php');
/////////////////////page d'administration de l'appli
include('headerAdmin.php');

////////////////////////////////////suppression

if(isset($_GET['idSuppression']))
{

    //faire méthode si modele existe 
    $id=(int)$_GET['idSuppression'];
    

    if(existInBase($id,'Utilisateur')){
        $userToDrop=UtilisateurRepo::getUtilisateur($id);
    }
    

    if($userToDrop !== null){
        if(!UtilisateurRepo::dropUser($userToDrop)){
                header("location:utilisateur.php");
                
        }
    }

    else{
         
        header("location:error_admin.php");
       
    }



}


$listeUsers=UtilisateurRepo::getUtilisateursNotGranted();//////////////tableau sans l'user admin 

usort($listeUsers,"order");
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
                <h2>Gestion des utilisateurs</h2>
                <hr>
                
                <a href='formulaireUtilisateur.php' class='btn btn-primary'>Ajouter</a>
                <hr>
                <!--la liste des users-->
                <table class="table ">
                    <thead>
                        <tr>
                            <th scope="col" style='width:80%;'>Utilisateur</th>
                            <th scope="col" style='width:150px;'></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($listeUsers as $user):?>
                        <tr>
                            <th scope="row"><?= $user->getNomUtilisateur().' '.$user->getPrenom()?></th>
                            <td><a href='formulaireUtilisateur.php?idUser=<?=getIdObject($user)?>' class='btn btn-primary'>Modifier</a></td>
                            <td><a href='utilisateur.php?idSuppression=<?=getIdObject($user)?>' class='btn btn-danger'>Supprimer</a></td>
                            
                        </tr>
                        <?php endforeach ?>
                    </tbody>

                </table>



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
