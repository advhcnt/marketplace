<?php


function passwordforgotmail($mail,$code)
{
	$to = $mail;

	$sujet ="Restoration de pass Vendeur sur DJAWAO " ;

	$message ='<h4 style="color: green;">Bienvenue sur notre plateforme de vente en ligne  DJAWAO</h4>
				<p>Votre code de verification est le suivant <br> <strong>'.$code;



	$heading="MINE-Version : 1.0\n";
	$heading .="From : advhcnt23@gmail.com\n ";
	$heading.="Replay-to : djawao@gmail.com\n";
	$heading.="Cc : georges@gmail.com\n";
	$heading.="Bc : adv@gmail.com\n";
	$heading.="X-Priority : 1\n";
	$heading.="Content-type: text/html\n";


	if(mail($to,$sujet,$message,$heading))
	{
		return 1;

	}
	else
	{
		return 0;
	}

}



			




		

?>
