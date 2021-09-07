<?php
session_start();

include 'fonction.php';

if (isset($_POST["login"]))
{
	$user = filter_input(INPUT_POST,"mail",FILTER_VALIDATE_EMAIL);
	$mdp = filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);

	if (!empty($user) AND !empty($mdp))
	{
		
		$select = $bdd->PREPARE("SELECT * FROM administrateur WHERE mail=? and mot_de_pass=?");
		$select->EXECUTE(array($user,$mdp));

		$info = $select->fetch();
		$nombre = $select->rowcount();
		if($nombre==1)
		{

			$_SESSION['admin'] = $user;
			$_SESSION['id_admin'] = $info['id_admin'];

			
			header("location:atchossou_tdb.php");
		}
		else
		{
			#header("location:atchossou_login.php?erreur=ADMINISTRATEUR NON RECONNU");
			$erreur = "ADMINISTRATEUR NON RECONNU";
		}

	}

}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/login.css">
    <link rel="shortcut icon" href="public/img/favicon/" type="image/x-icon">
    <title>Admin LOGIN</title>
</head>

<body class="">
    <div class="container conteneur align-items-center  ">
        <div class="row text-center ">
            <img src="public/img/avatar5.png" alt="" class="img img-circle image align-items-center">
        </div>
        <div class="row">
            <div class="col-12">
                <?php 
					if (isset($erreur)) 
					{?>
                <span class="alert alert-danger"><?=$erreur;?></span>
                <?php
					}
				?><!- afficher erreur ->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h3 class="text-center">ADMIN LOGIN</h3>
                <form action="" method="post" class="form">
                    <div class="form-group">
                        <label for="username">USERNAME </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" name="mail" required="" class="form-control" id="username">

                        </div>

                    </div>
                    <div class="form-group">
                        <label for="password">PASSWORD </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" name="password" required="" minlength="8" class="form-control"
                                id="password">
                        </div>

                    </div>
                    <div class="form-group">
                        <button class="btn btn-success form-control" type="submit" name="login">LOGIN</button>
                    </div>
                </form>
            </div>
        </div>


    </div>

</body>