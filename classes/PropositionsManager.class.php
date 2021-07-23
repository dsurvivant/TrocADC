<?php
/**
 * création jmt fevrier 2021
 */

class PropositionsManager
{
	private $_db;

	public function __construct(PDO $bdd) { $this->setDb($bdd); }

	public function setDb(PDO $db) { $this->_db = $db;}

	/**
	 * AJOUT / SUPPRESSION / MODIFICATION
	 */
	public function add(Proposition $proposition) //retourne l'id de la proposition créée automatiquement par sql
	{
		$q = $this->_db->prepare('INSERT INTO propositions(dateproposition, idjournee, idagent, commentaires, idup) VALUES (:dateproposition, :idjournee, :idagent, :commentaires, :idup)');

		$q->bindValue(':dateproposition', $proposition->getDateproposition());
		$q->bindValue(':idjournee', $proposition->getIdjournee());
		$q->bindValue(':idagent', $proposition->getIdagent());
		$q->bindValue(':commentaires', $proposition->getCommentaires());
		$q->bindValue(':idup', $proposition->getIdup());
		
		$q->execute();

		$bdd = $this->_db;
		$idproposition = $bdd->lastInsertId();
		return $idproposition;
	}

	/**
	 * mise à jour proposition à partir de l'id
	 */
	public function update(Proposition $proposition)
	{
		$q = $this->_db->prepare('UPDATE propositions SET idjournee=:idjournee, commentaires=:commentaires WHERE id=:id');

		$q->bindValue(':id', $proposition->getId());
		$q->bindValue(':idjournee', $proposition->getIdjournee());
		$q->bindValue(':commentaires', $proposition->getCommentaires());
		$q->execute();
	}

	/**
	 * suppression proposition à partir de l'id
	 * @param  Propositon $proposition [objet proposition contenant l'id]
	 */
	public function delete(Proposition $proposition)
	{
		$q = $this->_db->prepare('DELETE FROM propositions WHERE id=:id');

		$q->bindValue(':id', $proposition->getId());
		$q-> execute();
	}

	/**
	 * [deletePropositions suppression de l'ensemble des propositions d'un agent]
	 * @param  Agent  $agents [objet agent]
	 */
	function deletePropositions(Agent $agent)
	{
		$q = $this->_db->prepare('DELETE FROM propositions WHERE idagent=:idagent');

		$q->bindValue(':idagent', $agent->getId());
		$q-> execute();
	}

	/**
	 * MODULES
	 */
	
	//recherche d'une proposition par id
	//retourne true si trouvé sinon false
	//instancie l'objet $proposition
	public function findProposition(Proposition $proposition)
	{
		$q = $this->_db->prepare('SELECT * FROM propositions WHERE id=:id');
		$q->bindValue('id', $proposition->getId());
		$q->execute();

		if($donnees = $q->fetch())
        {
        	$proposition->hydrate($donnees);  
        	return true;
        }
        else { return false;}

	}
 
	//liste des propositions classées par id asc
	public function getListPropositionsById()
	{
		$propositions = [];

		$q = $this->_db->query('SELECT * FROM propositions ORDER BY id ASC');

		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$propositions[] = new Proposition($donnees);
		}
		return $propositions;
	}

	//liste des propositions classées par id desc
	public function getListPropositionsByIdDesc()
	{
		$propositions = [];

		$q = $this->_db->query('SELECT * FROM propositions ORDER BY id DESC');

		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$propositions[] = new Proposition($donnees);
		}
		return $propositions;
	}

	//liste des propositions classées par id desc et non obsoletes (date non dépassée) sur une up précise
	public function getListPropositionsByIdDescDateok(Proposition $proposition)
	{
		$propositions = [];

		$q = $this->_db->prepare('SELECT * FROM propositions WHERE idup=:idup AND dateproposition >= CURRENT_DATE() ORDER BY id DESC');

		$q->bindValue(':idup', $proposition->getIdup());
        $q->execute();

		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$propositions[] = new Proposition($donnees);
		}
		return $propositions;
	}


	//liste des propositions classées par date
	public function getListPropositionsByDate()
	{
		$propositions = [];

		$q = $this->_db->query('SELECT * FROM propositions ORDER BY dateproposition ASC');

		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$propositions[] = new Proposition($donnees);
		}
		return $propositions;
	}

	//liste des propositions classées par date pour une up précise
	public function getListPropositionsByDateAndUp(Proposition $proposition)
	{
		$propositions = [];

		$q = $this->_db->prepare('SELECT * FROM propositions WHERE idup=:idup ORDER BY dateproposition ASC');

		$q->bindValue(':idup', $proposition->getIdup());
        $q->execute();

		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$propositions[] = new Proposition($donnees);
		}
		return $propositions;
	}

	//liste des 10 dernieres propositions
	public function findDernieresPropositions()
	{
		$propositions = [];

		$q = $this->_db->query('SELECT * FROM propositions WHERE dateproposition > NOW()  ORDER BY id DESC LIMIT 10');

		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$propositions[] = new Proposition($donnees);
		}
		return $propositions;
	}

    //retourne une liste d'objet propositions sur une date donnee
    public function findPropositionsOnDate(Proposition $proposition)
   	{
   		$listepropositions= [];
       
        $q = $this->_db->prepare('SELECT * FROM propositions WHERE dateproposition=:dateproposition');
        $q->bindValue(':dateproposition', $proposition->getDateproposition());
        $q->execute();
            
        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$listepropositions[] = new Proposition($donnees);
		}
		return $listepropositions;
    }

    //retourne une liste d'objet propositions sur une date donnee et une up donné
    public function findPropositionsOnDateAndUp(Proposition $proposition)
   	{
   		$listepropositions= [];
       
        $q = $this->_db->prepare('SELECT * FROM propositions WHERE idup=:idup AND dateproposition=:dateproposition');
        $q->bindValue(':idup', $proposition->getIdup());
        $q->bindValue(':dateproposition', $proposition->getDateproposition());
        $q->execute();
            
        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$listepropositions[] = new Proposition($donnees);
		}
		return $listepropositions;
    }

    //retourne une liste d'objet propositions d'un agent (toutes les propositions de l'agent)
    public function findPropositionsByIdAgent(Proposition $proposition)
   	{
   		$listepropositions= [];
       
        $q = $this->_db->prepare('SELECT * FROM propositions WHERE idagent=:idagent');
        $q->bindValue(':idagent', $proposition->getIdagent());
        $q->execute();
            
        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$listepropositions[] = new Proposition($donnees);
		}
		return $listepropositions;
    }

    //retourne une liste d'objet propositions non obsolètes d'un agent 
    public function findPropositionsByIdAgentActives(Proposition $proposition)
   	{
   		$listepropositions= [];
       
        $q = $this->_db->prepare('SELECT * FROM propositions WHERE (idagent=:idagent) AND (dateproposition >= NOW()) ');
        $q->bindValue(':idagent', $proposition->getIdagent());
        $q->execute();
            
        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$listepropositions[] = new Proposition($donnees);
		}
		return $listepropositions;
    }

    //retourne le nombre de propostions sur une date donnée
    public function nbPropositionOnDate(Proposition $proposition)
   	{
        $q = $this->_db->prepare('SELECT COUNT(*) as nbpropositions FROM propositions WHERE dateproposition=:dateproposition');
        $q->bindValue(':dateproposition', $proposition->getDateproposition());
        $q->execute();

        $donnees = $q->fetch();
		$q->closeCursor();
		return $donnees['nbpropositions'];
    }

}