<?php
session_start();

include 'fonction.php';
if(isset($_SESSION['numero_vendeur']) AND isset($_SESSION['email_vendeur']) AND !empty($_SESSION['numero_vendeur']) AND !empty($_SESSION['email_vendeur']) AND is_numeric($_SESSION['numero_vendeur']) )
{
	
	/*if(isset($_GET['boutique']) AND !empty($_GET['boutique']) AND is_numeric($_GET['boutique']) )
	{
		$select=$bdd->PREPARE("SELECT * FROM boutique WHERE patron=? AND id_boutique=?");
		$select->EXECUTE(array($_SESSION['numero_vendeur'],$_GET['boutique']));
		$info=$select->fetch();
		$boutique=$select->rowcount();
		if($boutique==1)
		{
			?>

<h2>Boutique :
    <? echo($info['nom']); ?>
</h2>

<?php

		}
		else
		{
			header("location:erreur_404.php");
		}

	}*/

	$select=$bdd->PREPARE("SELECT * FROM patron WHERE id_patron=? AND email=?  ");
	$select->EXECUTE(array($_SESSION['numero_vendeur'],$_SESSION['email_vendeur']));

	$nombre = $select->rowcount();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
	

    <title>Dashboard VENDEUR</title>

</head>

<body>
    <div class="container-fluid">
       
        <div class="row">
            <h3 class="bg-success text-center">Dashboard VENDEUR</h3>
            <a href="deconnexion.php"><button class="btn btn-success text-right">Deconnexion</button></a>
            <?php
	
	if($nombre==1)
	{

		$select=$bdd->PREPARE("SELECT * FROM boutique WHERE patron=?");
		$select->EXECUTE(array($_SESSION['numero_vendeur']));

		$boutique=$select->fetchall();

		foreach ($boutique as $key ) 
		{
			# code...
			?>
            <!-- Liste des boutiques du propriétaire-->


            <a href="lesboutiques.php?boutique=<?php echo($key['id_boutique']);?>"><button
                    class="btn btn-success"><?php echo($key['nom']);?></button></a>

            <?php

		}
	}
	else
	{
		header("location:erreur_404.php");
	}


}
else
{
	header("location:login_vendeur.php");
}
?>
        </div>
    </div>



</body>

</html>