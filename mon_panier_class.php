<?php
#include 'fonction.php';
$bdd = new PDO("mysql:host=127.0.0.1;dbname=marquetplace","root","");
class Panier
{
	public function __construct()
	{
		
		if(!isset($_SESSION))
		{
			session_start();
		}
		if(!isset($_SESSION["pan"]))
		{
			#$_SESSION["pan"]=array(); 
			$_SESSION["pan"]["id_produit"]=array(); 
			$_SESSION["pan"]["libelle"]=array(); 
			$_SESSION["pan"]["quantite"]=array(); 
			$_SESSION["pan"]["prix"]=array(); 
			$_SESSION["pan"]["boutique"]=array();  
		}
	}


 	public function ajouter($produit_id,$quantite)
	{
		$position = array_search($produit_id, $_SESSION["pan"]["id_produit"]);
		if($position!=False)
		{
			$_SESSION["pan"]["quantite"][$position]+=$quantite;
			//echo('<meta http-equiv="refresh" content="0;url=acceuil.php">');

		}
		else
		{
			$bdd = new PDO("mysql:host=127.0.0.1;dbname=marketplace","root","");
			$select=$bdd->PREPARE("SELECT * from produits where id_prod=?");
			$select->EXECUTE(array($produit_id));
			$info = $select->fetch();

			array_push($_SESSION["pan"]["id_produit"], $info["id_prod"]);
			array_push($_SESSION["pan"]["libelle"],$info["libelle"]);
			array_push($_SESSION["pan"]["quantite"],$quantite);
			array_push($_SESSION["pan"]["prix"],$info["prix_unitaire"]);
			array_push($_SESSION["pan"]["boutique"], $info["boutique"]);
			//echo('<meta http-equiv="refresh" content="0;url=acceuil.php">');
		}
		
	}

	public function modifier_produit($produit_id,$quantite)
	{
		$position=array_search($produit_id, $_SESSION["pan"]["id_produit"]);

		if($position)
		{
			array_push($_SESSION["pan"]["quantite"][$position],$quantite);
		}
	}

	public function supprimer_produit($produit_id)
	{
		
			$temporaire = array();
			$temporaire["id_produit"]=array(); 
			$temporaire["libelle"]=array(); 
			$temporaire["quantite"]=array(); 
			$temporaire["prix"]=array(); 
			$temporaire["boutique"]=array();

			for($i=0;$i<count($_SESSION["pan"]["id_produit"]);$i++)
			{
				if($_SESSION["pan"]["id_produit"][$i]!==$produit_id)
				{
					array_push($temporaire["id_produit"],$_SESSION["pan"]["id_produit"], );
					array_push($temporaire["libelle"],$_SESSION["pan"]["libelle"]);
					array_push($temporaire["quantite"],$_SESSION["pan"]["quantite"],1);
					array_push($temporaire["prix"],$_SESSION["pan"]["prix"]);
					array_push($temporaire["boutique"],$_SESSION["pan"]["boutique"]);
				}
				$_SESSION['pan']=$temporaire;

				unset($temporaire);
			}
		
	}


	public function nombre_produit()
	{
		return count($_SESSION["pan"]["id_produit"]);
	}


	public function Montant_global()
	{
		$total = 0;
		if(count($_SESSION["pan"]["id_produit"])>0)
		{
			for($i=0;$i<count($_SESSION["pan"]["id_produit"]);$i++)
			{
				$total += $_SESSION["pan"]["quantite"][$i]*$_SESSION["pan"]["prix"][$i];
			}
			return $total;
		}
		else
		{
			return 0;
		}
	}

	public function Montant_TTC($tva=0.18)
	{
		return $this->Montant_global()*$tva + $this->Montant_global();
	}

	public function Rabais($value)
	{
		return  $this->Montant_global()-$this->Montant_global()*$value ;
	}


}



?> 