<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
include('bdd/connexion.php');

require __DIR__.'/../PHPMailer-master/src/Exception.php';
require __DIR__.'/../PHPMailer-master/src/PHPMailer.php';
require __DIR__.'/../PHPMailer-master/src/SMTP.php';
/* Utilisation de spl_autoload_registrer */
function charge($nomClasse)
{
	include __DIR__ . '/classes/' . $nomClasse . '.php';
}

spl_autoload_register('charge');

////////// méthode qui check si un objet existe parmis un tableau d'objet

function getIdObject(object $object) 
{
	$id=match(get_class($object)){
		'Modele'=>$object->getIdModel(),
		'Genre'=>$object->getIdGenre(),
		'Marque'=>$object->getIdMarque(),
		'Finition'=>$object->getIdFinition(),
		'Favoris'=>$object->getIdFavoris(),
		'Utilisateur'=>$object->getIdUtilisateur(),
		'Guitare'=>$object->getIdGuitare()
	};
	return $id;
}

function getNomObject(object $object) : string 
{
	$nom=match(get_class($object)){
		'Modele'=>$object->getModel(),
		'Genre'=>$object->getGenre(),
		'Marque'=>$object->getNomMarque(),
		'Finition'=>$object->getFinition(),
		'Utilisateur'=>$object->getNomUtilisateur(),
		'Guitare'=>$object->getNomGuitare()
	};

	return $nom;

}

function getAllIdObject(array $arrayObject) : array 
{
	$array=[];
	foreach($arrayObject as $object){

		array_push($array,getIdObject($object));

	}
	
	return $array;

}

function getAllNomObject(array $arrayObject) : array 
{
	$array=[];
	foreach($arrayObject as $object){

		array_push($array,getNomObject($object));

	}
	
	return $array;

}

function existInBase($needle,string $type):bool
{

	$array=array();

	if(is_int($needle)){

		$array=match($type){
			'Modele'=>getAllIdObject(ModeleRepo::getModeles()),
			'Genre'=>getAllIdObject(GenreRepo::getGenres()),
			'Finition'=>getAllIdObject(FinitionRepo::getFinitions()),
			'Marque'=>getAllIdObject(MarqueRepo::getMarques()),
			'Guitare'=>getAllIdObject(GuitareRepo::getGuitares()),
			'Utilisateur'=>getAllIdObject(UtilisateurRepo::getUtilisateurs())
		};
	}

	elseif(is_string($needle))
	{
		$array=match($type){
			'Modele'=>getAllNomObject(ModeleRepo::getModeles()),
			'Genre'=>getAllNomObject(GenreRepo::getGenres()),
			'Finition'=>getAllNomObject(FinitionRepo::getFinitions()),
			'Marque'=>getAllNomObject(MarqueRepo::getMarques()),
			'Guitare'=>getAllNomObject(GuitareRepo::getGuitares()),
			'Utilisateur'=>getAllNomObject(UtilisateurRepo::getUtilisateurs())
		};
	}
	

	return in_array($needle,$array);


}

function checkDateFab(string $date):bool{

	if((int)$date < 1900 || (int)$date >2023){

		return FALSE;
	}

	else{
		return TRUE;
	}
}


///////////////////checkphoto////////////////////

	function checkPhoto(string $path){

		$destination=__DIR__.'/../guitare_images'; //pour enregistrement
		$widthFormat=225;
		$heightFormat=225;

		$type=exif_imagetype($path); // recupération du type
		$newPath=uniqid().'.jpeg';//le nouveau nom de ma photo

		if($type !== IMAGETYPE_JPEG){//on ne veut que du jpeg

			echo "<div class='alert alert-danger' role='alert'>
					Le type de l'image n'est pas le bon !
		  		 </div>";
		}

		

		else{
			//si le type est le bon
			//Extraction des infos
			list($width,$height)=getimagesize($path);

			//si la size ne correspond pas
			if($width > $widthFormat || $height > $heightFormat){

				//resize image

				$img_src=imagecreatefromjpeg($path);
				$dest=imagecreatetruecolor($widthFormat,$heightFormat);
				imagecopyresampled($dest,$img_src,0,0,0,0,$widthFormat,$heightFormat,$width,$height);

				//enregistrement de la photo
				if(!imagejpeg($dest,$destination.'/'.$newPath)) 
				{
					echo "<div class='alert alert-danger' role='alert'>
			Une erreur s'est produite !
		  </div>";
				}

				else{//on sauve l'image son nom est uniqid.jpeg
					return $newPath;
				} 

			}

			
			else{ //si la size est ok


				if(move_uploaded_file($path,$destination.'/'.$newPath))
				{
						return $newPath;
				}
				else{echo 'une erreur s\'est produite !';
					echo $path;
				}

			}
	}


	
}

function cleanInput(string $input):string
{

	return trim(strip_tags(($input)));
}

///////////////////envoie de mail/////////////////////////////////////////

function sendMail($adresse,$nom,$jeton){



//	if(isset($_POST['submit'])){

		$content='Bonjour '.$nom.' ! Validez votre inscription en cliquant sur le lien suivant votre_serveur/guitare_app/client/validation.php?jeton='.$jeton;
		$mail = new PHPMailer(true);

		try{

			$mail->SMTPDebug = 2;
			$mail->isSMTP();
			$mail->Host='mail.gandi.net';
			$mail->SMTPAuth=TRUE;
			$mail->Port=587;
			$mail->Username='';//votre webmail
			$mail->Password='';//votre mot de pass


			//expe

			$mail->setFrom('mighty.guitarshop@shop.com','Admin');
			$mail->addAddress($adresse,$nom);

			//content

			$mail->isHTML(TRUE);
			$mail->Subject='Confirmez votre inscription !';
			$mail->Body=$content;


			//envoie

			$mail->send();
			return true;
			
		}

		catch (Exception $error){


		}
///	}
}

////////////////////////envoie d'une newsletter


function sendNewsletter(Utilisateur $user, string $content, string $subject){



	if(isset($_POST['submit'])){

		$content='Bonjour '.$user->getNomUtilisateur().'! <br>'.$content;
		$mail = new PHPMailer(true);

		try{

			$mail->SMTPDebug = 2;
			$mail->isSMTP();
			$mail->Host='mail.gandi.net';
			$mail->SMTPAuth=TRUE;
			$mail->Port=587;
			$mail->Username='';//votre webmail
			$mail->Password='';//votre pass


			//expe

			$mail->setFrom('mighty.guitarshop@shop.com','MGS');
			$mail->addAddress($user->getMail(),$user->getNomUtilisateur());

			//content

			$mail->isHTML(TRUE);
			$mail->Subject=$subject;
			$mail->Body=$content;


			//envoie

			$mail->send();
			header('location:newsletter.php?flag=1');
		}

		catch (Exception $error){


		}
	}
}

function order($a,$b){
	
		if(getNomObject($a) == getNomObject($b)){
			return 0;
		}
		else if(getNomObject($a) < getNomObject($b)){
			return -1;
		}
		else{
			return 1;
		}
	
	
}
function saveNewsletter(string $subject, string $content):bool 
{

	$PDO=connexion_bdd();
	$data=array(':subject'=>$subject,':content'=>$content);
	$query='INSERT INTO message (content,dateEnvoie,subject)VALUES(:content,(SELECT now()),:subject)';
	if($requete=$PDO->prepare($query)){
		if($requete->execute($data)){
			return TRUE;
		}
		else{

			return FALSE;
		}
	}
}
