<?php
/**
 * 
 */
	//autochargement des classes
	function chargerClasse($classe)
	{
		require 'classes/' . $classe . '.class.php';
	}
	spl_autoload_register('chargerClasse');

	require ('model/config.php'); //connection $bdd
	//require ('config.php'); gestion des évènements desactivé car bdd à construire

?>
