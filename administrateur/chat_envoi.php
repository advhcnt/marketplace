<?php
session_start();
echo(is_int("23"));
require_once("fonction.php");



#sending_message=sending_message&amp;destinataire=<?=$id_vendeur;? lien 2
#sending_message=sending_message&amp;destinateure=client&amp;client=<?$client; lien 1
if(isset($_GET['sending_message']) && $_GET['sending_message']=="sending_message" && isset($_GET['destinataire']) && filter_input(INPUT_GET,"destinataire",FILTER_VALIDATE_INT) && isset($_GET['commande']) && filter_input(INPUT_GET,"commande",FILTER_VALIDATE_INT))
{
    if(isset($_POST['envoie']))
    {
        $photo = $_FILES["photo"];
        $profil = verification_image($photo);
        $fichier_extension = extension($photo);
        $nom = $_SESSION['id_client'].time();
        $nom=sha1($nom);
        $photo_dis = $nom.'.'.$fichier_extension;
        $client = $_GET['destinataire'];
        $commande = $_GET['commande'];
        $jour=date("Y/m/d");
        $heure = date("H:i:s");

        if(!empty($fichier_extension))
        {
            $liste_photo = array('jpg', 'jpeg', 'png','gif');
            $liste_video = array("mp4");
            $liste_document = array('txt','doc','docx','pdf','xlsx');
            $liste_zip = array('zip','rar');
            $liste_audio = array('mp3');

            $insert = $bdd->PREPARE("INSERT INTO chat(id_client1,id_client2,fichier,auteur,jour,heure,commande) values(?,?,?,?,?,?,?)");
            $insert->EXECUTE(array(2147483647,$client,$photo_dis,2147483647,$jour,$heure,$commande));
            
            if(in_array($fichier_extension,$liste_photo))
            {
                move_uploaded_file($profil,'../include/public/img/chat_photo/'.$photo_dis);
            }
            elseif(in_array($fichier_extension,$liste_video))
            {
                move_uploaded_file($profil,'../include/public/img/chat_video/'.$photo_dis);
            }
            elseif(in_array($fichier_extension,$liste_document))
            {
                move_uploaded_file($profil,'../include/public/img/chat_document/'.$photo_dis);
            }
            elseif(in_array($fichier_extension,$liste_zip))
            {
                move_uploaded_file($profil,'../include/public/img/chat_zip/'.$photo_dis);
            }
            elseif(in_array($fichier_extension,$liste_audio))
            {
                move_uploaded_file($profil,'../include/public/img/chat_audio/'.$photo_dis);
            }
            
            header("location:chat.php?commande=".$commande."&destine=vendeur&numero_vendeur=".$_GET['destinataire']);

            
        }
        elseif(!empty($_POST['message']))
        {
            $message = filter_input(INPUT_POST,"message",FILTER_SANITIZE_STRING);
         

            #$client = $_GET['destinataire'];
            #$commande = $_GET['commande'];

            $insert = $bdd->PREPARE("INSERT INTO chat(id_client1,id_client2,message,auteur,jour,heure,commande) values(?,?,?,?,?,?,?)");
            $insert->EXECUTE(array(2147483647,$client,$message,2147483647,$jour,$heure,$commande));
            #print_r(array(2147483647,$_client,$message,2147483647,$jour,$heure,$_SESSION['num_commande']));
            
            #?commande=<=$commande["idcmd"];>&amp;destine=vendeur&amp;numero_vendeur=<?=$commande[6] ; retour 2

            header("location:chat.php?commande=".$commande."&destine=vendeur&numero_vendeur=".$_GET['destinataire']);

        }
        else{
            header("location:chat.php?commande=".$_SESSION['num_commande']);
        }
        
    }
    else{
        header("location:chat.php?commande=".$_SESSION['num_commande']);
    }
    
}
else if(isset($_GET['sending_message']) && $_GET['sending_message']=="sending_message" && isset($_GET['destinateure']) && $_GET['destinateure']=="client" && isset($_GET['client']) && is_int(intval($_GET['client'])) && isset($_GET['commande']) && filter_input(INPUT_GET,"commande",FILTER_VALIDATE_INT))
{
    if(isset($_POST['envoie']))
    {
        $photo = $_FILES["photo"];
        $profil = verification_image($photo);
        $fichier_extension = extension($photo);
        $nom = $_SESSION['id_client'].time();
        $nom=sha1($nom);
        $photo_dis = $nom.'.'.$fichier_extension;
        $client = $_GET['client'];
        $commande = $_GET['commande'];
        $jour=date("Y/m/d");
        $heure = date("H:i:s");

        if(!empty($fichier_extension))
        {
            $liste_photo = array('jpg', 'jpeg', 'png','gif');
            $liste_video = array("mp4");
            $liste_document = array('txt','doc','docx','pdf','xlsx');
            $liste_zip = array('zip','rar');
            $liste_audio = array('mp3');

            $insert = $bdd->PREPARE("INSERT INTO chat(id_client1,id_client2,fichier,auteur,jour,heure,commande) values(?,?,?,?,?,?,?)");
            $insert->EXECUTE(array(2147483647,$client,$photo_dis,2147483647,$jour,$heure,$_SESSION['num_commande']));
            
            if(in_array($fichier_extension,$liste_photo))
            {
                move_uploaded_file($profil,'../include/public/img/chat_photo/'.$photo_dis);
            }
            elseif(in_array($fichier_extension,$liste_video))
            {
                move_uploaded_file($profil,'../include/public/img/chat_video/'.$photo_dis);
            }
            elseif(in_array($fichier_extension,$liste_document))
            {
                move_uploaded_file($profil,'../include/public/img/chat_document/'.$photo_dis);
            }
            elseif(in_array($fichier_extension,$liste_zip))
            {
                move_uploaded_file($profil,'../include/public/img/chat_zip/'.$photo_dis);
            }
            elseif(in_array($fichier_extension,$liste_audio))
            {
                move_uploaded_file($profil,'../include/public/img/chat_audio/'.$photo_dis);
            }

            header("location:chat.php?commande=".$_SESSION['num_commande']."&destine=client&identifiant_client=".$client);

            
        }
        elseif(!empty($_POST['message']))
        {
            
            $message = filter_input(INPUT_POST,"message",FILTER_SANITIZE_STRING);
           

           

            $insert = $bdd->PREPARE("INSERT INTO chat(id_client1,id_client2,message,auteur,jour,heure,commande) values(?,?,?,?,?,?,?)");
            $insert->EXECUTE(array(2147483647,$client,$message,2147483647,$jour,$heure,$_SESSION['num_commande']));
            //print_r(array($_SESSION['id_client'],$_GET['destinataire'],$message,$jour,$heure,$_SESSION['num_commande']));
            #?commande=<=$commande["id_bondecommande"];>&amp;destine=client&amp;identifiant_client=<=$commande["client"]; retour 1
            header("location:chat.php?commande=".$_SESSION['num_commande']."&destine=client&identifiant_client=".$client);

        }
        else{
            die("erreur");
            #header("location:chat.php?commande=".$_SESSION['num_commande']);
        }
        
    }
    else{
        die("erreur");
        #header("location:chat.php?commande=".$_SESSION['num_commande']);
    }
}
else{
    die("erreur");
    #header("location:chat.php?commande=".$_SESSION['num_commande']);
}


?>