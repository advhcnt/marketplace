<?php
include 'fonction.php';
//fin de la balise nav qui contiendra les liens des categories
echo"<nav>";
$select=$bdd->PREPARE("SELECT * FROM categories");
$select->EXECUTE();

$liste = $select->fetchall();
foreach ($liste as $key) 
{
	?>
	<dl><a href="#"><?php echo($key['nom_cat']); ?></a>
</dl>
	<?php
	$select2=$bdd->PREPARE("SELECT * FROM sous_categories1 WHERE cat_id=?");
	$select2->EXECUTE(array($key['id_cat']));

	$liste2 = $select2->fetchall();
	
	foreach ($liste2 as $key2) 
	{
		?>

				<dd><a href="#"><?php echo($key2['nom_sous_cat1']); ?></a></dd>

		<?php
		# code...
		$select3=$bdd->PREPARE("SELECT *  FROM sous_categories2 WHERE sous_cat_id=?");
		$select3->EXECUTE(array($key2['id_sous_cat1']));

		$liste3 = $select3->fetchall();
		
		foreach ($liste3 as $key3) 
		{

			$select4=$bdd->PREPARE("SELECT *  FROM produits WHERE souscat_id=?");
			$select4->EXECUTE(array($key3['id_souscat2']));
			?>

					<ol><a href="">aaa</a></ol>

			<?php

			
			
		}
	}
}

echo"</nav>";

//fin de la balise nav qui contiendra les liens des categories