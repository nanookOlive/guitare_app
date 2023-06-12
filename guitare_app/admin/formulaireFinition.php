<?php
/////////////le formulaire pour ajout et modification

include_once('../includes/page.inc.php');
include_once('headerAdmin.php');


$message='';
$idFinition=0;
$action='';

if(isset($_GET['idFinition'])){ //si isset alors modification

    if($_GET['idFinition'] !== null)
    {
        $finition=FinitionRepo::getFinition($_GET['idFinition']);
        $idFinition=getIdObject($finition);
        $message="modification de ".getNomObject($finition)." :";
        $action='Modification ';
    }
}
else{//sinon ajout 

    $message='nouvelle finition :';
    $action='Ajout ';
}


if(isset($_POST["submit"])){///envoie des requetes

    if(isset($_POST['nomFinition']) && !empty($_POST['nomFinition'])){

        if($_POST['id'] > 0){//si id est positif alors modification
        $upFinition=FinitionRepo::getFinition($_POST['id']);
        $upFinition->setFinition($_POST['nomFinition']);
        FinitionRepo::setFinition($upFinition);
        header('location:finition.php');// plus bandeau validation
    }

    else{//ajout 
        if(!existInBase($_POST['nomFinition'],'Finition')){//on érifie qu'elle n'exite pas en base 

        $newFinition=new Finition(0,cleanInput($_POST['nomFinition']));
        ///traitement de l'input 
        
        FinitionRepo::addFinition($newFinition);
        header('location:finition.php?flag=1');// plus bandeau
        }

        else{

            $message="cette finition existe déjà !";
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
                        <a href="finition.php" class="btn btn-outline-danger">Finition</a>
                        <a href='genre.php' class='btn btn-outline-primary'>Genre</a>
                        <a href="guitare.php" class="btn btn-outline-primary">Guitare</a>
                        <a href="utilisateur.php" class="btn btn-outline-primary">Utilisateur</a>
                        <a href="newsletter.php" class="btn btn-outline-primary">Newsletter</a>

                    </span>
                    <hr>
                    <h2><?=$action?>d'une finition</h2>
                    <hr>
                    <form action='<?=$_SERVER['PHP_SELF']?>' method='POST'>
                        <div class='input-group mb-3'>
                        <span class="input-group-text" id="basic-addon1"><?=$message?></span>
                        <input type='text' class='form-control' name='nomFinition'>
                        </div>
                     

                        <div class='text-center'> 
                            <input type='submit' name='submit' class='btn btn-success btn-lg' value='valider'>
                            <input type='hidden' name='id' value='<?=$idFinition?>'> 
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
