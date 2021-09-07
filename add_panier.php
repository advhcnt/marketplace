<?php
//session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=marquetplace","root","");
include 'mon_panier_class.php';
$_SESSION['monpanier']=new Panier($bdd);


if(isset($_GET['action']))
{
	if($_GET['action']=="ajout")
	{
		if(isset($_GET['produit']) AND is_numeric($_GET['produit']))
		{
			$select=$bdd->PREPARE("SELECT * from produits where id_prod=?");
			$select->EXECUTE(array($_GET['produit']));

			if($select)
			{
				$_SESSION['monpanier']->ajouter($_GET['produit'],$_GET['quantite']);
				header("location:acceuil.php");

			}
			else
			{
				$erreur="Vous ne pouvez pas ajouter ce produit";
			} 
			

		}
	}
	elseif ($_GET['action']=="modifier") 
	{
		$nombre= count($_GET["q"]);
		$lesq=$_GET["q"];
		for($i=0;$i<$nombre;$i++)
		{
			$_SESSION['monpanier']->modifier_produit($_SESSION["panier"]["id_produit"][$i],$lesq[$i]);
		}
	}
	else if($_GET['action']=="suppression")
	{
		$_SESSION['monpanier']->supprimer_produit($_GET["l"]);
	}
}

var_dump($_SESSION["pan"]['id_produit']);
?>
<!--<meta http-equiv="refresh" content="0">-->