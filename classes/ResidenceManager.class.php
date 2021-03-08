<?php
/**
 * création jmt fevrier 2021
 */

class ResidenceManager
{
	private $_db;

	public function __construct(PDO $bdd) { $this->setDb($bdd); }

	public function setDb(PDO $db) { $this->_db = $db; }

	/**
	 * AJOUT / SUPPRESSION / MODIFICATION
	 */
	public function add(Residence $residence) //retourne l'id de l'agent créé automatiquement par sql
	{
		$q = $this->_db->prepare('INSERT INTO residences(id, nomresidence, idup) VALUES (:id, :nomresidence, :idup)');

		$q->bindValue(':id', $residence->getId());
		$q->bindValue(':nomresidence', $residence->getNomresidence());
		$q->bindValue(':idup', $residence->getIdup());
		
		$q->execute();

		$bdd = $this->_db;
		$idResidence = $bdd->lastInsertId();
		return $idResidence;
	}

	/**
	 * mise à jour residence à partir de son id
	 */
	public function update(Residence $residence)
	{
		$q = $this->_db->prepare('UPDATE residences SET nomresidence=:nomresidence, idup=:idup WHERE id=:id');

		$q->bindValue(':id', $residence->getId());
		$q->bindValue(':nomresidence', $residence->getNomresidence());
		$q->bindValue(':idup', $residence->getIdup());

		$q->execute();
	}

	public function delete(Residence $residence)
	{
		$q = $this->_db->prepare('DELETE FROM residences WHERE id=:id');

		$q->bindValue(':id', $residences->getId());
		$q-> execute();
	}

	/**
	 * MODULES
	 */
	
	//liste des residences classés par id
	//retourne un tableau contenant les objets résidences
	public function getListResidencesId()
	{
		$residences = [];

		$q = $this->_db->query('SELECT * FROM residences ORDER BY id ASC');

		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$residences[] = new Residence($donnees);
		}
		return $residences;
	}

	//liste des residences classés par nom
	//retourne un tableau contenant les objets résidences
	public function getListResidencesNom()
	{
		$residences = [];

		$q = $this->_db->query('SELECT * FROM residences ORDER BY nomresidence ASC');

		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$residences[] = new Residence($donnees);
		}
		return $residences;
	}

	
    /**
    *	RECHERCHER d'une résidence A PARTIR De l'id
    *	si trouvé, instancie la résidence et retourne true
    *	sinon retourne false 
    */    
    public function findResidenceById(Residence $residence)
   	{
        $q = $this->_db->prepare('SELECT * FROM residences WHERE id=:id');
        $q->bindValue(':id', $residence->getId());
        $q->execute();
            
        if($donnees = $q->fetch())
        {
        	$residence->hydrate($donnees);  
        	return true;
        }
        else
        {
        	return false;
        }
    }

}