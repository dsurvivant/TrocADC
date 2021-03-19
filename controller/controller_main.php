<?php
	/**
	 * créé par jmt janvier 2021
	 */

	function demandeConnexion()
	{
		//demande de connection
		if (isset($_POST['nocp']) and isset($_POST['password']))
		{
			$result = connexionAgent($_POST['nocp'], $_POST['password']);
		}

		if (isset($_SESSION['nocp'])) //connecté
		{
			//vérifiaction si l'utilisateur est bien activé
			if($_SESSION['actif']==1) { header('location: index.php?page=calendrier');}
			else 
			{ 
				session_destroy();
				require('view/public/messages/view_message_compte_non_active.php');
			}
			
		}
		else
		{
			$_SESSION['message'] = "Identifiants incorrects";
			viewConnection();
		}
	}

	function viewParametres()
	{
		$_SESSION['message']='';
		//modification des infos sur la page parametres (retour form)
		if( isset($_POST['telephone']) and isset($_POST['email']) )
		{	
			$telephone =sanitizeString(trim($_POST['telephone']));
			$email=sanitizeString(trim($_POST['email']));
			$idroulement= 1;
	
			$message = modifInfosProfil($telephone, $email, $idroulement);
			$_SESSION['message']= $message;
		}

		//modification du mot de passe (retour form)
		if( isset($_POST['password']) and isset($_POST['newpassword']) and isset($_POST['confirmpassword']))
		{
			$password = sanitizeString(trim($_POST['password']));
			$newpassword = sanitizeString(trim($_POST['newpassword']));
			$confirmpassword = sanitizeString(trim($_POST['confirmpassword']));

			if(cryptagemotdepasse($password) == $_SESSION['password'])
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

		//affichage page paramètres
		$titrepage = "Paramètres";
		require('view/public/view_parametres.php');
	}

	function viewInscription()
	{
		$_SESSION['message']='';
		
		if (isset($_POST['nocp']) and isset($_POST['nom']) and isset($_POST['prenom']) and isset($_POST['telephone']) and isset($_POST['email']) and isset($_POST['password']) and isset($_POST['confirmpassword'])) 
		{
			//securisation
			$nocp = sanitizeString(trim($_POST['nocp']));
			$nom = sanitizeString(trim($_POST['nom']));
			$prenom = sanitizeString(trim($_POST['prenom']));
			$telephone = sanitizeString(trim($_POST['telephone']));
			$email = sanitizeString(trim($_POST['email']));
			$password = sanitizeString(trim($_POST['password']));
			$confirmpassword =sanitizeString($_POST['confirmpassword']);
			$idroulement =1;
			//
			$droits = 0;
			$cle = md5(microtime(TRUE)*10000);
			$actif = 0;

			//champs vides
			if( $nocp=='' or $nom=='' or $prenom=='' or $telephone=='' or $email=='' or $password=='') { $_SESSION['message']= "Merci de remplir tous les champs";}
			//vérification concordances mots de passe
			if ($password!=$confirmpassword) { $_SESSION['message']= "Les mots de passe ne sont pas identiques";}
			//vérification cp unique
			if (findCp($nocp)) { $_SESSION['message']= "Le numéro de cp est déjà enregistré";}
			//vérification email unique
			if (findEmail($email)) { $_SESSION['message']= "L'adresse mail existe déjà";}
			//vérification format email
			if (!validationemail($email)) { $_SESSION['message']= "Le format de l'adresse mail n'est pas valide";}
			//vérification format telephone
			if (!validationtelephone($telephone)) { $_SESSION['message']= "Le format du numéro de téléphone n'est pas valide";}

			//enregistrement en base de donnée de l'agent
			if ($_SESSION['message']=='') 
				{ 
					$dateinscription = time();

					AjouterAgent($nom, $prenom, $telephone, $email, $nocp, $droits, $password, $dateinscription, $actif, $idroulement, $cle); 
					
					$titrepage = "inscription";
					require('view/public/messages/view_message_confirmation_activation.php');

					//message admin de d'inscription
					$messageadmin = "nouvelle inscription TrocADC de " . $nom . " " . $prenom;
					mail('jmtentelier@gmail.com', "nouvelle inscription", $messageadmin, "trocadc.fr");
				}
			else 
			{
				require('view/public/view_form_agent.php');
			}
		}
		else
		{	
			//affichage formulaire d'inscription
			$nocp=$nom=$prenom=$telephone=$email=$password=$roulement=$residence='';

			$titrepage = "Inscription";
			require('view/public/view_form_agent.php');
		}
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
		if(isset($_SESSION['nocp']))
		{
			if (isset($_GET['choixdate'])) { $datederecherche = $_GET['choixdate']; }
			else { $datederecherche = time(); }

			$tabpropositions = [];
			$i=0;
			$listepropositions = ListePropositionsParDate($datederecherche);
			//association pour chaque proposition à l'agent et le roulement
			foreach ($listepropositions as $proposition) 
			{
				$idagent = $proposition->getIdagent();
				$idjournee = $proposition->getIdjournee();

				//recherche de la journee
				$journee = findIdJournee($idjournee);
				//recherche de l'agent correspondant
				$agent = findId($idagent);

				//ajout au tableau
				$tabpropositions[$i][0] = $proposition;
				$tabpropositions[$i][1] = $journee;
				$tabpropositions[$i][2] = $agent;
				$i++;	
			}

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
		if (isset($_SESSION['nocp']))
		{
			if(isset($_GET['jour'])) //date de proposition obligatoire
			{
				if(isset($_POST['idresidence']) and isset($_POST['idroulement']) and isset($_POST['commentaires']) and isset($_POST['idjournee']) and isset($_POST['idup'])) // validation du formulaire d'ajout de proposition
				{

					//sécurisation des champs
					$idresidence = sanitizeString(trim($_POST['idresidence']));
					$noroulement = sanitizeString(trim($_POST['idroulement']));
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
				else //affichage du formulaire d'ajout proposition
				{
					//récupération des journées de roulement
					$journees = ListeJournees();

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

				//récupération journée
				$journee = findIdJournee($proposition->getIdjournee());
				//liste des journées
				$journees = ListeJournees();
				//récupération roulement, résidence, UP
				
				$titrepage = "Modifier une proposition";
				require('view/public/view_modifier_proposition.php');
			}
		}
		else { require('view/connection/view_connexion.php');}
	}

	function viewMespropositions()
	{
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
				$idjournee = $proposition->getIdjournee();

				//recherche de la journee
				$journee = findIdJournee($idjournee);
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

	//retire $option du menu déroulant
	function menu($option)
	{
		$_SESSION['menu']= [];
		$menu = array('Calendrier', 'Mes propositions', 'Paramètres','Déconnexion');
		$menu = array_diff($menu, array($option));

		$_SESSION['menu'] = $menu;
	}
?>