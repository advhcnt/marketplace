<?php
#chat_envoi.php?sending_message=sending_message&amp;destinataire=<?=$client;>&amp;destinateur=<?=$id_vendeur;>

#http://127.0.0.1/marketplace/vendeur/chat.php?commande=8&destine=client&numero_client=1&boutique=2
#http://127.0.0.1/marketplace/vendeur/chat.php?commande=11&destine=service&boutique=2
session_start();

require_once("fonction.php");

if(isset($_GET['sending_message']) && $_GET['sending_message']=="sending_message" && isset($_GET['destinataire']) && filter_input(INPUT_GET,"destinataire",FILTER_VALIDATE_INT) && isset($_GET['destinateur']) && filter_input(INPUT_GET,"destinateur",FILTER_VALIDATE_INT))
{
    if(isset($_POST['envoie']))
    {
        $photo = $_FILES["photo"];
        $profil = verification_image($photo);
        $fichier_extension = extension($photo);
        $nom = $_SESSION['id_client'].time();
        $nom=sha1($nom);
        $photo_dis = $nom.'.'.$fichier_extension;
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
            $insert->EXECUTE(array($_GET['destinateur'],$_GET['destinataire'],$photo_dis,$_GET['destinateur'],$jour,$heure,$_SESSION['num_commande']));
           
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
           
            
            header("location:chat.php?commande=".$_SESSION['num_commande']."&destine=client&numero_client=".$_GET['destinataire']."&boutique=".$_GET['destinateur']);
        }
        elseif(!empty($_POST['message']))
        {
            $message = filter_input(INPUT_POST,"message",FILTER_SANITIZE_STRING);
           

            $insert = $bdd->PREPARE("INSERT INTO chat(id_client1,id_client2,message,auteur,jour,heure,commande) values(?,?,?,?,?,?,?)");
            $insert->EXECUTE(array($_GET['destinateur'],$_GET['destinataire'],$message,$_GET['destinateur'],$jour,$heure,$_SESSION['num_commande']));
            //print_r(array($_SESSION['id_client'],$_GET['destinataire'],$message,$jour,$heure,$_SESSION['num_commande']));
            
            header("location:chat.php?commande=".$_SESSION['num_commande']."&destine=client&numero_client=".$_GET['destinataire']."&boutique=".$_GET['destinateur']);

        }
        else{
            header("location:chat.php?commande=".$_SESSION['num_commande']);
        }
        
    }
    else{
        header("location:chat.php?commande=".$_SESSION['num_commande']);
    }
    
}
else if(isset($_GET['sending_message']) && $_GET['sending_message']=="sending_message" && isset($_GET['destinataire']) && $_GET['destinataire']=="service" && isset($_GET['destinateur']) && filter_input(INPUT_GET,"destinateur",FILTER_VALIDATE_INT) )
{
    if(isset($_POST['envoie']))
    {

        $photo = $_FILES["photo"];
        $profil = verification_image($photo);
        $fichier_extension = extension($photo);
        $nom = $_SESSION['id_client'].time();
        $nom=sha1($nom);
        $photo_dis = $nom.'.'.$fichier_extension;
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
            $insert->EXECUTE(array($_GET['destinateur'],2147483647,$$photo_dis,$_GET['destinateur'],$jour,$heure,$_SESSION['num_commande']));
            
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
           
            
            header("location:chat.php?commande=".$_SESSION['num_commande']."&destine=service&boutique=".$_GET['destinateur']);

        }
        if(!empty($_POST['message']))
        {
            $message = filter_input(INPUT_POST,"message",FILTER_SANITIZE_STRING);

            $insert = $bdd->PREPARE("INSERT INTO chat(id_client1,id_client2,message,auteur,jour,heure,commande) values(?,?,?,?,?,?,?)");
            $insert->EXECUTE(array($_GET['destinateur'],2147483647,$message,$_GET['destinateur'],$jour,$heure,$_SESSION['num_commande']));
            
            #print_r(array($_GET['destinateur'],2147483647,$message,$_GET['destinateur'],$jour,$heure,$_SESSION['num_commande']));
            
            header("location:chat.php?commande=".$_SESSION['num_commande']."&destine=service&boutique=".$_GET['destinateur']);

        }
        else{
            header("location:chat.php?commande=".$_SESSION['num_commande']);
        }
        
    }
    else{
        header("location:chat.php?commande=".$_SESSION['num_commande']);
    }
}
else{
    header("location:chat.php?commande=".$_SESSION['num_commande']);
}


?>