<?php
session_start();
include 'panier_fonction.php';
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
    <link rel="stylesheet" href="panier.css">

    <title>le panier</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include("../acheteur/entete.php");?>
        </div>
        <div class="row tableau">
            <?php
$bdd = new PDO("mysql:host=localhost;dbname=marquetplace","root","");
$_SESSION['pseudo']="toto";
$_SESSION['password']="bigeboss";
$_SESSION['email']="adv@gmail.com";
#require('includes/header.php');
#require('panier_fonction.php');
include('paypal.php');
$erreur=false;
$action=(isset($_POST['action'])? $_POST['action']:(isset($_GET['action'])?$_GET['action']:null));
if ($action !==null) {
	if (!in_array($action, array('ajout',"suppression","refresh")))


	
		$erreur=true;
		$l=(isset($_POST['l'])? $_POST['l']:(isset($_GET['l'])?$_GET['l']:null));
		$q=(isset($_POST['q'])? $_POST['q']:(isset($_GET['q'])?$_GET['q']:null));
		$p=(isset($_POST['p'])? $_POST['p']:(isset($_GET['p'])?$_GET['p']:null));

		$l = preg_replace('#\v#', '',$l);
		$p = floatval($p);

		if (is_array($q))
		{      
			$QteArticle = array();       
			$i=0;    
			  
			foreach ($q as $contenu)
			{         
				$QteArticle[$i++] = intval($contenu);      
			} 

		}   
		else
		
			$q = intval($q); 
		

	if (!$erreur) 
		{
			switch ($action) {
				case 'ajout':

						if ($_SESSION['pseudo'] && $_SESSION['password'] && $_SESSION['email']){
							AjouterArticle($l,$q,$p);
							
							header('location:http://127.0.0.1/marketplace/acheteur/index.php');
						}
						else
						{
							$erreur ="Achat impossible veillez bien vous identifiez pour continuer";
						}
					
						break;

				case 'suppression':
					supprimerArticle($l);
					header("location:panier.php");
						
					break;

				case "refresh" :         
						for ($i = 0 ; $i < count($QteArticle) ; $i++)         
						{            
							modifierQTeArticle($_SESSION['panier']['libelleProduit'][$i],round($QteArticle[$i])); 
						}         
						break;
				Default:
					
				break;
			}
		}

}

?>
            <a href="http://127.0.0.1/marketplace/acheteur/" style="margin-top:250px"><button class="btn btn-success " style="margin-top:30px">Retour</button></a>
            <form action=" " method="POST" class="form">
                <h3 class="text-center bg-primary" colspan="4">Votre Panier</h3>
                <table width="500" class="table">
                    <thead class="bg-success">
                        <tr>
                            <td>Libelle Produit </td>
                            <td>Prix unitaire </td>
                            <td>Quantité </td>
                            <td>TVA </td>
                            <td>Action </td>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
 	if (isset($_GET['deletepanier']) && $_GET['deletepanier']==true) {
 		supprimePanier();
 	}
 		if (creationPanier()) {
 			
 		
	 		$nbproduit=count($_SESSION['panier']['libelleProduit']);

	 		if ($nbproduit<=0) {
	 			
	 			echo "<b style='text-align:center;font-size:20px;color:red;'>Oooops votre panier est vide</b>";
	 			
	 		}
	 		else{
	 			$tht=montantGlobal();
	 			$totaltva=MontanTva();
	 			#$shipping=calculPort();
	 			/*$paypal=new Paypal();
	 			$params=array(
	 				'RETURNURL' =>'http:127.0.0.1/site_e_commerce/process.php',
	 				'CANCELURL'=>'http:127.0.0.1/site_e_commerce/cancel.php',

	 				'PAYMENTREQUEST_0_AMT'=> $totaltva+$shipping,
	 				'PAYMENT_O_CURRENCYCODE'=>'EUR',
	 				'PAYMENTREQUEST_0_SHIPPINGAMT'=>$shipping,
	 				'PAYMENTREQUEST_0_ITEMAMT'=>$totaltva

	 			);

	 			$response=$paypal->request('SetExpressCheckout',$params);

	 			if ($response){
	 				$paypal='https://sandbox.paypal.com/webscr?cmd=express-Checkout&useraction=commit&token='.$response['TOKEN'].' ';
	 			}
	 			else
	 			{
	 				var_dump($paypal->errors);
	 				die("erreur");
	 				
	 			}
	 			*/
	 			for ($i=0; $i <$nbproduit ; $i++) { 
	 				?>
                        <tr>
                            <td><?php echo($_SESSION['panier']['libelleProduit'][$i]);?></td>
                            <td><?php echo($_SESSION['panier']['prixProduit'][$i]);?> €</td>
                            <td><input type="text" name="q[]"
                                    value="<?php echo($_SESSION['panier']['qteProduit'][$i]);?>" size="5">

                            <td>18 %</td>
                            <td><a
                                    href="panier.php?action=suppression&amp;l=<?php echo rawurlencode($_SESSION['panier']['libelleProduit'][$i]);?>">X</a>
                            </td>
                        </tr>
                        <?php } 
	 				
					?>
                        <tr>
                            <td colspan="2">
                                <p>MONTANT : <?php echo $tht;?> €</p>
                                <p>MONTANT TVA : <?php echo $tht*0.18;?>€</p>
                                <p>MONTANT TTC : <?php echo $tht+$tht*0.18 ;?> €</p>
                                <!--<p>Frais de Port : <--<?php //echo $shipping;  ?> ->€</p>	-->

                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <!--<a href="?php// echo $paypal  ;?>"><input type="button" value="Payer la commande"></a>-->

                                <input type="submit" value="rafraichir" class="btn btn-primary">
                                <input type="hidden" name="action" value="refresh">
                                <a href="?deletepanier=true"><input type="button" name="" class="btn btn-seconary"
                                        value="suppression panier"></a>
                            </td>
                        </tr>

                        <?php 
	 			
	 			
	 			}


 			}

 		
 	?>
                    </tbody>
                </table>


            </form>


            <?php
if ($nbproduit>0)
{
	if(isset($erreur) && !empty($erreur))
	{
		?>
            <div class="row text-center">
                <h2 class='text-center text-warning'><?=$erreur;?></h2>
                <a href="connect.php" class="link text-center">Cliquez ici pour vous connectez à votre compte</a>
            </div>

            <?php
		
	}
	else
	{
		?>
            <a href="moyendelivraison.php?action=info_de_livraison"><button class="btn btn-success ">Passer à l'etape
                    suivant </button></a>
            <?php
	}
	
}
?>
        </div>

        <div class="row">
            <?php include("../footer.php");?>

        </div>


        <script src="../public/js/jquery.min.js "></script>
        <script src="../public/js/bootstrap.min.js "></script>
        <script src="../public/js/bootstrap.min.js.map "></script>
        <script src="../public/js/popover.js "></script>
        <script src="../public/js/tooltip.js "></script>
        <script src="../public/js/carousel.js "></script>
        <script src="../public/js/collapse.js "></script>
        <script src="../public/js/monjs.js "></script>
    </div>


</body>

</html>