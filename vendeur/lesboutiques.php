<?php
//Afficher les informations d'une boutique
session_start();
include 'fonction.php';
if(isset($_GET['boutique']) AND !empty($_GET['boutique']) AND is_numeric($_GET['boutique']) )
{
	$select=$bdd->PREPARE("SELECT * FROM boutique WHERE patron=? AND id_boutique=?");
	$select->EXECUTE(array($_SESSION['numero_vendeur'],$_GET['boutique']));
	$info=$select->fetch();
	$boutique=$select->rowcount();


	if($boutique==1)
	{
		$_SESSION['boutique'] = $_GET['boutique'];
		?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/lesboutiques1.css">

    <title>Ma boutique</title>

</head>

<body>
    <div class="container-fluid">

        <div class="row display-flex" style="margin-bottom:10px">
            <h2 class="text-center bg-success col-8">Boutique : <?php echo($info['nom']); ?></h2>
            <a href="deconnexion.php" class="col-4"><button class="btn btn-success text-right">Deconnexion</button></a>
        </div>

        <div class="row btn_goup_1 ">
            <div class="btn-group ">
                <a href="lesboutiques.php?boutique=<?php echo($_SESSION['boutique']);?>&amp;action=ajout"
                    class="btn  btn-success "> Ajout
                    produit</a>
                <a href="lesboutiques.php?boutique=<?php echo($_SESSION['boutique']);?>&amp;action=modi_sup"
                    class="btn  btn-danger ">
                    Modifier/suprimer produit</a>

                <a href="lesboutiques.php?boutique=<?php echo($_SESSION['boutique']);?>&amp;action=liste_commande"
                    class="btn  btn-primary ">
                    Liste des commandes</a>

                <a href="chat.php" class="btn  btn-success ">
                    Chat</a>
            </div>
        </div>


    </div>



    <?php
		

		if(isset($_GET["action"]))
		{
			
			if($_GET["action"]=="ajout")
			{
				if(isset($_POST['submit']))
				{
					$categorie = verification($_POST['categorie']);
					$libelle = verification($_POST['libelle']);
					$description = verification($_POST['description']);
					$poid = verification($_POST['poid']);
					$prix = verification($_POST['prix']);

					$quantite = verification($_POST['quantite']);

                    $extension = extension($_FILES['photo_profil']);
                    $photo = verification_image($_FILES['photo_profil']);
                    $profil = strval(time()).$info['nom'].".".$extension;

                    $tableau_image = tableau_fichier($_FILES['autre']);
                    $extension_multiple=extension_multiple($tableau_image);
                    $image_multiple = verification_image_multiple($tableau_image);
                    $nombre_photo = count($extension_multiple);

                    $listephoto = array();#liste des photos
                    $text_photo ="";#texte des photos 

                    for($i=0;$i<$nombre_photo;$i++)
                    {
                        $picture = strval(time()).$info['nom']."$i".".".$extension_multiple[$i];
                        $listephoto[$i] = $picture;
                        $text_photo.=$picture."-";
                    }
                   

					if(!empty($categorie) AND !empty($libelle) AND !empty($description) AND !empty($poid) AND !empty($prix) AND !empty($quantite) )
					{
						$select=$bdd->PREPARE("SELECT id_souscat2 FROM sous_categories2 WHERE nom_sous_cat2=?");
						$select->EXECUTE(array($categorie));
						$cate=$select->fetch();
						#echo "<br><br>";
						#print_r($cate);
						$cat=$cate['id_souscat2'];

						#echo "<br><br>";
						#print_r(array("",$libelle,$poid,$description,$prix,$cat,$quantite,$_SESSION['boutique']));


						$insert = $bdd->PREPARE("INSERT INTO produits values(?,?,?,?,?,?,?,?,?)");
						$insert->EXECUTE(array("",$libelle,$poid,$description,$prix,$cat,$quantite,$_SESSION['boutique'], $profil));

                        $select = $bdd->PREPARE("SELECT*  FROM produits WHERE photo=?");
						$select->EXECUTE(array($profil));
                        $pho = $select->fetch();

                        $insert = $bdd->PREPARE("INSERT INTO autres_photos(produit,nombre,photos) values(?,?,?)");

                        $insert->EXECUTE(array($pho["id_prod"],$nombre_photo,$text_photo));

                        
                        for($b=0;$b<$nombre_photo;$b++)
                        {
                            $fichier = $image_multiple[$b];
                            move_uploaded_file($fichier,"../include/public/photo_produit/".$listephoto[$b]);
                        }
                        move_uploaded_file($photo,"../include/public/photo_produit/".$profil);
                    }



					
				}

				?>
    <h3 class="text-center">Ajout de produit</h3>
    <form action="" method="post" class="form form_1 " multipart=""  enctype="multipart/form-data">
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label>Categorie : </label>
                <select name="categorie" class="form-control">
                    <?php  

												$select=$bdd->PREPARE("SELECT * FROM sous_categories2 ");
												$select->EXECUTE();
												$liste=$select->fetchall();
												foreach ($liste as $key) {
													# code...
													?>
                    <option value="<?php echo($key['nom_sous_cat2']);?>"><?php echo($key['nom_sous_cat2']);?>
                    </option>

                    <?php
												}

											?>
                </select>
            </div>
            <div class="form-group">
                <label for="libelle">Nom : </label>
                <input type="text" name="libelle" required="" class="form-control" id="libelle">
            </div>

            <div class="form-group">
                <label for="description">Description : </label>
                <input type="text" name="description" required="" class="form-control" id="description">
            </div>

            <div class="form-group">
                <label for="pu">Prix unitaire : </label>
                <input type="text" name="prix" required="" class="form-control" id="pu">
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="poid">Poids </label>
                <input type="text" name="poid" required="" class="form-control" id="poid">
            </div>

            <div class="form-group">
                <label for="qte">Quantite </label>
                <input type="text" name="quantite" required="" class="form-control" id="qte">
            </div>

            <div class="form-group">
                <label for="poid">Photo </label>
                <div class="input-group input-file" name="photo_profil">
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-choose" type="button">Choisir un fichier</button>
                    </span>
                    <input type="text" class="form-control" placeholder='fichier image' multiple />

                </div>
            </div>

            <div class="form-group">
                <label for="autes">Autres photos </label>
                <input type="file" name="autre[]" id="autes" multiple>
            </div>

        </div>

        <div class="form-group">

            <input type="submit" name="submit" value="envoyé" class="btn btn-success form-control">
        </div>

    </form>

    <?php
	
			}
			elseif($_GET["action"]=="liste_commande")
			{
				$select=$bdd->PREPARE("SELECT * from commandes WHERE boutique=?  ORDER BY idcmd DESC");
                $select->EXECUTE(array($_SESSION['boutique']));
                $commandes=$select->fetchall();

				if(isset($_POST["submit"]))
				{
					
					if(isset($_POST['lacommande']) && filter_input(INPUT_POST,"lacommande",FILTER_VALIDATE_INT))
					{
						$commande = intval($_POST['lacommande']);

						if($_POST["submit"]=="terminer")
						{
							$update = $bdd->PREPARE("UPDATE commandes set etat =? WHERE idcmd=?");
							$update ->EXECUTE(array("Terminée",$commande));
							$url = $_SERVER['REQUEST_URI'];
							header("Location:$url");
						}
						elseif($_POST["submit"]=="annuler")
						{
							$update = $bdd->PREPARE("UPDATE commandes set etat =? WHERE idcmd=?");
							$update ->EXECUTE(array("Annulée",$commande));
							$url = $_SERVER['REQUEST_URI'];
							header("Location:$url");
						}
						elseif($_POST["submit"]=="livrer")
						{
							$update = $bdd->PREPARE("UPDATE commandes set etat =? WHERE idcmd=?");
							$update ->EXECUTE(array("Livrée",$commande));
							$url = $_SERVER['REQUEST_URI'];
							header("Location:$url");
						}	
					}	
				}
				if(isset($_POST["submit_liste"]))
				{
					if($_POST["submit_liste"]=="terminer_liste"){
						$select=$bdd->PREPARE("SELECT * from commandes WHERE boutique=? AND etat=?  ORDER BY idcmd DESC");
						$select->EXECUTE(array($_SESSION['boutique'],"Terminée"));
						$commandes=$select->fetchall();
					}
					elseif($_POST["submit_liste"]=="livrer_liste"){
						$select=$bdd->PREPARE("SELECT * from commandes WHERE boutique=? AND etat=?  ORDER BY idcmd DESC");
						$select->EXECUTE(array($_SESSION['boutique'],"Livrée"));
						$commandes=$select->fetchall();
					}
					elseif($_POST["submit_liste"]=="annuler_liste"){
						$select=$bdd->PREPARE("SELECT * from commandes WHERE boutique=? AND etat=?  ORDER BY idcmd DESC");
						$select->EXECUTE(array($_SESSION['boutique'],"Annulée"));
						$commandes=$select->fetchall();
					}
					elseif($_POST["submit_liste"]=="en_cours_liste"){
						$select=$bdd->PREPARE("SELECT * from commandes WHERE boutique=? AND etat=?  ORDER BY idcmd DESC");
						$select->EXECUTE(array($_SESSION['boutique'],"En attente"));
						$commandes=$select->fetchall();
					}
					elseif($_POST["submit_liste"]=="tout_liste"){
						$select=$bdd->PREPARE("SELECT * from commandes WHERE boutique=?   ORDER BY idcmd DESC");
						$select->EXECUTE(array($_SESSION['boutique']));
						$commandes=$select->fetchall();
					}
				}
				

			
				?>
    <div class="mt-5 my-5" style="margin-top:15px">
        <div class="text-center w3-display-left " style="margin-bottom:10px">
            <form action="#" method="post">
                <div class="btn-group ">
                    <button class="btn submit btn-primary " name="submit_liste" value="terminer_liste">Terminée</button>
                    <button class="btn submit btn-danger" name="submit_liste" value="annuler_liste">Annulée</button>
                    <button class="btn submit btn-success" name="submit_liste" value="livrer_liste">Livrée</button>
                    <button class="btn submit btn-primary" name="submit_liste" value="en_cours_liste">En cours</button>
                    <button class="btn submit btn-secondary" name="submit_liste" value="tout_liste">Toute les
                        commandes</button>
                </div>
            </form>

        </div>
        <table class="table table-bordered table-hover table-condensed table-responsive">
            <thead class="bg-success text-uppercase text_carousel text-center style-bold">
                <tr>
                    <td>Commande</td>
                    <td>Libelle</td>
                    <td>Quantite</td>
                    <td>Prix</td>
                    <td>Etat</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                <?php
			foreach ($commandes as $commande)
				{?>
                <form action="" method="post">
                    <tr>
                        <input type="hidden" name="lacommande" value="<?=$commande["idcmd"];?>">
                        <td class="text-center"><?=$commande["idcmd"];?></td>
                        <td class="text-center"><?=$commande["libelle"];?></td>
                        <td class="text-center"><?=$commande["qte"];?></td>
                        <td class="text-center"><?=$commande["prix"];?></td>
                        <td class="text-center"><?=$commande["etat"];?></td>
                        <td class="text-center">

                            <div class="btn-group ">
                                <button class="btn submit btn-primary " name="submit" value="terminer">Terminée</button>
                                <button class="btn submit btn-danger" name="submit" value="annuler">Annulée</button>
                                <button class="btn submit btn-success" name="submit" value="livrer">Livrée</button>

                            </div>
                            <a href="http://"><button class="btn  btn-success">Chat <span
                                        class="glyphicon glyphicon-envelope"></span> </button></a>


                        </td>
                    </tr>
                </form>

                <?php

				}?>

            </tbody>
        </table>
        <h3 class="text-info text-center">
            <?=(!isset($commande))?"Désolé vous n'avez pas encore de commade à cet stade ......":"";?></h3>

    </div>


    <?php

				
			}
			elseif ($_GET['action']=="modi_sup") 
			{
				if(isset($_POST['valide']))
				{
					$categorie = verification($_POST['categorie']);
					$libelle = verification($_POST['libelle']);
					$numero = verification($_POST['numero']);
					$description = verification($_POST['description']);
					$poid = verification($_POST['poid']);
					$prix = verification($_POST['prix']);
					$quantite = verification($_POST['quantite']);
					
					if(!empty($categorie) AND !empty($libelle) AND !empty($numero) AND !empty($description) AND !empty($poid) AND !empty($prix) AND !empty($quantite) )
					{
						$select = $bdd->PREPARE("SELECT * from produits where id_prod=?");
						$select->EXECUTE(array($numero));
						$produit=$select->rowcount();

						if($produit==1)
						{

							$select=$bdd->PREPARE("SELECT id_souscat2 FROM sous_categories2 WHERE nom_sous_cat2=?");
							$select->EXECUTE(array($categorie));
							$cate=$select->fetch();
							$cat=$cate['id_souscat2'];

							$update=$bdd->PREPARE("UPDATE produits set libelle=?,poids=?,description=?,prix_unitaire=?,souscat_id=?,quantite=? WHERE id_prod=?");
							$update->EXECUTE(array($libelle,$poid,$description,$prix,$cat,$quantite,$numero));

							
						}
					}

					
				}
				elseif(isset($_POST['valide_pomo']))
				{

					$promo = filter_input(INPUT_POST,'promo',FILTER_SANITIZE_NUMBER_INT);
					$produit = filter_input(INPUT_POST,'produit',FILTER_SANITIZE_NUMBER_INT);
					$code = filter_input(INPUT_POST,'code',FILTER_SANITIZE_STRING);
					$reduction =floatval($_POST['reduction']);
					$debut = $_POST['datededebut'];
					$fin = $_POST['datedefin'];

					if(!empty($reduction) && !empty($debut) && !empty($fin))
					{
						if(!empty($promo) && !empty($produit)){

							$update = $bdd->PREPARE("UPDATE promos set reduction = ?,code=?,datedebut=?,datedefin=? WHERE id_promo=? AND produit=?");
							$update->EXECUTE(array($reduction,$code,$debut,$fin,$promo,$produit));
							#die(array($reduction,$debut,$fin,$promo,$produit));
						}
						elseif(!empty($produit))
						{
							$insert = $bdd->PREPARE("INSERT INTO promos(produit,reduction,code,datedebut,datedefin) values(?,?,?,?,?)");
							$insert->EXECUTE(array($produit,$reduction,$code,$debut,$fin));
							
						}
					}
					else{
						$erreur = "Impossible d'éffecyuer l'action demandé";
					}
				}

				if(isset($_POST["submit"]))
				{
					//pour modifier un produits
					if($_POST["submit"]=="Modifier")
					{

						if(!empty($_POST["produit"]) and !empty($_POST["produit"]) AND is_numeric($_POST["produit"]))
						{




							$select = $bdd->PREPARE("SELECT * from produits where id_prod=?");
							$select->EXECUTE(array($_POST["produit"]));
							$produits=$select->fetch();

							$select = $bdd->PREPARE("SELECT * from promos where produit=?");
							$select->EXECUTE(array($_POST["produit"]));
							$promo=$select->fetch();


							?>

    <div class="row">

        <!--Modification de produit -->
        <div class="col-xs-12 col-sm-12 col-md-6">

            <form action="" method="post" class="form form_1" enctype="multipart/form-data">
                <h3 class="text-center">Modification de produit</h3>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label>Nom : </label>
                        <select name="categorie" class="form-control">
                            <?php  

											$select=$bdd->PREPARE("SELECT * FROM sous_categories2 ");
											$select->EXECUTE();
											$liste=$select->fetchall();
											foreach ($liste as $key) {
												# code...
												?>
                            <option value="<?php echo($key['nom_sous_cat2']);?>"
                                <?php echo(($key['id_souscat2']==$produits['souscat_id'])?"selected=":'');?>>
                                <?php echo($key['nom_sous_cat2']);?></option>

                            <?php
											}

										?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nom2">Nom : </label>
                        <input type="text" name="libelle" required="" value="<?php echo($produits['libelle']);?>"
                            id="nom2" class="form-control">
                        <input type="hidden" name="numero" value="<?php echo($produits['id_prod']);?>">
                    </div>


                    <div class="form-group">
                        <label for="des">Description : </label>
                        <input type="text" name="description" required=""
                            value="<?php echo($produits['description']);?>" id="des" class="form-control">

                    </div>

                    <div class="form-group">
                        <label for="pu2">Prix unitaire : </label>
                        <input type="text" name="prix" required="" value="<?php echo($produits['prix_unitaire']);?>"
                            id="pu2" class="form-control">
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="p2">Poids </label>
                        <input type="text" name="poid" required="" value="<?php echo($produits['poids']);?>" id="p2"
                            class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="qte2">Quantite </label>
                        <input type="text" name="quantite" required="" value="<?php echo($produits['quantite']);?>"
                            id="qte2" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="poid">Photo </label>
                        <div class="input-group input-file" name="photo_profil">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-choose" type="button">Choisir un fichier</button>
                            </span>
                            <input type="text" class="form-control" placeholder='fichier image' multiple />

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="autes">Autres photos </label>
                        <input type="file" name="autre" id="autes" multiple>
                    </div>
                </div>



                <div class="form-group">

                    <input type="submit" name="valide" value="valide" class="form-control btb btn-success">
                </div>



            </form>
        </div>
        <!--Div code promo -->
        <div class="col-xs-12 col-sm-12 col-md-6">
            <form action="" method="post" class="form form_1">
                <h3 class="text-center">CODE PROMO</h3>

                <div class="form-group">
                    <!--<label for="libelle">Nom : </label>
                    <input type="text" name="libelle" required="" value="<?php echo($produits['libelle']);?>"
                        id="libelle" class="form-control disabled">-->

                    <input type="hidden" name="produit" value="<?=($produits['id_prod']);?>">
                    <input type="hidden" name="promo" value="<?=($promo['id_promo']);?>">
                </div>


                <div class="form-group">
                    <label for="reduction">Reduction : </label>
                    <input type="text" name="reduction" required="" value="<?=($promo['reduction']);?>" id="reduction"
                        class="form-control" placeholder="Entre le pourcentage de reduction Ex:12.5">

                </div>

                <div class="form-group">
                    <label for="code">Code Promo : </label>
                    <input type="text" name="code" required="" value="<?=($promo['code']);?>" id="code"
                        class="form-control" placeholder="Entre le code promo Ex:ASEDX23">

                </div>

                <div class="form-group">
                    <label for="promo1">Debut Promo : </label>
                    <input type="date" name="datededebut" required="" value="<?=($promo['datedebut']);?>" id="promo1"
                        class="form-control">


                </div>

                <div class="form-group">
                    <label for="promo2">Fin Promo : </label>
                    <input type="date" name="datedefin" required="" value="<?=($promo['datedefin']);?>" id="promo2"
                        class="form-control">
                </div>

                <div class="form-group">

                    <input type="submit" name="valide_pomo" value="Ajouter/Modifier"
                        class="form-control btb btn-success">
                </div>



            </form>
        </div>
    </div>



    <?php
						}
					}
					elseif ($_POST["submit"]=="X") {
						#pour supprimer un produit
						# code...
						$select = $bdd->PREPARE("SELECT * from produits where id_prod=?");
						$select->EXECUTE(array($_POST["produit"]));
						$produits=$select->rowcount();

						if($produits==1)
						{
							$delete=$bdd->PREPARE("DELETE FROM produits WHERE id_prod=?");
							$delete->EXECUTE(array($_POST["produit"]));
						}
						
					}

				}
				$select = $bdd->PREPARE("SELECT * from produits where boutique=?");
				$select->EXECUTE(array($_SESSION['boutique']));
				$produits=$select->fetchall();
?>
    <h3 class="text-center">Liste des produits</h3>
    <?php
				foreach ($produits as $key) 
				{
					# code...
					?>

    <div style="justify-content:center;align-content:center;text-align:center">
        <form action="" method="post" class="form btn_modification  form-inline">

            <div class="form-group ">
                <h3><?php echo($key['libelle']) ?></h3>
                <input type="hidden" name="produit" value="<?php echo($key['id_prod']) ?>">
            </div>
            <div class="btn-group">
                <input type="submit" name="submit" value="Modifier" class="btn btn-primary">
                <input type="submit" name="submit" value="X" class="btn btn-danger">
            </div>

        </form>
    </div>


    <?php
				}
			}
			else
			{
				header("location:erreur_404.php");
			}
		}
?>
    <script src="public/js/jquery.min.js "></script>
    <script src="public/js/bootstrap.min.js "></script>
    <script src="public/js/fichier.js"></script>
</body>
<?php
	}
	else
	{
		header("location:erreur_404.php");
	}

}


?>