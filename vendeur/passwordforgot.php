<?php session_start();  ?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/login.css">
    <title>Password Forgot</title>
    <meta charset="utf-8">

</head>

<body>
    <?php 
include 'fonction.php';
include 'mailpasswordforgot.php';
if (isset($_GET['reset']) and !empty($_GET['reset']) )
{
	
	if(isset($_POST['submit']))
	{
		if($_POST['submit']=="valider")
		{
			$mail = verification_mail($_POST['mail']);
			
			$select = $bdd->PREPARE("SELECT * FROM clients WHERE mail=?");
			$select->EXECUTE(array($mail));
			if($select)
			{
				for ($i=0; $i <8 ; $i++) 
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
					header('location:passwordforgot.php?reset=confirmation');
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
				header("location:passwordforgot.php?reset=chager_password");
			}
			else
			{
				echo "erreur";
			}
		}
		else if($_POST['submit']=="Changer")
		{
			if(isset($_POST['code']) && isset($_POST['confirmcode']))
			{
				$password=filter_input(INPUT_POST,'code',FILTER_SANITIZE_SPECIAL_CHARS);
				$passwordconfirm=filter_input(INPUT_POST,'confirmcode',FILTER_SANITIZE_SPECIAL_CHARS);

				if(!empty($password) && !empty($passwordconfirm) && $password==$passwordconfirm && strlen($password)>=8)
				{
					if($_SESSION['type']=="client")
					{	
						#Mise à jour du mot de passe	
						$update = $bdd->PREPARE("UPDATE clients set motdepasse=? WHERE mail=?");
						$update->EXECUTE(array($password,$_SESSION['mail']));

						#Suppression de la demande password forgot
						$delete=$bdd->PREPARE("DELETE FROM passwordforgot WHERE mail=?");
						$delete->EXECUTE(array($_SESSION['mail']));

						#vreification et redirection
						$select=$bdd->PREPARE("SELECT * FROM clients WHERE motdepasse=? AND mail=?  ");
						$select->EXECUTE(array($password,$_SESSION['mail']));

						$infoo=$select->fetch();

						$nombre = $select->rowcount();
									
						if($nombre==1)
						{

							$_SESSION['id_client']=$infoo['id_client'];
							header("location:../acheteur/index.php");

								
						}
					}
					else if($_SESSION['type']=="vendeur")
					{
						#Mise à jour du mot de passe
						$update = $bdd->PREPARE("UPDATE patron set mot_de_pass=? WHERE email=?");
						$update->EXECUTE(array($password,$_SESSION['mail']));

						#Suppression de la demande password forgot
						$delete=$bdd->PREPARE("DELETE FROM passwordforgot WHERE mail=?");
						$delete->EXECUTE(array($_SESSION['mail']));

						#vreification et redirection 

						$select=$bdd->PREPARE("SELECT * FROM patron WHERE mot_de_pass=? AND email=?  ");
						$select->EXECUTE(array($password,$_SESSION['mail']));

						$infoo=$select->fetch();

						$nombre = $select->rowcount();
									
						if($nombre==1)
						{

							$_SESSION['numero_vendeur']=$infoo['id_patron'];
							$_SESSION['email_vendeur']=$infoo['email'];
							header("location:../vendeur/vendeur_dashbord.php");

						}
					}
				
				}
				else
				{
					$erreur="Vos deux mot de passe sont incompatibles";
				}
			}
			else
			{
				$erreur="Veillez remplir tout les champs";
			}
		}
		

	}

	if($_GET['reset']=="oui")
	{
		$_SESSION['type'] = verification($_GET['type']);
		?>

    <form action="" method="post" class="form">
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                <input type="email" name="mail" placeholder="atchossou@gmail.com" required="" class="form-control">
            </div>


        </div>
        <div class="form-group">
            <input type="submit" name="submit" value="valider" class="btn btn-success form-control">
        </div>

    </form>
    <?php
	}
	else if($_GET['reset']=="confirmation")
	{
		?>

    <form action="" method="post" class="form">
        <p>Veillez entrer le code de confirmation à 8 chiffres envoyé à votre adress mail</p>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input type="text" name="lecode" placeholder="le code de confirmation" required="" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <input type="submit" name="submit" value="confirmer" class="btn btn-success form-control">

        </div>

    </form>

    <?php
	}
	else if($_GET['reset']=="chager_password")
	{
		?>

    <form action="" method="post" class="form">
        <p>Veillez entrer votre nouveau mot de passe</p>
        <?php 
					if(isset($erreur)){
						?>
        <span class="alert alert-danger bg-danger"><?=$erreur;?></span>
        <?php
					}?>
        <div class="form-group">
            <label for="code">Password</label>
            <div class="input-group">

                <span for="code" class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input type="password" name="code" required="" class="form-control" id="code">
            </div>
        </div>
        <div class="form-group">
            <label for="code1">Confirm Password</label>
            <div class="input-group">
                <span for="code1" class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input type="password" name="confirmcode" required="" class="form-control" id="code1">
            </div>
        </div>
        <div class="form-group">
            <input type="submit" name="submit" value="Changer" class="btn btn-success form-control">

        </div>

    </form>

    <?php
	}
} 

?>

</body>

</html>