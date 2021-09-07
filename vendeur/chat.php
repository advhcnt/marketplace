<?php
session_start();
require_once("fonction.php");
$liste_photo = array('jpg', 'jpeg', 'png','gif');
$_liste_video = array("mp4");
$liste_document = array('txt','doc','docx','pdf','xlsx');
$liste_zip = array('zip','rar');
$liste_audio = array('mp3');
#include_once("../include/refresh.php");


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/chat2.css">
    <link rel="stylesheet" href="public/css/w3.css">
    <title>chat</title>
</head>

<body>
    <div class="container">
        <div class="row mt-5 ">
            <!--Liste des commades-->
            <div class="col-md-6 visible-lg visible-md liste_commande" style="padding-top:30px">

                <?php

                    $select=$bdd->PREPARE("SELECT * FROM boutique WHERE patron=?");
                    $select->EXECUTE(array($_SESSION['numero_vendeur']));

                    $boutiques=$select->fetchall();
                    ?>
                <!--<pre><php print_r($boutiques);?></pre>-->
                <h3>Liste des commandes</h3>
                <?php

                     foreach ($boutiques as $boutique)
                     {
                        $select=$bdd->PREPARE("SELECT * from bon_command WHERE boutique LIKE '%".$boutique['id_boutique']."%'  ORDER BY id_bondecommande DESC");
                        $select->EXECUTE();
                        $commandes=$select->fetchall();
                        $i=1;
                        
                        ?>
                <!--<pre><php print_r($commandes);?></pre>-->
                <?php
                        foreach($commandes as $commande)
                        {
                            ?>
                <div class="button_commande bg-primary"
                    style="justify-content:center; align-content:center;text-align:center;margin-left:auto;margin-right:auto">
                    <p><button class="btn btn-info " style="width:100%;letter-spacing: 5px;">Commande
                            n°<?=$i;?></button></p>
                    <br>
                    <p class="btn-group ">
                        <button class="btn btn-info " onclick="myFunction('Demo<?=$i;?>')"
                            style="padding-left:100px;padding-right:100px">Detail
                        </button>


                        <a
                            href="?commande=<?=$commande["id_bondecommande"];?>&amp;destine=service&amp;boutique=<?=$boutique['id_boutique'] ;?>"><button
                                class="btn btn-default ">Message au
                                service</button>
                        </a>

                    <div id="Demo<?=$i;?>" class="w3-hide">

                        <?php

                                    $select = $bdd->PREPARE("SELECT * FROM commandes,bon_command WHERE commandes.boutique=?  AND id_bondecommande=? AND id_bondecommande=commandes.boncommand  ");
                                    $select->EXECUTE(array($boutique['id_boutique'],$commande["id_bondecommande"]));

                                    $nomrbre_cours = $select->rowcount();

                                    $commandes_cours=$select->fetchall();



                                ?>

                        <!-- <pre><php print_r($commandes_cours);?></pre>-->

                        <div class="card card-body table-responsive">
                            <table class="table  table-bordered">
                                <thead class="bg-info text-danger">
                                    <tr>
                                        <td>N°</td>
                                        <td>Date</td>
                                        <td>Commande</td>
                                        <td>Montant</td>
                                        <td></td>

                                    </tr>
                                </thead>
                                <tbody class="bg-primary ">
                                    <?php

                                                                                                foreach($commandes_cours as $commande)
                                                                                                {
                                                                                                    ?>
                                    <tr>
                                        <td><?=$commande['idcmd'];?></td>
                                        <td><?=$commande['jour'];?></td>
                                        <td><?=$commande['libelle'];?> </td>
                                        <td><?=$commande[3];?> €</td>
                                        <td><a
                                                href="?commande=<?=$commande["idcmd"];?>&amp;destine=client&amp;numero_client=<?=$commande['client'] ;?>&amp;boutique=<?=$commande[6] ;?>"><button
                                                    class="btn btn-default">Message</button></a>
                                        </td>

                                    </tr>
                                    <?php
                                                                                                }
                                                                                            ?>


                                </tbody>

                            </table>
                        </div>


                    </div>

                    </p>
                </div>

                <hr>
                <?php
                            $i+=1;
                        }

                     }
                ?>

            </div>

            <!--La discussion-->
            <div class="col-md-6">
                <div class="row bg-primary">
                    <div class="col-xs-3 col-md-3 col-lg-3">
                        <figure>
                            <img src="http://127.0.0.1/marketplace/acheteur/avatar.jpg" alt=""
                                class="img img-responsive img-circle" style="width: 60px;height: 60px;">
                            <figcaption><span class="badge "
                                    style="background-color: green;color:green;margin-left:40px;margin-top:-100px">.</span>
                            </figcaption>
                        </figure>
                    </div>
                    <div class="col-xs-9 col-md-9 col-lg-9">
                        <?php

                    if(isset($_GET['numero_client']))
                    {
                        $select = $bdd->PREPARE("SELECT * FROM clients WHERE id_client=?");
                        $select->EXECUTE(array($_GET['numero_client']));

                        $client_infos=$select->fetch();
                    }
                    


