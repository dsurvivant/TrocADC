<?php

	// FONCTIONS ROULEMENTS

	//retourne un tableau contenant les objets roulements
	function ListeRoulements()
	{
		global $bdd;

		$manager = new RoulementsManager($bdd);
		return $manager->getListRoulements();
	}
?>