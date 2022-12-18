<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBoutiqueScrapper</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<nav class="navbar navbar-light bg-light mb-4">
  <a class="navbar-brand mx-auto" href="http://vps-087c241e.vps.ovh.net/">MyBoutiqueScrapper by Nathan</a>
</nav>
<body>
    <div class="container">
        <div class="row">
        <?php
            $acceptedPages = [1, 2, 3, 4, 5, 6, 7, 8];
            $selectedPage = $_GET['page'];
            if(!isset($selectedPage)){
                $selectedPage = 1;
            }
            elseif(!in_array($selectedPage, $acceptedPages)){
                $selectedPage = 1;
            }

            $strJsonFileContents = file_get_contents("products.json");
            $array = json_decode($strJsonFileContents, true);
            foreach($array as $elem){
                if($elem["page"] == $selectedPage)
                {
                    $imgurl = $elem["img"];
                    $name = $elem["name"];
                    $id = $elem["id"];
                    $tag = $elem["tag"];
                    $price = str_replace("$", "€", $elem["price"]);
                    if($tag == "Sale!"){
                        $tag = "Promotion";
                    }
                    elseif($tag == "NEW"){
                        $tag = "Nouveau";
                    }
                    echo("<div class='col-md-3'>
                    <div class='card mb-2'>
                        <img src='$imgurl' class='card-img-top'>
                        <div class='card-body'>
                            <span class='badge bg-success mb-2'>$tag</span>
                            <h6 class='card-title'>$name</h6>
                            <p>Prix: <strong>$price</strong></p>
                            <a href='/product.php?id=$id' class='btn btn-primary'>Voir le produit</a>
                        </div>
                    </div>
                </div>");
                }
            }
        ?>
        </div>
        <nav aria-label="Navigation entre les pages">
            <ul class="pagination justify-content-center">
                <?php
                $previousPage = $selectedPage-1;
                $nextPage = $selectedPage-1;
                if(intval($selectedPage) == 1){
                    $button1 = $selectedPage;
                    $button2 = $selectedPage+1;
                    $button3 = $selectedPage+2;

                }
                elseif(intval($selectedPage) == 8)
                {
                    $button1 = $selectedPage-2;
                    $button2 = $selectedPage-1;
                    $button3 = $selectedPage; 
                }
                else{
                    $button1 = $selectedPage-1;
                    $button2 = $selectedPage;
                    $button3 = $selectedPage+1;
                }  
                ?>
                <li class="page-item <?php if($selectedPage == 1){echo "disabled";}?>"><a class="page-link" href="?page=<?=$previousPage?>">Précédent</a></li>
                <li class="page-item <?php if($selectedPage == 1){echo "disabled";}?>"><a class="page-link" href="?page=<?=$button1?>"><?=$button1?></a></li>
                <li class="page-item <?php if($selectedPage != 1 AND $selectedPage != 8){echo "disabled";}?>"><a class="page-link" href="?page=<?=$button2?>"><?=$button2?></a></li>
                <li class="page-item <?php if($selectedPage == 8){echo "disabled";}?>"><a class="page-link" href="?page=<?=$button3?>"><?=$button3?></a></li>
                <li class="page-item <?php if($selectedPage == 8){echo "disabled";}?>"><a class="page-link" href="?page=<?=$selectedPage+1?>">Suivant</a></li>
            </ul>
        </nav>
    </div>  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>  
</body>
</html>

