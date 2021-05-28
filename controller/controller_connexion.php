<?php
	/**
	 * créé par jmt janvier 2021
	 */

	function viewConnection()
	{
		require('view/connection/view_connexion.php');
	}

	function demandeConnexion()
	{
		global $bdd;

		//demande de connection
		if (isset($_POST['nocp']) and isset($_POST['password']))
		{
			$result = connexionAgent($_POST['nocp'], $_POST['password']);
		}

		if (isset($_SESSION['nocp'])) //connecté
		{
			//enregistrement historique de connexion
			if (isset($_SESSION['id'])){$idagent=$_SESSION['id'];}
			else {$idagent='';}
			$dateconnexion = date('Y-m-d H:i:s');

			$historiqueconnexion = new Historiqueconnexion(['dateconnexion'=>$dateconnexion,
															'idagent'=>$idagent]);
			$manager = new HistoriqueconnexionsManager($bdd);
			$manager->add($historiqueconnexion);

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

	function viewInscription()
	{
		global $bdd;
		//récupération des UP, résidences, roulements
		//liste des up
		$manager = new UpManager($bdd);
		$ups = $manager->getListUpId();
		//liste des roulements
		$manager = new RoulementsManager($bdd);
		$roulements = $manager->getListRoulements(); 
		//liste des résidences
		$manager = new ResidenceManager($bdd);
		$residences = $manager->getListResidencesId();

		$_SESSION['message']='';
		
		if (isset($_POST['noroulement']) and isset($_POST['nocp']) and isset($_POST['nom']) and isset($_POST['prenom']) and isset($_POST['telephone']) and isset($_POST['email']) and isset($_POST['password']) and isset($_POST['confirmpassword'])) 
		{
			//securisation
			$nocp = sanitizeString(trim($_POST['nocp']));
			$nom = sanitizeString(trim($_POST['nom']));
			$prenom = sanitizeString(trim($_POST['prenom']));
			$telephone = sanitizeString(trim($_POST['telephone']));
			$email = sanitizeString(trim($_POST['email']));
			$password = sanitizeString(trim($_POST['password']));
			$confirmpassword =sanitizeString($_POST['confirmpassword']);
			$idroulement = sanitizeString($_POST['noroulement']);
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
					$entete = "From: inscription@trocadc.fr";
					$dateinscription = time();
					$messageadmin = "nouvelle inscription TrocADC de " . $nom . " " . $prenom;
					
					mail('jmtentelier@gmail.com','nouvelle inscription',$messageadmin ,$entete);
					
					AjouterAgent($nom, $prenom, $telephone, $email, $nocp, $droits, $password, $dateinscription, $actif, $idroulement, $cle); 
					
					$titrepage = "inscription";
					require('view/public/messages/view_message_confirmation_activation.php');
					//message admin de d'inscription
					
					
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