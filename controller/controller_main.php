<?php
	/**
	 * créé par jmt janvier 2021
	 */

	function viewParametres()
	{
		global $bdd;

		$_SESSION['message']='';
		//modification des infos sur la page parametres (retour form)
			if( isset($_POST['telephone']) and isset($_POST['email']) and isset($_POST['noroulement']) and isset($_POST['noresidence']) and isset($_POST['noup']) )
			{	
				$telephone =sanitizeString(trim($_POST['telephone']));
				$email=sanitizeString(trim($_POST['email']));
				$idup = sanitizeString(trim($_POST['noup']));
				$idresidence = sanitizeString(trim($_POST['noresidence']));
				$idroulement= sanitizeString(trim($_POST['noroulement']));
		
				$message = modifInfosProfil($telephone, $email, $idroulement);
				$_SESSION['message']= $message;

				//mis à jour parametres session de l'utilisateur
				$_SESSION['idup'] = $idup;
				$_SESSION['idresidence'] = $idresidence;
				$_SESSION['idroulement'] = $idroulement;
			}

		//modification du mot de passe (retour form)
			if( isset($_POST['password']) and isset($_POST['newpassword']) and isset($_POST['confirmpassword']))
			{
				//instanciation de l'agent afin de pouvoir récupérer le mdp actuel
				$agent = new Agent(['nocp'=>$_SESSION['nocp']]);
	    		$manager = new AgentsManager($bdd);
	    		$manager->findNocpAgent($agent);
	    		

				$password = sanitizeString(trim($_POST['password']));
				$newpassword = sanitizeString(trim($_POST['newpassword']));
				$confirmpassword = sanitizeString(trim($_POST['confirmpassword']));

				//
				if(cryptagemotdepasse($password) == $agent->getMotdepasse())
				{
					if ($newpassword == $confirmpassword)
					{
						//tous les critères sont réunis pour modifier le mot de passe
						modifPassword(cryptagemotdepasse($newpassword));
						$_SESSION['message']='Mot de passe modifié avec succes';
					}
					else
					{
						$_SESSION['message'] = "Les nouveaux mots de passe ne sont pas identiques";
					}
				}
				else
				{
					$_SESSION['message'] = "L'ancien mot de passe n'est pas valide";
				}		
			}

		//modification case à cocher "Afficher nom et prénom"
		if (isset($_POST['filtrename']))
		{
			AffichageNomAgent($_POST['checkname'], $_SESSION['nocp']);
			$_SESSION['displayname']=$_POST['checkname'];
		}

		//modification case à cocher "Afficher mail"
		if (isset($_POST['filtremail']))
		{
			AffichageMailAgent($_POST['checkmail'], $_SESSION['nocp']);
			$_SESSION['displaymail']=$_POST['checkmail'];
		}

		//liste des up
		$manager = new UpManager($bdd);
		$ups = $manager->getListUpId();
		//liste des résidences
		$manager = new ResidenceManager($bdd);
		$residences = $manager->getListResidencesId();
		//liste des roulements
		$manager = new RoulementsManager($bdd);
		$roulements = $manager->getListRoulements();
		
		$titrepage = "Paramètres";
		require('view/public/view_parametres.php');
	}

	/**
	 * ENTREE: $_GET['choixdate'], facultatif, à défaut date du jour
	 * SORTIE: tableau multidimensionel: tabpropositions[[($proposition,$journee, $agent]], où
	 * $proposition est un objet Proposition, $journee est un objet
	 * $agent est un objet Agent
	 * A une proposition correspond une journee un agent
	 *
	 *
	 * cette fonction affiche la page principale contenant le calendrier et les propositions
	 *	elle recherche les éléments nécessaires à l'affichage de la page: 
	 * - Facultatif: la date concernée: fournie par $_GET['choixdate']
	 * - par défaut, date du jour
	 * - recherche les propositions du jour concerné
	 * - recherche pour chaque proposition l'agent et le roulement
	 * 
	 * Retourne un tableau tabpropositions[[($proposition, $agent, $roulement]] qui contient les
	 * objets de la recherche
	 */
	function viewMain()
	{
		global $bdd;

		if(isset($_SESSION['nocp']))
		{
			if (isset($_GET['choixdate'])) { $datederecherche = $_GET['choixdate']; }
			else { $datederecherche = time(); }

			
		//récupération des propositions sur la date choisie
			$tabpropositions = [];
			$i=0;
			$listepropositions = ListePropositionsParDate($datederecherche);

			//association pour chaque proposition à l'agent et le roulement
			foreach ($listepropositions as $proposition) 
			{
				$idagent = $proposition->getIdagent();
				$idjournee = $proposition->getIdjournee();

				//recherche de la journee
				$journee = new Journee(['id'=>$idjournee]);
	    		$manager = new JourneesManager($bdd);
	   			$manager->findJourneeById($journee);

				//recherche de l'agent correspondant
				$agent = findId($idagent);

				//ajout au tableau
				$tabpropositions[$i][0] = $proposition;
				$tabpropositions[$i][1] = $journee;
				$tabpropositions[$i][2] = $agent;
				$i++;	
			}

		//récupération des dernieres propositions
		$tabDernieresPropositions = Dernierespropositions();

			$titrepage = "Calendrier";
			require('view/public/view_main.php');
		}
		else
		{
			viewConnection();	
		}
	}

	function viewAjouterProposition()
	{
		global $bdd;
		
		if (isset($_SESSION['nocp']))
		{
			//CAS D'UNE PROPOSITION JOURNEE FAC
			if(isset($_GET['journeefac']))
			{
				global $bdd;
				//AJOUT DE LA JOURNEE FAC DANS LA BDD
				
				//sécurisation des champs
				$noroulement = sanitizeString(trim($_POST['noroulement']));
				$nomjournee = sanitizeString(trim($_POST['nomjournee']));
				$heureps = sanitizeString(trim($_POST['heureps']));
				$lieups = sanitizeString(trim($_POST['lieups']));
				$heurefs = sanitizeString($_POST['heurefs']);
				$lieufs = sanitizeString($_POST['lieufs']);

				$journee = new Journee([
								'idroulement'=>$noroulement,
								'nomjournee'=>$nomjournee,
								'heureps'=>$heureps,
								'heurefs'=>$heurefs,
								'lieups'=>$lieups,
								'lieufs'=>$lieufs
								]);
				$manager = new JourneesManager($bdd);
				$idjournee = $manager->add($journee);

				//AJOUT DE LA PROPOSITION DANS LA BDD
				$idresidence = 1;
				$commentaires = sanitizeString(trim($_POST['commentaires']));
				$idagent = $_SESSION['id'];
				$dateconcernee = date('Y-m-d', $_GET['jour']);

				//controle des champs
				if ($commentaires=='') { $commentaires= "Aucun commentaire";}
				Ajouterproposition($dateconcernee, $idjournee, $idagent, $commentaires);

				$chemin = "index.php?page=calendrier&choixdate=" . $_GET['jour'];
				header('location:' . $chemin);
			}

			if(isset($_GET['jour'])) //date de proposition obligatoire
			{
				//CAS D'UNE PROPOSITION AVEC JOURNEE EN ROULEMENT
				if(isset($_POST['noroulement']) and isset($_POST['commentaires']) and isset($_POST['idjournee']) ) // validation du formulaire d'ajout de proposition
				{

					//sécurisation des champs
					//$idresidence = sanitizeString(trim($_POST['idresidence']));
					//$idresidence = 1;
					//$noroulement = sanitizeString(trim($_POST['idroulement']));
					$commentaires = sanitizeString(trim($_POST['commentaires']));
					$idjournee = sanitizeString(trim($_POST['idjournee']));
					$idagent = $_SESSION['id'];

					$dateconcernee = date('Y-m-d', $_GET['jour']);
					
					//controle des champs
					if ($commentaires=='') { $commentaires= "Aucun commentaire";}
					Ajouterproposition($dateconcernee, $idjournee, $idagent, $commentaires);

					$chemin = "index.php?page=calendrier&choixdate=" . $_GET['jour'];
					header('location:' . $chemin);
				}
				//AFFICHAGE FORMULAIRE AJOUT DE PROPOSITION
				else 
				{
					//récupération des UP, résidences, roulements
					//liste des up
					//$manager = new UpManager($bdd);
					//$ups = $manager->getListUpId();
					//liste des roulements
					$manager = new RoulementsManager($bdd);
					$roulements = $manager->getListRoulements(); 
					//liste des résidences
					$manager = new ResidenceManager($bdd);
					$residences = $manager->getListResidencesId();

					//liste des journées de roulement
					$manager = new JourneesManager($bdd);
					$journees = $manager->getListJournee();

					//valeur des selects
					
					$titrepage = "Ajout d'une proposition";
					require('view/public/view_ajout_proposition.php');
				}

			}
			else { require('view/public/view_main.php');}
		}
		else { require ('view/connection/view_connexion.php');}
	}

	function viewModifierProposition()
	{
		global $bdd;

		if (isset($_SESSION['nocp']))
		{
			
			//modification
			if(isset($_POST['idup']) and isset($_POST['idresidence']) and isset($_POST['idroulement']) and isset($_POST['commentaires']) and isset($_POST['idjournee'])) // validation du formulaire d'ajout de proposition
			{	
				//sécurisation des champs
				$idproposition = $_GET['idproposition'];
				$idproposition = sanitizeString(trim($idproposition));
				$idresidence = sanitizeString(trim($_POST['idresidence']));
				$noroulement = sanitizeString(trim($_POST['idroulement']));
				$commentaires = sanitizeString(trim($_POST['commentaires']));
				$idjournee = sanitizeString(trim($_POST['idjournee']));
				$idagent = $_SESSION['id'];

				//$dateconcernee = date('Y-m-d', $_GET['jour']);
					
				//controle des champs
				if ($commentaires=='') { $commentaires= "Aucun commentaire";}
				Modifierproposition($idproposition, $idjournee, $commentaires);

				//$chemin = "index.php?page=calendrier&choixdate=" . $_GET['jour'];
				header("location:index.php?page=mes propositions&idproposition=" . $idproposition);
			}
			else
			{
				$idproposition = $_GET['idproposition'];
				$dateproposition = $_GET['dateproposition'];
				
				//récupération de la proposition
				$proposition = RechercheProposition($idproposition);
				$id = $proposition->getIdjournee();
				//récupération journée
				$journee = new Journee(['id'=>$id]);
	    		$manager = new JourneesManager($bdd);
				$manager->findJourneeById($journee);

				//liste des journées
				$manager = new JourneesManager($bdd);
				$journees = $manager->getListJournee();

				//récupération roulement, résidence, UP
				
				$titrepage = "Modifier une proposition";
				require('view/public/view_modifier_proposition.php');
			}
		}
		else { require('view/connection/view_connexion.php');}
	}

	function viewMespropositions()
	{
		global $bdd;

		if (isset($_SESSION['nocp']))
		{
			$_SESSION['message']='';
			//suppression d'une proposition
			if(isset($_GET['supprimer']))
			{
				$idproposition = $_GET['supprimer'];
				Supprimerproposition($idproposition);
				$_SESSION['message']="Proposition supprimée";
			}
			

			$tabpropositions = [];
			//RECUPERATION DES PROPOSITIONS DE L'AGENT
			$idagent = $_SESSION['id']; 
			$listepropositions = ListePropositionsParNocp($idagent);
			//RECUPERATION DES JOURNEES LIEES AUX PROPOSITIONS

			$i=0;
			//association pour chaque proposition à l'agent et le roulement
			foreach ($listepropositions as $proposition) 
			{
				$idagent = $proposition->getIdagent();
				$id = $proposition->getIdjournee();

				//recherche de la journee
				$journee = new Journee(['id'=>$id]);
	   			$manager = new JourneesManager($bdd);
				$manager->findJourneeById($journee);

				//recherche de l'agent correspondant
				$agent = findId($idagent);

				//ajout au tableau
				$tabpropositions[$i][0] = $proposition;
				$tabpropositions[$i][1] = $journee;
				$i++;
			}
			
			$titrepage = "Mes propositions";
			require('view/public/view_mespropositions.php');
		}
		else
		{
			require ('view/connection/view_connexion.php');
		}
	}

	//récupération des 10 dernieres propositions
	function Dernierespropositions()
	{
		global $bdd;

		if (isset($_SESSION['nocp']))
		{
			$_SESSION['message']='';
			
			$tabDernieresPropositions = [];
			//RECUPERATION DES 10 dernieres propositions
			$listeDernieresPropositions = ListeDernieresPropositions();
			//RECUPERATION DES JOURNEES LIEES AUX PROPOSITIONS

			$i=0;
			//association pour chaque proposition à l'agent et le roulement
			foreach ($listeDernieresPropositions as $proposition) 
			{
				$idagent = $proposition->getIdagent();
				$idjournee = $proposition->getIdjournee();

				//recherche de la journee
				$journee = new Journee(['id'=>$idjournee]);
	    		$manager = new JourneesManager($bdd);
			 	$manager->findJourneeById($journee);

				//recherche de l'agent correspondant
				$agent = findId($idagent);

				//ajout au tableau
				$tabDernieresPropositions[$i][0] = $proposition;
				$tabDernieresPropositions[$i][1] = $journee;
				$tabDernieresPropositions[$i][2] = $agent;
				$i++;
			}
			return $tabDernieresPropositions;;
		}
		else
		{
			require ('view/connection/view_connexion.php');
		}
	}
	//retire $option du menu déroulant
	function menu($option)
	{
		$_SESSION['menu']= [];
		$menu = array('Calendrier', 'Mes propositions', 'Paramètres','Déconnexion');
		$menu = array_diff($menu, array($option));

		$_SESSION['menu'] = $menu;
	}
?>