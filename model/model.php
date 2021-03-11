<?php
	//autochargement des classes
	function chargerClasse($classe)
	{
		require 'classes/' . $classe . '.class.php';
	}
	spl_autoload_register('chargerClasse');

	require ('model/config.php'); //connection $bdd
	//require ('config.php'); gestion des évènements desactivé car bdd à construire
	
	
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
		        $_SESSION['password'] = $agent->getMotdepasse();
		        $_SESSION['dateinscription'] = $agent->getDateinscription();
		        $_SESSION['actif'] = $agent->getActif();
		        $_SESSION['idroulement'] = $agent->getIdroulement();
		    
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
		function activerAgent($nocp)
		{
			global $bdd;
			$agent = new Agent(['nocp'=>$nocp]);
			$manager = new AgentsManager($bdd);
			$manager->activer($agent);
		}

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
	 * [findId description] determine si l'id existe
	 * @param  [type] $id [description]
	 * @return [type]       retourne true et instancie agent si existe sinon false
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
	function findEmail ($email)
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

	//retourne un tableau contenant les objets Agents
	function ListeAgents()
	{
		global $bdd;

		$manager = new AgentsManager($bdd);
		return $manager->getListAgentsNomAsc();
	}

// FONCTIONS JOURNEES

	//retourne un tableau contenant les objets journees
	function ListeJournees()
	{
		global $bdd;

		$manager = new JourneesManager($bdd);
		return $manager->getListJournee();
	}

	function Ajouterjournee($idroulement, $nomjournee, $heureps, $heurefs, $lieups, $lieufs)
	{
		global $bdd;
		$journee = new Journee([
								'idroulement'=>$idroulement,
								'nomjournee'=>$nomjournee,
								'heureps'=>$heureps,
								'heurefs'=>$heurefs,
								'lieups'=>$lieups,
								'lieufs'=>$lieufs
								]);
		$manager = new JourneesManager($bdd);
		$idjournee = $manager->add($journee);
	}

	/**
	 * [findId description] determine si l'id existe
	 * @param  [type] $id [description]
	 * @return [type]       retourne true et instancie la journee si existe sinon false
	 */
	function findIdJournee($id)
	{
		global $bdd;
		//=== SECURISATION DES CHAMPS
	    $id = trim(sanitizeString($id));

	     //instanciation de la journee
	    $journee = new Journee(['id'=>$id]);
	    $manager = new JourneesManager($bdd);

	    $manager->findIdJournee($journee);
	    return $journee;
	}

// FONCTIONS ROULEMENTS

	//retourne un tableau contenant les objets roulements
	function ListeRoulements()
	{
		global $bdd;

		$manager = new RoulementsManager($bdd);
		return $manager->getListRoulements();
	}

// FONCTIONS PROPOSITIONS

	function Ajouterproposition($dateproposition, $idjournee, $idagent, $commentaires)
	{
		global $bdd;
		
		$proposition = new Proposition([
								'dateproposition'=>$dateproposition,
								'idjournee'=>$idjournee,
								'idagent'=>$idagent,
								'commentaires'=>$commentaires
								]);
		
		$manager = new PropositionsManager($bdd);
		$idproposition = $manager->add($proposition);
	}

	function Modifierproposition($idproposition, $idjournee, $commentaires)
	{
		global $bdd;

		$proposition = new Proposition(['id'=>$idproposition, 'idjournee'=>$idjournee, 'commentaires'=>$commentaires]);
		$manager = new PropositionsManager($bdd);
		$manager->update($proposition);
	}

	function Supprimerproposition($idproposition)
	{
		global $bdd;

		//$proposition = new Proposition(['id'=>$idproposition]);
		$proposition = new Proposition(['id'=>$idproposition]);
		$manager = new PropositionsManager($bdd);
		$manager->delete($proposition);
	}

	//retourne un tableau contenant les objets propositions
	function ListePropositions()
	{
		global $bdd;

		$manager = new PropositionsManager($bdd);
		return $manager->getListPropositionsByDate();
	}

	//retourne un tableau contenant les objets propositions sur une date données
	//la date est sous la forme d'un timestamp
	function ListePropositionsParDate($date)
	{
		global $bdd;
		//recherche des propositions correspondant à la date demandée
		$proposition = new Proposition(['dateproposition'=>date('Y-m-d', $date)]);

		$manager = new PropositionsManager($bdd);
		return $manager->findPropositionsOnDate($proposition);
	}

	//retourne un tableau contenant les objets propositions d'un agent
	//ENTREE: $idagent: l'id de l'agent
	//SORTIE: tableau contenant les objets propositions
	function ListePropositionsParNocp($idagent)
	{
		global $bdd;
		//recherche des propositions correspondant à la date demandée
		$proposition = new Proposition(['idagent'=>$idagent]);

		$manager = new PropositionsManager($bdd);
		return $manager->findPropositionsByIdAgent($proposition);
	}

	//retourne le nombre de propositions sur une date
	function NbPropositionsOnDate($date)
	{
		global $bdd;
		$proposition = new Proposition(['dateproposition'=>$date]);

		$manager = new PropositionsManager($bdd);
		return $manager->nbPropositionOnDate($proposition);
	} 

	function RechercheProposition($id)
	{
		global $bdd;
		$proposition = new Proposition(['id'=>$id]);

		$manager = new PropositionsManager($bdd);
		$manager->findProposition($proposition);

		return $proposition;
	}


?>
