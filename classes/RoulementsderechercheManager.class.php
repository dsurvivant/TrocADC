<?php
/**
 * création jmt janvier 2021
 */

class RoulementsderechercheManager
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
	public function add(Roulementsderecherche $roulementsderecherche) //retourne l'id 
	{
		$q = $this->_db->prepare('INSERT INTO roulementsderecherche(idagent, idroulement) VALUES (:idagent, :idroulement)');

		$q->bindValue(':idagent', $roulementsderecherche->getIdagent());
		$q->bindValue(':idroulement', $roulementsderecherche->getIdroulement());

		$q->execute();

		$bdd = $this->_db;
		$idroulementsderecherche = $bdd->lastInsertId();
		return $idroulementsderecherche;
	}

	/**
	 * SUPPRESSION
	 */
	public function delete(Roulementsderecherche $roulementsderecherche)
	{
		$q = $this->_db->prepare('DELETE FROM roulementsderecherche WHERE idroulement=:idroulement AND idagent=:idagent');

		$q->bindValue(':idroulement', $roulementsderecherche->getIdroulement());
		$q->bindValue(':idagent', $roulementsderecherche->getIdagent());
		$q-> execute();

	}

	/**
	 * FORMATAGE DE LA TABLE (remis à zero de l'auto incrément)
	 */
	public function erase()
	{
		$q = $this->_db->prepare('TRUNCATE TABLE roulementsderecherche');
		$q-> execute();
	}

	/**
	 * LISTE DES ROULEMENTS DE RECHERCHE POUR UN AGENT
	 */
	public function ListRoulementsDeRecherche(Roulementsderecherche $roulementsderecherche)
	{
		$tabroulementsderecherche = [];

		$q = $this->_db->prepare('SELECT * FROM roulementsderecherche WHERE idagent=:idagent');
		$q->bindValue(':idagent', $roulementsderecherche->getIdagent());
		$q-> execute();

		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$tabroulementsderecherche[] = $donnees['idroulement'];
		}
		return $tabroulementsderecherche;
	}
}