<?php 

$bdd = new PDO("mysql:host=127.0.0.1;dbname=marquetplace","root","");
#include 'mon_panier_class.php';
#$monpanier=new Panier($bdd);
#var_dump($_SESSION["pan"]);

function verification($texte)
{
	#$texte = strip($texte);
	$texte = htmlspecialchars($texte);
	$texte = htmlentities($texte);
	$texte = trim($texte);

	return $texte;
}

function verification_mail($num)
{
	#$num = verification($num);
	if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#",$num))
	{
		return $num;
	}
	else
	{
		return  ;
	}
}

function verification_num($num)
{
	$num = verification($num);
	if (preg_match("#^((\+|00)[1-9]{3})?([-. ]?[0-9]{2}){4}$#",$num))
	{
		return $num;
	}
	else
	{
		return  ;
	}

}

function verification_image($image){
	if ($image && $image['error']==false){
		if ($image['size']<10000000) {
			$infosfichier = pathinfo($image['name']); 
			$extension_upload = $infosfichier['extension'];
			#$extensions_autorisees = array('jpg', 'jpeg', 'png');
			return $image['tmp_name'];	 
		}
	}
	else
	{
		return false;
	}
}

function salutation($nom){
	if(date('H')<12){
		echo("Bonjour M/Mme et bienvenues sur DJAWAO ");
	}
	else
	{
		echo("Bonsoir M/Mme  et bienvenues sur DJAWAO");
	}
}

function extension($image){
	if ($image && $image['error']==false){
		if ($image['size']<10000000) {
			$infosfichier = pathinfo($image['name']); 
			$extension_upload = $infosfichier['extension'];
			return $extension_upload;                        
		}
	}
	else
	{
		return false;
	}
}

 ?>