<?php
session_start();
echo(is_int("23"));
require_once("../fonction.php");
#chat_envoi.php?sending_message=sending_message&amp;destinataire=<?=$id_vendeur;

if(isset($_GET['sending_message']) && $_GET['sending_message']=="sending_message" && isset($_GET['destinataire']) && filter_input(INPUT_GET,"destinataire",FILTER_VALIDATE_INT))
{
    #Vendeur
    if(isset($_POST['envoie']))
    {
        $photo = $_FILES["photo"];
        $profil = verification_image($photo);
        $fichier_extension = extension($photo);
        $nom = $_SESSION['id_client'].time();
        $nom=sha1($nom);
        $photo_dis = $nom.'.'.$fichier_extension;
       
        if(!empty($fichier_extension))
        {
            $liste_photo = array('jpg', 'jpeg', 'png','gif');
            $liste_video = array("mp4");
            $liste_document = array('txt','doc','docx','pdf','xlsx');
            $liste_zip = array('zip','rar');
            $liste_audio = array('mp3');

            $jour=date("Y/m/d");
            $heure = date("H:i:s");

            $insert = $bdd->PREPARE("INSERT INTO chat(id_client1,id_client2,fichier,auteur,jour,heure,commande) values(?,?,?,?,?,?,?)");
            $insert->EXECUTE(array($_SESSION['id_client'],$_GET['destinataire'],$photo_dis,$_SESSION['id_client'],$jour,$heure,$_SESSION['num_commande']));
            //print_r(array($_SESSION['id_client'],$_GET['destinataire'],$message,$jour,$heure,$_SESSION['num_commande']));
            if(in_array($fichier_extension,$liste_photo))
            {
                move_uploaded_file($profil,'../../include/public/img/chat_photo/'.$photo_dis);
            }
            elseif(in_array($fichier_extension,$liste_video))
            {
                move_uploaded_file($profil,'../../include/public/img/chat_video/'.$photo_dis);
            }
            elseif(in_array($fichier_extension,$liste_document))
            {
                move_uploaded_file($profil,'../../include/public/img/chat_document/'.$photo_dis);
            }
            elseif(in_array($fichier_extension,$liste_zip))
            {
                move_uploaded_file($profil,'../../include/public/img/chat_zip/'.$photo_dis);
            }
            elseif(in_array($fichier_extension,$liste_audio))
            {
                move_uploaded_file($profil,'../../include/public/img/chat_audio/'.$photo_dis);
            }
           

          
            
            header("location:chat.php?commande=".$_SESSION['num_commande']."&destine=vendeur&numero_vendeur=".$_GET['destinataire']);
        }
        elseif(!empty($_POST['message']))
        {
            $message = filter_input(INPUT_POST,"message",FILTER_SANITIZE_STRING);
            $jour=date("Y/m/d");
            $heure = date("H:i:s");

            $insert = $bdd->PREPARE("INSERT INTO chat(id_client1,id_client2,message,auteur,jour,heure,commande) values(?,?,?,?,?,?,?)");
            $insert->EXECUTE(array($_SESSION['id_client'],$_GET['destinataire'],$message,$_SESSION['id_client'],$jour,$heure,$_SESSION['num_commande']));
            
            header("location:chat.php?commande=".$_SESSION['num_commande']."&destine=vendeur&numero_vendeur=".$_GET['destinataire']);

        }
        else{
            header("location:chat.php?commande=".$_SESSION['num_commande']);
        }
        
    }
    else{
        header("location:chat.php?commande=".$_SESSION['num_commande']);
    }

    
}
else if(isset($_GET['sending_message']) && $_GET['sending_message']=="sending_message" && isset($_GET['destinataire']) && $_GET['destinataire']=="service" )
{
    #service client
    if(isset($_POST['envoie']))
    {
        $photo = $_FILES["photo1"];
        $profil = verification_image($photo);
        $fichier_extension = extension($photo);
        $nom = $_SESSION['id_client'].time();
        $nom=sha1($nom);
        $photo_dis = $nom.'.'.$fichier_extension;

        if(!empty($fichier_extension))
        {
            $liste_photo = array('jpg', 'jpeg', 'png','gif');
            $_liste_video = array("mp4");
            $liste_document = array('txt','doc','docx','pdf','exl');
            $liste_zip = array('zip','rar');
            $liste_audio = array('mp3');

            $jour=date("Y/m/d");
            $heure = date("H:i:s");

            $insert = $bdd->PREPARE("INSERT INTO chat(id_client1,id_client2,fichier,auteur,jour,heure,commande) values(?,?,?,?,?,?,?)");
            $insert->EXECUTE(array($_SESSION['id_client'],2147483647,$photo_dis,$_SESSION['id_client'],$jour,$heure,$_SESSION['num_commande']));
            //print_r(array($_SESSION['id_client'],$_GET['destinataire'],$message,$jour,$heure,$_SESSION['num_commande']));
            if(in_array($fichier_extension,$liste_photo))
            {
                move_uploaded_file($profil,'../../include/public/img/chat_photo/'.$photo_dis);
            }
            elseif(in_array($fichier_extension,$liste_video))
            {
                move_uploaded_file($profil,'../../include/public/img/chat_video/'.$photo_dis);
            }
            elseif(in_array($fichier_extension,$liste_document))
            {
                move_uploaded_file($profil,'../../include/public/img/chat_document/'.$photo_dis);
            }
            elseif(in_array($fichier_extension,$liste_zip))
            {
                move_uploaded_file($profil,'../../include/public/img/chat_zip/'.$photo_dis);
            }
            elseif(in_array($fichier_extension,$liste_audio))
            {
                move_uploaded_file($profil,'../../include/public/img/chat_audio/'.$photo_dis);
            }

            header("location:chat.php?commande=".$_SESSION['num_commande']."&destine=service");
           
        }
        elseif(!empty($_POST['message']))
        {
            $message = filter_input(INPUT_POST,"message",FILTER_SANITIZE_STRING);
            $jour=date("Y/m/d");
            $heure = date("H:i:s");

            $insert = $bdd->PREPARE("INSERT INTO chat(id_client1,id_client2,message,auteur,jour,heure,commande) values(?,?,?,?,?,?,?)");
            $insert->EXECUTE(array($_SESSION['id_client'],2147483647,$message,$_SESSION['id_client'],$jour,$heure,$_SESSION['num_commande']));
            //print_r(array($_SESSION['id_client'],$_GET['destinataire'],$message,$jour,$heure,$_SESSION['num_commande']));
            header("location:chat.php?commande=".$_SESSION['num_commande']."&destine=service");

        }
        else{
            #header("location:chat.php?commande=".$_SESSION['num_commande']);
            print($fichier_extension);
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