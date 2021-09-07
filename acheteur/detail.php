<?php
session_start();
include 'fonction.php';
include '../include/panier_fonction.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/ionicons.min.css">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="userspace/style.css">

    <title>Document</title>
</head>

<body class="container-fluid">
    <div class="container">
        <div class="row lenav">
            <?php  include("entete.php"); ?>
        </div>
    </div>
    <?php

/*Cette page pour afficher les détauils d'un produit spécifiqu et ausssi faire une proposition des produits similaire*/
if(isset($_GET['produit']) and isset($_GET['identifiant']))
{
	$produit=filter_input(INPUT_GET, 'produit',FILTER_SANITIZE_SPECIAL_CHARS);
	$identifiant=filter_input(INPUT_GET, 'identifiant',FILTER_SANITIZE_NUMBER_INT);

	if(!empty($produit) and !empty($identifiant))
	{
		$select=$bdd->PREPARE("SELECT * FROM produits WHERE id_prod=?");
		$select->EXECUTE(array($identifiant));
		$info = $select->fetch();

        $select=$bdd->PREPARE("SELECT * FROM autres_photos WHERE produit=?");
		$select->EXECUTE(array($identifiant));
		$photo = $select->fetch();

        $tableau = explode("-",$photo['photos']);
        
		

		?>
    <div class="row">
        <div class="col-xs-8 col-sm-8 col-md-4">
            <figure>
                <img src="../include/public/photo_produit/<?php echo($info['photo']);?>" alt="le produit" height="200"
                    width="200">
                <figcaption>
                    <p> Prix : <?php  echo($info['prix_unitaire']); ?>F CFA</p>
                    <p>
                        <a
                            href="../include/panier.php?action=ajout&amp;l=<?php echo($info['libelle']);?>&amp;q=1&amp;p=<?php echo($info['prix_unitaire']);?>"><button
                                class="btn btn-success">ajouté <span
                                    class="glyphicon glyphicon-shopping-cart"></span></button>
                        </a>
                    </p>
                </figcaption>
            </figure>

        </div>
        <div class="col-xs-12  col-md-8">
            <p class="text-center">
                <?php echo($info['description']); ?>
            </p>
        </div>



    </div>

    <div class="row">
        <h2 class="text-center bg-success">Autres photos du produit</h2>
        <?php for($i=0;$i<$photo['nombre'];$i++):?>

        <div class=" col-xs-12 col-md-4 col-lg-3"
            style="justify-content:center;text-alingn:center;align-content:center">

            <img src="../include/public/photo_produit/<?php echo($tableau[$i]);?>" alt=""
                class="img-responsive card-img img-thumbnail" height="200" width="200">

        </div>

        <?php endfor ?>


    </div>

    <?php
	}

	?>

    <hr>
    <hr>
    <h3>Articles similaire</h3>



    <?php
	$produit='%'.$produit.'%';
	$select=$bdd->PREPARE("SELECT * FROM produits WHERE id_prod !=? AND libelle  like ?  ");
	$select->EXECUTE(array($identifiant,$produit));
	$info = $select->fetchall();
	$i=0;
	foreach ($info as $prod_similaire) 
	{
		if($prod_similaire['id_prod']!==$produit)
		{
			$i+=1;
			if($i<5)
			{
				?>
    <td>
        <figure>
            <a
                href="detail.php?identifiant=<?php echo($prod_similaire['id_prod']);?>&amp;produit=<?php echo($prod_similaire['libelle']);?>"><img
                    src="../include/public/photo_produit/<?php echo($prod_similaire['phot']);?>" alt="<?php echo($prod_similaire['libelle']);?>"></a>
            <figcaption>
                <p><label>Description: <?php echo(substr($prod_similaire["description"],0,10).'...' );?></label></p>
                <p><a
                        href="../include/panier.php?action=ajout&amp;l=<?php echo($prod_similaire['libelle']);?>&amp;q=1&amp;p=<?php echo($prod_similaire['prix_unitaire']);?>"><button
                            class="btn btn-success">ajouté <span
                                class="glyphicon glyphicon-shopping-cart"></span></button>></a>
                </p>
            </figcaption>
        </figure>
    </td>
    <?php
			}
			else
			{
				$i=1;
				?>
    </tr>
    <tr>
        <td>
            <figure>
                <a
                    href="detail.php?identifiant=<?php echo($prod_similaire['id_prod']);?>&amp;produit=<?php echo($prod_similaire['libelle']);?>"><img
                        src="#" alt="<?php echo($prod_similaire['libelle']);?>"></a>
                <figcaption>
                    <p><label>Description: <?php echo(substr($prod_similaire["description"],0,10).'...' );?></label></p>
                    <p><a
                            href="../include/panier.php?action=ajout&amp;l=<?php echo($prod_similaire['libelle']);?>&amp;q=1&amp;p=<?php echo($prod_similaire['prix_unitaire']);?>"><button
                                class="btn btn-success">ajouté <span
                                    class="glyphicon glyphicon-shopping-cart"></span></button></a>
                    </p>
                </figcaption>
            </figure>
        </td>
        <?php
			}
		
		}
	
	}
}


?>
    </tr>
    <?php include("footer.php"); ?>

    <script src="public/js/jquery.min.js "></script>
    <script src="public/js/bootstrap.min.js "></script>
    <script src="public/js/bootstrap.min.js.map "></script>
    <script src="public/js/popover.js "></script>
    <script src="public/js/tooltip.js "></script>
    <script src="public/js/carousel.js "></script>
    <script src="public/js/collapse.js "></script>
    <script src="public/js/monjs.js "></script>
</body>

</html>