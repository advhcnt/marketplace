<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/categorie.css">
    <link rel="shortcut icon" href="public/img/favicon/" type="image/x-icon">

    <title>LES CATEGORIES</title>
    <meta charset="utf-8">

</head>

<body>
    <marquee class="text-center bg-primary text-white">
        <h2>ADMINISTRATEUR GUIDJO😎😎😎😎😎😎😎OO DE DJAWA😎</h2>
    </marquee>
	<?php include("entete.php");?>
    <a class="link text-white" href="atchossou_tdb.php"><button class="btn btn-success btn-md m-5" style="margin:10px;padding-left:40px;padding-right:40px">Retour</button></a>
    <div class="row bg-primary text-info">
        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
            <a class="link text-white" href="?action=ajout&amp;niveau=categorie">Ajout Categorie</a>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
            <a class="link text-white" href="?action=modi_sup&amp;niveau=categorie">modifier/Suprimer Categorie</a>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
            <a class="link text-white" href="?action=ajout&amp;niveau=sous_categorie1">Ajout sous Categorie1</a>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
            <a class="link text-white" href="?action=modi_sup&amp;niveau=sous_categorie1">modifier/Suprimer sous
                Categorie1</a>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
            <a class="link text-white" href="?action=ajout&amp;niveau=sous_categorie2">Ajout sous Categorie2</a>

        </div>

        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
            <a class="link text-white" href="?action=modi_sup&amp;niveau=sous_categorie2">modifier/Suprimer sous
                Categorie2</a>
        </div>


        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
            <a class="link text-white" href="?action=ajout&amp;niveau=coursier">Ajout coursier</a>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
            <a class="link text-white" href="?action=modi_sup&amp;niveau=coursier">modifier/Suprimer coursier</a>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
            <a class="link text-white" href="?action=ajout&amp;niveau=info_coursier">Ajout info coursier</a>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
            <a class="link text-white" href="?action=modi_sup&amp;niveau=info_coursier">modifier/Suprimer info
                coursier</a>
        </div>

    </div>

</body>

</html>

<?php
include 'fonction.php';

