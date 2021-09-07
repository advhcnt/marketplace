<?php

session_start();
include 'panier_fonction.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/ionicons.min.css">
    <link rel="stylesheet" href="../acheteur/userspace/style.css">
    <link rel="stylesheet" href="panier.css">

    <title>Choix d'un moyen de livraison</title>
    <style>
    form {
        width: 350px;
        border: 1px solid black;
        border-radius: 12px;
        margin: auto;
        padding: 15px;
        margin-top: 70px;
        margin-bottom: 30px;

    }

    .footer {
        position: relative;
        top: 10vh;

    }

    h2 {
        margin-top: 70px;
        margin-top: 70px;
    }
    </style>

</head>

<body>
    <div class="container">
        <div class="row">
            <?php include("../acheteur/entete.php");?>
        </div>
        <div class="row">

            <?php

include '../acheteur/fonction.php';
if (isset($_GET['action']) and !empty($_GET['action'])) 
{

	$action = filter_input(INPUT_GET,'action',FILTER_SANITIZE_SPECIAL_CHARS);
	
	if ($action == "info_de_livraison") {
		
		if (isset($_POST['next'])) {
			$_SESSION['pays']=verification($_POST['pays']);
			$_SESSION['ville']=verification($_POST['ville']);
			$_SESSION['adress']=verification($_POST['adress']);
			$_SESSION['code']=verification($_POST['code']);
			#$moyen=verification($_POST['moyen']);
			
			#header('location:moyendelivraison.php?action=coursier');
			?>
            <script>
            window.location.href = "moyendelivraison.php?action=coursier";
            </script>
            <?php

		}



		?>

            <form action="" method="post" class="form ">
                <h3 class="text-center">Informations de livraison</h3>

                <div class="form-group">
                    <label>Pays : </label>
                    <input type="text" name="pays" required="required" class="form-control">
                </div>
                <div class="form-group">
                    <label>Ville : </label>
                    <input type="text" name="ville" required="required" class="form-control">
                </div>
                <div class="form-group">
                    <label>Adress : </label>
                    <input type="text" name="adress" required="required" class="form-control">
                </div>
                <div class="form-group">
                    <label>Code Postale : </label>
                    <input type="text" name="code" required="required" class="form-control">
                </div>
                <div class="form-group">

                    <input type="submit" name="next" value="Suivant" class="form-control btn btn-success">
                </div>

            </form>
            <?php
	}
	else if($action == "coursier")
	{
		$re ='%'.$_SESSION['ville'].'%';
		$select=$bdd->PREPARE('SELECT * FROM tarif WHERE ville like ?');
		$select->EXECUTE(array($re));

		if($select)
		{
			if(isset($_POST['toto']))
			{
				$_SESSION['coursier']=$_POST['moyen'];
				header("location:paiement.php");
				?>
            <script>
            window.location.href = "paiement.php";
            </script>
            <!--<h2 class="alert alert-danger text-center">Les frais de livraison <=#calculPort();?>F cfa</h2>-->
            <?php
			}
			/*else
			{
				?>
            <h2 class="alert alert-danger text-center">Désolé pour la livraison</h2>
            <?php
			}*/
					
			?>
            <form action="" method="post" class="form ">
                <h3 class="text-center">Choix du cousier</h3>
                <div class="form-group">
                    Coursier
                    <select name="moyen" class="form-control">
                        <?php

									$info = $select->fetchall();
									foreach ($info as $livreur) {

										$select=$bdd->PREPARE("SELECT * FROM coursiers where id_coursier=?");
										$select->EXECUTE(array($livreur["coursier"]));
										$nom=$select->fetch();
										?>

                        <option value="<?php echo $nom['id_coursier'] ?>"><?php echo $nom["nom"] ?></option>
                        <?php
									}


								?>
                    </select>
                </div>
                <div class="form-group">

                    <button type="submit" name="toto" class="form-control btn btn-success">Suivant</button>
                </div>

            </form>

            <?php
		}
	}

}

			?>
        </div>
    </div>
    <div class="row">
        <?php include("../footer.php");?>
    </div>

</body>

</html>