<?php
session_start();
include '../fonction.php';
#L'existence des variables et des valeurs dans l'URL
if (isset($_GET['patron']) AND isset($_GET['id_vendeur']) AND !empty($_GET['patron']) AND !empty($_GET['id_vendeur'] and is_numeric($_GET['id_vendeur'])))
{
	$patron = $_GET['patron'];

	$select = $bdd->PREPARE("SELECT * FROM attente where id_attente=?");
	$select->EXECUTE(array($_GET['id_vendeur']));
	
	$info=$select->fetch();

	$nombre = $select->rowcount();

	#Si la demande en attente existe vraiment
	if($nombre==1)
	{


		if (isset($_POST['submit']))
		{
			if (isset($_POST['password']) AND isset($_POST['password2']) AND !empty($_POST['password']) AND !empty($_POST['password2'])) {

				$password = verification($_POST['password']);
				$password2 = verification($_POST['password2']);

				if($password==$password2 AND strlen($password)>=8)
				{
					

					#si le patron est un ancient
					if($patron=="ancient")
					{

						$select = $bdd->PREPARE("SELECT * FROM patron where email=?");
						$select->EXECUTE(array($info['mail']));
							
						$infoo=$select->fetch();


						$insert = $bdd->PREPARE("INSERT INTO  boutique values(?,?,?,?,?,?,?)");
						$insert->EXECUTE(array("",$info['id_proprietaire'],$info["nom"],$info["ville"],$info["adresse"],$info["ifu"],$info["rccm"]));

						$delete = $bdd->PREPARE("DELETE  FROM attente where id_attente=?");
						$delete->EXECUTE(array($_GET['id_vendeur']));

						$_SESSION['numero_vendeur']=$infoo['id_patron'];
						$_SESSION['email_vendeur']=$infoo['email'];

						header("location:vendeur_dashbord.php");

					}
					elseif ($patron=="nouveau") 
					{

						$select=$bdd->PREPARE("SELECT * from patron where email=?");
						$select->EXECUTE(array($info['mail']));
						
						$nombre=$select->rowcount();
						

						if($nombre==0)
						{
							echo "salut <br><br>";
							$insert = $bdd->PREPARE("INSERT INTO patron values(?,?,?,?,?,?,?,?)");
							$insert->EXECUTE(array("",$info['nom_proprietaire'], $info['prenom_proprietaire'],$info['mail'],$info['telephone'],$info['ville'],$info['adresse'],$password));
							#print_r(array("",$propre, join($info3," "),$info['mail'],$info['telephone'],$info['ville'],$info['adresse'],$password));

							$select = $bdd->PREPARE("SELECT * FROM patron where email=?");
							$select->EXECUTE(array($info['mail']));
							
							$infoo=$select->fetch();
							$patron=$infoo['id_patron'];
							print_r(array("",$patron,$info["boutique"],$info["ville"],$info["adresse"],$info["ifu"],$info["rccm"]));
							$insert = $bdd->PREPARE("INSERT INTO  boutique values(?,?,?,?,?,?,?)");
							$insert->EXECUTE(array("",$patron,$info["boutique"],$info["ville"],$info["adresse"],$info["ifu"],$info["rccm"]));
							//print_r(array("",$patron,$info["nom"],$info["ville"],$info["adresse"],$info["ifu"],$info["rccm"]));

							$_SESSION['numero_vendeur']=$infoo['id_patron'];
							$_SESSION['email_vendeur']=$infoo['email'];

							$delete = $bdd->PREPARE("DELETE  FROM attente where id_attente=?");
							$delete->EXECUTE(array($_GET['id_vendeur']));

							header("location:vendeur_dashbord.php");

						}
						else
						{
							echo "erreur4";
							#header("location:erreur_404.php");
						}
						
					}
					else
					{
						echo "erreur3";
						#header("location:erreur_404.php");
					}

					
				}
				else
				{
					$erreur = "Vos deux mot de passe sont incompatible";
				}
			}
			else
			{
				$erreur = "CHAMPS VIDES";
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
    <link rel="stylesheet" href="public/css/tb_vendeur.css">
    <title>LOGIN VENDEUR</title>

</head>

<body>
<h1 class="text-center bg-light"><?php salutation($patron); ?> </h1>
    <!-- afficher erreur -->
    <form action="" method="post" class="form">
        <div class="image">
            <img src="public/img/avatar04.png" alt="" srcset="" class="img img-circle "
                style="width:100px;height:100px;">
        </div>
        <div class="alert">
            <?php 
					if (isset($erreur)) 
					{?>
            <h5 class="alert bg-danger text-center"> <?=$erreur;?></h5>
            <?php
					}
				?>
        </div>

        <h4 class="text-center">Création de mot de passe</h4>

        <?php
						if($_GET['patron']=='ancient')
						{
							?>
        <div class="form-group">



            <input type="submit" name="submit" value="Continué" class="btn btn-success form-control">
        </div>


        <?php
						}
						else if ($_GET['patron'] =='nouveau') {
							?>
        <div class="form-group">
            <label>PASSWORD</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input type="password" name="password" minlength="8" class="form-control require" require="require">
            </div>

        </div>

        <div class="form-group">
            <label>PASSWORD confirm</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input type="password" name="password2" minlength="8" class="form-control require" require="require">
            </div>

        </div>
        <div class="form-group">



            <input type="submit" name="submit" class="btn btn-success form-control" value="Validé">
        </div>

        <?php
						}
						else
						{
							header("location:erreur_404.php");
						}



						?>



    </form>

</body>

</html>

<?php
	}
	else
	{
		echo "erreur2";
		#header("location:erreur_404.php");
	
	}
}
else
{
	echo "erreur1";
	#header("location:erreur_404.php");
}

?>