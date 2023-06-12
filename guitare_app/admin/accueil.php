<?php
include(__DIR__.'/../includes/page.inc.php');
include('headerAdmin.php');
/////////////////////page d'administration de l'appli
?>

<!DOCTYPE html>

<html>

	<head>
		<meta charset='utf-8'>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
		<title>Accueil</title>
		
	</head>
	<body>
	<div class="container-fluid">

		<div class="card">
  			<div class="card-header">
				<h2>Bienvenue <?= $user->getPrenom()?></h2>
			</div>
		<div class="card-body">
				<p>Bienvenue sur l'espace d'administration du Mighty Guitar Shop !</p>
		</div>
		<div class="card-footer">
				<a href="index.admin.php" class="btn btn-primary">Se rendre sur l'espace admin</a>
				<a href="log.out.admin.php" class="btn btn-primary">Se déconnecter</a>
			</div>
		</div>
	</div>
	</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
	</body>

</hmtl>
