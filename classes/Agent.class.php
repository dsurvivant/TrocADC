<?php
/**
 * création jmt janvier 2021
 */
	class Agent
	{
		private $_id;
		private $_nom;
		private $_prenom;
		private $_telephone;
		private $_email;
		private $_nocp;
		private $_droits;
		private $_motdepasse;
		private $_dateinscription;
		private $_actif;
		private $_idroulement;
		private $_cle;
		private $_displayname;
		private $_displaymail;
		private $_displaylastpropositions;

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
		public function getNom(){return $this->_nom;}
		public function getPrenom(){return $this->_prenom;}
		public function getTelephone(){return $this->_telephone;}
		public function getEmail(){return $this->_email;}
		public function getNocp(){return $this->_nocp;}
		public function getMotdepasse(){return $this->_motdepasse;}
		public function getDroits(){return $this->_droits;}
		public function getDateinscription(){return $this->_dateinscription;}
		public function getActif(){return $this->_actif;}
		public function getIdroulement(){return $this->_idroulement;}
		public function getCle(){return $this->_cle;}
		public function getDisplayname(){return $this->_displayname;}
		public function getDisplaymail(){return $this->_displaymail;}
		public function getDisplaylastpropositions(){return $this->_displaylastpropositions;}

		/**
		 * SETTEURS
		 */
		
		public function setId($id){ $this->_id = $id;}
		public function setNom($nom){ $this->_nom = $nom;}
		public function setPrenom($prenom){ $this->_prenom = $prenom;}
		public function setTelephone($telephone)
		{ 
			if (preg_match("#^[0-9]{10}$#", $telephone)) { $this->_telephone = $telephone;}
			else
				{$this->_telephone = "néant";}
		}

		public function setNocp($nocp){ $this->_nocp = $nocp;}
		public function setMotdepasse($motdepasse){ $this->_motdepasse = $motdepasse;}
		public function setDroits($droits)
		{ 
			if (preg_match("#^[0-9]{1}$#", $droits)) {$this->_droits = $droits;} //1 chiffre
		}
		public function setEmail($email)
		{
			$this->_email = $email;
		}
		public function setDateinscription($dateenregistrement)
		{
			$this->_dateinscription = $dateenregistrement;
		}
		public function setActif($actif) { $this->_actif = $actif; }
		public function setIdroulement($idroulement) { $this->_idroulement = $idroulement; }
		public function setCle($cle) { $this->_cle = $cle; }
		public function setDisplayname($displayname) { $this->_displayname = $displayname; }
		public function setDisplaymail($displaymail) { $this->_displaymail = $displaymail; }
		public function setDisplaylastpropositions($displaylastpropositions) { $this->_displaylastpropositions = $displaylastpropositions; }

	}