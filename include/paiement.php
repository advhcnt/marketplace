<?php
session_start();
if(isset($_SESSION['panier']))
{
    include('panier_fonction.php');
    include("paypal.php");
    $bdd = new PDO("mysql:host=localhost;dbname=marquetplace","root","");
    $shipping=calculPort();
    $tht=montantGlobal();
    $totaltva=MontanTva();
    $total = $shipping+$tht+$totaltva;
    if(isset($_GET["moyendepaiement"]) and !empty($_GET["moyendepaiement"]))
    {	
        

        $moyen=filter_input(INPUT_GET,'moyendepaiement',FILTER_SANITIZE_SPECIAL_CHARS);

        if(!empty($moyen))
        {
            if($moyen=="paypal")
            {
                print_r(array("shiping"=>$shipping,"prix"=>$tht,"tva"=>$totaltva,"total"=>$total));
                $paypal=new Paypal();
                
                $params=array(
                    'RETURNURL' =>'http://127.0.0.1/marketplace/acheteur/userspace/process.php',
                    'CANCELURL'=>'http://127.0.0.1/marketplace/acheteur/userspace/cancel.php',

                    'PAYMENTREQUEST_0_AMT'=> $total,
                    'PAYMENT_O_CURRENCYCODE'=>'EUR',
                    'PAYMENTREQUEST_0_SHIPPINGAMT'=>$shipping,
                    'PAYMENTREQUEST_0_ITEMAMT'=>$tht+$total

                );
                $nbproduit=count($_SESSION['panier']['libelleProduit']);
                $prix=$tht+$total;
                $quantite="";
                $libelle="";
                $boutique="";

                for ($i=0; $i <$nbproduit ; $i++)
                { 
                    
                    //id_bondecommande	produit_id		quantite	prix	ville	moyen	jour	client	boutique

                    $select = $bdd->PREPARE("SELECT boutique from produits WHERE libelle=?");
                    $select->EXECUTE(array($_SESSION['panier']['libelleProduit'][$i]));
                    $produit=$select->FETCH();
                    
                    $boutique .=strval($produit["boutique"])." ";
                    $quantite .=$_SESSION['panier']['qteProduit'][$i]." ";
                    $libelle .=$_SESSION['panier']['libelleProduit'][$i]." ";
                    
                    
                }
                //insertion
                $jour=date("Y/m/d");
                #echo($quantite);
            
                $insert = $bdd->PREPARE("INSERT INTO bon_command values(?,?,?,?,?,?,?,?,?)");
                $insert->EXECUTE(array("",$libelle,$quantite,$prix,$_SESSION['ville'],$_SESSION['coursier'],$jour,$_SESSION['id_client'],$boutique));

                $select = $bdd->PREPARE("SELECT * FROM bon_command WHERE client =? ORDER BY id_bondecommande DESC limit 1");
                $select->EXECUTE(array($_SESSION['id_client']));
                $bon_commande=$select-> fetch();

                $bon_command = $bon_commande["id_bondecommande"];

                $nbproduit=count($_SESSION['panier']['libelleProduit']);

                for ($i=0; $i <$nbproduit ; $i++)
                { 
                    $select = $bdd->PREPARE("SELECT  id_prod,boutique from produits WHERE libelle=?");
                    $select->EXECUTE(array($_SESSION['panier']['libelleProduit'][$i]));
                    $produit=$select->FETCH();

                    #	idcmd	libelle	qte	prix	jour	heure	boutique	boncommand	etat

                    $libelle = $_SESSION['panier']['libelleProduit'][$i];
                    $qte = $_SESSION['panier']['qteProduit'][$i];
                    $prix = $_SESSION['panier']['prixProduit'][$i]*$qte;
                    $heure = date("H:i:s");
                    $boutique = $produit['boutique'];


                    $insert = $bdd->PREPARE("INSERT INTO commandes(libelle,qte,prix,jour,heure,boutique,boncommand,etat) values(?,?,?,?,?,?,?,?)");
                    $insert->EXECUTE(array($libelle,$qte,$prix,$jour,$heure,$boutique,$bon_command,"En entente"));
                    print_r(array($libelle,$qte,$prix,$jour,$heure,$boutique,$bon_command,"En entente"));
                    echo("<br> $bon_command");
                }

                
                unset($_SESSION['panier']);
                
                header("location:../acheteur/userspace");

                $response=$paypal->request('SetExpressCheckout',$params);

                if ($response){
                    #https://www.sandbox.paypal.com/checkoutnow?token=
                    $paypal='https://sandbox.paypal.com/webscr?cmd=express-Checkout&useraction=commit&token='.$response['TOKEN'].' ';
                }
                else
                {
                    var_dump($paypal->errors);
                    die("erreur");
                                    
                }
            }
            else if($moyen=="stripe")
            {
                print_r(array("shiping"=>$shipping,"prix"=>$tht,"tva"=>$totaltva,"total"=>$total));
                $nbproduit=count($_SESSION['panier']['libelleProduit']);
                ?>
    <script>
    alert("salut la famille");
    </script>
    <?php

                for ($i=0; $i <$nbproduit ; $i++)
                { 
                    //id_bondecommande	produit_id	boutique_id	quantite	prix	ville	moyen	jour	client	boutique
                    $select = $bdd->PREPARE("SELECT  id_prod,boutique from produits WHERE libelle=?");
                    $select->EXECUTE(array($_SESSION['panier']['libelleProduit'][$i]));
                    $produit=$select->FETCH();
                    $jour=date("d/m/Y");
                    echo($jour);
                    echo("Produit_id=".$produit['id_prod']);
                    
                    #echo("Produit_id=".$produit['id_prod'].",boutique_id=".$produit['boutique_id'],quantite=$_SESSION['panier']['qteProduit'][$i],prix=$_SESSION['panier']['prixProduit'][$i]*$_SESSION['panier']['qteProduit'][$i], ville=$_SESSION['ville'], moyen=$_SESSION['coursier'], jour=$jour,client=$_SESSION['id_client']");
                } 
            }
            else if($moyen=="momo")
            {
                $nbproduit=count($_SESSION['panier']['libelleProduit']);
                for ($i=0; $i <$nbproduit ; $i++)
                    { 
                
            //id_bondecommande	produit_id	boutique_id	quantite	prix	ville	moyen	jour	client	boutique
                    $select = $bdd->PREPARE("SELECT  id_prod,boutique from produits WHERE libelle=?");
                    $select->EXECUTE(array($_SESSION['panier']['libelleProduit'][$i]));
                    $produit=$select->FETCH();
                    $jour=date("d/m/Y");
                    #echo("Produit_id=$produit['id_prod'],boutique_id=$produit['boutique_id'],quantite=$_SESSION['panier']['qteProduit'][$i],prix=$_SESSION['panier']['prixProduit'][$i]*$_SESSION['panier']['qteProduit'][$i], ville=$_SESSION['ville'], moyen=$_SESSION['coursier'], jour=$jour,client=$_SESSION['id_client']");
                
                    } 
            }
            else if($moyen=="flooz")
            {
                $nbproduit=count($_SESSION['panier']['libelleProduit']);
                                    for ($i=0; $i <$nbproduit ; $i++)
                                    { 
                    //id_bondecommande	produit_id	boutique_id	quantite	prix	ville	moyen	jour	client	boutique
                    $select = $bdd->PREPARE("SELECT  id_prod,boutique from produits WHERE libelle=?");
                    $select->EXECUTE(array($_SESSION['panier']['libelleProduit'][$i]));
                    $produit=$select->FETCH();
                    $jour=date("d/m/Y");
                #echo("Produit_id=$produit['id_prod'],boutique_id=$produit['boutique_id'],quantite=$_SESSION['panier']['qteProduit'][$i],prix=$_SESSION['panier']['prixProduit'][$i]*$_SESSION['panier']['qteProduit'][$i], ville=$_SESSION['ville'], moyen=$_SESSION['coursier'], jour=$jour,client=$_SESSION['id_client']");
            
                                    } 
            }
            else
            {
                header("location:error404.php");
            }
        }
    }


    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../public/css/bootstrap.min.css">
        <link rel="stylesheet" href="../public/css/ionicons.min.css">
        <link rel="stylesheet" href="../acheteur/userspace/style.css">
        <title>Paiement de la commande</title>
    </head>

    <body>
        <div class="container">
            <div class="row">
                <?php include("../acheteur/entete.php");?>
            </div>
            <div class="row" style="margin-top:90px">
                <div class="row">
                    <h4 class="text-center text-decoration-underline">Détail de la commande</h4>


                    <div class="card col-xs-12 col-lg-12">
                        <table class="table table-bordered table-condensed table-responsive table-striped text-center">
                            <thead class="bg-primary ">
                                <tr>
                                    <td>Produit</td>
                                    <td>Quantité</td>
                                    <td>PU</td>
                                    <td>TOtal</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                
                                $nbproduit=count($_SESSION['panier']['libelleProduit']);
                                    for ($i=0; $i <$nbproduit ; $i++)
                                    { 
                                    ?>
                                <tr>
                                    <td><?php echo($_SESSION['panier']['libelleProduit'][$i]);?></td>
                                    <td><?php echo($_SESSION['panier']['qteProduit'][$i]);?></td>
                                    <td><?php echo($_SESSION['panier']['prixProduit'][$i]);?> €</td>
                                    <td><?php echo($_SESSION['panier']['prixProduit'][$i]*$_SESSION['panier']['qteProduit'][$i]);?>
                                        €</td>
                                </tr>
                                <?php 
                                    } 
                                    
                                ?>
                                <tr>
                                    <td colspan="2"><strong>Shiping:</strong></td>
                                    <td colspan="2"><?=$shipping;?> €</td>

                                </tr>
                                <tr>
                                    <td colspan="2"><strong>TVA:</strong></td>
                                    <td colspan="2"><?=$totaltva;?> €</td>

                                </tr>
                                <tr>
                                    <td colspan="2"><strong>Total:</strong></td>
                                    <td colspan="2"><?=$total;?> €</td>

                                </tr>
                            </tbody>


                        </table>
                    </div>
                </div>
                <div class="row text-center">
                    <h3 class="text-center">
                        Payer votre commande par :

                    </h3>
                    <ul class="list list-unstyled list-inline">
                        <li><a href="?moyendepaiement=momo"><img src="public/img/momo.png" alt="MoMo" srcset=""
                                    style="width:105px;height:50px"></a> </li>
                        <li><a href="?moyendepaiement=flooz"><img src="public/img/flooz.jpeg" alt="MoMo" srcset=""
                                    style="width:105px;height:50px"></a> </li>
                        <li><a href="?moyendepaiement=paypal"><img src="public/img/paypal.png" alt="MoMo" srcset=""
                                    style="width:105px;height:50px"></a> </li>
                        <li><a href="?moyendepaiement=stripe"><img src="public/img/stripe.png" alt="MoMo" srcset=""
                                    style="width:105px;height:50px"></a> </li>


                    </ul>
                </div>
            </div>


            <div class="row">
                <?php include("../footer.php");?>
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
    header("location:../acheteur/");
}

?>