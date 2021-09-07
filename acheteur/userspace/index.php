<?php
session_start();
if(isset($_SESSION['id_client']) && !empty($_SESSION['id_client']) && intval($_SESSION['id_client']))
{
    include '../../include/panier_fonction.php';
	#include 'add_panier.php';
	include '../fonction.php';

    #-----------------------------toutes les commandes

    $select = $bdd->PREPARE("SELECT * FROM bon_command WHERE client=?");
    $select->EXECUTE(array($_SESSION['id_client']));

    $nomrbre = $select->rowcount();

    $commandes=$select->fetchall();

    #-----------------------------Commandes en cours

    $select = $bdd->PREPARE("SELECT * FROM commandes,bon_command WHERE client=? AND etat = ? AND id_bondecommande=commandes.boncommand  ");
    $select->EXECUTE(array($_SESSION['id_client'],"En entente"));

    $nomrbre_cours = $select->rowcount();

    $commandes_cours=$select->fetchall();

    #-----------------------------Commandes annulée

    $select = $bdd->PREPARE("SELECT * FROM commandes,bon_command WHERE client=? AND etat=? AND id_bondecommande=commandes.boncommand  ");
    $select->EXECUTE(array($_SESSION['id_client'],"Annulee"));

    $nomrbre_annulees = $select->rowcount();

    $commandes_annulees=$select->fetchall();



     #-----------------------------Commandes terminées

     $select = $bdd->PREPARE("SELECT * FROM commandes,bon_command WHERE client=?  AND etat=? AND id_bondecommande=commandes.boncommand  ");
     $select->EXECUTE(array($_SESSION['id_client'],"Terminee"));
 
     $nombre_terminees = $select->rowcount();
 
     $commandes_terminees=$select->fetchall();

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/ionicons.min.css">
    <link rel="stylesheet" href="style.css">
    <title>USER SPACE</title>
    <style>
    .boutons {
        width: 100px;
    }
    </style>
</head>

<body>
    <div class="container-fluid ">
        <div class="row lenav">
            <?php  include("../entete.php"); ?>
        </div>
        <div class="row ">
            <div class="row profil">

                <div class="text-center">
                    <div>
                        <figure class="">
                            <div>
                                <img src="http://127.0.0.1/marketplace/acheteur/avatar.jpg"
                                    class="img img-responsive img-circle" alt="" srcset=""
                                    style="margin-left: auto;margin-right: auto;">
                                <div class="justify-content-center">
                                    <a class="" href="#"> <span class="glyphicon glyphicon-camera camera"></span></a>
                                </div>

                            </div>

                            <figcaption class="caption"><a href="#" class="lien_info"><strong>ADV hcnt</strong></a>
                            </figcaption>
                        </figure>
                    </div>

                    <div class="">
                        <ul class="list list-unstyled list-inline">
                            <li><a href="#" class="link lien_info">Changer votre Mot de passe</a></li>
                            <li><a href="#" class="link lien_info">Changer votre Email</a></li>
                            <li><a href="deconnexion.php" class="link lien_info">Deconnexion</a></li>
                        </ul>
                    </div>

                </div>


            </div>
            <div class="row " style="margin-top:50px">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-8 col-md-3 col-lg-3 ">
                        <table class=" table table-bordered border">
                            <tr class=" bg-primary">

                                <td><a href="http://127.0.0.1/marketplace/acheteur/userspace/index.php?commande_etat=tout" class="lien_info link text-dark"><strong>Toutes les commandes</strong>
                                    </a><span class="badge bg-success"
                                        style="background-color:green"><?=$nomrbre;?></span></td>
                            </tr>
                            <tr class=" bg-primary">
                                <td><a href="http://127.0.0.1/marketplace/acheteur/userspace/index.php?commande_etat=entente" class="lien_info link text-dark"><strong>Commandes en cours</strong>
                                    </a><span class="badge bg-success"
                                        style="background-color:blue"><?=$nomrbre_cours;?></span></td>
                            </tr>
                            <tr class=" bg-primary">
                                <td><a href="http://127.0.0.1/marketplace/acheteur/userspace/index.php?commande_etat=termine" class="lien_info link text-dark"><strong>commande terminées</strong>
                                    </a><span class="badge bg-success"
                                        style="background-color:gold"><?=$nombre_terminees;?></span></td>
                            </tr>
                            <tr class=" bg-primary">
                                <td><a href="http://127.0.0.1/marketplace/acheteur/userspace/index.php?commande_etat=annulee" class="lien_info link text-dark"><strong>commande Annulées</strong>
                                    </a><span class="badge bg-success"
                                        style="background-color:brown"><?=$nomrbre_annulees;?></span></td>
                            </tr>

                        </table>
                    </div>
                    <div class="col-xs-12 col-md-9 col-lg-9">
                        <div class="bg-primary ">


                            <?php

                                if(isset($_GET['commande_etat']) && $_GET['commande_etat']=="entente" )
                                {
                                    ?>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="bg-info text-danger">
                                                    <tr>
                                                        <td>N° commande</td>
                                                        <td>Date commande</td>
                                                        <td>Commande</td>
                                                        <td>Montant</td>

                                                    </tr>
                                                </thead>
                                                <tbody class="bg-primary ">
                                                    <?php

                                                        foreach($commandes_cours as $commande)
                                                        {
                                                            ?>
                                                    <tr>
                                                        <td><?=$commande['idcmd'];?></td>
                                                        <td><?=$commande['jour'];?></td>
                                                        <td><?=$commande['libelle'];?> </td>
                                                        <td><?=$commande[6];?> €</td>

                                                    </tr>
                                                    <?php
                                                        }
                                                    ?>

                                                
                                                </tbody>

                                            </table>
                                        </div>
                                    <?php
                                }
                                else if(isset($_GET['commande_etat']) && $_GET['commande_etat']=="annulee")
                                {
                                    ?>
                                    <div class="table-responsive"></div>
                                        <table class="table table-responsive">
                                            <thead class="bg-info text-danger">
                                                <tr>
                                                    <td>N° commande</td>
                                                    <td>Date commande</td>
                                                    <td>Commande</td>
                                                    <td>Montant</td>

                                                </tr>
                                            </thead>
                                            <tbody class="bg-primary ">
                                                <?php

                                                    foreach($commandes_annulees as $commande)
                                                    {
                                                        ?>
                                                <tr>
                                                    <td><?=$commande['idcmd'];?></td>
                                                    <td><?=$commande['jour'];?></td>
                                                    <td><?=$commande['libelle'];?> </td>
                                                    <td><?=$commande[6];?> €</td>

                                                </tr>
                                                <?php
                                                    }
                                                ?>

                                               
                                            </tbody>

                                        </table>
                                    <?php
                                }
                                else if(isset($_GET['commande_etat']) && $_GET['commande_etat']=="termine")
                                {
                                    ?>
                                    <div class="table-responsive"> 
                                        <table class="table table-responsive">
                                            <thead class="bg-info text-danger">
                                                <tr>
                                                    <td>N° commande</td>
                                                    <td>Date commande</td>
                                                    <td>Commande</td>
                                                    <td>Montant</td>

                                                </tr>
                                            </thead>
                                            <tbody class="bg-primary ">
                                                <?php

                                                    foreach($commandes_terminees as $commande)
                                                    {
                                                        ?>
                                                <tr>
                                                    <td><?=$commande['idcmd'];?></td>
                                                    <td><?=$commande['jour'];?></td>
                                                    <td><?=$commande['libelle'];?> </td>
                                                    <td><?=$commande[6];?> €</td>

                                                </tr>
                                                <?php
                                                    }
                                                ?>

                                               
                                            </tbody>

                                        </table>
                                    </div>
                                       
                                    <?php
                                }
                                else if(isset($_GET['commande_etat']) && $_GET['commande_etat']=="tout")
                                {
                                    ?>
                                    <div class="table-responsive">
                                        <table class="table table-responsive">
                                                <thead class="bg-info text-danger">
                                                    <tr>
                                                        <td>N° commande</td>
                                                        <td>Date commande</td>
                                                        <td>Commande</td>
                                                        <td>Montant</td>

                                                    </tr>
                                                </thead>
                                                <tbody class="bg-primary ">
                                                    <?php

                                                        foreach($commandes as $commande)
                                                        {
                                                            ?>
                                                    <tr>
                                                        <td><?=$commande['id_bondecommande'];?></td>
                                                        <td><?=$commande['jour'];?></td>
                                                        <td><?=$commande['produit_id'];?> </td>
                                                        <td><?=$commande['prix'];?> €</td>

                                                    </tr>
                                                    <?php
                                                        }
                                                    ?>

                                                
                                                </tbody>

                                        </table>
                                    </div>
                                        
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div class="table-responsive">

                                        <table class="table table-responsive">
                                                <thead class="bg-info text-danger">
                                                    <tr>
                                                        <td>N° commande</td>
                                                        <td>Date commande</td>
                                                        <td>Commande</td>
                                                        <td>Montant</td>

                                                    </tr>
                                                </thead>
                                                <tbody class="bg-primary ">
                                                    <?php

                                                        foreach($commandes as $commande)
                                                        {
                                                            ?>
                                                    <tr>
                                                        <td><?=$commande['id_bondecommande'];?></td>
                                                        <td><?=$commande['jour'];?></td>
                                                        <td><?=$commande['produit_id'];?> </td>
                                                        <td><?=$commande['prix'];?> €</td>

                                                    </tr>
                                                    <?php
                                                        }
                                                    ?>
                                                </tbody>

                                            </table>
                                    </div>
                                        
                                    <?php
                                }

                            ?>


                        </div>

                    </div>
                </div>


            </div>
        </div>
        <div class="row">
            <?php include("../footer.php"); ?>
        </div>
    </div>
    <script src="../public/js/jquery.min.js "></script>
    <script src="../public/js/bootstrap.min.js "></script>
    <script src="../public/js/bootstrap.min.js.map "></script>
    <script src="../public/js/popover.js "></script>
    <script src="../public/js/tooltip.js "></script>
    <script src="../public/js/carousel.js "></script>
    <script src="../public/js/collapse.js "></script>
    <script src="../public/js/monjs.js "></script>
</body>

</html>
<?php
}
else
{
    header("location:../");
}
?>