<?php
	// FONCTIONS PROPOSITIONS

	/**
	 * [SupprimerPropositions supprime l'ensemble des propostions d'un agent]
	 * @param [type] $agent [objet $agent]
	 */
	function SupprimerPropositions($agent)
	{
		global $bdd;
		$manager = new PropositionsManager($bdd);
		$manager->deletePropositions($agent);
	}

	//retourne le nombre de propositions sur une date
	function NbPropositionsOnDate($date)
	{
		global $bdd;
		$proposition = new Proposition(['dateproposition'=>$date]);

		$manager = new PropositionsManager($bdd);
		return $manager->nbPropositionOnDate($proposition);
	} 

?>