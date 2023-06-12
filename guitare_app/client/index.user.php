<?php require_once(__DIR__.'/../includes/page.inc.php');
 session_start();
    if((!isset($_SESSION['user']))){
        header('location:../index.php');
    }


    // if(isset($_POST['submit'])){
        
    //    FavorisRepo::addGuitare(GuitareRepo::getGuitare($_POST['guitare']),$_POST['listeFavoris']);
    // }
    //      $tabi = GuitareRepo :: getGuitares(); 

    $marques = MarqueRepo::getMarques();
    $modeles= ModeleRepo::getModeles();
    $finitions= FinitionRepo::getFinitions(); 
    $genres=GenreRepo::getGenres();
    $favorisUser=FavorisRepo::getFavoris($_SESSION['user']);

    
 ?>


<!DOCTYPE html>
<html>

    <head>
        <meta charset='utf-8'>
        <link rel='stylesheet' href='../styles/styles.css'>
        <title>MGS</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    </head>


    <header>

        <div class='nav'>
            <img id='logo' src='../res/logo_guitare_2.png'>
            <div class='little_cont'>
                <h2><?= 'bonjour '.$_SESSION['user']->getPrenom()?> !</h2>
                <a href='favoris.php'><button id='btn_favoris' class='btn_app'>Mes Favoris</button></a>
                <a href='log.out.php'><button id='btn_deco' class='btn_app'>Se déconnecter</button></a>
            </div>
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
                                    <div> <?=$modele->getModel().' '?><input type='radio' id='modele' name='prix' value='<?=$modele->getModel()?>'></div>
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
                                    <div> <?=$genre->getGenre().' '?><input type='radio' id='genre' name='prix' value='<?=$genre->getGenre()?>'></div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <input type='submit' name='submit' value='Lancer la recherche' id='send'>
                <input type='hidden' name='id' id='id' value="<?=$_SESSION['user']->getIdUtilisateur()?>">

            </form> 

            <h3 style='text-align:center'>Vos favoris</h3>
            <!---- si le user ne possede pas de collection---->
            <?php if(empty($favorisUser)):?>
                <p>Vous ne possédez pas encore de collections !</p>
            <?php endif ?>

            <!--on affiche toutes les collections du user -->

            <div id="btn-group" role="group" aria-label="Basic radio toggle button group">
                
                <?php foreach($favorisUser as $favoris):?>
                <input type="radio" class="btn-check" name="btnradio" id="btnradio<?=$favoris->getIdFavoris()?>" onclick="setIdFavoris(<?= $favoris->getIdFavoris()?>)"  value='<?=$favoris->getIdFavoris()?>'autocomplete="off" checked>
                <label class="btn btn-outline-primary" for="btnradio<?=$favoris->getIdFavoris()?>"><?=$favoris->getNomFavoris()?></label>
                <?php endforeach?>
            </div>
        </div>
    
        <div id='affichage'>
    </div>
    
<body>

</html>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script>
        var btn= document.getElementById('send');
        
        // var idFavoris='';

        function bof(val){
            addGuitare(val,idFavoris);

        }
        

        function setIdFavoris(val){
            idFavoris=val;
            ajaxCall("tout",'tout','<?=$_SESSION['user']->getIdUtilisateur()?>',idFavoris);
           // $('#tout').prop('checked',true);

        }
        function addGuitare(nomGuitare,idFavoris,idUser){

            $.ajax({

                type:'POST',
                url:'ajaxFavoris.php',
                data :{
                    flag :1,
                    nomGuitare:nomGuitare,
                    idFavoris: idFavoris
                },
                dataType:'json'
            }).done(function(data,textStatus,jqXHR)
            {   
                $('input[type="radio"][name="prix"]:checked').each(function() {  flagN=(this.value); nom=this.getAttribute('id')});

                ajaxCall(flagN,nom,<?=$_SESSION['user']->getIdUtilisateur()?>,idFavoris);
                //ajaxCall('tout','tout','<?=$_SESSION['user']->getIdUtilisateur()?>',idFavoris);
                // $('#tout').prop('checked',true);

}); 
        }
        function ajaxCall(flagN,nom,idUser,idFavoris){
            $.ajax({

        type:'POST',
        url:'ajax.php',
        data:{

            flag : flagN,
            id : nom,
            userId :idUser,
            idFavoris : idFavoris
        },
        dataType:'json'

        }).done(function(data,textStatus,jqXHR)
        {
            data.pop();
            $('#affichage').empty();
            data.sort(function compare(a, b) {
                if (a.nom < b.nom)
                    return -1;
                if (a.nom > b.nom )
                    return 1;
                return 0;
                });
            

            if(data.length>0){

            for(var a=0;a<data.length;a++){
                

                $('#affichage').append(" <div id=\"guitare\">\n <div id=\"nomGuitare\"><h2>"+data[a].nom+"</h2></div> <div id=\"container\"><div class='image_guitare'><image src='../guitare_images/"+data[a].photo+"'></div><div id=\"bloc_text\"><p>Guitare "+data[a].nbCordes+" cordes de "+data[a].dateFab+".</p><p>Guitare de type "+data[a].modele+"</p><p>Marque : "+data[a].marque+"<p>"+data[a].description+"</p><p>Idéale pour jouer : "+data[a].genre+"</p><p>Existe en : "+data[a].finition+"</p><p>Livrée "+data[a].etui+"</p><div class=\"prix\">Prix : "+data[a].prix+" euros.</div><button type='button' class='btn btn-primary' id='addBtn' onclick=\"bof('"+data[a].nom+"')\"><i class='bi bi-star'></i> Ajouter</button></div></div></div></div>");
                
                
            };
        }

        else{

            $("#affichage").append("<h2>Aucune guitare ne correspond à votre recherche :(</h2>");
        }
            
        });
                }
/* au chargement de la page si user a une collection on veut afficher les guitares restantes*/


    document.addEventListener('DOMContentLoaded', function(){
        
        
        var idUser='<?=$_SESSION['user']->getIdUtilisateur()?>';
    /* le user ne possede pas de collections*/
        
        if('<?=empty($favorisUser)?>'){
            
            idFavoris=null;

           
        }
        else{
            ($('input[type="radio"][name="btnradio"]:checked').each(function(){
            idFavoris=this.value;
        }));

        }



        ajaxCall('tout','tout',idUser,idFavoris);
        
    });


    
   
    

    $('#send').click(function(event){

    this.setAttribute('checked','');
    event.preventDefault();
    var flagN='';
    var nom='';
    var idUser=document.getElementById("id").value;
    $('input[type="radio"][name="prix"]:checked').each(function() {  flagN=(this.value); nom=this.getAttribute('id')});

    ajaxCall(flagN,nom,idUser,idFavoris);

    });
        </script>
</body>



