<?php
	// FONCTIONS RESIDENCES

	function ListeResidences()
	{
		global $bdd;

		$manager = new ResidenceManager($bdd);
		return $manager->getListResidencesId();
	}
?>