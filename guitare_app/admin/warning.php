<?php
include(__DIR__.'/../includes/page.inc.php');
$id=$_GET['idSuppression'];
$classe=mb_strtolower($_GET['classe']);

$guitare=GuitareRepo::getGuitareByTag($classe,$id);

?>


<!DOCTYPE html>


<html>
    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>
<body style='display:flex;justify-content:center;'>

<div class="card text-bg-danger mb-3" style="max-width: 18rem;margin-top:200Px;text-align:center">
  <div class="card-header"><h2>Attention !<h2></div>
  <div class="card-body">
    <h5 class="card-title">Cette suppression affectera la ou les guitares suivantes. Cette opération est définitive.</h5>
    <ul class="list-group">
        <?php foreach($guitare as $val):?>
    <li class="list-group-item"><?=$val?></li>
            <?php endforeach?>
    </ul>
    <p>Etes-vous sûr ?</p>
    <a href="<?=$classe?>.php?idSuppression=<?=$id?>" class="btn btn-warning">Oui</a>
    <a href="<?=$classe?>.php" class="btn btn-warning">Non</a>
  </div>
</div>



<!----ON AFFICHE LA LISTE DES GUITARES CONCERNEES---------------------------------->


</body>

</html>
