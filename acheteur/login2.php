<?php
session_start();
include 'fonction.php';
if(isset($_POST['submit']))
{
	if(!empty($_POST['mail']) AND !empty($_POST['password'])  )
	{
		$mail=verification_mail($_POST['mail']);
		$password=verification($_POST['password']);

		$select=$bdd->PREPARE("SELECT * FROM clients WHERE motdepasse=? AND mail=?  ");
		$select->EXECUTE(array($password,$mail));

		$infoo=$select->fetch();

		$nombre = $select->rowcount();
		
		if($nombre==1)
		{

			$_SESSION['id_client']=$infoo['id_client'];
			header("location:index.php");

		}
		else
		{
			#header("location:login.php");
            echo("erreur2");
		}
	}
	else
	{
		#header("location:login.php");
        echo("erreur1");
	}
}



?>