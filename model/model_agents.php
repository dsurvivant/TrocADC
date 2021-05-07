<?php
/**
 * CREER PAR JMT AVRIL 2021
 *
 * fonctions:
 * 	- connexionAgent($nocp, $password) ==> connexion et instanciation de l'agent
 * 	- activerAgent($nocp)
 * 	- findCp($nocp) ==> détermine si le nocp existe (retourne true/false) et instanciation de $agent
 * 	- returnAgent($nocp) ==> retourne l'instanciation $agent correspondant à $nocp
 * 	- findId($id) ==> Instanciation de l'agent $id
 * 	- findEmail($email) ==> determine si l'email existe déjà (retourne true/false)
 * 	- modifInfosProfil($telephone, $email, $idroulement) ==> modification de l'utilisateur en cours à l'aide de $_SESSION['nocp']])
 * 	- modifPassword($password) ==> modification du mot de passe à partir de $_SESSION['nocp']])
 * 	- AjouterAgent($nom, $prenom, $telephone, $email, $nocp, $droits, $motdepasse, $dateinscription, $actif, $roulement, $cle)
 * 	- ModifierAgent($agent) ==> modification de l'agent $agent
 * 	- AffichageNomAgent($displayname, $nocp) ==> modifie le parametre d'affichage du nom et prenom
 * 	- AffichageMailAgent($displaymail, $nocp) ==> modifie le parametre d'affichage du mail
 * 	- SupprimerAgent($agent) ==> à partir de l'id
 * 	- ListeAgents() ==> retourne un tableau contenant les objets Agents
 */

