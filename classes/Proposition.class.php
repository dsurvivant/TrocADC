<?php
/**
 * création jmt février 2021
 */
	class Proposition
	{
		private $_id;
		private $_dateproposition;
		private $_idjournee;
		private $_idagent;
		private $_commentaires;
		private $_datecreation;

		public function __construct($donnees)
		{
			$this->hydrate($donnees);
		}

		public function hydrate(array $donnees)
        {
            foreach ($donnees as $key => $value)
            {
                //on récupère le nom du setter correspondant à l'attribut
                $method = 'set'.ucfirst($key);
                
                //si le setter correspondant existe
                if (method_exists($this, $method))
                {
                    //on appelle le setter
                    $this->$method($value);
                }
                
            }
        }

		/**
		 * GETTEURS
		 */
		public function getId(){return $this->_id;}
		public function getDateproposition(){return $this->_dateproposition;}
		public function getIdjournee(){return $this->_idjournee;}
		public function getIdagent(){return $this->_idagent;}
		public function getCommentaires(){return $this->_commentaires;}
		public function getDatecreation(){return $this->_datecreation;}

		/**
		 * SETTEURS
		 */
		
		public function setId($id){ $this->_id = $id;}
		public function setDateproposition($dateproposition){ $this->_dateproposition = $dateproposition;}
		public function setIdjournee($idjournee){ $this->_idjournee = $idjournee;}
		public function setIdagent($idagent){ $this->_idagent = $idagent;}
		public function setCommentaires($commentaires){ $this->_commentaires = $commentaires;}
		public function setDatecreation($datecreation){ $this->_datecreation = $datecreation;}

	}