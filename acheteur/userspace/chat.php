<?php
session_start();

require_once("../fonction.php");
$liste_photo = array('jpg', 'jpeg', 'png','gif');
$_liste_video = array("mp4");
$liste_document = array('txt','doc','docx','pdf','xlsx');
$liste_zip = array('zip','rar');
$liste_audio = array('mp3');
//include_once("../../include/refresh.php");
if(isset($_SESSION['id_client']) && !empty($_SESSION['id_client']) && filter_var($_SESSION['id_client'],FILTER_VALIDATE_INT))
{
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="chat.css">
    <link rel="stylesheet" href="w3.css">

    <title>chat</title>
</head>

<body>
    <div class="container">
        <div class="row mt-5 ">
            <!--Liste des commades-->
            <div class="col-md-6 visible-lg visible-md liste_commande" style="padding-top:30px">

                <?php
    
                        $select=$bdd->PREPARE("SELECT * from bon_command WHERE client=?  ORDER BY id_bondecommande DESC");
                        $select->EXECUTE(array($_SESSION['id_client']));
                        $commandes=$select->fetchall();
                        $i=1;
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


                        <a href="?commande=<?=$commande["id_bondecommande"];?>&amp;destine=service"><button
                                class="btn btn-default ">Message au
                                service</button></a>

                    <div id="Demo<?=$i;?>" class="w3-hide">

                        <?php
    
                                    $select = $bdd->PREPARE("SELECT * FROM commandes,bon_command WHERE client=?  AND id_bondecommande=? AND id_bondecommande=commandes.boncommand  ");
                                    $select->EXECUTE(array($_SESSION['id_client'],$commande["id_bondecommande"]));
    
                                    $nomrbre_cours = $select->rowcount();
    
                                    $commandes_cours=$select->fetchall();
    
    
    
                                ?>
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
                                                href="?commande=<?=$commande["idcmd"];?>&amp;destine=vendeur&amp;numero_vendeur=<?=$commande[6] ;?>"><button
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
    
                        if(isset($_GET['numero_vendeur']))
                        {
                            $select= $bdd->PREPARE("SELECT nom FROM boutique where id_boutique = ?");
                            $select->EXECUTE(array($_GET['numero_vendeur']));
    
                            $infos = $select->fetch();
                        }
                        if( isset($_POST["annuler"]) && $_POST["annuler"]=="annuler" && isset($_POST["commande"]) && filter_input(INPUT_POST,"commande",FILTER_VALIDATE_INT))
                            {
                                $commade_ici = intval($_GET['commande']);
                                $update = $bdd->PREPARE("UPDATE commandes set etat=? WHERE idcmd=?");
                                $update ->EXECUTE(array("Annulée",$commade_ici));
                                
                                $url = $_SERVER['REQUEST_URI'];
                                #header_remove();
                                #header("Location:$url");
                                echo("<script>
                                window.location.href=$url;
                                </script>");
                            }
                            elseif(isset($_POST["annuler"]) && $_POST["annuler"]=="relancer" && isset($_POST["commande"]) && filter_input(INPUT_POST,"commande",FILTER_VALIDATE_INT))
                            {
                                $commade_ici = intval($_GET['commande']);
                                $update = $bdd->PREPARE("UPDATE commandes set etat=? WHERE idcmd=?");
                                $update ->EXECUTE(array("En attente",$commade_ici));
                                
                                $url = $_SERVER['REQUEST_URI'];
                                
                                #header("Location:$url");
                                echo("<script>
                                window.location.href=$url;
                                </script>");
                            }
    
    ?>

                        <p class="text-center">
                            <i><?=(isset($_GET['numero_vendeur']))?"BOUTIQUE ".$infos['nom']:"";?></i>
                        </p>
                        <h4 class="text-center">Commande :
                            <i><?=(isset($_GET['commande']))?$_GET['commande']:"";?></i><br>
                            <i><?=(isset($_GET['numero_vendeur']))?"Vendeur N° ".$_GET['numero_vendeur']:"";?></i><br>

                            <?php if(isset($_GET['numero_vendeur'])):?>

                            <form action='' method='post'>

                                <input type='hidden' name='commande' value='<?=($_GET['commande']);?>'>
                                <div class="btn-group">
                                    <button class='submit btn btn-danger' value='annuler' name='annuler'>Annuler la
                                        commande</button>
                                    <button class='submit btn btn-success' value='relancer' name='annuler'>Relancer la
                                        commande</button>
                                </div>

                            </form>

                            <?php endif;?>
                            <i><?=(isset($_GET['destine']) && $_GET['destine']=="service")?"Service client de DJAWAO":"";?></i><br>

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
                                    $select = $bdd->PREPARE("SELECT * FROM bon_command WHERE id_bondecommande =?");
                                    $select->EXECUTE(array($id_commande));
                                    $commande_info = $select->fetch();
    
                                    if($select->rowcount() >0)
                                    {
    
                                        $select=$bdd->PREPARE("SELECT * FROM chat WHERE  commande=? AND (id_client1=? or id_client2=?) AND (id_client1=? or id_client2=?)");
                                        $select->EXECUTE(array($id_commande,$_SESSION['id_client'],$_SESSION['id_client'],2147483647,2147483647));
    
                                        $_SESSION['num_commande']=$id_commande;
    
                                        $messages = $select->fetchall();
    
                                        foreach ($messages as $chat) {
                                            $fichier = (!empty($chat['fichier']))?explode(".",$chat['fichier']):false;

                                            if($chat["auteur"]==$_SESSION['id_client'])
                                            {
                                                
                                                ?>
                    <div class="row client " >
                        <?php if(!empty($chat['message'])): ?>

                            <span class="alert text-center bg-danger" style="margin-top: 5px;float:left"><?=$chat['message'];?></span>

                        <?php elseif(!empty($chat['fichier'])):?>
                            
                            <?php if(in_array($fichier[1],$liste_photo)): ?>

                                <span class="alert text-center bg-danger" style="margin-top: 5px;float:left">

                                    <img src="../../include/public/img/chat_photo/<?=$chat['fichier'];?>" alt="image" sizes="70" height="50" srcset="">

                                </span>

                            <?php elseif(in_array($fichier[1],$liste_audio)):?>

                                <span class="alert text-center bg-danger" style="margin-top: 5px;float:left">

                                    <audio src="../../include/public/img/chat_photo/<?=$chat['fichier'];?>" controls type="audio/mp3"></audio>
                                    
                                </span>

                            <?php elseif(in_array($fichier[1],$_liste_video)):?>

                                <span class="alert text-center bg-danger" style="margin-top: 5px;float:left">

                                    <video src="../../include/public/img/chat_photo/<?=$chat['fichier'];?>"><?=$chat['fichier'];?></video>
                                        

                                </span> 

                            <?php elseif(in_array($fichier[1],$liste_document)):?>

                                <span class="alert text-center bg-danger" style="margin-top: 5px;float:left">

                                    <a herf="../../include/public/img/chat_photo/<?=$chat['fichier'];?>"><?=$chat['fichier'];?></a>
                                            

                                </span> 

                             <?php elseif(in_array($fichier[1],$liste_zip)):?>

                                <span class="alert text-center bg-danger" style="margin-top: 5px;float:left">

                                    <a herf="../../include/public/img/chat_photo/<?=$chat['fichier'];?>"><?=$chat['fichier'];?></a>

                                </span> 
                            <?php endif ?> 
                                                                      

                        <?php endif ?>

                    </div>

                    <?php
                                            }
                                            else
                                            {?>

                    <div class="row autre ">
                        <span class="alert text-center bg-danger " style="margin-top: 5px;float:right;">

                            <?php if(!empty($chat['message'])): ?>

                                    <?=$chat['message'];?>

                            <?php elseif(!empty($chat['fichier'])):?>

                                <?php if(in_array($fichier[1],$liste_photo)): ?>

                                    <img src="../../include/public/img/chat_photo/<?=$chat['fichier'];?>" alt="image" sizes="70" height="50" srcset="">

                                <?php elseif(in_array($fichier[1],$liste_audio)):?>

                                    <audio src="../../include/public/img/chat_audio/<?=$chat['fichier'];?>" controls type="audio/mp3"><?=$chat['fichier'];?></audio>
                                    
                                <?php elseif(in_array($fichier[1],$_liste_video)):?>

                                    <video src="../../include/public/img/chat_video/<?=$chat['fichier'];?>" controls preload="false" ></video>
                                                        
                                <?php elseif(in_array($fichier[1],$liste_document)):?>

                                    <a herf="../../include/public/img/chat_document/<?=$chat['fichier'];?>"><?=$chat['fichier'];?></a>
                                                            
                                <?php elseif(in_array($fichier[1],$liste_zip)):?>

                                    <a herf="../../include/public/img/chat_zip/<?=$chat['fichier'];?>"><?=$chat['fichier'];?></a>

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

                        <form action="chat_envoi.php?sending_message=sending_message&amp;destinataire=service"
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
                                else if(isset($_GET['destine']) && $_GET['destine']=="vendeur" && isset($_GET["numero_vendeur"]) && is_int(intval($_GET["numero_vendeur"])) )
                                {
                                    $id_commande=$_GET['commande'];
                                    $id_vendeur= $_GET["numero_vendeur"];
    
                                    $select = $bdd->PREPARE("SELECT * FROM commandes WHERE idcmd =?");
                                    $select->EXECUTE(array($id_commande));
                                    $commande_info = $select->fetch();
    
                                    if($select->rowcount() >0)
                                    {
    
                                        $select=$bdd->PREPARE("SELECT * FROM chat WHERE  commande=? AND (id_client1=? or id_client2=?) AND (id_client1=? or id_client2=?)");
                                        $select->EXECUTE(array($id_commande,$_SESSION['id_client'],$_SESSION['id_client'],$id_vendeur,$id_vendeur));
    
                                        $_SESSION['num_commande']=$id_commande;
    
                                        $messages = $select->fetchall();

                                        foreach ($messages as $chat) {
                                            $fichier = (!empty($chat['fichier']))?explode(".",$chat['fichier']):false;
                                            if($chat["auteur"]==$_SESSION['id_client'])
                                            {
                                                ?>
                    <div class="row client " style="">

                        <span class="alert text-center bg-danger" style="margin-top: 5px;float:left">
                            <?php if(!empty($chat['message'])): ?>

                                <?=$chat['message'];?>

                            <?php elseif(!empty($chat['fichier'])):?>

                                <?php if(in_array($fichier[1],$liste_photo)): ?>

                                    <img src="../../include/public/img/chat_photo/<?=$chat['fichier'];?>" alt="image" sizes="70" height="50" srcset="">

                                <?php elseif(in_array($fichier[1],$liste_audio)):?>

                                    <audio src="../../include/public/img/chat_audio/<?=$chat['fichier'];?>" controls type="audio/mp3" ></audio>
                                    
                                <?php elseif(in_array($fichier[1],$_liste_video)):?>

                                    <video src="../../include/public/img/chat_video/<?=$chat['fichier'];?>" controls  ></video>
                                                    
                                <?php elseif(in_array($fichier[1],$liste_document)):?>

                                    <a herf="../../include/public/img/chat_document/<?=$chat['fichier'];?>"><?=$chat['fichier'];?><span class="glyphicon-arrow-down"></span></a>
                                                        
                                <?php elseif(in_array($fichier[1],$liste_zip)):?>

                                    <a herf="../../include/public/img/chat_zip/<?=$chat['fichier'];?>"><?=$chat['fichier'];?><span class="glyphicon-arrow-down"></span></a>

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

                                <?=$chat['message'];?>

                            <?php elseif(!empty($chat['fichier'])):?>

                                <?php if(in_array($fichier[1],$liste_photo)): ?>

                                        <img src="../../include/public/img/chat_photo/<?=$chat['fichier'];?>" alt="image" sizes="70" height="50" srcset="">

                                    <?php elseif(in_array($fichier[1],$liste_audio)):?>

                                        <audio  src="../../include/public/img/chat_audio/<?=$chat['fichier'];?>" type="audio/mp3" controls></audio>
                                        

                                    <?php elseif(in_array($fichier[1],$_liste_video)):?>

                                        <video src="../../include/public/img/chat_video/<?=$chat['fichier'];?>" controls></video>
                                                        
                                    <?php elseif(in_array($fichier[1],$liste_document)):?>

                                        <a herf="../../include/public/img/chat_document/<?=$chat['fichier'];?>"><?=$chat['fichier'];?><i class="glyphicon-arrow-down"></i></a>
                                                            
                                    <?php elseif(in_array($fichier[1],$liste_zip)):?>

                                        <a herf="../../include/public/img/chat_zip/<?=$chat['fichier'];?>"><?=$chat['fichier'];?> <i class="glyphicon-arrow-down"></i></a>

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

                        <form action="chat_envoi.php?sending_message=sending_message&amp;destinataire=<?=$id_vendeur;?>"
                            class="form form-inline bg-dark float-right" method="post" enctype='multipart/form-data'  id="formulaire2">
                            
                            <input type="hidden" class="form-control" value="<?=$id_vendeur;?>" name="vendeur" id="vendeur"/>
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
    <script src="../public/js/jquery.min.js "></script>
    <script src="../public/js/bootstrap.min.js "></script>
    <script src="../public/js/video_script.js "></script>
    <script src="fichier.js"></script>

    <script>

        /*var cacher = document.getElementById("toto").value;
       
        
            alert(cacher);*/
       
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
<?php
}
else
{
    header("location:http://127.0.0.1/marketplace");
}
?>