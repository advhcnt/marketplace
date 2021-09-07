<?php
session_start();
include 'fonction.php';
#echo(is_numeric($_SESSION['id_admin']));
if(isset($_SESSION['admin'] ) AND isset($_SESSION['id_admin']))
{
	$select = $bdd->PREPARE("SELECT * FROM administrateur WHERE mail = ? AND id_admin=?");
	$select->EXECUTE(array($_SESSION['admin'],$_SESSION['id_admin']));

		$info = $select->fetch();
		$nombre = $select->rowcount();

		if($nombre==1)
		{
			$select = $bdd->PREPARE("SELECT * from attente");
			$select->EXECUTE();

			$liste_attente = $select->fetchall();
			?>
<!DOCTYPE html>
<html>

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/atchossou_tdb.css">
    <link rel="stylesheet" href="public/css/entete.css">
    <link rel="shortcut icon" href="public/img/favicon/" type="image/x-icon">

    <title>ADMIN DASHBOARD</title>

</head>

<body class="bg-info container">
    <div class="table table-responsive">
        <marquee class="text-center bg-primary text-white">
            <h2>ADMINISTRATEUR GUIDJO😎😎😎😎😎😎😎oo DE DJAWA😎</h2>
        </marquee>
    </div>

    <div class="row">
        <?php include("entete.php");?>
    </div>

    <!--<div class="bg-primary visible-xs visible-sm">
        <h2>ADMINISTRATEUR GUIDJOOOOOOOOOOOOO😎😎😎😎😎😎😎😎😎😎😎😎😎😎 DE DJAWAO</h2>
    </div>-->

    <div class="row">
        <br><br>
        <a href="categorie.php"><button class="btn btn-info">LES CATEGORIES</button></a>
        <br><br><br>
    </div>


    <table class="table table-bordered table-responsive">
        <thead class="bg-danger">
            <tr>
                <th class="text-center">BOUTIQUE</th>
                <th class="text-center">ADRESSE</th>
                <th class="text-center">PAYS</th>
                <th class="text-center">VILLE</th>
                <th class="text-center">EMAIL</th>
                <th class="text-center">TELEPHONE</th>
                <th class="text-center">NOM BOSS</th>
                <th class="text-center">Propriétaire</th>

                <th class="text-center">RCCM</th>
                <th class="text-center">IFU</th>
                <th class="text-center">Action</th>
            </tr>

        </thead>

        <tbody>
            <?php

			foreach ($liste_attente as $key)
			{
				$famille = ($key["id_proprietaire"] ==0)?"nouveau":"ancien";
				?>

            <tr>

                <td class="text-center"><?php echo $key["boutique"] ?></td>
                <td class="text-center"><?php echo $key["adresse"] ?></td>
                <td class="text-center"><?php echo $key["pays"] ?></td>
                <td class="text-center"><?php echo $key["ville"] ?></td>
                <td class="text-center"><?php echo $key["mail"] ?></td>
                <td class="text-center"><?php echo $key["telephone"] ?></td>
                <td class="text-center"><?php echo $key["nom_proprietaire"] ?></td>
                <td class="text-center"><?php echo $key["prenom_proprietaire"] ?></td>

                <td class="text-center"><?php echo $key["rccm"] ?></td>
                <td class="text-center"><?php echo $key["ifu"] ?></td>

                <td class="text-center"><a
                        href="envoi_mail.php?patron=<?php echo($famille);?>&amp;vendeur=<?php echo $key["id_attente"] ?>"><button
                            class="btn btn-success">Répondre</button></a>
                </td>
            </tr>

            <?php
			}

			?>
        </tbody>
        <caption class="caption text-center">Liste des demandes vendeurs</caption>
    </table>
</body>

</html>

<?php

		}

}
else
{
	#header("location:atchossou_login.php");
	echo(is_numeric($_SESSION['id_admin']));
}



?>