?>
                        <p class="text-center">
                            <i><?=(isset($_GET['numero_client']))?" ".$client_infos['nom']." ".$client_infos['prenoms']:"";?></i>
                        </p>
                        <h4 class="text-center">Commande :
                            <i><?=(isset($_GET['commande']))?$_GET['commande']:"";?></i><br>
                            <i><?=(isset($_GET['numero_client']))?"client N° ".$_GET['numero_client']:"";?></i><br>
                            <?=(isset($_GET['numero_client']))?"<a href='#'><button class='btn btn-danger '>Annuler la commande</button></a> ":"";?>
                            <i><?=(isset($_GET['destine']) && $_GET['destine']=="service")?"Service client de DJAWAO":"";?></i><br>
                            <!--<a href="#"><button class="btn btn-danger ">Annuler la commande</button></a> -->
                        </h4>
                    </div>

                </div>

                <div class="row partie_message">

                    <?php

                        if(isset($_GET['commande']) && intval($_GET['commande']))
                        {
                            if(isset($_GET['destine']) && $_GET['destine']=="service" )
                            {
                                $id_commande=$_GET['commande'];
                                $boutique_id=$_GET['boutique'];
                                $select = $bdd->PREPARE("SELECT * FROM bon_command WHERE id_bondecommande =?");
                                $select->EXECUTE(array($id_commande));
                                $commande_info = $select->fetch();

                                if($select->rowcount() >0)
                                {

                                    $select=$bdd->PREPARE("SELECT * FROM chat WHERE  commande=? AND (id_client1=? or id_client2=?) AND (id_client1=? or id_client2=?) ");
                                    $select->EXECUTE(array($id_commande,$boutique_id,$boutique_id,2147483647,2147483647));

                                    $_SESSION['num_commande']=$id_commande;

                                    $messages = $select->fetchall();

                                   
                                    foreach ($messages as $chat) {
                                        $fichier = (!empty($chat['fichier']))?explode(".",$chat['fichier']):false;
                                        if($chat["auteur"]==$boutique_id)
                                        {
                                            ?>
                    <div class="row client " style="">

                        <span class="alert text-center bg-danger " style="margin-top: 5px;float:left">
                            <?php if(!empty($chat['message'])): ?>
                            <?=$chat['message'];?> <?php elseif(!empty($chat['fichier'])):?>
                            <?php if(in_array($fichier[1],$liste_photo)): ?> <img
                                src="../include/public/img/chat_photo/<?=$chat['fichier'];?>" alt="image" sizes="70"
                                height="50" srcset="">

                            <?php elseif(in_array($fichier[1],$liste_audio)):?>

                            <audio src="../include/public/img/chat_audio/<?=$chat['fichier'];?>" controls
                                type="audio/mp3"></audio>

                            <?php elseif(in_array($fichier[1],$_liste_video)):?>

                            <video src="../include/public/img/chat_video/<?=$chat['fichier'];?>" controls></video>

                            <?php elseif(in_array($fichier[1],$liste_document)):?>

                            <a herf="../include/public/img/chat_document/<?=$chat['fichier'];?>"><?=$chat['fichier'];?><span
                                    class="glyphicon-arrow-down"></span></a>

                            <?php elseif(in_array($fichier[1],$liste_zip)):?>

                            <a herf="../include/public/img/chat_zip/<?=$chat['fichier'];?>"><?=$chat['fichier'];?><span
                                    class="glyphicon-arrow-down"></span></a>

                            <?php endif ?>

                            <?php endif ?>
                        </span>
                    </div>

                    <?php
                                        }
                                        else
                                        {
                                            
                                    
                                            ?>
                    <div class="row autre ">
                        <span class="alert text-center bg-danger" style="margin-top: 5px;float:right">
                            <?php if(!empty($chat['message'])): ?>
                            <?=$chat['message'];?> <?php elseif(!empty($chat['fichier'])):?>
                            <?php if(in_array($fichier[1],$liste_photo)): ?>
                            <img src="../include/public/img/chat_photo/<?=$chat['fichier'];?>" alt="image" sizes="70"
                                height="50" srcset="">

                            <?php elseif(in_array($fichier[1],$liste_audio)):?>

                            <audio src="../include/public/img/chat_audio/<?=$chat['fichier'];?>" controls
                                type="audio/mp3"></audio>

                            <?php elseif(in_array($fichier[1],$_liste_video)):?>

                            <video src="../include/public/img/chat_video/<?=$chat['fichier'];?>" controls></video>

                            <?php elseif(in_array($fichier[1],$liste_document)):?>

                            <a herf="../include/public/img/chat_document/<?=$chat['fichier'];?>"><?=$chat['fichier'];?><span
                                    class="glyphicon-arrow-down"></span></a>

                            <?php elseif(in_array($fichier[1],$liste_zip)):?>

                            <a herf="../include/public/img/chat_zip/<?=$chat['fichier'];?>"><?=$chat['fichier'];?><span
                                    class="glyphicon-arrow-down"></span></a>

                            <?php endif ?>

                            <?php endif ?>
                        </span>
                    </div>
                    <?php
                                        }
                                      
                                    }
                                }
                                ?>

                    <div class="row bg-dark fixed-bottom" style="bottom:12px;float:right;position:fixed">

                        <form
                            action="chat_envoi.php?sending_message=sending_message&amp;destinataire=service&amp;destinateur=<?=$boutique_id;?>"
                            class="form form-inline bg-dark float-right" method="post" enctype='multipart/form-data' id="formulaire1">

                           <!--Pour envoyer une photo -->
                           <div class="input-group input-file" name="photo1">
                                <span class="input-group-btn">
                                    <button class="btn btn-choose btn-default" type="button"
                                        style="margin-top:-40px"><img
                                            src="http://127.0.0.1/marketplace/acheteur/public/img/grid.png" alt=""
                                            srcset="" class="img-responsive" style="width: 30px;height: 30px;">
                                    </button>
                                </span>
                                <input type="hidden" class="form-control" value="0" name="cacher" id="toto1"/>
                            </div>
                            <textarea id="message1" cols="20" rows="2" style="border-radius: 12px;" class=""
                                name="message"></textarea>

                            <button class="btn" type="submit" style="margin-top:-40px" name="envoie"><img
                                    src="http://127.0.0.1/marketplace/acheteur/public/img/android-send.png" alt=""
                                    srcset="" class="img-responsive" style="width: 30px;height: 30px;">
                            </button>
                        </form>


                    </div>

                    <?php
                            }
                            else if(isset($_GET['destine']) && $_GET['destine']=="client" && isset($_GET["boutique"]) && is_int(intval($_GET["boutique"])) )
                            {
                                $id_commande=$_GET['commande'];
                                $id_vendeur= $_GET["boutique"];
                                $client = $_GET['numero_client'];

                                $select = $bdd->PREPARE("SELECT * FROM commandes WHERE idcmd =?");
                                $select->EXECUTE(array($id_commande));
                                $commande_info = $select->fetch();

                                if($select->rowcount() >0)
                                {

                                    $select=$bdd->PREPARE("SELECT * FROM chat WHERE  commande=? AND (id_client1=? or id_client2=?) AND (id_client1=? or id_client2=?) ");
                                    $select->EXECUTE(array($id_commande,$client,$client,$id_vendeur,$id_vendeur));

                                    $_SESSION['num_commande']=$id_commande;

                                    $messages = $select->fetchall();

                                    foreach ($messages as $chat) {
                                        $fichier = (!empty($chat['fichier']))?explode(".",$chat['fichier']):false;
                                        if($chat["auteur"]==$id_vendeur)
                                        {
                                            ?>
                    <div class="row client " style="">

                        <span class="alert text-center bg-danger" style="margin-top: 5px;;float:left">
                            <?php if(!empty($chat['message'])): ?>
                            <?=$chat['message'];?> <?php elseif(!empty($chat['fichier'])):?>
                            <?php if(in_array($fichier[1],$liste_photo)): ?>
                            <img src="../include/public/img/chat_photo/<?=$chat['fichier'];?>" alt="image" sizes="70"
                                height="50" srcset="">

                            <?php elseif(in_array($fichier[1],$liste_audio)):?>

                            <audio src="../include/public/img/chat_audio/<?=$chat['fichier'];?>" controls
                                type="audio/mp3"></audio>

                            <?php elseif(in_array($fichier[1],$_liste_video)):?>

                            <video src="../include/public/img/chat_video/<?=$chat['fichier'];?>" controls></video>

                            <?php elseif(in_array($fichier[1],$liste_document)):?>

                            <a herf="../include/public/img/chat_document/<?=$chat['fichier'];?>"><?=$chat['fichier'];?><span
                                    class="glyphicon-arrow-down"></span></a>

                            <?php elseif(in_array($fichier[1],$liste_zip)):?>

                            <a herf="../include/public/img/chat_zip/<?=$chat['fichier'];?>"><?=$chat['fichier'];?><span
                                    class="glyphicon-arrow-down"></span></a>

                            <?php endif ?>

                            <?php endif ?>
                        </span>
                    </div>

                    <?php
                                        }
                                        else
                                        {
                                            
                                    
                                            ?>
                    <div class="row autre ">
                        <span class="alert text-center bg-danger" style="margin-top: 5px;float:right;">
                            <?php if(!empty($chat['message'])): ?>
                            <?=$chat['message'];?> <?php elseif(!empty($chat['fichier'])):?>
                            <?php if(in_array($fichier[1],$liste_photo)): ?>
                            <img src="../include/public/img/chat_photo/<?=$chat['fichier'];?>" alt="image" sizes="70"
                                height="50" srcset="">

                            <?php elseif(in_array($fichier[1],$liste_audio)):?>

                            <audio src="../include/public/img/chat_audio/<?=$chat['fichier'];?>" controls
                                type="audio/mp3"></audio>

                            <?php elseif(in_array($fichier[1],$_liste_video)):?>

                            <video src="../include/public/img/chat_video/<?=$chat['fichier'];?>" controls></video>

                            <?php elseif(in_array($fichier[1],$liste_document)):?>

                            <a herf="../include/public/img/chat_document/<?=$chat['fichier'];?>"><?=$chat['fichier'];?><span
                                    class="glyphicon-arrow-down"></span></a>

                            <?php elseif(in_array($fichier[1],$liste_zip)):?>

                            <a herf="../include/public/img/chat_zip/<?=$chat['fichier'];?>"><?=$chat['fichier'];?><span
                                    class="glyphicon-arrow-down"></span></a>

                            <?php endif ?>

                            <?php endif ?>
                        </span>
                    </div>
                    <?php
                                        }
                                      
                                    }
                                }
                                ?>

                    <div class="row bg-dark fixed-bottom" style="bottom:12px;float:right;position:fixed">

                        <form
                            action="chat_envoi.php?sending_message=sending_message&amp;destinataire=<?=$client;?>&amp;destinateur=<?=$id_vendeur;?>"
                            class="form form-inline bg-dark float-right" method="post" enctype='multipart/form-data' id="formulaire2">

                           <!--Pour envoyer une photo -->
                           <div class="input-group input-file" name="photo">
                                <span class="input-group-btn">
                                    <button class="btn btn-choose btn-default" type="button"
                                        style="margin-top:-40px"><img
                                            src="http://127.0.0.1/marketplace/acheteur/public/img/grid.png" alt=""
                                            srcset="" class="img-responsive" style="width: 30px;height: 30px;">
                                    </button>
                                </span>
                                <input type="hidden" class="form-control" value="0" name="cacher" id="toto"/>
                            </div>

                            <textarea id="message2" cols="20" rows="2" style="border-radius: 12px;" class=""
                                name="message"></textarea>

                            <button class="btn" type="submit" style="margin-top:-40px" name="envoie"><img
                                    src="http://127.0.0.1/marketplace/acheteur/public/img/android-send.png" alt=""
                                    srcset="" class="img-responsive" style="width: 30px;height: 30px;">
                            </button>
                        </form>


                    </div>

                    <?php
                            }
                            else
                            {

                            }  
                           
                        }
                    ?>
                </div>

            </div>
        </div>
    </div>
    <script src="public/js/jquery.min.js "></script>
    <script src="public/js/bootstrap.min.js "></script>
    <script src="public/js/fichier.js"></script>
    <script>
    function myFunction(id) {
        var x = document.getElementById(id);
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
        } else {
            x.className = x.className.replace(" w3-show", "");
        }
    }
    </script>

</body>

</html>