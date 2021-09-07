<?php
session_start();
include 'fonction.php';
if(isset($_POST['submit']))
{
	if(!empty($_POST['mail']) AND !empty($_POST['password'])  )
	{
		$mail=verification_mail($_POST['mail']);
		$password=verification($_POST['password']);

		$select=$bdd->PREPARE("SELECT * FROM clients WHERE motdepasse=? AND mail=?  ");
		$select->EXECUTE(array($password,$mail));

		$infoo=$select->fetch();

		$nombre = $select->rowcount();
		
		if($nombre==1)
		{

			$_SESSION['id_client']=$infoo['id_client'];
			header("location:index.php");

		}
		else
		{
			$erreur="Veillez revoir vos identifiants de connexion";
		}
	}
	else
	{
		$erreur="Veillez bien remplir les champs";
	}
}



?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/login.css">
    <title>LOGIN CLIENT</title>
    <meta charset="utf-8">

</head>

<body>
    <h3 class="text-center">DJAWAO client Login</h3>
    <form action="" method="post" class="form">

        <div class="image">
            <img src="public/img/avatar04.png" alt="" srcset="" class="img img-circle "
                style="width:100px;height:100px;">
        </div>
        <?php
if(isset($erreur) && !empty($erreur))
{
    ?>
        <h3 class="alert alert-warning text-center">
            <?=$erreur;?>
        </h3>
        <?php
}

?>
        <h3 class="text-center">LOGIN</h3>
        <div class="form-group">
            <label>Email : </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                <input type="email" name="mail" placeholder="Ex:guidjo@gmail.com" required="" class="form-control">
            </div>

        </div>

        <div class="form-group">
            <label>Password : </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input type="password" name="password" required="" class="form-control">
            </div>

        </div>

        <div class="form-group">

            <input type="submit" name="submit" value="Login" class="btn btn-success form-control">
        </div>


        <div class="text-center "> MOT DE PASSE OUBLIE <a href="passwordforgot.php?reset=oui&amp;type=client">ici</a>
            <div class="text-center "> Vous n'avez pas un compte? <a href="register_client.php">Créé</a>
            </div>
    </form>


</body>

</html>