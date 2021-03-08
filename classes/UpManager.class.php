<?php
/**
 * création jmt fevrier 2021
 */

class UpManager
{
	private $_db;

	public function __construct(PDO $bdd) { $this->setDb($bdd); }

	public function setDb(PDO $db) { $this->_db = $db; }

	/**
	 * AJOUT / SUPPRESSION / MODIFICATION
	 */
	public function add(Up $up) //retourne l'id de l'agent créé automatiquement par sql
	{
		$q = $this->_db->prepare('INSERT INTO up(id, nomup) VALUES (:id, :nomup)');

		$q->bindValue(':id', $up->getId());
		$q->bindValue(':nomup', $up->getNomup());
		
		$q->execute();

		$bdd = $this->_db;
		$idup = $bdd->lastInsertId();
		return $idup;
	}

	/**
	 * mise à jour up à partir de son id
	 */
	public function update(Up $up)
	{
		$q = $this->_db->prepare('UPDATE up SET nomup=:nomup WHERE id=:id');

		$q->bindValue(':id', $up->getId());
		$q->bindValue(':nomup', $up->getNomup());

		$q->execute();
	}

	public function delete(Up $up)
	{
		$q = $this->_db->prepare('DELETE FROM up WHERE id=:id');

		$q->bindValue(':id', $up->getId());
		$q-> execute();
	}

	/**
	 * MODULES
	 */
	
	//liste des up classés par id
	//retourne un tableau contenant les objets up
	public function getListUpId()
	{
		$up = [];

		$q = $this->_db->query('SELECT * FROM up ORDER BY id ASC');

		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$up[] = new Up($donnees);
		}
		return $up;
	}

	//liste des ups classés par nom
	//retourne un tableau contenant les objets up
	public function getListUpNom()
	{
		$up = [];

		$q = $this->_db->query('SELECT * FROM up ORDER BY nomup ASC');

		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$up[] = new Up($donnees);
		}
		return $up;
	}

	
    /**
    *	RECHERCHER d'une up A PARTIR De l'id
    *	si trouvé, instancie l'up et retourne true
    *	sinon retourne false 
    */    
    public function findUpById(Up $up)
   	{
        $q = $this->_db->prepare('SELECT * FROM up WHERE id=:id');
        $q->bindValue(':id', $up->getId());
        $q->execute();
            
        if($donnees = $q->fetch())
        {
        	$up->hydrate($donnees);  
        	return true;
        }
        else
        {
        	return false;
        }
    }

}