// FONCTIONS AGENTS

	/**
	 * [connexionAgent instanciation de l'agent si connexion valide]
	 * @param  [type] $cp       [cp saisi sur formulaire de connexion]
	 * @param  [type] $password [mdp saisi sur formulaire de connexion]
	 * @return [type]           [retourne true si instanciation réussie sinon false]
	 */
	function connexionAgent($nocp, $password)
	{
	    
	    global $bdd;
	    //=== SECURISATION DES CHAMPS
	    $nocp = trim(sanitizeString($nocp));
		$password = cryptagemotdepasse(trim(sanitizeString($password)));

	    //instanciation de l'agent
	    $agent = new Agent(['nocp'=>$nocp]);
	    $manager = new AgentsManager($bdd);
	                                                    
	    $result = $manager->findNocpAgent($agent);
	                                                    
	    if ($result) //utilisateur trouvé et instancié
	    {
		    if ($password == $agent->getMotdepasse())
		    { 
				$_SESSION['id'] = $agent->getId();
		        $_SESSION['nom'] = $agent->getNom();
		        $_SESSION['prenom'] = $agent->getPrenom();
		        $_SESSION['telephone'] = $agent->getTelephone();
		        $_SESSION['email'] = $agent->getEmail();
		        $_SESSION['nocp'] = $agent->getNocp();
		        $_SESSION['droits'] = $agent->getDroits();
		        //$_SESSION['password'] = $agent->getMotdepasse();
		        $_SESSION['dateinscription'] = $agent->getDateinscription();
		        $_SESSION['actif'] = $agent->getActif();
		        $_SESSION['idroulement'] = $agent->getIdroulement();
		        $_SESSION['displayname'] = $agent->getDisplayname();
		        $_SESSION['displaymail'] = $agent->getDisplaymail();

		        $roulement = new Roulement(['id'=>$_SESSION['idroulement']]);
		        $manager = new RoulementsManager($bdd);
		        $manager->findIdRoulement($roulement);
		        $_SESSION['idresidence'] = $roulement->getIdresidence();

		        $residence = new Residence(['id'=>$_SESSION['idresidence']]);
		        $manager = new ResidenceManager($bdd);
		        $manager->findIdUp($residence);
		        $_SESSION['idup'] = $residence->getIdup();
 		    
				return true;
			}
		    else { return false; }
		} 
	    else //l'agent n'existe pas
	    {
	    	return false;
	    }
	   
	}

	/**
	 * [activation d'un agent]
	 * @param  [type] $nocp [nocp de l'agent à activer]
	 * @return [type]         [description]
	 */

	/**
	 * [findCp description] determine si le numéro de cp existe déjà
	 * @param  [type] $nocp [entree]
	 * @return [type] retourne true et instancie agent si existe sinon false
	 */
	function findCp($nocp)
	{
		global $bdd;
	     //instanciation de l'agent
	    $agent = new Agent(['nocp'=>$nocp]);
	    $manager = new AgentsManager($bdd);

	     return $manager->findNocpAgent($agent);
	}

	/** retourne l'objet agent correspondant au nocp en entree */
	function returnAgent($nocp)
	{
		global $bdd;
	     //instanciation de l'agent
	    $agent = new Agent(['nocp'=>$nocp]);
	    $manager = new AgentsManager($bdd);

	    $manager->findNocpAgent($agent);
	    return $agent;
	}


	/**
	 * Instanciation de l'agent $id
	 * @param  [type] $id [description]
	 */
	function findId($id)
	{
		global $bdd;
		//=== SECURISATION DES CHAMPS
	    $id = trim(sanitizeString($id));

	     //instanciation de l'agent
	    $agent = new Agent(['id'=>$id]);
	    $manager = new AgentsManager($bdd);

	    $manager->findIdAgent($agent);
	    return $agent;
	}

	/**
	 * [findEmail description] determine si l'email existe déjà
	 * @param  [type] $email [entree]
	 * @return [type]  retourne true si existe sinon false
	 */
	function findEmail($email)
	{
		global $bdd;
		//=== SECURISATION DES CHAMPS
	    $email = trim(sanitizeString($email));

	     //instanciation de l'agent
	    $agent = new Agent(['email'=>$email]);
	    $manager = new AgentsManager($bdd);

	     return $manager->findEmailAgent($agent);
	}

	/**
	 * [modifInfosProfil : modifie les infos profil de l'utilisateur]
	 * @param  [type] $telephone [description]
	 * @param  [type] $email     [description]
	 * @return [type]            [description]
	 */
	function modifInfosProfil($telephone, $email, $idroulement)
	{
		$message ='';

		global $bdd;

		//instanciation de l'agent
	    $agent = new Agent(['nocp'=>$_SESSION['nocp']]);
	    $manager = new AgentsManager($bdd);
	                                                    
	    //hydratation de l'agent
	    $manager->findNocpAgent($agent);

		if (validationemail($email))
		{
			//email exist déjà
			if (findEmail($email)) 
			{ 
				if($email!=$agent->getEmail()) {$message = $message . "Email existe dèjà. Non enregistré.<br>"; }
			}
			else
			{ 
				//email valide, enregistrement dans la bdd
				$agent->setEmail($email);
				$_SESSION['email'] = $email;
			}
		}

		if (validationtelephone($telephone))
		{
			//email valide, enregistrement dans la bdd
			$agent->setTelephone($telephone);
			$_SESSION['telephone'] = $telephone;
		}
		else { $message = $message .  "No de téléphone non valide";}

		$agent->setIdroulement($idroulement);
		$_SESSION['idroulement'] = $idroulement;
		
		$manager->update($agent);
		$message = $message .  "Mis à jour terminée";

		return $message;
	}

	function modifPassword($password)
	{
		global $bdd;

		//instanciation de l'agent
	    $agent = new Agent(['nocp'=>$_SESSION['nocp']]);
	    $manager = new AgentsManager($bdd);
	         
	    //instanciation de l'agent                                           
	    $manager->findNocpAgent($agent);

		$agent->setMotdepasse($password);
		$manager->update($agent);

		$_SESSION['password'] = $agent->getMotdepasse();
	}

	function AjouterAgent($nom, $prenom, $telephone, $email, $nocp, $droits, $motdepasse, $dateinscription, $actif, $roulement, $cle)
	{
		global $bdd;

		$agent = new Agent(
					[
						'nom'=>$nom,
						'prenom'=>$prenom,
						'telephone'=>$telephone,
						'email'=>$email,
						'nocp'=>$nocp,
						'droits'=>$droits,
						'motdepasse'=>cryptagemotdepasse($motdepasse),
						'dateinscription'=>$dateinscription,
						'actif'=>$actif,
						'idroulement'=>$roulement,
						'cle'=>$cle
					]);
		$manager = new AgentsManager($bdd);
		$manager->add($agent);
	}

	function ModifierAgent($agent)
	{
		global $bdd;
		$manager = new AgentsManager($bdd);
		$manager->updateById($agent);
	}

	//modifie le parametre d'affichage du nom et prenom
	function AffichageNomAgent($displayname, $nocp)
	{
		global $bdd;
		$manager = new AgentsManager($bdd);
		$manager->updateDisplayName($displayname, $nocp);
	}

	//modifie le parametre d'affichage du mail
	function AffichageMailAgent($displaymail, $nocp)
	{
		global $bdd;
		$manager = new AgentsManager($bdd);
		$manager->updateDisplayMail($displaymail, $nocp);
	}

	//suppression de l'agent à partir de l'id
	function SupprimerAgent($agent)
	{
		global $bdd;
		$manager = new AgentsManager($bdd);
		$manager->delete($agent);
	}

	//retourne un tableau contenant les objets Agents
	function ListeAgents()
	{
		global $bdd;

		$manager = new AgentsManager($bdd);
		return $manager->getListAgentsNomAsc();
	}


?>