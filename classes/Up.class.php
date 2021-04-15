<?php
/**
 * création jmt février 2021
 */
    class Up
    {
        private $_id;
        private $_nomup;
        

        public function __construct($donnees){ $this->hydrate($donnees); }

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
        public function getNomup(){return $this->_nomup;}
        

        /**
         * SETTEURS
         */
        
        public function setId($id){ $this->_id = $id;}
        public function setNomup($nomup){ $this->_nomup = $nomup;}
        

    }