

<?php

include_once('../includes/page.inc.php');
include_once('headerAdmin.php');
$message='';
$idGuitare=0;
$action='';
$dateFab='';
$nom='';
$prix='';
$descritpion='';
$nbCordes=null;
$dest='';

$cheminPhoto='';
$photo='';
//ajout ou modif
if(isset($_GET['idGuitare'])){

    if($_GET['idGuitare'] !== null)
    {
        $guitare=GuitareRepo::getGuitare($_GET['idGuitare']);
        $action='Modification de la '.getNomObject($guitare);

        $idGuitare=getIdObject($guitare);
        $nom=$guitare->getNomGuitare();
        $prix=$guitare->getPrix();
        $nbCordes=$guitare->getNbCordes();
        $descritpion=$guitare->getDescription();
        $cheminPhoto=$guitare->getCheminPhoto();////////////////////////////////////////????????
        $dateFab=$guitare->getDateFab();
        $etui=$guitare->getEtui();
        

    }

    



}
else{

    $message='nouvelle guitare :';
    $action='Ajout d\'une guitare';
}

///AJOUT 

if(isset($_POST['submit'])){ //formu envoyé 

    


    //verification de l'entrée YEAR 
    if(isset($_POST['dateFab'])){

        if(checkDateFab($_POST['dateFab'])){



            //on vérifie le prix 

            if(filter_var($_POST['prix'],FILTER_VALIDATE_INT)){


                if($_POST['id'] >0){//dans le cas où le post est issu d'une modif 


                    //si files est isset alors on change de photo
                    if(isset($_FILES['newPhoto']) && !empty($_FILES['newPhoto']['tmp_name'])){ 
                       
                        $photo=$_FILES['newPhoto']['tmp_name'];//le chemin tempo vers la nouvelle photo
                    
                        $nomPhoto=checkPhoto($photo); //enregistre la photo dans le fichier guitare_images et renvoie 
                        // le nouveau nom 

                        //on supprime l'ancienne photo du dossier

                        unlink(__DIR__.'/../guitare_images/'.GuitareRepo::getGuitare($_POST["id"])->getCheminPhoto());
                        

                    }
                    else{ // on veut garder la même
                        
                        $nomPhoto=GuitareRepo::getGuitare($_POST["id"])->getCheminPhoto();
                        
                    }
                }

                else{//Ajout

                    $photo=$_FILES['photo']['tmp_name'];
                    $nomPhoto=checkPhoto($photo);

                }
                    //vérification de la photo TYPE plus SIZE
                
                

                    
                    
                    
//////////////////////////////MODIFICATION
                    //si ok on vérifie les inputs
                    if($_POST['id']>0){

                        
                        $guitareToSet=GuitareRepo::getGuitare($_POST['id']);

                        $guitareToSet->setNomGuitare(cleanInput($_POST['nomGuitare']));
                        $guitareToSet->setPrix($_POST['prix']);
                        $guitareToSet->setNbCordes($_POST['nbCordes']);
                        $guitareToSet->setDescription(cleanInput($_POST['description']));
                        $guitareToSet->setCheminPhoto($nomPhoto);
                        $guitareToSet->setDateFab($_POST['dateFab']);
                        $guitareToSet->setEtui($_POST['etui']);


                        GuitareRepo::updateGuitare($guitareToSet);
                        GuitareRepo::dropFinitionGuitare($guitareToSet);
                        GuitareRepo::dropGenreGuitare($guitareToSet);

                        if(isset($_POST['modele'])){
                            GuitareRepo::setModeleGuitare($guitareToSet,ModeleRepo::getModele($_POST['modele']));
                        }
                        if(isset($_POST['marque'])){
                            GuitareRepo::setMarqueGuitare($guitareToSet,MarqueRepo::getMarque($_POST['marque']));
                        }

                        if(isset($_POST["finition"])){

                            GuitareRepo::addFinition($guitareToSet,$_POST['finition']);
                        }
                        

                        if(isset($_POST["genre"])){

                            GuitareRepo::addGenre($guitareToSet,$_POST['genre']);
                        }



                        header('location:guitare.php');


                    }
                                
                    else{    
                        
                        ////////////AJOUT ///////////////////////

                        $newGuitare=new Guitare(0,cleanInput($_POST['nomGuitare']),$_POST['prix'],$_POST['nbCordes'],cleanInput($_POST['description']),$nomPhoto,
                        $_POST['dateFab'],$_POST['etui']);

                        //ajout de la guitare dans la base
                        GuitareRepo::addGuitare($newGuitare);
                        
                        $newGuitare=GuitareRepo::getGuitareByName($_POST['nomGuitare']);


                    

                        //on récupère la guitare nouvellement entrée 

                        //ajout d'une marque
                        if(isset($_POST['marque'])){

                            GuitareRepo::addMarque($newGuitare,MarqueRepo::getMarque($_POST['marque']));
                        }
                        //ajout d'un modele

                        if(isset($_POST['modele'])){

                            GuitareRepo::addModele($newGuitare,ModeleRepo::getModele($_POST['modele']));
                        }

                        //ajout Genre

                        if(isset($_POST['genre'])){

                            GuitareRepo::addGenre($newGuitare,$_POST['genre']);
                        }

                        //ajout des finitions

                        if(isset($_POST['finition'])){

                            GuitareRepo::addFinition($newGuitare,$_POST['finition']);
                        }

                    
                        header('location:guitare.php');
                    }

            } //fin if prix

          
        
            
            else{
                echo"<div class='alert alert-danger' role='alert'>
                Le format du prix n'est pas conforme !
                </div>";

            }
        
       
    
        }     //fin  if date 
        else{

            echo"<div class='alert alert-danger' role='alert'>
            La date rentrée n'est pas conforme !
            </div>";
        }
            
        }

        
    
 
    } // fin isset date 
   

    


    

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
                    <h2><?=$action?></h2>
                    <hr>
                    <form action='<?=$_SERVER['PHP_SELF']?>' method='POST' enctype='multipart/form-data'>
                        <div class='input-group mb-3'>
                        <span class="input-group-text" id="basic-addon1">Nom</span>
                        <input type='text' class='form-control' name='nomGuitare' value='<?=$nom?>' required>
                        </div>

                     <!--prix--->
                     <div class='input-group mb-3'>
                        <span class="input-group-text" id="basic-addon1">Prix</span>
                        <input type='text' class='form-control' name='prix' required value='<?=$prix?>'>
                        </div>

                     <!--nbcordes--->

                     <div class='input-group mb-3'>
                        <span class="input-group-text" id="basic-addon1">Nombre de cordes</span>
                        <select name='nbCordes' class='form-select'>
                           <?php for($a=4;$a<9;$a++):?>
                        
                                <option value=<?=$a?> <?php if(isset($guitare)){
                                   if($guitare->getNbCordes()=== $a){ echo'selected';}
                                    }
                                    ?>>
                                    <?=$a?>
                            </option>
                            <?php endfor?>

                        </select>
                        </div>
                     <!---description-->
                     <div class='input-group mb-3'>
                        <span class="input-group-text" id="basic-addon1">Description</span>
                        <textarea  class='form-control' name='description' row =10 required><?=$descritpion?></textarea>
                        </div>
                     
                     <!---chemin photo-->
                     <?php if(isset($_GET['idGuitare'])):?>
                       
                           <img src=<?='../guitare_images/'.$cheminPhoto?>>
                           <p>modifier la photo</p>
                           <input type='file' class='form-control' name='newPhoto'>
                     <?php endif?>
                    
                     <?php if(!isset($_GET['idGuitare'])):?>
                       
                        <div class='input-group mb-3'>
                        <span class='input-group-text' id='basic-addon1'>Photo</span>
                        <input type='file' class='form-control' name='photo' required>
                        </div>
                     
                     <?php endif?>
                     

                     <!--dateFab--->
                     <div class='input-group mb-3'>
                        <span class="input-group-text" id="basic-addon1">Année de fabrication</span>
                        <input type='text' class='form-control' name='dateFab' required value=<?=$dateFab?> >
                    </div>

                     <!--etui --->
                    <h3>Etui</h3>
                     <fieldset>
                        
                        <input type='radio' name='etui' value='1' 
                        <?php 
                        if(isset($etui)){
                            if($etui==1){
                                echo'checked';}
                                }
                                else{echo'checked';}?>> Non
                        <input type='radio' name='etui' value='2'
                        <?php 
                        if(isset($etui)){
                            if($etui==2){
                                echo'checked';}
                                }?>> Oui<br>


                    </fieldset>
                        <br>

                   


                    <!---les relations ----->


                    <!--marque-->
                    <h3>Marque</h3>
                    <fieldset>
                    <?php foreach(MarqueRepo::getMarques() as $marque) : ?>
                        <input type='radio' name='marque' value=<?=$marque->getIdMarque()?>
                        <?php if(isset($guitare)){
                            if(!strcmp($marque->getNomMarque(),GuitareRepo::getMarqueGuitare($guitare))){ echo'checked';}
                            }?>>
                        <?=' '.$marque->getNomMarque().'<br>'?>
                        

                        <?php endforeach?>
                    </fieldset>
                    <br>

                    <!--finition-->

                    <h3>Finition</h3>
                    <fieldset>
                        
                    <?php foreach(FinitionRepo::getFinitions() as $finition) : ?>
                        <input type='checkbox' name='finition[]' value=<?=$finition->getIdFinition()?>
                        <?php if(isset($guitare)){
                         if(in_array($finition->getFinition(),GuitareRepo::getFinitionGuitare($guitare))){
                            echo'checked';
                        } }?>
                        ><?=' '.$finition->getFinition().'<br>'?>

                        <?php endforeach?>
                    </fieldset>
                    <!--genre-->
                        <br>
                    <h3>Genre</h3>
                    <fieldset>
                        
                    <?php foreach(GenreRepo::getGenres() as $genre) : ?>
                        <input type='checkbox' name='genre[]' value=<?=$genre->getIdGenre()?>
                            <?php if(isset($guitare))
                            {if(in_array($genre->getGenre(),GuitareRepo::getGenreGuitare($guitare))){
                                echo'checked';
                            }}
                            ?>
                        
                        ><?=' '.$genre->getGenre().'<br>'?>

                        <?php endforeach?>
                    </fieldset>
                    <!--modele-->
                    <br>
                    <h3>Modèle</h3>
                    <fieldset>
                        
                    <?php foreach(ModeleRepo::getModeles() as $modele) : ?>
                        <input type='radio' name='modele' value=<?=$modele->getIdModel()?>
                        <?php 
                        if(isset($guitare)){
                        if(!strcmp($modele->getModel(),GuitareRepo::getModeleGuitare($guitare))) {echo'checked';}}?>>
                        <?=' '.$modele->getModel().'<br>'?>

                        <?php endforeach?>
                    </fieldset>






                        <div class='text-center'> 
                            <input type='submit' name='submit' class='btn btn-success btn-lg' value='valider'>
                            <input type='hidden' name='id' value='<?=$idGuitare?>'> 
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
