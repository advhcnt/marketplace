<?php
session_start();
include("fonction.php");
if(isset($_POST["valide"]))
{
	if (!empty($_POST['boutique']) AND !empty($_POST['ville']) AND !empty($_POST['pays']) AND !empty($_POST['adresse'])) 
	{
		$_SESSION['boutique'] = verification($_POST['boutique']);
		$_SESSION['ville'] = verification($_POST['ville']);
		$_SESSION['pays'] = verification($_POST['pays']);
		$_SESSION['adresse'] = verification($_POST['adresse']);

		header("location:?page=1");


	} 
	

}


?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    
	<link rel="stylesheet" href="public/css/register_vendeur.css">

	<title>SALER'S REGISTER </title>
	<meta charset="utf-8">
</head>
<body>
<h3 class="text-center">Enregistrement d'un nouveau Vendeur</h3>
	

<!-- NIVEAU 2 DE L'INSCRIPTION D'UN VENDEUR -->
<?php
if (isset($_GET['page']))
{
	if($_GET['page']==1)
	{

		if(isset($_POST["valide2"]))
		{
			if(!empty($_POST['propietaire']) AND !empty($_POST['mail']) AND !empty($_POST['telephone']) AND !empty($_POST['pre_propietaire']) )
			{
				$_SESSION['propietaire'] = verification($_POST['propietaire']);
				$_SESSION['pre_propietaire'] = verification($_POST['pre_propietaire']);
				$_SESSION['mail'] = verification_mail($_POST['mail']);
				$_SESSION['telephone'] = verification_num($_POST['telephone']);
				header("location:?page=2");
			}
		}
		?>

		<form action="" method="post" class="form">
				<div class="image">
					<img src="public/img/avatar04.png" alt="" srcset="" class="img img-circle "
						style="width:100px;height:100px;">
				</div>
			
				<div class="form-group">
					<label>NOM Propriétaire</label>
					<input type="text" class="form-control" name="propietaire" required="" placeholder="Nom ou son identifiant sur le site" spellcheck="true" >
				</div>

				<div class="form-group">
					<label> Prenom Propriétaire</label>
					<input type="text" class="form-control" name="pre_propietaire" required="" placeholder="Nom ou son identifiant sur le site" spellcheck="true" >
				</div>

				<div class="form-group">
					<label>Mail</label>
					<input type="email" class="form-control" name="mail" required="" spellcheck="true" >
				</div>

				<div class="form-group">
					<label>Telephone</label>
					<input type="text" class="form-control" name="telephone" required="" spellcheck="true" >
				</div>

				<div class="form-group">
					
						
					
					<input type="submit" class="btn btn-success form-control" name="valide2" value="Envoyer">
				</div>
				

			
		</form>

		<?php

	}
	elseif($_GET['page']==2) 
	{
		if(isset($_POST["valide3"]))
		{
			if(!empty($_POST['ifu']) AND !empty($_POST['rccm']) )
			{
				$_SESSION['ifu'] = verification($_POST['ifu']);
				$_SESSION['rccm'] = verification($_POST['rccm']);
				
				header("location:?page=3");
			}
		}
		?>
		<!-- NIVEAU TROIS DE L'INSCRIPTION d'UN VENDEUR-->

		<form enctype="mulipart/form-data" accept="" method="post" class="form">

				<div class="form-group">
					<label>IFU</label>
					<input type="text" class="form-control" name="ifu" spellcheck="true" >
				</div>

				<div class="form-group">
					<label>RCCM</label>
					<input type="text" class="form-control" name="rccm"  spellcheck="true" >
				</div>

				<div class="form-group">
					<label>fichier</label>
					<input type="file" name="fichier" >
				</div>

				<div class="form-group">
					
						
					
					<input type="submit" class="btn btn-success form-control" name="valide3" value="Envoyer" type="pdf" multiple="">
				</div>
				

			
			
		</form>
		<?php
	}
	elseif($_GET['page']==3) 
	{
		#Si l'information donnée concenant le patron est un id
		if(is_numeric($_SESSION['propietaire']))
		{
			#On verifie l'existence du patron dans la base de donnée
			$select = $bdd->PREPARE("SELECT * FROM patron where id_patron=?");
			$select->EXECUTE(array($_SESSION['propietaire']));

			$nbr=$select->rowcount();
			if($nbr==1)
			{
				#s'il existe alors on utlise son id
				$insert = $bdd->PREPARE("INSERT INTO attente values(?,?,?,?,?,?,?,?,?,?,?,?)");
				$insert->EXECUTE(array("",$_SESSION['boutique'],$_SESSION['adresse'],$_SESSION['pays'],$_SESSION['ville'],$_SESSION['mail'],$_SESSION['telephone'],"","",$_SESSION['propietaire'],$_SESSION['rccm'],$_SESSION['ifu']));

				?>
					<h3>VOTRE DEMANDE A ETE ENVOYE AVEC SUCCES</h3>
					<P>Veillez suivre de près votre adresse mail. Nous vous enverrons un message dans un delai de 24h MINIMUM<br><a href="http://127.0.0.1/marketplace/acheteur/index.php"> Cliquez ici pour continuer à explore notre site.</a></P>

				<?php

			}
			else
			{
				#on retourne une erreur
				header("location : erreur_404.php");
			}

			
		}
		#si ce n'est pas un id
		else
		{
			$insert = $bdd->PREPARE("INSERT INTO attente values(?,?,?,?,?,?,?,?,?,?,?,?)");
			$insert->EXECUTE(array("",$_SESSION['boutique'],$_SESSION['adresse'],$_SESSION['pays'],$_SESSION['ville'],$_SESSION['mail'],$_SESSION['telephone'],$_SESSION['propietaire'],$_SESSION['pre_propietaire'],"",$_SESSION['rccm'],$_SESSION['ifu']));

			?>
				<h3>VOTRE DEMANDE A ETE ENVOYE AVEC SUCCES</h3>
				<P>Veillez suivre de près votre adresse mail. Nous vous enverrons un message dans un delai de 24h MINIMUM<br><a href="http://127.0.0.1/marketplace/acheteur/index.php"> Cliquez ici pour continuer à explore notre site.</a></P>

			<?php
		}
		
		
	}
	else
	{
		header("location:register_vendeur.php");
	}


	
}
else
{
	?>
	<form class="debut form" method="post" action="">

			
			<div class="form-group">
				<label>BOUTIQUE</label>
				<input type="text" class="form-control" name="boutique" required="" spellcheck="true" >
			</div>

			<div class="form-group">
				<label>ville</label>
				<input type="text" class="form-control" name="ville" required="" spellcheck="true" >
			</div>

			<div class="form-group">
				<label>Pays</label>
				<input type="text" class="form-control" name="pays" required="" spellcheck="true" >
			</div>
			<div class="form-group">
				<label>Adresse</label>
				<input type="text" class="form-control" name="adresse" required="" spellcheck="true" >
			</div>

			<div class="form-group">
				
					
				
				<input type="submit" class="btn btn-success form-control" name="valide" value="Envoyer">
			</div>

		
	</form>


	<?php
	
		
}

?>



</body>
</html>