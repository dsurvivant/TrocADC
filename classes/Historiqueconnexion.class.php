<?php
/**
 * création jmt mai 2021
 */
	class Historiqueconnexion
	{
		private $_id;
		private $_dateconnexion;
		private $_idagent;

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
		public function getDateconnexion(){return $this->_dateconnexion;}
		public function getIdagent(){return $this->_idagent;}

		/**
		 * SETTEURS
		 */
		
		public function setId($id){ $this->_id = $id;}
		public function setDateconnexion($dateconnexion){ $this->_dateconnexion = $dateconnexion;}
		public function setIdagent($idagent){ $this->_idagent = $idagent;}
		

	}