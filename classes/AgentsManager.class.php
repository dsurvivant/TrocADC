<?php
/**
 * création jmt janvier 2021
 */

class AgentsManager
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
	 * AJOUT / SUPPRESSION / MODIFICATION
	 */
	public function add(Agent $agent) //retourne l'id de l'agent créé automatiquement par sql
	{
		$q = $this->_db->prepare('INSERT INTO agents(nom, prenom, telephone, email, nocp, droits, motdepasse,dateinscription, actif, idroulement, cle) VALUES (:nom, :prenom, :telephone, :email,  :nocp, :droits, :motdepasse,:dateinscription, :actif, :idroulement, :cle)');

		$q->bindValue(':nom', $agent->getNom());
		$q->bindValue(':prenom', $agent->getPrenom());
		$q->bindValue(':telephone', $agent->getTelephone());
		$q->bindValue(':email', $agent->getEmail());
		$q->bindValue(':nocp', $agent->getNocp());
		$q->bindValue(':droits', $agent->getdroits());
		$q->bindValue(':motdepasse', $agent->getMotdepasse());
		$q->bindValue(':dateinscription', $agent->getDateinscription());
		$q->bindValue(':actif', $agent->getActif());
		$q->bindValue(':idroulement', $agent->getIdroulement());
		$q->bindValue(':cle', $agent->getCle());
		

		$q->execute();

		$bdd = $this->_db;
		$idAgent = $bdd->lastInsertId();
		return $idAgent;
	}

	/**
	 * mise à jour agent à partir de son no cp
	 * @param  Agent  $agent [description]
	 * @return [type]        [description]
	 */
	public function update(Agent $agent)
	{
		$q = $this->_db->prepare('UPDATE agents SET nom=:nom, prenom=:prenom, telephone=:telephone, email=:email, nocp=:nocp, droits=:droits, motdepasse=:motdepasse, dateinscription=:dateinscription, actif=:actif, idroulement=:idroulement WHERE nocp=:nocp');

		$q->bindValue(':nom', $agent->getNom());
		$q->bindValue(':prenom', $agent->getPrenom());
		$q->bindValue(':telephone', $agent->getTelephone());
		$q->bindValue(':email', $agent->getEmail());
		$q->bindValue(':nocp', $agent->getNocp());
		$q->bindValue(':droits', $agent->getdroits());
		$q->bindValue(':motdepasse', $agent->getMotdepasse());
		$q->bindValue(':dateinscription', $agent->getDateinscription());
		$q->bindValue(':actif', $agent->getActif());
		$q->bindValue(':idroulement', $agent->getIdroulement());
		$q->bindValue(':nocp', $agent->getNocp());

		$q->execute();
	}

	/**
	 * mise à jour agent à partir de son id
	 * @param  Agent  $agent [description]
	 * @return [type]        [description]
	 */
	public function updateById(Agent $agent)
	{
		if($agent->getMotdepasse()=='')
		{ $q = $this->_db->prepare('UPDATE agents SET nom=:nom, prenom=:prenom, telephone=:telephone, email=:email, nocp=:nocp, droits=:droits, dateinscription=:dateinscription, actif=:actif, idroulement=:idroulement WHERE id=:id');}
		else
		{ $q = $this->_db->prepare('UPDATE agents SET nom=:nom, prenom=:prenom, telephone=:telephone, email=:email, nocp=:nocp, droits=:droits, motdepasse=:motdepasse, dateinscription=:dateinscription, actif=:actif, idroulement=:idroulement WHERE id=:id');}
		

		$q->bindValue(':nom', $agent->getNom());
		$q->bindValue(':prenom', $agent->getPrenom());
		$q->bindValue(':telephone', $agent->getTelephone());
		$q->bindValue(':email', $agent->getEmail());
		$q->bindValue(':nocp', $agent->getNocp());
		$q->bindValue(':droits', $agent->getdroits());
		$q->bindValue(':dateinscription', $agent->getDateinscription());
		$q->bindValue(':actif', $agent->getActif());
		$q->bindValue(':idroulement', $agent->getIdroulement());
		$q->bindValue(':id', $agent->getId());

		if($agent->getMotdepasse()!='') { $q->bindValue(':motdepasse', $agent->getMotdepasse());}
	
		$q->execute();
	}

	public function delete(Agent $agent)
	{
		$q = $this->_db->prepare('DELETE FROM agents WHERE id=:id');

		$q->bindValue(':id', $agent->getId());
		$q-> execute();

	}

	//=====
    //== Activation d'un agent à partir du nocp
    //== clé remise à '***Active***' lors de l'activation afin de neutraliser le lien mail
    //=====
    function activer(Agent $agent)
    {
        $q =  $this->_db->prepare("UPDATE agents SET actif = 1, cle='***Active***' WHERE nocp like :nocp ");
        $q->bindValue(':nocp', $agent->getNocp());
        $q->execute();
    }

	/**
	 * MODULES
	 */
	
	//liste des agents classés par nom asc
	public function getListAgentsNomAsc()
	{
		$agents = [];

		$q = $this->_db->query('SELECT * FROM agents ORDER BY nom ASC');

		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$agents[] = new Agent($donnees);
		}
		return $agents;
	}


	//liste des agents classés par nom desc
	public function getListAgentsNomDesc()
	{
		$agents = [];

		$q = $this->_db->query('SELECT * FROM agents ORDER BY nom DESC');

		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$agents[] = new Agent($donnees);
		}
		return $agents;
	}

	
	//liste des agents classés par prénom asc
	public function getListAgentsPrenomAsc()
	{
		$agents = [];

		$q = $this->_db->query('SELECT * FROM agents ORDER BY prenom ASC');

		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$agents[] = new Agent($donnees);
		}
		return $agents;
	}

	//liste des agents classés par prénom desc
	public function getListAgentsPrenomDesc()
	{
		$agents = [];

		$q = $this->_db->query('SELECT * FROM agents ORDER BY prenom DESC');

		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$agents[] = new Agent($donnees);
		}
		return $agents;
	}

	//liste des agents classés par NOCP ASC
	public function getListAgentsNocpAsc()
	{
		$agents = [];

		$q = $this->_db->query('SELECT * FROM agents ORDER BY nocp ASC');

		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$agents[] = new Agent($donnees);
		}
		return $agents;
	}

	
    /**
    *	RECHERCHER UN AGENT A PARTIR DU NOCP
    *	si trouvé, instancie l'agent et retourne true
    *	sinon retourne false 
    */    
    public function findNocpAgent(Agent $agent)
   	{
        $q = $this->_db->prepare('SELECT * FROM agents WHERE nocp=:nocp');
        $q->bindValue(':nocp', $agent->getNocp());
        $q->execute();
            
        if($donnees = $q->fetch())
        {
        	$agent->hydrate($donnees);  
        	return true;
        }
        else
        {
        	return false;
        }
    }

    /**
    *	RECHERCHER UN AGENT A PARTIR DU mail
    *	si trouvé, instancie l'agent et retourne true
    *	sinon retourne false 
    */
    public function findEmailAgent(Agent $agent)
    {
    	$q = $this->_db->prepare('SELECT * FROM agents WHERE email=:email');
        $q->bindValue(':email', $agent->getEmail());
        $q->execute();
            
        if($donnees = $q->fetch())
        {
        	$agent->hydrate($donnees);  
        	return true;
        }
        else
        {
        	return false;
        }
    }

    /**
    *	RECHERCHER UN AGENT A PARTIR DE l'id
    *	si trouvé, instancie l'agent et retourne true
    *	sinon retourne false 
    */    
    public function findIdAgent(Agent $agent)
   	{
        $q = $this->_db->prepare('SELECT * FROM agents WHERE id=:id');
        $q->bindValue(':id', $agent->getId());
        $q->execute();
            
        if($donnees = $q->fetch())
        {
        	$agent->hydrate($donnees);  
        	return true;
        }
        else
        {
        	return false;
        }
    }

}