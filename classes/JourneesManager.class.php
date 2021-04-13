<?php

class JourneesManager
{
	private $_db;

	public function __construct(PDO $bdd) { $this->setDb($bdd); }

	public function setDb(PDO $db) { $this->_db = $db; }

	public function add(Journee $journee)
	{
		$q = $this->_db->prepare('INSERT INTO journees(idroulement, nomjournee, heureps, heurefs, lieups, lieufs) VALUES (:idroulement, :nomjournee, :heureps, :heurefs,  :lieups, :lieufs)');

		$q->bindValue(':idroulement', $journee->getIdroulement());
		$q->bindValue(':nomjournee', $journee->getNomjournee());
		$q->bindValue(':heureps', $journee->getHeureps());
		$q->bindValue(':heurefs', $journee->getHeurefs());
		$q->bindValue(':lieups', $journee->getLieups());
		$q->bindValue(':lieufs', $journee->getLieufs());
		
		$q->execute();

		$bdd = $this->_db;
		$idJournee = $bdd->lastInsertId();
		return $idJournee;
	}

	public function delete(Journee $journee)
	{
		$q = $this->_db->prepare('DELETE FROM journees WHERE id=:id');

		$q->bindValue(':id', $journee->getId());
		$q-> execute();
	}

	public function getListJournee()
	{

		$journees = [];

		$q = $this->_db->query('SELECT * FROM journees ORDER BY idroulement, nomjournee  ASC');

		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$journees[] = new Journee($donnees);
		}

		return $journees;
	}

	/**
    *	RECHERCHER UNE JOURNEE A PARTIR DE l'id
    *	si trouvé, instancie la journee et retourne true
    *	sinon retourne false 
    */    
    public function findIdJournee(JOURNEE $journee)
   	{
        $q = $this->_db->prepare('SELECT * FROM journees WHERE id=:id');
        $q->bindValue(':id', $journee->getId());
        $q->execute();
            
        if($donnees = $q->fetch())
        {
        	$journee->hydrate($donnees);  
        	return true;
        }
        else
        {
        	return false;
        }
    }
}
?>