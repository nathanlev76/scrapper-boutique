<?php
    $id = $_GET['id'];
    $success = False;
    if(!isset($id)){
        header("Location: http://vps-087c241e.vps.ovh.net/");
    }
    $strJsonFileContents = file_get_contents("products.json");
    $array = json_decode($strJsonFileContents, true);
    foreach($array as $elem){
        if($elem["id"] == $id)
        {
            $success = True;
            $name = $elem["name"];
            $img = $elem["img"];
            $price = str_replace("$", "€", $elem["price"]);
            $tag = $elem["tag"];
            if($tag=="Sale!"){
                $tag = "Promotion";
            }
            else{
                $tag = "Nouveau";
            }
            $desc = $elem["description"];
        }
    }
    if(!$success){
        header("Location: http://vps-087c241e.vps.ovh.net/");
    }
?>   

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title><?=$name?></title>
</head>
<nav class="navbar navbar-light bg-light mb-4">
  <a class="navbar-brand mx-auto" href="http://vps-087c241e.vps.ovh.net/">MyBoutiqueScrapper by Nathan</a>
</nav>
<body>
    <div class="container text-center">
        <h3 class="text-center"><?=$name?>  <span class='badge bg-success mb-2'><?=$tag?></span></h3>
        <img src="<?=$img?>" class="rounded mx-auto d-block" heigth="300" width="300">
        <p class="mt-3 text-center"><?=$desc?></p>
        <button class="btn btn-success text-center">Acheter le produit (<?=$price?>)</button>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>    
</body>
</html>
