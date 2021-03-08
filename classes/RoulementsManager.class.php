<?php

class RoulementsManager
{
	private $_db;

	public function __construct(PDO $bdd) { $this->setDb($bdd); }

	public function setDb(PDO $db) { $this->_db = $db; }

	public function add(Journee $roulement)
	{
		$q = $this->_db->prepare('INSERT INTO roulements(etablissement, noroulement, idresidence) VALUES (:etablissement, :noroulement, :idresidence)');

		$q->bindValue(':etablissement', $roulement->getEtablissement());
		$q->bindValue(':noroulement', $roulement->getNoroulement());
		$q->bindValue(':idresidence', $roulement->getIdresidence());
		
		$q->execute();

		$bdd = $this->_db;
		$idRoulement = $bdd->lastInsertId();
		return $idRoulement;
	}

	public function getListRoulements()
	{

		$roulements = [];

		$q = $this->_db->query('SELECT * FROM roulements ORDER BY noroulement ASC');

		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$roulements[] = new Roulement($donnees);
		}

		return $roulements;
	}
}
?>