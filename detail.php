<?php
include 'fonction.php';
/*Cette page pour afficher les détauils d'un produit spécifiqu et ausssi faire une proposition des produits similaire*/
if(isset($_GET['produit']) and isset($_GET['identifiant']))
{
	$produit=filter_input(INPUT_GET, 'produit',FILTER_SANITIZE_SPECIAL_CHARS);
	$identifiant=filter_input(INPUT_GET, 'identifiant',FILTER_SANITIZE_NUMBER_INT);

	if(!empty($produit) and !empty($identifiant))
	{
		$select=$bdd->PREPARE("SELECT * FROM produits WHERE id_prod=?");
		$select->EXECUTE(array($identifiant));
		$info = $select->fetch();
		

		?>
		<div>
			<img src="#" alt="le produit">
			<p>
				<?php echo($info['description']); ?>
			</p>
			<p>
				<label>Prix : <?php  echo($info['prix_unitaire']); ?></label> 
				<br>
				<a href="include/panier.php?action=ajout&amp;l=<?php echo($info['libelle']);?>&amp;q=1&amp;p=<?php echo($info['prix_unitaire']);?>"><button>ajouté</button></a>
			</p>
		</div>

		<?php
	}

	?>

		<hr><hr>
		<h3>Articles similaire</h3>



	<?php
	$produit='%'.$produit.'%';
	$select=$bdd->PREPARE("SELECT * FROM produits WHERE libelle like ?");
	$select->EXECUTE(array($produit));
	$info = $select->fetchall();
	$i=0;
	foreach ($info as $prod_similaire) 
	{
		if($prod_similaire['id_prod']!==$produit)
		{
			$i+=1;
			if($i<5)
			{
				?>
				<td>
					<figure>
						<a href="detail.php?identifiant=<?php echo($prod_similaire['id_prod']);?>&amp;produit=<?php echo($prod_similaire['libelle']);?>"><img src="#" alt="<?php echo($prod_similaire['libelle']);?>"></a>
						<figcaption>
							<p><label>Description: <?php echo(substr($prod_similaire["description"],0,10).'...' );?></label></p>
							<p><a href="include/panier.php?action=ajout&amp;l=<?php echo($prod_similaire['libelle']);?>&amp;q=1&amp;p=<?php echo($prod_similaire['prix_unitaire']);?>"><button>ajouté</button></a></p>
						</figcaption>
					</figure>
				</td>
				<?php
			}
			else
			{
				$i=1;
				?>
				</tr>
				<tr>
					<td>
						<figure>
							<a href="detail.php?identifiant=<?php echo($prod_similaire['id_prod']);?>&amp;produit=<?php echo($prod_similaire['libelle']);?>"><img src="#" alt="<?php echo($prod_similaire['libelle']);?>"></a>
							<figcaption>
								<p><label>Description: <?php echo(substr($prod_similaire["description"],0,10).'...' );?></label></p>
								<p><a href="include/panier.php?action=ajout&amp;l=<?php echo($prod_similaire['libelle']);?>&amp;q=1&amp;p=<?php echo($prod_similaire['prix_unitaire']);?>"><button>ajouté</button></a></p>
							</figcaption>
						</figure>
					</td>
				<?php
			}
		
		}
	
	}
}


?>