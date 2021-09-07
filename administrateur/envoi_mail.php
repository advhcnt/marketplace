<?php
include 'fonction.php';
if(isset($_GET["patron"]) AND isset($_GET['vendeur']) AND !empty($_GET["patron"]) AND !empty($_GET["vendeur"]) AND is_numeric($_GET["vendeur"]))
{
	if($_GET["patron"] =="nouveau" OR $_GET["patron"] =="ancien")
	{
		$select = $bdd->PREPARE("SELECT * from attente WHERE id_attente=?");
		$select->EXECUTE(array($_GET["vendeur"]));

		$nombre = $select->rowcount();

		if($nombre==1)

		{
			$to = "advhcnt23@gmail.com";

			$sujet ="Inscription Vendeur sur DJAWAO " ;


			$lien = '<a style="color: red" href="tb_vendeur.php?patron='.$_GET["patron"].'&amp;id_vendeur='.$_GET["vendeur"].' "> ici</a>';
			#echo($lien);

			$message ='<h4 style="color: green;">Bienvenue sur notre plateforme de vente en ligne  DJAWAO</h4>
				<p>Nous vous remercions vraiment pour votre inscrisption et la confiance que vous nous placé. Nous vous envoyons ce message en vous informant que après l\'etude de votre dossier de 
				soumission vous êtes éligible pour vendre sur DJAWAO. Pour vous connecter à votre tablo de bord, 
				veillez clicquez'.'<a style="color: red" href="http://127.0.0.1/marketplace/vendeur/tb_vendeur.php?patron='.$_GET["patron"].'&amp;id_vendeur='.$_GET["vendeur"].' "> ici</a>';
				#echo ($message);



			$heading="MINE-Version : 1.0\n";
			$heading .="From : advhcnt23@gmail.com\n ";
			$heading.="Replay-to : djawao@gmail.com\n";
			$heading.="Cc : georges@gmail.com\n";
			$heading.="Bc : adv@gmail.com\n";
			$heading.="X-Priority : 1\n";
			$heading.="Content-type: text/html\n";


			if(mail($to,$sujet,$message,$heading))
			{
				echo "Mail envoyé avec succès";

			}
			else
			{
				echo "Mail  non envoyé, Veillez revoir votre adresses email";
			}




		?>

			<!--<!DOCTYPE html>
			<html>
			<head>
				<title></title>
			</head>
			<body>
				<h4 style="color: green;">Bienvenue sur notre plateforme de vente en ligne  DJAWAO</h4>
				<p>Nous vous remercions vraiment pour votre inscrisption et la confiance que vous nous placé. Nous vous envoyons ce message en vous informant que après l'etude de votre dossier de soumission vous êtes éligible pour vendre sur DJAWAO. Pour vous connecter à votre tablo de bord, veillez clicquez <a style="color: red" href="http://127.0.0.1/marketplace/vendeur/tb_vendeur.php?patron=<php// echo($_GET['patron']);?>&amp;id_vendeur=<php //echo($_GET['vendeur']);?>"> ici</a></p>
				
			</body>
			</html>-->
		<?php
		}

	}

	
}

?>
