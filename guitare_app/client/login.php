<?php
/////////////////va vérifier si le password envoyé par post correspond bien au hash du password utilisateur si oui alors redirection vers index.user.php et création d'un objet session sinon retour vers index.php
session_start();
include('../includes/page.inc.php');


		$mail=(isset($_POST['email'])) ? trim(strip_tags($_POST['email'])) : ''; 
		$password=(isset($_POST['password'])) ? trim(strip_tags($_POST['password'])) :''; 

		//////////////
		
		
		$user=UtilisateurRepo::authentification($mail);
		
		if($user!=null){
		
			if(password_verify($password,$user->getPassword()) && $mail==$user->getMail()){//le user est inscrit

				if($user->getValide()){
					$_SESSION['user']=$user;
					header('location:index.user.php');
				}
				else{

					header("location:../index.php?flag=4&id=".$user->getIdUtilisateur());//user inscrit mais pas validé
				
				}
			}
			else
		{
			
			header('location:../index.php?flag=5');
		}
		}

		else{

			header('location:../index.php?flag=5');
		}
		


?>
