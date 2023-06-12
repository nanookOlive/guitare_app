<?php
include(__DIR__.'/../includes/page.inc.php');
include('headerAdmin.php');

$message='';
$idModele=0;
$action='';

if(isset($_GET['idModele'])){

    if($_GET['idModele'] !== null)
    {
        $modele=ModeleRepo::getModele($_GET['idModele']);
        $idModele=getIdObject($modele);
        $message="modification de ".getNomObject($modele)." :";
        $action='Modification ';
    }

    



}
else{
    $action ='Ajout ';
    $message='nouveau modèle :';
}
if(isset($_POST["submit"])){

    if(isset($_POST['nomModele']) && !empty($_POST['nomModele'])){

        if($_POST['id'] > 0){
        $upModele=ModeleRepo::getModele($_POST['id']);
        $upModele->setModel(cleanInput($_POST['nomModele']));
        ModeleRepo::setModele($upModele);
        header('location:modele.php');
    }

    else{
        if(!existInBase(cleanInput($_POST['nomModele']),'Modele')){

        $newModele=new Modele(0,cleanInput($_POST['nomModele']));
        ModeleRepo::addModele($newModele);
        header('location:modele.php?flag=1');
        }

        else{

            $message="ce modèle existe déjà";
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
                        <a href="modele.php" class="btn btn-outline-danger">Modèle</a>
                        <a href="finition.php" class="btn btn-outline-primary">Finition</a>
                        <a href='genre.php' class='btn btn-outline-primary'>Genre</a>
                        <a href="guitare.php" class="btn btn-outline-primary">Guitare</a>
                        <a href="utilisateur.php" class="btn btn-outline-primary">Utilisateur</a>
                        <a href="newsletter.php" class="btn btn-outline-primary">Newsletter</a>

                    </span>
                    <hr>
                    <h2><?=$action?> d'un modèle</h2>
                    <hr>
                    <form action='<?=$_SERVER['PHP_SELF']?>' method='POST'>
                        <div class='input-group mb-3'>
                        <span class="input-group-text" id="basic-addon1"><?=$message?></span>
                        <input type='text' class='form-control' name='nomModele'>
                        </div>
                     

                        <div class='text-center'> 
                            <input type='submit' name='submit' class='btn btn-success btn-lg' value='valider'>
                            <input type='hidden' name='id' value='<?=$idModele?>'> 
                         </div>
                    </form>
                </div>
            

                <div class="card-footer">
                    <a href="index.admin.php" class="btn btn-outline-primary">Retour à l'espace d'administration</a>
                    <a href="../index.php" class="btn btn-outline-primary">Retour au site</a>
                    <a href="log.out.admin.php" class="btn btn-outline-primary">Se déconnecter</a>

                </div>
            </div>
        </div>
    </body>
</html>