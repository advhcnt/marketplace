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


function salutation($nom){
	if(date('H')<12){
		echo("Bonjour M/Mme et bienvenues sur DJAWAO ");
	}
	else
	{
		echo("Bonsoir M/Mme  et bienvenues sur DJAWAO");
	}
}

function verification_image($image){
	if ($image && $image['error']==false){
		if ($image['size']<10000000) {
			$infosfichier = pathinfo($image['name']); 
			$extension_upload = $infosfichier['extension'];
			
				return $image['tmp_name'];                        
				 
		}
	}
}


function verification_image_multiple($images){
	$path = array();
	$i=0;
	foreach ($images as $image) {
		# code...
		if ($image && $image['error']==false){
		
			if ($image['size']<10000000) {

				$infosfichier = pathinfo($image['name']); 
				$extension_autorise = array('jpg', 'jpeg', 'png','gif');
				$extension_upload = $infosfichier['extension'];

				if(in_array($extension_upload,$extension_autorise))
				{
					$path[$i]=$image['tmp_name']; 
					$i+=1;      
				}                 
					 
			}
		}
	}
	return $path;
	
}

function extension_multiple($images){
	$extension = array();
	$i=0;
	foreach($images as $image)
	{
		if ($image && $image['error']==false){
			if ($image['size']<10000000) {

				$infosfichier = pathinfo($image['name']); 
				$extension_autorise = array('jpg', 'jpeg', 'png','gif');
				$extension_upload = $infosfichier['extension'];

				if(in_array($extension_upload,$extension_autorise))
				{
					$extension[$i] = $extension_upload;
					$i+=1;
				}
				                        
			}
		}
	}
	return $extension;
	
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




function tableau_fichier($file)
{
    $file_ary = array();
    $file_count = count($file['name']);
    $file_key = array_keys($file);
   
    for($i=0;$i<$file_count;$i++)
    {
        foreach($file_key as $val)
        {
            $file_ary[$i][$val] = $file[$val][$i];
        }
    }
    return $file_ary;
}
 ?>