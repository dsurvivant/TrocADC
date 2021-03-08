<?php

class Journee
{
	private $_id;
	private $_idroulement;
	private $_nomjournee;
	private $_heureps;
	private $_heurefs;
	private $_lieups;
	private $_lieufs;

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
   	public function getId() {return $this->_id;}
   	public function getIdroulement() {return $this->_idroulement;}
   	public function getNomjournee() {return $this->_nomjournee;}
   	public function getHeureps() {return $this->_heureps;}
   	public function getHeurefs() {return $this->_heurefs;}
   	public function getLieups() {return $this->_lieups;}
   	public function getLieufs() {return $this->_lieufs;}

   	/**
   	 * SETTEURS
   	 */

   	public function setId($id) { $this->_id = $id;}
   	public function setIdroulement($idroulement) { $this->_idroulement = $idroulement;}
   	public function setNomjournee($nomjournee) { $this->_nomjournee = $nomjournee;}
   	public function setHeureps($heureps) { $this->_heureps = $heureps;}
   	public function setHeurefs($heurefs) { $this->_heurefs = $heurefs;}
   	public function setLieups($lieups) { $this->_lieups = $lieups;}
   	public function setLieufs($lieufs) { $this->_lieufs = $lieufs;}
}

?>