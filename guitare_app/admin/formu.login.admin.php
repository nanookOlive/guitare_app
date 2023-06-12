<?php

if(isset($_GET['flag'])){

    if($_GET['flag']==1){
    echo"<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Vous n'êtes pas autorisé à accéder à l'espace d'administration du site !</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";}

    elseif($_GET['flag']==2){
        echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>À bientôt !</strong>
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";

    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <link rel='stylesheet' href='styles_formu_admin.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    
</head>
<body>
<img src='../res/logo_guitare_2.png'>
<form method='POST' action='login.admin.php' id='formu'>

    <label for='login'>Login</label>
    <input id='login 'type='email' name='login' required>
    <label for='pass'>Password</label>
    <input id='pass' type='password' name='pass' required>
    <input id='btn_sumbit' type='submit' name='submit' value='Connexion'>
<form>
</body>
</html>
