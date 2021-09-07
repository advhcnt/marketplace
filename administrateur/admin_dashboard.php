<?php
session_start();
include 'fonction.php';

if(isset($_SESSION['admin'] ) AND isset($_SESSION['id_admin']) AND is_integer($_SESSION['id_admin']))
{
	$select = $bdd->PREPARE("SELECT * FROM administrateur WHERE nom = ? AND id_admin=?");
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
				<title>ADMIN DASHBOARD</title>
				<meta charset="utf-8">
				<style type="text/css">
					tr,td,table
					{
						border: 1px solid;
						border-collapse: collapse;
					}
					.entete
					{
						font-family: all;
						font-weight: all;
					}
				</style>
			</head>
			<body>
			
			
			<caption>Liste des demande vendeurs</caption>
			<table>
				<tr class="entete">
					<td>ID ATTENTE</td>
					<td>BOUTIQUE</td>
					<td>ADRESSE</td>
					<td>PAYS</td>
					<td>VILLE</td>
					<td>EMAIL</td>
					<td>TELEPHONE</td>
					<td>NOM BOSS</td>
					<td>PRENOM BOSS</td>
					<td>ID BOSS</td>
					<td>RCCM</td>
					<td>IFU</td>
				</tr>
			

			<?php

			foreach ($liste_attente as $key)
			{
				?>
				<tr>
					<td><?php echo $key["id_attente"] ?></td>
					<td><?php echo $key["nom"] ?></td>
					<td><?php echo $key["adresse"] ?></td>
					<td><?php echo $key["pays"] ?></td>
					<td><?php echo $key["ville"] ?></td>
					<td><?php echo $key["mail"] ?></td>
					<td><?php echo $key["telephone"] ?></td>
					<td><?php echo $key["nom_proprietaire"] ?></td>
					<td><?php echo $key["prenom_proprietaire"] ?></td>
					<td><?php echo $key["id_proprietaire"] ?></td>
					<td><?php echo $key["rccm"] ?></td>
					<td><?php echo $key["ifu"] ?></td>
				</tr>

				<?php
			}

			?>

			</table>
			</body>
			</html>

			<?php

		}

}



?>