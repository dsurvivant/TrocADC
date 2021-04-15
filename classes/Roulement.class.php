<?php

class Roulement
{
	private $_id;
	private $_noroulement;
    private $_idresidence;

	public function __construct($donnees) { $this->hydrate($donnees);}

	public function hydrate($donnees)
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
    public function getId() { return $this->_id;}
    public function getNoroulement() { return $this->_noroulement;}
    public function getIdresidence() { return $this->_idresidence;}

    /**
     * SETTEURS
     */

    public function setId($id) { $this->_id = $id; }
    public function setNoroulement($noroulement) { $this->_noroulement = $noroulement; }
    public function setIdresidence($idresidence) { $this->_idresidence = $idresidence; }
}

?>