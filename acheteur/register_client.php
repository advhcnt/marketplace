<?php
session_start();
include_once 'fonction.php';
if(isset($_POST['valide']))
{

	if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['email']) AND !empty($_POST['password2']) AND !empty($_POST['password']) AND !empty($_POST['password2']))
	{
		$nom = verification($_POST['nom']);
		$prenom = verification($_POST['prenom']);
		$email = verification_mail($_POST['email']);
		$telephone = verification_num($_POST['telephone']);
		$password = verification($_POST['password']);
		$password2 = verification($_POST['password2']);

		$select = $bdd->PREPARE("SELECT * FROM  clients WHERE mail=?");
		$select ->EXECUTE(array($email));
		$nombre=$select->rowcount();

		if($nombre==0)
		{

			if($password==$password2 AND strlen($password2)>=8)
			{

				$insert = $bdd->PREPARE("INSERT INTO clients values(?,?,?,?,?,?)");
				$insert->EXECUTE(array("",strtoupper($nom),strtoupper($prenom),$mail,$telephone,$password));

				$select = $bdd->PREPARE("SELECT * FROM clients WHERE mail=? AND mot_de_pass=? ");

				$resultat=$select->fetch();
				$_SESSION['client_id'] = $resultat['id_client'];
				$_SESSION['mail'] = $resultat['mail'];
				header("location:index.php");


			}
			

		}



	}
}




?>


<!DOCTYPE html>
<html>

<head>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="../public/css/bootstrap.min.css">

        <title>REGISTER | CLIENT</title>
        <meta charset="utf-8">


    </head>

<body>

    <div>
        <form action="" method="post">
            <table>
                <tr>
                    <td><label>Nom : </label></td>
                    <td><input type="text" name="nom" required=""></td>
                </tr>

                <tr>
                    <td><label>Prenom : </label></td>
                    <td><input type="text" name="prenom" required="">
                </tr>
                </tr>

                <tr>
                    <td><label>Email : </label></td>
                    <td><input type="email" name="email" required="">
                </tr>
                </tr>

                <tr>
                    <td><label>Telephone : </label></td>
                    <td><input type="text" name="telephone" required="">
                </tr>
                </tr>

                <tr>
                    <td><label>Password : </label></td>
                    <td><input type="password" name="password" required="">
                </tr>
                </tr>

                <tr>
                    <td><label>Password confirm : </label></td>
                    <td><input type="password" name="password2" required="">
                </tr>
                </tr>

                <tr>
                    <td></td>
                    <td><input type="submit" name="valide" value="Valide"></td>
                </tr>
            </table>
        </form>
    </div>

</body>

</html>