if(isset($_GET["action"]) AND !empty($_GET["action"]) AND isset($_GET["niveau"]) AND !empty($_GET["niveau"]))
{
	if($_GET["action"]=="ajout")
	{
		if($_GET["niveau"]=="categorie")
		{
			if(isset($_POST['submit']))
			{
				$nom=$_POST['nom'];
				$insert = $bdd->PREPARE("INSERT INTO categories values(?,?) ");
				$insert->EXECUTE(array("",$nom));
			}

			?>

<h3 class="text-center">Formulaires de Modification des Catégories</h3>

<form action="" method="post" class="form form-inline  text-center"
    style="margin-top:10px;padding-top:10px;padding-bottom:10px;">
    <div class="form-group">
        <label for="categorie">Nouvelle categorie : </label>
        <input type="text" name="nom" required="" placeholder="nom categorie" class="form-control" id="categorie">
    </div>
    <div class="form-group">

        <button class="btn btn-success form-control" type="submit" name="submit">enregistrer</button>
    </div>
</form>

<?php
		}
		elseif ($_GET['niveau']=="sous_categorie1") 
		{
			if(isset($_POST['submit']))
			{
				if(!empty($_POST['categorie']) AND !empty($_POST['sous_cateorie']))
				{
					$select = $bdd->PREPARE("SELECT * FROM categories where nom_cat=?");
					$select->EXECUTE(array($_POST['categorie']));

					$info = $select->fetch();
					

					$insert = $bdd->PREPARE("INSERT INTO sous_categories1 values(?,?,?)");
					$insert->EXECUTE(array("",$_POST['sous_cateorie'],$info['id_cat']));


				}
			}
			
			?>
<h3 class="text-center">Formulaires d'ajout des Sous Catégories de niveau 1</h3>
<form action="" method="post" class="form form-inline text-center" style="margin-top:10px;padding-top:10px;padding-bottom:10px">
    <div class="form-group">
        <label>Carégorie : </label>
        <select class="form-control" name="categorie" required="" class="form-control">
            <?php
				$select=$bdd->PREPARE("SELECT * From categories");
				$select->EXECUTE();

				$liste_cat=$select->fetchall();
				foreach ($liste_cat as $key) 
				{
					# code...

				?>

            <option class="option" value="<?php echo($key['nom_cat']);?>"><?php echo($key['nom_cat']);?></option>

            <?php
				}

			?>
        </select>
    </div>
    <div class="form-group">
        <label>Sous Carégorie : </label>
        <input type="text" class="form-control" name="sous_cateorie" required="" placeholder="nom categorie"
            class="form-control">
    </div>
    <div class="form-group">
        <button class="btn-success btn form-control" type="submit" name="submit">enregistrer</button>
    </div>

</form>

<?php
		}
		elseif($_GET['niveau']=="sous_categorie2")
		{

			if(isset($_POST['submit']))
			{
				if(!empty($_POST['categorie']) AND !empty($_POST['sous_cateorie']))
				{
					$select = $bdd->PREPARE("SELECT * FROM sous_categories1 where nom_sous_cat1=?");
					$select->EXECUTE(array($_POST['categorie']));

					$info = $select->fetch();
					

					$insert = $bdd->PREPARE("INSERT INTO sous_categories2 values(?,?,?)");
					$insert->EXECUTE(array("",$_POST['sous_cateorie'],$info['id_sous_cat1']));


				}
			}
			
			?>
<h3 class="text-center">Formulaires d'ajout des Sous Catégories de niveau 2</h3>
<form action="" method="post" class="form form-inline text-center" style="margin-top:10px;padding-top:10px;padding-bottom:10px">


    <div class="form-group">

        <label>Carégorie : </label>

        <select class="form-control" name="categorie" required="">


            <?php
							$select=$bdd->PREPARE("SELECT * From sous_categories1");
							$select->EXECUTE();

							$liste_cat=$select->fetchall();
							foreach ($liste_cat as $key) {
								# code...

							?>

            <option value="<?php echo($key['nom_sous_cat1']);?>"><?php echo($key['nom_sous_cat1']);?></option>

            <?php
							}

							?>
        </select>

    </div>
    <div class="form-group">

        <label>Sous Carégorie : </label>

        <input type="text" class="form-control" name="sous_cateorie" required="" placeholder="nom categorie">
    </div>
    <div class="form-group">

        <input type="submit" class="btn btn-success form-control" name="submit" value="enregistrer">
    </div>

</form>

<?php

		}
		elseif ($_GET['niveau']=="coursier") 
		{
			if(isset($_POST['lecoursier']))
			{
				$coursier = verification($_POST['nom_coursier']);

				if(!empty($coursier))
				{
					$insert = $bdd->PREPARE("INSERT into coursiers values(?,?)");
					$insert->EXECUTE(array("",$coursier));
					#header("location:categorie.php?action=ajout&amp;niveau=coursier");
				}
			}
			?>
<h3 class="text-center">Formulaires d'ajout de Coursiers</h3>
<form action="" method="post" class="form form-inline text-center" style="margin-top:10px;padding-top:10px;padding-bottom:10px">

    <div class="form-group">
        <label>Nom : </label>
        <input type="text" class="form-control" name="nom_coursier" placeholder="nom du coursier" required="">
    </div>
    <div class="form-group">

        <input type="submit" class="btn btn-success form-control" name="lecoursier" value="Enregistrer">
    </div>

</form>


<?php
		}
		elseif ($_GET['niveau']=="info_coursier") 
		{
			if(isset($_POST['tarif']))
			{
				$Pays=verification($_POST['Pays']);
				$Ville=verification($_POST['Ville']);
				$Poids=verification($_POST['Poids']);
				$coursier=verification($_POST['coursier']);
				$Montant=verification($_POST['Montant']);

				if (is_numeric($Montant) AND is_numeric($Poids) AND is_numeric($coursier)) 
				{
					echo "string";
					$select=$bdd->PREPARE("SELECT *FROM coursiers WHERE id_coursier=?");
					$select->EXECUTE(array($coursier));

					if($select)
					{
						echo "bien";
						$insert=$bdd->PREPARE("INSERT INTO tarif values(?,?,?,?,?,?)");
						$insert->EXECUTE(array('',$Pays,$Ville,$Poids,$Montant,$coursier));
					}
					else
					{
						$erreur = "Veillez revoir les informations";
					}

				}
				else
				{
					$erreur = "Veillez revoir les informations";
				}
				
			}

			?>
<h3 class="text-center">Formulaires d'ajout des informations des coursiers</h3>
<form action="" method="post" class="form " style="margin-top:10px;padding:15px; width:500px;margin:auto;border:1px solid black;border-radius:12px">
    <?php 
					if (isset($erreur)) 
					{
						echo "<h1 style='color:red;'> $erreur</h1>";
					}
				?>
    <!-- afficher erreur -->

    <div class="form-group">
        <label>Pays : </label>
        <input type="text" class="form-control" name="Pays" placeholder="Ex:Bénin" required="">
    </div>
    <div class="form-group">
        <label>Ville : </label>
        <input type="text" class="form-control" name="Ville" placeholder="Ex:cotonou" required="">
    </div>
    <div class="form-group">
        <label>Poids : </label>
        <input type="text" class="form-control" name="Poids" placeholder="En Kg" required="">
    </div>


    <div class="form-group">
        <label>Coursie : </label>
        <select class="form-control" name="coursier">
            <?php
								$select=$bdd->PREPARE("SELECT * from coursiers");
								$select->EXECUTE();
								$liste=$select->fetchall();
								foreach ($liste as $coursier) 
								{
									?>
            <option value="<?php echo($coursier['id_coursier']);?>"><?php echo($coursier['nom']);?></option>
            <?php
								}
								?>
        </select>
    </div>
    <div class="form-group">
        <label>Montant : </label>
        <input type="text" class="form-control" name="Montant" placeholder="Ex:200" required="">
    </div>

    <div class="form-group">

        <input type="submit" class="btn btn-success form-control" name="tarif" value="Enregistrer">
    </div>

</form>

<?php
		}
		else
		{
			header("location:erreur_404.php");
		}
	}
	else if($_GET["action"]=="modi_sup")
	{
		if($_GET['niveau']=="categorie")
		{
			if(isset($_POST['submit']))
			{
				echo "boss";
				if($_POST['submit']=="modifier")
				{
					$update = $bdd->PREPARE("UPDATE  categories set nom_cat=? WHERE id_cat=? ");
					$update->EXECUTE(array($_POST['nom'],$_POST['categorie']));
					
					#header("location:?action=modi_sup&amp;niveau=categorie");
				}
				elseif ($_POST['submit']=="X") 
				{
					# code...
					$update = $bdd->PREPARE("DELETE FROM  categories WHERE  id_cat=? ");
					$update->EXECUTE(array($_POST['categorie']));
					
					#header("location:?action=modi_sup&amp;niveau=categorie");

				}
				else
				{
					header("location:?action=modi_sup&amp;niveau=categorie");
				}
			}

		
			$select = $bdd->PREPARE("SELECT * from categories");
			$select->EXECUTE();

			$liste=$select->fetchall();
			?>
<h3 class="text-center">Formulaires de Modification des Catégories</h3>
<?php
			foreach ($liste as $key) 
			{

				?>
<form action="" method="post" class="form text-center" style="margin-top:10px;padding-top:10px;padding-bottom:10px">
    <div class="form-inline">
        <input type="texte" class="form-control" name="nom" value="<?php echo($key["nom_cat"]);?>">
        <input type="hidden" name="categorie" value="<?php echo($key['id_cat']);?>">
        <div class="btn-group">
            <input type="submit" class="btn btn-success form-control" name="submit" value="modifier">

            <input type="submit" class="btn btn-danger form-control" name="submit" value="X">
        </div>

    </div>

</form>

<?php
			}
			
		}
		else if($_GET['niveau']=="sous_categorie1")
		{
			if(isset($_POST['submit']))
			{
				if($_POST['submit']=="modifier")
				{
					$select = $bdd->PREPARE("SELECT id_cat FROM categories WHERE nom_cat=?");
					$select->EXECUTE(array($_POST["categorie"]));

					$cat=$select->fetch();

					$update = $bdd->PREPARE("UPDATE sous_categories1  SET cat_id=? ,nom_sous_cat1=? WHERE id_sous_cat1=?");
					$update->EXECUTE(array($cat["id_cat"],$_POST["nom"],$_POST['numero']));

				}
				else if($_POST['submit']=="X")
				{
					$update = $bdd->PREPARE("DELETE FROM  sous_categories1 WHERE  id_sous_cat1=? ");
					$update->EXECUTE(array($_POST['numero']));

				}
			}

			$select = $bdd->PREPARE("SELECT * FROM sous_categories1");
			$select->EXECUTE(array());

			$liste=$select->fetchall();
			?>
<h3 class="text-center">Formulaires de Modification des Sous Catégories de niveau 1</h3>
<?php
			foreach ($liste as $key) {
				# code...
				$select2 = $bdd->PREPARE("SELECT * FROM categories WHERE id_cat=?");
				$select2->EXECUTE(array($key['cat_id']));

				$info=$select2->fetch();
				

				?>
<div class="formulaire">

    <form action="" method="post" class="form text-center" style="margin-top:10px;padding-top:10px;padding-bottom:10px">
        <div class="form-inline">
            <div class="form-group">
                <label>Categorie</label>
                <select class="form-control" name="categorie">
                    <?php

									$select=$bdd->PREPARE("SELECT * FROM categories");
									$select->EXECUTE();

									$liste2=$select->fetchall();
									
									foreach ($liste2 as $key3) 
									{
										?>
                    <option value="<?php echo($key3['nom_cat']) ?>"
                        <?php echo(($key3['id_cat']==$key['cat_id'])?"selected='selected'":" ") ;?>>
                        <?php echo($key3['nom_cat']) ?></option>
                    <?php
									}

								?>


                </select>

            </div>


            <div class="form-group">
                <label>Sous Categorie</label>
                <input type="texte" class="form-control" name="nom" value="<?php echo($key["nom_sous_cat1"]);?>">

                <input type="hidden" name="numero" value="<?php echo($key['id_sous_cat1']);?>">
            </div>

            <div class="form-group">
                <div class="btn-group">
                    <input type="submit" class="btn btn-success form-control" name="submit" value="modifier">

                    <input type="submit" class="btn btn-danger form-control" name="submit" value="X">
                </div>

            </div>
        </div>



    </form>
</div>

<?php
			}

		}
		else if($_GET['niveau']=="sous_categorie2")
		{
			
			if(isset($_POST['submit']))
			{
				if($_POST['submit']=="modifier")
				{

					$select = $bdd->PREPARE("SELECT id_sous_cat1 FROM sous_categories1 WHERE nom_sous_cat1=?");
					$select->EXECUTE(array($_POST["categorie"]));

					$cat=$select->fetch();

					$update = $bdd->PREPARE("UPDATE sous_categories2  SET sous_cat_id=? ,nom_sous_cat2=? WHERE id_souscat2=?");
					$update->EXECUTE(array($cat["id_sous__cat"],$_POST["nom"],$_POST['numero']));

				}
				else if($_POST['submit']=="X")
				{
					$update = $bdd->PREPARE("DELETE FROM  sous_categories2 WHERE  id_souscat2=? ");
					$update->EXECUTE(array($_POST['numero']));

				}
			}

			$select = $bdd->PREPARE("SELECT * FROM sous_categories2");
			$select->EXECUTE(array());

			$liste=$select->fetchall();
			?>
<h3 class="text-center">Formulaires de Modification des Sous Catégories de niveau 2</h3>
<?php

			foreach ($liste as $key) {
				# code...
				$select2 = $bdd->PREPARE("SELECT * FROM sous_categories1 WHERE id_sous_cat1=?");
				$select2->EXECUTE(array($key['sous_cat_id']));

				$info=$select2->fetch();
				

				?>
<div class="formulaire">

    <form action="" method="post" class="form text-center" style="margin-top:10px;padding-top:10px;padding-bottom:10px">

        <div class="form-inline">
            <div class="form-group">
                <label>Categorie</label>
                <select class="form-control" name="categorie">
                    <?php

									$select=$bdd->PREPARE("SELECT * FROM sous_categories1");
									$select->EXECUTE();

									$liste2=$select->fetchall();

									foreach ($liste2 as $key3) 
									{
										?>
                    <option value="<?php echo($key3['nom_sous_cat1']) ?>"
                        <?php echo(($key3['id_sous_cat1']==$key['sous_cat_id'])?"selected='selected'":" ") ;?>>
                        <?php echo($key3['nom_sous_cat1']) ?></option>
                    <?php
									}

								?>


                </select>

            </div>


            <div class="form-group">
                <label>Sous Categorie</label>
                <input type="texte" class="form-control" name="nom" value="<?php echo($key["nom_sous_cat2"]);?>">

                <input type="hidden" name="numero" value="<?php echo($key['id_souscat2']);?>">
            </div>

            <div class="btn-group">
                <input type="submit" class="btn btn-success form-control" name="submit" value="modifier">

                <input type="submit" class="btn btn-danger form-control" name="submit" value="X">
            </div>
        </div>


    </form>
</div>

<?php
			}


		}
		elseif ($_GET['niveau']=="coursier") {

			if (isset($_POST['lecoursier'])) 
			{
				if ($_POST['lecoursier']=='modifier') 
				{
					$identifiant = verification($_POST['identifiant']);
					$nom = verification($_POST['nom_coursier']);

					$select = $bdd->PREPARE("SELECT * FROM coursiers WHERE id_coursier=?");
					$select->EXECUTE(array($identifiant));
					if($select)
					{
						$modifier=$bdd->PREPARE("UPDATE coursiers set nom=? WHERE id_coursier=?");
						$modifier->EXECUTE(array($nom,$identifiant));
					}
					else
					{
						$erreur="Impossible de modifier le coursier";
					}
				}
				elseif ($_POST['lecoursier']=='X') 
				{
					$select = $bdd->PREPARE("SELECT * FROM coursiers");
					$select->EXECUTE();
					if($select)
					{
						$delete= $bdd->PREPARE("DELETE FROM coursiers WHERE id_coursier=?");
						$delete->EXECUTE(array($_POST['identifiant']));
					}
					else
					{
						$erreur="Impossible de supprimer le coursier";
					}
				}
			}
			

			$select = $bdd->PREPARE("SELECT * FROM coursiers");
			$select->EXECUTE();
			$liste = $select->fetchall();
			?>
<h3 class="text-center">Formulaires de Modification du nom des Coursiers</h3>
<?php
			foreach ($liste as $coursier) {
				?>

<form action="" method="post" class="form text-center" style="margin-top:10px;padding-top:10px;padding-bottom:10px">

    <div class="form-inline">
        <label>Nom : </label>
        <input type="text" class="form-control" name="nom_coursier" value="<?php echo($coursier['nom']);?>" required="">
        <input type="hidden" name="identifiant" value="<?php echo($coursier['id_coursier']);?>">
        <div class="btn-group">

            <input type="submit" class="btn btn-success form-control" name="lecoursier" value="modifier">
            <input type="submit" class="btn btn-danger form-control" name="lecoursier" value="X">
        </div>

    </div>


</form>

<?php
			}
		}
		elseif ($_GET['niveau']=="info_coursier")
		{
			
			if(isset($_POST['tarif']))
			{
				$Pays=verification($_POST['Pays']);
				$Ville=verification($_POST['Ville']);
				$Poids=verification($_POST['Poids']);
				$coursier=verification($_POST['coursier']);
				$Montant=verification($_POST['Montant']);
				$identidiant=verification($_POST['identidiant']);

				if ($_POST['tarif']=="Modifier") {
					$select = $bdd->PREPARE("SELECT * FROM tarif WHERE id_tarif=?");
					$select->EXECUTE(array($identidiant));
					if ($select) {
						$update = $bdd->PREPARE("UPDATE tarif set pays=?,ville=?,poids=?,montant=?,coursier=? where id_tarif=?");
						$update->EXECUTE(array($Pays,$Ville,$Poids,$Montant,$coursier,$identidiant));
					}
				}
				elseif ($_POST['tarif']=="X") {
					$select = $bdd->PREPARE("SELECT * FROM tarif WHERE id_tarif=?");
					$select->EXECUTE(array($identidiant));
					if($select)
					{

						$delete=$bdd->PREPARE("DELETE FROM tarif WHERE id_tarif=?");
						$delete->EXECUTE(array($identidiant));
					}
					else
					{
						$erreur = "Impossible";
					}
					
				}
			}
			$select=$bdd->PREPARE("SELECT id_coursier,id_tarif,nom,pays,ville,poids,montant,tarif.coursier FROM coursiers,tarif where tarif.coursier=coursiers.id_coursier");
			$select->EXECUTE(array());

			$liste = $select->fetchall();
			?>
<h3 class="text-center">Formulaires de Modification des informations Coursier</h3>
<?php
			foreach ($liste as $info) 
			{
				?>

<form action="" method="post" class="form text-center" style="margin-top:10px;padding-top:10px;padding-bottom:10px">

    <?php 
							if (isset($erreur)) 
							{
								echo "<h1 style='color:red;'> $erreur</h1>";
							}
					?>
    <!-- afficher erreur -->
    <div class="form-inline">
        <div class="form-group">
            <input type="hidden" name="identidiant" value="<?php echo($info['id_tarif']);?>">
            <label>Pays : </label>
            <input type="text" class="form-control" name="Pays" value="<?php echo($info['pays']);?>" required="">
        </div>
        <div class="form-group">
            <label>Ville : </label>
            <input type="text" class="form-control" name="Ville" value="<?php echo($info['ville']);?>" required="">
        </div>
        <div class="form-group">
            <label>Poids : </label>
            <input type="text" class="form-control" name="Poids" value="<?php echo($info['poids']);?>" required="">
        </div>


        <div class="form-group">
            <label>Coursie : </label>
            <select class="form-control" name="coursier">
                <?php
								$select=$bdd->PREPARE("SELECT * from coursiers");
								$select->EXECUTE();
								$liste=$select->fetchall();
								foreach ($liste as $coursier) 
								{
									?>
                <option <?php echo(($coursier['id_coursier']==$info['coursier'])?"selected=''":"");?>
                    value="<?php echo($coursier['id_coursier']);?>"><?php echo($coursier['nom']);?></option>
                <?php
								}
								?>
            </select>
        </div>
        <div class="form-group">
            <label>Montant : </label>
            <input type="text" class="form-control" name="Montant" value="<?php echo($info['montant']);?>" required="">
        </div>

        <div class="btn-group form-inline">


            <input type="submit" class="btn btn-success form-control" name="tarif" value="Modifier">
            <input type="submit" class="btn btn-danger form-control" name="tarif" value="X">

        </div>
    </div>


</form>

<?php
			}

		}


	}
}


?>