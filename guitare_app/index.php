<?php

include(__DIR__.'/includes/page.inc.php');

    //on check si un flag est isset, si oui la page index a été ouverte à partir de la page inscription
    if(isset($_GET['flag'])){

        switch($_GET['flag']){

        case 1:
        
        echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Demande d'inscription en cours !</strong> Un mail vous a été envoyé, cliquez sur le lien pour finaliser votre inscription.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        break;

    

    case 3 :

        echo"<div class='alert alert-info alert-dismissible fade show' role='alert'>
            <strong>Votre inscription a déjà été validée !</strong> 
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
            break;
    

    case 2:

        echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Inscription validée!</strong> 
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    break;


    case 4:

       echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Vous n'avez pas validé votre inscription !</strong> Un mail vous avez été envoyé, cliquez <a href='client/mailAgain.php?id=".$_GET['id']."'>ici</a> pour le recevoir de nouveau.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";

            break;

    case 5:

        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Erreur d'authentification</strong> 
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        

        }

    }

    //////////////qq variables 
    $marques = MarqueRepo::getMarques();
    $modeles= ModeleRepo::getModeles();
    $finitions= FinitionRepo::getFinitions(); 
    $genres=GenreRepo::getGenres();
?>


<!DOCTYPE html>

<html>

    <head>
        <meta charset='utf-8'>
        <link rel='stylesheet' href='styles/styles.css'>
        <title>MGS</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    </head>


    <header>

        <div class='nav'>
                <img id='logo' src='res/logo_guitare_2.png'>
                <form id='form_connexion' action='client/login.php' method='POST'>
                    <input id='login' type='email' name='email' required placeholder='login'>
                    <input id='password' type='password' name='password' required placeholder='password'>
                    <button type='submit' id='btn_submit_connexion' class='btn_app' name='submit_connexion' value='connexion'>Se connecter</button>
                    <a href='client/inscription.php'>S'inscrire</a>
                </form>
        </div>
    </header>


    <body>

    <div id='mamaFlex'> <!--partie dans laquelle seront affichées les options de tri-->
        <div id='option_tri'>
            <form id='formu' method='POST'>
                <fieldset id='sel'>

                    <div><label for='tout'>Toutes les guitares</label>
                         <input type='radio' id='tout' name='prix' value='tout' checked></div>

                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Par Prix
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div><label for='prix'>Plus de 2000 euros</label>
                                        <input type='radio' id='prix' name='prix' value='prix1'></div>
                                    <div><label for='prix'>Moins de 2000 euros</label>
                                        <input type='radio' id='prix' name='prix' value='prix2'></div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Par nombre de cordes
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div>4 <input type='radio' id='corde' name='prix' value=4></div>
                                    <div>5 <input type='radio' id='corde' name='prix' value=5></div>
                                    <div>6 <input type='radio' id='corde' name='prix' value=6></div>
                                    <div>7 <input type='radio' id='corde' name='prix' value=7></div>
                                    <div>8 <input type='radio' id='corde' name='prix' value=8></div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Par Marque
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <?php foreach($marques as $marque) :?>
                                    <div> <?=$marque->getNomMarque().' '?><input type='radio' id='marque' name='prix' value="<?=$marque->getNomMarque()?>"></div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                            
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Par modèle
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <?php foreach($modeles as $modele) :?>
                                    <div> <?=$modele->getModel().' '?><input type='radio' id='modele' name='prix' value="<?=$modele->getModel()?>"></div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Par finition
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <?php foreach($finitions as $finition) :?>
                                    <div> <?=$finition->getFinition().' '?><input type='radio' id='finition' name='prix' value='<?=$finition->getFinition()?>'></div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                            
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    étui
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div>sans étui <input type='radio' id='etui' name='prix' value=1></div>
                                    <div>avec étui <input type='radio' id='etui' name='prix' value=2></div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeveb">
                                    Par genre
                                </button>
                            </h2>
                            <div id="collapseSeven" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <?php foreach($genres as $genre) :?>
                                    <div> <?=$genre->getGenre().' '?><input type='radio' id='genre' name='prix' value="<?=$genre->getGenre()?>"></div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <input type='submit' name='submit' value='Lancer la recherche' id='send'>
            </form>  
        </div>

        <div id='affichage'>
        </div>

    </div>

</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <!----LE JAVASCRIPT-------------------------------------->

    <script>


        var btn= document.getElementById('send');//on récupére le bouton du formulaire 

        

        function ajaxCall(flagN,nom){ // la requête ajax qui appelle toutes les guitares selon le critère de recherche
            $.ajax({
                type:'POST',
                url:'client/ajax.php',
                data:{

                    flag : flagN,
                    id : nom
                },
                dataType:'json'

            }).done(function(data,textStatus,jqXHR)
            {
                $('#affichage').empty();//on vide l'affichage
                data.pop(); // on supprime le dernier élé du tableau qui est en fait la liste des favoris
                data.sort(function compare(a, b) {
                if (a.nom < b.nom)
                    return -1;
                if (a.nom > b.nom )
                    return 1;
                return 0;
                });
                if(data.length==0){
                    $("#affichage").append('<h2>Aucun résultat pour votre recherche</h2>');
                }
                else{
                    for(var a=0;a<data.length;a++){
                    $('#affichage').append(" <div id=\"guitare\">\n <div id=\"nomGuitare\"><h2>"+data[a].nom+"</h2></div> <div id=\"container\"><div class='image_guitare'><image src='guitare_images/"+data[a].photo+"'></div><div id=\"bloc_text\"><p>Guitare "+data[a].nbCordes+" cordes de "+data[a].dateFab+".</p><p>Guitare de type "+data[a].modele+"</p><p>Marque : "+data[a].marque+"<p>"+data[a].description+"</p><p>Idéale pour jouer : "+data[a].genre+"</p><p>Existe en : "+data[a].finition+"</p><p>Livrée "+data[a].etui+"</p><div class=\"prix\">Prix : "+data[a].prix+" euros.</div></div></div></div>");
                    }
                }
            });
        }

    document.addEventListener('DOMContentLoaded', ajaxCall('tout','tout'));//on appelle la requete d'affichage au chargement de la page

    $('#send').click(function(event){ // quand on lance une recherche

        this.setAttribute('checked','');
        event.preventDefault();
        var flagN='';
        var nom='';
    
        $('input[type="radio"]:checked').each(function() {  
            flagN=(this.value); 
            nom=this.getAttribute('id')});
        ajaxCall(flagN,nom);
    });
        </script>
    </body>

</html>

