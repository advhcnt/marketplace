<?php session_start();  ?>
<!DOCTYPE html>
<html>
<head>
	<title>Forgot Password</title>
	<meta charset="utf-8">
</head>
<body>
<?php 
include 'fonction.php';
include 'mailpasswordforgot.php';
if (isset($_GET['reset']) and !empty($_GET['reset']))
{
	
	if(isset($_POST['submit']))
	{
		if($_POST['submit']=="valider")
		{
			$mail = verification_mail($_POST['mail']);
			
			$select = $bdd->PREPARE("SELECT * FROM patron WHERE email=?");
			$select->EXECUTE(array($mail));
			if($select)
			{
				for ($i=0; $i <6 ; $i++) 
				{ 
					if($i==0)
					{
						$code=(rand(1,9));
					}
					else
					{
						$code.=(rand(1,9));
					}
					
				}
				$insert = $bdd->PREPARE("INSERT INTO passwordforgot values(?,?,?,?)");
				$insert->EXECUTE(array("",$mail,$code,$_SESSION['type']));
				echo "salut";

				echo(passwordforgotmail($mail,$code));
				if(passwordforgotmail($mail,$code)==1)
				{
					$_SESSION['mail']=$mail;
					header('location:vendeur/pageshtml/forgot-password.php?reset=confirmation');
				}

				
			}

		}
		else if($_POST['submit']=="confirmer")
		{
			$lecode = verification($_POST['lecode']);
			$select=$bdd->PREPARE("SELECT * FROM passwordforgot WHERE mail=? and identifiant=? and genredepersonne=?");
			$select->EXECUTE(array($_SESSION['mail'],$lecode,$_SESSION['type']));
			$nbr=$select->rowcount();

			if($nbr==1)
			{
				if($_SESSION['type']=="client")
				{
					echo "salut vendeur";
				}
				else if($_SESSION['type']=="vendeur")
				{
					echo "salut client";
				}

			}
			else
			{
				echo "erreur";
			}
		}
		

	}

	if($_GET['reset']=="oui")
	{
		$_SESSION['type'] = verification($_GET['type']);
		?>

			<form action="" method="post">
				<input type="email" name="mail" placeholder="atchossou@gmail.com" required="">
				<input type="submit" name="submit" value="valider">
			</form>
		<?php
	}
	else if($_GET['reset']=="confirmation")
	{
		?>

			<form action="" method="post">
				<h3>Veillez entrer le code de confirmation à 8 chiffres envoyé à votre adress mail</h3>
				<input type="text" name="lecode" placeholder="le code de confirmation" required="">
				<input type="submit" name="submit" value="confirmer">
			</form>

		<?php
	}
} 

?>

</body>
</html>