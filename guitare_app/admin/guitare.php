<?php
include(__DIR__.'/../includes/page.inc.php');
include('headerAdmin.php');


////////////////////////////////////suppression

if(isset($_GET['idSuppression']))
{

    //récupération de l'id via le get du href
    $id=(int)$_GET['idSuppression'];

    //on verifie si le id existe dans la table genre

    if(existInBase($id,'Guitare')){    

        //on crée l'objet à partir de son id

        $guitareToDrop=GuitareRepo::getGuitare($id);}

        //suppression
    if($guitareToDrop !== null){

        if(!GuitareRepo::dropGuitare($guitareToDrop)){
              
        }
        else{
           
        }
    }

    else{
         
        header("location:error_admin.php");
        exit();
    }



}

/////////////array ressources
$listeGuitares=GuitareRepo::getGuitares();
////////////////
usort($listeGuitares,"order");
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
                    <a href="guitare.php" class="btn btn-outline-danger">Guitare</a>
                    <a href="utilisateur.php" class="btn btn-outline-primary">Utilisateur</a>
                    <a href="newsletter.php" class="btn btn-outline-primary">Newsletter</a>
                </span>
                <hr>
                <h2>Gestion des guitares</h2>
                <hr>
                <!--vers le formulaire d'ajout ------->
                <a href='formulaireGuitare.php' class='btn btn-primary'>Ajouter</a>
                <hr>
                <!--la liste des guitares-->
                <table class="table ">
                    <thead>
                        <tr>
                            <th scope="col" style='width:80%;'>Guitare</th>
                            <th scope="col" style='width:150px;'></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($listeGuitares as $guitare):?>
                        <tr>
                            <th scope="row"><?= getNomObject($guitare)?></th>
                            <td><a href='formulaireGuitare.php?idGuitare=<?=getIdObject($guitare)?>' class='btn btn-primary'>Modifier</a></td>
                            <td><a href='guitare.php?idSuppression=<?=getIdObject($guitare)?>' class='btn btn-danger'>Supprimer</a></td>
                            
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
