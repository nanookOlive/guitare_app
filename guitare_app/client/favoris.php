<?php
include(__DIR__.'/../includes/page.inc.php');
session_start();

if(!isset($_SESSION['user'])){
    header('location:../index.php');
}
/////////////au chargement de la page
/////////////////////////////les messages//////////////////////////////////////




// $favorisUser=FavorisRepo::getFavoris($_SESSION['user']);
// //////////////ajout d'une favoris
// $newFavoris=(isset($_POST['newFavoris'])) ? trim(strip_tags($_POST['newFavoris'])) : '';

// if(isset($_POST['btn_newFavoris'])){

//     FavorisRepo::addFavoris($_SESSION['user'],$_POST['newFavoris']);
//     $favorisUser=FavorisRepo::getFavoris($_SESSION['user']);

// }
// if(isset($_GET['drop_favoris'])){

//     $fav=FavorisRepo::getFavori($_GET['drop_favoris'],$_SESSION['user']->getIdUtilisateur());
//     FavorisRepo::dropFavoris($fav,$_SESSION['user']->getIdUtilisateur());
// }

// if(isset($_POST['retire'])){
    
//     FavorisRepo::retireGuitare($_POST['retire'],$_POST['fav']);
// }
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

</html>
<header>

<div class='nav'>
        <img id='logo' src='../res/logo_guitare_2.png'>
        <a href='index.user.php'><button type='button' class='btn_app' id='btn_retour'>Retour au site</button></a>
        
</div>

</header>
<body>




<div id='mamaFlex'>
    <div id='option_tri'>
        <h2 style='margin-top:30px;'>Mes favoris</h2>

        <!-----------les favoris ------------------------------------------------------------------>

        <div id="btn-group" role="group" aria-label="Basic radio toggle button group">


        </div>

            <input type="text" name='newFavoris' placeholder='nom de ma nouvelle collection' id='newFavoris'>
            <button id='btnAdd'>Ajouter</button>
            <button onclick="supprime()">Supprimer</button>
        </div>
<!-----------SUPRESSION FAVORIS ----------------------------------------------->
        
   

    <div id='affichage'>

    </div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>



<script>// le script qui va gérer l'affichage des collection au chargement, la suppression d'une collection et l'éviction
// d'une guitare d'une collection

function bof(val){

    $('input[type="radio"][name="btnradio"]:checked').each(function(){
        idFavoris=this.value;
        console.log(idFavoris);
    })
    retireGuitare(idFavoris,val);


}
function retireGuitare(idFavoris,idGuitare){


    $.ajax({
        type:'POST',
        url: 'ajaxFavoris.php',
        data :{
            flag :4,
            idFavoris : idFavoris,
            idGuitare : idGuitare
        },
        dataType :'json'
    }).done(function(data){

        showGuitare('<?=$_SESSION['user']->getIdUtilisateur()?>',idFavoris);
});


}

function setIdFavoris(val){
            idFavoris=val;
            showGuitare('<?=$_SESSION['user']->getIdUtilisateur()?>',idFavoris);
            ///faire message si vide 

        }

function supprime(){

    $('input[type="radio"][name="btnradio"]:checked').each(function(){
            idFavoris=this.value;});

    $.ajax({
        type:'POST',
        url:'ajaxFavoris.php',
        data :{
            flag :5,
            idFavoris : idFavoris,
            userId : '<?=$_SESSION['user']->getIdUtilisateur()?>'   
        },
        dataType :'json'
    }).done(function()
    {
        fetchFavoris();
        $("#affichage").empty();
    })

}

$("#btnAdd").on('click',function(){
    addFavoris('<?=$_SESSION['user']->getIdUtilisateur()?>',$("#newFavoris").val());
    fetchFavoris();
    $("#newFavoris").val('');


})


function addFavoris(idUser,nomFavoris){

    $.ajax({
        type:'POST',
        url:'ajaxFavoris.php',
        data :{
            flag:2,
            userId : idUser,
            nomFavoris : nomFavoris
        },
        datatype : 'json'
    }).done(function(data){
        // $("#affichage").empty();

    })
};

function fetchFavoris(){

    $.ajax({

        type:'POST',
        url:'ajaxFavoris.php',
        data :{
            flag :3,
            userId :'<?=$_SESSION['user']->getIdUtilisateur()?>'
        },
        dataType:'json'
    }).done(function(data,textStatus,jqXHR){
            $("#btn-group").empty();

            for(var a=0;a<data.length;a++)
            {
                $("#btn-group").append("<input type='radio' class='btn-check' name='btnradio' id='btnradio"+data[a].id+"' onclick=\"setIdFavoris("+data[a].id+")\"  value="+data[a].id+" autocomplete='off' checked><label class='btn btn-outline-primary' for='btnradio"+data[a].id+"'>"+data[a].nom+"</label>")
            }
          
            showGuitare('<?=$_SESSION['user']->getIdUtilisateur()?>',data[0].id);
        //faire toutes les guitares checked reset option tri
        });
}
function showGuitare(idUser,idFavoris){

    $('input[type="radio"][name="btnradio"]:checked').each(function(){
            idFavoris=this.value;
            

       });
            $.ajax({

        type:'POST',
        url:'ajaxFavoris.php',
        data:{
            flag : 0,
            userId :'<?=$_SESSION['user']->getIdUtilisateur()?>',
            idFavoris : idFavoris
        },
        dataType:'json'

        }).done(function(data,textStatus,jqXHR)
        {
            $('#affichage').empty();
            if(data.length!==0){
                data.sort(function compare(a, b) {
                if (a.nom < b.nom)
                    return -1;
                if (a.nom > b.nom )
                    return 1;
                return 0;
                });
            for(var a=0;a<data.length;a++){

                $('#affichage').append(" <div id=\"guitare\">\n <div id=\"nomGuitare\"><h2>"+data[a].nom+"</h2></div> <div id=\"container\"><div class='image_guitare'><image src='../guitare_images/"+data[a].photo+"'></div><div id=\"bloc_text\"><p>Guitare "+data[a].nbCordes+" cordes de "+data[a].dateFab+".</p><p>Guitare de type "+data[a].modele+"</p><p>Marque : "+data[a].marque+"<p>"+data[a].description+"</p><p>Idéale pour jouer : "+data[a].genre+"</p><p>Existe en : "+data[a].finition+"</p><p>Livrée "+data[a].etui+"</p><div class=\"prix\">Prix : "+data[a].prix+" euros.</div><button type='button' class='btn btn-primary' id='addBtn' onclick=\"bof('"+data[a].idGuitare+"')\">Retirer</button></div></div></div></div>");
                
            };}
            else{

                $("#affichage").append('<h2>Il n\'y a pas encore de guitares dans cette collection ! <a href=\"index.user.php\">En ajouter</a></h2>');
            }

        });
    }


//au chargement de la page /////////////////////////////////////////////////////////////////////////////
document.addEventListener('DOMContentLoaded', function(){

    

//si le user n'a pas de collec

    if('<?= empty(FavorisRepo::getFavoris($_SESSION['user']))?>'){
        $("#affichage").empty();
        $("#affichage").append("<h2>Vous ne possedez pas de collection pour l'instant !</h2>");
    }
/////////sinon on affiche les guitares de la première collection

    else{//on récupére un id de Favoris

      
    }
    fetchFavoris();
    //function append bouton dans option tri 
});
</script>
</body>



