<?php

session_start();
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
	
    <title>Document</title>
</head>

<body class="container-fluid">

    <?php
		include 'include/panier_fonction.php';
		#include 'add_panier.php';
		include 'fonction.php';

			
?>
    <div class="row mb-5" style="margin-bottom:2vh">
        <?php  include 'entete.php'; ?>
    </div>
    <!--la div pour afficher les trois derniers articles-->


    <div class="row">
        <h3 class=text-center>Les nouveaux produits </h3>

        <?php
    $select=$bdd->PREPARE("SELECT * FROM produits ORDER BY id_prod DESC LIMIT 3");
    $select->EXECUTE();

    $liste=$select->fetchall();

    foreach ($liste as $key) {
		?>

        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card ">
                <div class="card-header ">
                    <div class="card-img-top  text-center">
                        <a
                            href="detail.php?identifiant=<?php echo($key['id_prod']);?>&amp;produit=<?php echo($key['libelle']);?>"><img
                                src="public/img/image1.jpg" alt="<?php echo($key['libelle']);?>"
                                class="img img-responsive card_image"></a>
                    </div>
                </div>
                <div class="card-body">
                    <p><label>Description: <?php echo(substr($key["description"],0,3).'...' );?></label></p>
                    <div class="card-link text-center btn_achat">
                        <a class=" text-center "
                            href="include/panier.php?action=ajout&amp;l=<?php echo($key['libelle']);?>&amp;q=1&amp;p=<?php echo($key['prix_unitaire']);?>"><button
                                class="btn btn-primary">ajouté <span
                                    class="glyphicon glyphicon-shopping-cart"></span></button></a>
                    </div>

                </div>

            </div>


        </div>

        <?php
 
    }


    ?>
    </div>
    <!--liste des produits les plus vendus-->

    <div class="row">
        <h3 class='text-center'>Les ploduits les plus vendus</h3>
        <?php
			//
			

			$select=$bdd->PREPARE("SELECT * FROM boutique ");
			$select->EXECUTE();

			$liste=$select->fetchall();


			foreach ($liste as $key) {

				echo('<br>'.$key["nom"]);

				$select2=$bdd->PREPARE("SELECT * FROM vendus WHERE boutique=? ORDER BY quantite DESC LIMIT 3");
				$select2->EXECUTE(array($key['id_boutique']));

				$liste2=$select2->fetchall();

				foreach ($liste2 as $key2) {
					echo('<br>'.$key2["libelle"]."SALUT");
					
					# code...
				}
				
				# code...
			}
		?>

    </div>

    <div class="row">

        <h3 class='text-center'>Les autres produits</h3>

        <?php


			$select=$bdd->PREPARE("SELECT * FROM sous_categories2");
			$select->EXECUTE();

			$liste = $select->fetchall();
			foreach ($liste as $produit) {
				# code...
				$select=$bdd->PREPARE("SELECT * FROM produits WHERE souscat_id=?");
				$select->EXECUTE(array($produit["id_souscat2"]));

				$info=$select->fetchall();
						
						foreach ($info as $produit) 
						{
							
								?>
							<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
								<div class="card ">
									<div class="card-header ">
										<div class="card-img-top">
											<a
												href="detail.php?identifiant=<?php echo($produit['id_prod']);?>&amp;produit=<?php echo($produit['libelle']);?>"><img
													src="public/img/image2.jpg" alt="<?php echo($produit['libelle']);?>"
													class="img img-responsive card_image"></a>
										</div>
									</div>
									<div class="card-body">
										<p><label>Description: <?php echo(substr($produit["description"],0,3).'...' );?></label></p>
										<div class="card-link text-center btn_achat">
											<a
												href="include/panier.php?action=ajout&amp;l=<?php echo($produit['libelle']);?>&amp;q=1&amp;p=<?php echo($produit['prix_unitaire']);?>"><button
													class="btn btn-primary ">ajouté <span
														class="glyphicon glyphicon-shopping-cart"></span></button></a>
										</div>

									</div>
								</div>


							</div>


    <?php
	}
		}
	?>
	    </div>

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