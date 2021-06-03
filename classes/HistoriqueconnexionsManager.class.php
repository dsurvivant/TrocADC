<?php
/**
 * création jmt janvier 2021
 */

class HistoriqueconnexionsManager
{
	private $_db;

	public function __construct(PDO $bdd)
	{
		$this->setDb($bdd);
	}

	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}

	/**
	 * AJOUT
	 */
	public function add(Historiqueconnexion $historiqueconnexion) //retourne l'id de l'historiqueconnexion créé automatiquement par sql
	{
		$q = $this->_db->prepare('INSERT INTO historiqueconnexion(dateconnexion, idagent) VALUES (:dateconnexion, :idagent)');

		$q->bindValue(':dateconnexion', $historiqueconnexion->getDateconnexion());
		$q->bindValue(':idagent', $historiqueconnexion->getIdagent());

		$q->execute();

		$bdd = $this->_db;
		$idhistoriqueconnexion = $bdd->lastInsertId();
		return $idhistoriqueconnexion;
	}

	/**
	 * LISTES
	 */
	
	//liste d'historique de connexion par id
	public function getListHistoriqueconnexionByIdAsc()
	{
		$historiqueconnexions = [];

		$q = $this->_db->query('SELECT * FROM historiqueconnexion ORDER BY id ASC');

		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$historiqueconnexions[] = new Historiqueconnexion($donnees);
		}
		return $historiqueconnexions;

		dd($historiqueconnexions);
		exit;
	}


	//liste d'historique de connexion par date de connexion du plus
	//récent au moins récent
	public function getListHistoriqueconnexionByDate()
	{
		$historiqueconnexions = [];

		$q = $this->_db->query('SELECT * FROM historiqueconnexion ORDER BY dateconnexion DESC');

		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$historiqueconnexions[] = new Historiqueconnexion($donnees);
		}
		return $historiqueconnexions;
	}

	
	//liste d'historique de connexion par agent (id croissant)
	public function getListHistoriqueconnexionByIdagent()
	{
		$historiqueconnexions = [];

		$q = $this->_db->query('SELECT * FROM historiqueconnexion ORDER BY idagent ASC');

		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$historiqueconnexions[] = new Historiqueconnexion($donnees);
		}
		return $historiqueconnexions;
	}
}