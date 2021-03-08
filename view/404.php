<?php 
if(isset($errormessage))
{
	$titre = "trocADC - Erreur";
	$menu = array('Connexion','Inscription');
	$main = "<h3 class='jumbotron'>" . $errormessage . "</h3>";
	require('public/template_main.php');
}
else
{
	echo ("<h3>Oups, il semblerai qu'il y ai un problème. Merci de contacter l'administrateur.</h3>");
}
