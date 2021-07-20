<?php
/**
 * création jmt mai 2021
 */
	class Roulementsderecherche
	{
		private $_id;
		private $_idagent;
		private $_idroulement;

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
		public function getIdagent(){return $this->_idagent;}
		public function getIdroulement(){return $this->_idroulement;}

		/**
		 * SETTEURS
		 */
		
		public function setId($id){ $this->_id = $id;}
		public function setIdagent($idagent){ $this->_idagent = $idagent;}
		public function setIdroulement($idroulement){ $this->_idroulement = $idroulement;}
		

	}