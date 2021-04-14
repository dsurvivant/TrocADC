<?php
	// FONCTIONS PROPOSITIONS

	function Ajouterproposition($dateproposition, $idjournee, $idagent, $commentaires)
	{
		global $bdd;
		
		$proposition = new Proposition([
								'dateproposition'=>$dateproposition,
								'idjournee'=>$idjournee,
								'idagent'=>$idagent,
								'commentaires'=>$commentaires
								]);
		
		$manager = new PropositionsManager($bdd);
		$idproposition = $manager->add($proposition);
	}

	function Modifierproposition($idproposition, $idjournee, $commentaires)
	{
		global $bdd;

		$proposition = new Proposition(['id'=>$idproposition, 'idjournee'=>$idjournee, 'commentaires'=>$commentaires]);
		$manager = new PropositionsManager($bdd);
		$manager->update($proposition);
	}

	/**
	 * [Supprimerproposition suppression d'une propostion]
	 * @param [type] $idproposition [id de la proposition à supprimer]
	 */
	function Supprimerproposition($idproposition)
	{
		global $bdd;

		//$proposition = new Proposition(['id'=>$idproposition]);
		$proposition = new Proposition(['id'=>$idproposition]);
		$manager = new PropositionsManager($bdd);
		$manager->delete($proposition);
	}

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

	//retourne un tableau contenant les objets propositions
	function ListePropositions()
	{
		global $bdd;

		$manager = new PropositionsManager($bdd);
		return $manager->getListPropositionsByDate();
	}

	//retourne un tableau contenant les objets propositions sur une date données
	//la date est sous la forme d'un timestamp
	function ListePropositionsParDate($date)
	{
		global $bdd;
		//recherche des propositions correspondant à la date demandée
		$proposition = new Proposition(['dateproposition'=>date('Y-m-d', $date)]);

		$manager = new PropositionsManager($bdd);
		return $manager->findPropositionsOnDate($proposition);
	}

	//retourne un tableau contenant les objets propositions d'un agent
	//ENTREE: $idagent: l'id de l'agent
	//SORTIE: tableau contenant les objets propositions
	function ListePropositionsParNocp($idagent)
	{
		global $bdd;
		//recherche des propositions correspondant à la date demandée
		$proposition = new Proposition(['idagent'=>$idagent]);

		$manager = new PropositionsManager($bdd);
		return $manager->findPropositionsByIdAgent($proposition);
	}

	function ListeDernieresPropositions()
	{
		global $bdd;
		$manager = new PropositionsManager($bdd);
		//recherche des 10 dernieres proposition
		return $manager->findDernieresPropositions();
	}

	//retourne le nombre de propositions sur une date
	function NbPropositionsOnDate($date)
	{
		global $bdd;
		$proposition = new Proposition(['dateproposition'=>$date]);

		$manager = new PropositionsManager($bdd);
		return $manager->nbPropositionOnDate($proposition);
	} 

	function RechercheProposition($id)
	{
		global $bdd;
		$proposition = new Proposition(['id'=>$id]);

		$manager = new PropositionsManager($bdd);
		$manager->findProposition($proposition);

		return $proposition;
	}


?>