<?php

include('../includes/page.inc.php');

//utilisateur

if(isset($_GET['flag'])){
  if($_GET['flag']==1){

    echo"<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Attention un des champs du formulaire est vide !</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
  }

  elseif($_GET['flag']==2){

    echo"<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Adresse mail déjà liée à un compte !</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
  }
}


$user=new Utilisateur(0,'','','','',0,null,null);


//on teste les entrées

if(isset($_POST['submit'])){//formu envoyé

  if(isset($_POST['nom']) && // si le formu n'est pas vide et bien isset
    isset($_POST['prenom']) &&
    isset($_POST['email']) &&
    isset($_POST['password']) &&
    !empty($_POST['nom']) &&
    !empty($_POST['prenom']) &&
    !empty($_POST['email']) &&
    !empty($_POST['password'])
    ) 

    {
      //on clean les inputs cf /includes/page.inc.php pour fonction cleanInput()

      $nom=cleanInput($_POST['nom']);
      $prenom=cleanInput($_POST['prenom']);
      $mail=cleanInput($_POST['email']);
      $password=cleanInput($_POST['password']);
      //on check si le user n'existe pas déjà en base 


      if(!UtilisateurRepo::userExists($mail)){

          //on crée un jeton et on hash le pass

          $jeton=uniqid();
                


          //on set le user

          $user->setNomUtilisateur($nom);
          $user->setPrenom($prenom);
          $user->setMail($mail);
          $user->setPassword($password);
          $user->setJeton($jeton);

          //on fait l'insert


          if(UtilisateurRepo::insertUser($user)){

            //on envoie le mail avec le jeton en get 

            sendMail($user->getMail(),$user->getPrenom(),$jeton);
            header('location:../index.php?flag=1');
          }
      }

      else{

        header('location:inscription.php?flag=2');
      }

    }

    else
      {

        header('location:inscription.php?flag=1');
      }
}


?>
<!-----------le formulaire en bootstrap pour l'instant--------------------------------------------->

<!DOCTYPE html>

<html>

  <head>
      <meta charset='utf-8'>
      <title>Inscription</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  </head>


  <body style='display:flex; flex-direction:column;align-items:center;'>


<!--LE FORMULAIRE -------------------------->
    <img src='../res/logo_guitare_2.png' style='width:300px;height:300px;'>
    <div class='card' style='width:60%;margin-top:10vh'>
      <div class='card-header'>
        <h2>S'inscrire à M.G.S</h2>
      </div>
      <div class='card-body'>
        <form class="row g-3" method='POST' action=<?=$_SERVER['PHP_SELF']?>>
          <div class="col-md-6">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" name='nom' required>
          </div>
          <div class="col-md-6">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="prenom" class="form-control" name='prenom' required>
          </div>
          <div class="col-12">
            <label for="email" class="form-label">Email</label>
            <input type="mail" class="form-control" name='email' required>
          </div>
          <div class="col-12">
            <label for="inputAddress2" class="form-label">Password</label>
            <input type="text" class="form-control" name='password' required>
          </div>
          <div class="col-12">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="gridCheck">
              <label class="form-check-label" for="gridCheck">Je ne suis pas un robot</label>
            </div>
          </div>
          <div class="col-12">
            <input type='submit' name='submit' class='btn btn-success'>
          </div>
        </form>
        <p class='text-center'><a href='index.php'>Retour au site </a></p>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

  </body>
</html>





