<?php

class RoulementsManager
{
	private $_db;

	public function __construct(PDO $bdd) { $this->setDb($bdd); }

	public function setDb(PDO $db) { $this->_db = $db; }

	public function add(Roulement $roulement)
	{
		$q = $this->_db->prepare('INSERT INTO roulements(noroulement, idresidence) VALUES (:noroulement, :idresidence)');

		$q->bindValue(':noroulement', $roulement->getNoroulement());
		$q->bindValue(':idresidence', $roulement->getIdresidence());
		
		$q->execute();

		$bdd = $this->_db;
		$idRoulement = $bdd->lastInsertId();
		return $idRoulement;
	}

	public function delete(Roulement $roulement)
	{
		$q = $this->_db->prepare('DELETE FROM roulements WHERE id=:id');

		$q->bindValue(':id', $roulement->getId());
		$q-> execute();
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

	/**
	 * INSTANCIE OBJET ROULEMENT A PARTIR DE L ID ROULEMENT
	 */
	public function findIdResidence(Roulement $roulement)
	{
		$q = $this->_db->prepare('SELECT * FROM roulements WHERE id=:id');
        $q->bindValue(':id', $roulement->getId());
        $q->execute();
            
        if($donnees = $q->fetch())
        {
        	$roulement->hydrate($donnees);  
        	return true;
        }
        else
        {
        	return false;
        }
	}
}
?>