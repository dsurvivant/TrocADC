<?php

/**
 * CREE PAR JMT MARS 2021
 * 
 */

/**
 * - Récupère la liste des objets agents dans $agents
 * - Récupère la liste des objets journees dans $journees
 * - Récupère la liste des objets roulements dans $roulements
 * @param  string $id [facultatif: permet de mettre la ligne correspondant à l'id en rouge]
 * @return affiche la page view_gestionsite.php
 */
function viewGestionsite($id='')
{
	global $bdd;
	
	//options d'affichages (onglet,journee,residence roulement)
		//defaut
		$idjournee = '';
		$idroulement = $_SESSION['idroulement'];
		$idresidence=$_SESSION['idresidence'];
		$idup=$_SESSION['idup'];
		//changement
		if (isset($_GET['onglet'])) { $onglet = $_GET['onglet']; }
		if (isset($_GET['idroulement'])) { $idroulement = $_GET['idroulement']; }
		if (isset($_GET['idresidence'])) { $idresidence = $_GET['idresidence']; }
		if (isset($_GET['idup'])) 
			{ 
				$idup = $_GET['idup'];	
				if (!isset($_GET['idresidence']))
				{
					//résidence par défaut
					$residence = new Residence(['idup'=>$_GET['idup']]);
					$manager = new ResidenceManager($bdd);
					$residences = $manager->getListResidencesWithUp($residence);

					if(!empty($residences)){$idresidence = $residences[0]->getId(); }
				}
			}
		
	//onglet actif
		
	
	//ajout d'une journée
	if (isset($_POST['noroulement']) and isset($_POST['nomjournee']) and isset($_POST['heureps']) and isset($_POST['lieups']) and isset($_POST['heurefs']) and isset($_POST['lieufs']))
	{
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

		$onglet = "journees";
		$idroulement = $noroulement;
		$idjournee = $idjournee;
	}
	//suppression d'une journee
	else if(isset($_GET['deleteday']) and isset($_GET['idjournee']))
	{
		$idjournee = sanitizeString(trim($_GET['idjournee']));
		 //instanciation de la journee
	    $journee = new Journee(['id'=>$idjournee]);
	    $manager = new JourneesManager($bdd);

	 	$manager->delete($journee);

		$onglet = "journees";
	}
	//ajout d'un roulement
	if (isset($_POST['noup']) and isset($_POST['noresidence']) and isset($_POST['newroulement']) )
	{
		$idup = $_POST['noup'];
		$noroulement = sanitizeString(trim($_POST['newroulement']));
		$idresidence = sanitizeString(trim($_POST['noresidence']));

		$roulement = new Roulement(['noroulement'=>$noroulement, 'idresidence'=>$idresidence]);

		$manager = new RoulementsManager($bdd);
		$idroulement = $manager->add ($roulement);

		$onglet = "roulements";
	}
	//suppression d'un roulement
	else if (isset($_GET['deleteroulement']) and isset($_GET['idroulement']))
	{

		$idroulement = sanitizeString(trim($_GET['idroulement']));

		//instanciation de la residence
	    $roulement = new Roulement(['id'=>$idroulement]);
	    $manager = new RoulementsManager($bdd);

	 	$manager->delete($roulement);

		$onglet = "roulements";
	}	
	//ajout d'une résidence
	else if (isset($_POST['newresidence']) and isset($_POST['noup']))
	{
		$nomresidence = sanitizeString(trim($_POST['newresidence']));
		$idup = sanitizeString(trim($_POST['noup']));

		$residence = new Residence(['nomresidence'=>$nomresidence, 'idup'=>$idup]);

		$manager = new ResidenceManager($bdd);
		$idresidence = $manager->add($residence);

		$onglet ="residences";
	}
	//suppression d'un résidence
	else if (isset($_GET['deleteresidence']) and isset($_GET['idresidence'])) 
	{
		$idresidence = sanitizeString(trim($_GET['idresidence']));

		//instanciation de la residence
	    $residence = new Residence(['id'=>$idresidence]);
	    $manager = new ResidenceManager($bdd);

	 	$manager->delete($residence);

		$onglet = "residences";
	}
	//ajout d'une up
	else if(isset($_POST['newup']))
	{
		$nomup = sanitizeString(trim($_POST['newup']));
		//instanciation de l'up
		$up = new Up(['nomup'=>$nomup]);
		$manager = new UpManager($bdd);

		$idup = $manager->add($up);
		$onglet = "up";
	}
	//suppression up
	else if (isset($_GET['deleteup']) and isset($_GET['idup']) ) 
	{
		$idup = sanitizeString(trim($_GET['idup']));

		//instanciation de l'up
		$up = new Up(['id'=>$idup]);
		$manager = new UpManager($bdd);

		$manager->delete($up);

		$onglet = "up";
	}

	//récupération des listes agents, journees, roulements si administrateur
	$agents = ListeAgents();
	//liste des journees
	$manager = new JourneesManager($bdd);
	$journees = $manager->getListJournee();
	//liste des roulements 
	$roulements = ListeRoulements();
	//liste des résidences
	$manager = new ResidenceManager($bdd);
	$residences = $manager->getListResidencesId();
	//liste des up
	$manager = new UpManager($bdd);
	$ups = $manager->getListUpId();

	$titrepage = "Gestion";
	require('view/public/view_gestionsite.php');
}

/**
 * [viewFicheAgent affichage / modification /suppression d'un agent]
 * @param [$_GET['id']] [affichage de l'agent correspondant à l'id]
 * @param [$_GET['modifier']] [modification de l'agent en retour formulaire type POST]
 * @return [type] [description]
 */
function viewFicheAgent()
	{
		$nom=$prenom=$nocp=$telephone=$email=$roulement=$residence=$droits=$dateinscription='';
		$actif=0;
	/******* FICHE AGENT *******/
		if(isset($_GET['id']))
		{
			$id=sanitizeString(trim($_GET['id']));
			$agent =findId($id);
			$nom = $agent->getNom();
			$prenom = $agent->getPrenom();
			$telephone = $agent->getTelephone();
			$email = $agent->getEmail();
			$nocp = $agent->getNocp();
			$droits = $agent->getDroits();
			$dateinscription = $agent->getDateinscription();
			$actif = $agent->getActif();
			$idroulement = $agent->getIdroulement();

			//affichage formulaire de l'agent
			$titrepage = "Informations Agent";
			require('view/public/view_form_agent.php');
		}
	/******* MODIFICATION AGENT *******/
		else if(isset($_GET['modifier']))
		{
			//récupération des éléments
			$nom = sanitizeString(trim($_POST['nom']));
			$prenom = sanitizeString(trim($_POST['prenom']));
			$telephone = sanitizeString(trim($_POST['telephone']));
			$email = sanitizeString(trim($_POST['email']));
			$nocp = sanitizeString(trim($_POST['nocp']));
			$droits = sanitizeString(trim($_POST['droits']));
			$idroulement = 1;
			
			//récupération objet agent concerné
			$agent = returnAgent($nocp);
			$dateinscription = $agent->getDateinscription();
			$id = $agent->getId();

			if (isset($_POST['actif']))
			{ $actif = sanitizeString(trim($_POST['actif']));} else { $actif=0;}
			$modifpassword = sanitizeString(trim($_POST['password']));
			$confirmpassword = sanitizeString(trim($_POST['confirmpassword']));
			
			//vérification concordances mots de passe
			if ($confirmpassword!=$modifpassword) { $_SESSION['message']= "Les mots de passe ne sont pas identiques";}
			//vérification cp unique
			//if (findCp($nocp)) { $_SESSION['message']= "Le numéro de cp est déjà enregistré";}
			//vérification email unique
			//if (findEmail($email)) { $_SESSION['message']= "L'adresse mail existe déjà";}
			//vérification format email
			if (!validationemail($email)) { $_SESSION['message']= "Le format de l'adresse mail n'est pas valide";}
			//mail existe déjà
			if (findEmail($email)) 
			{ 
				if($email!=$agent->getEmail()) { $_SESSION['message']= "L'adresse mail existe déjà. Modifications non validées"; }
			}
			//vérification format telephone
			if (!validationtelephone($telephone)) { $_SESSION['message']= "Le format du numéro de téléphone n'est pas valide";}
			//champs vides
			if( $nocp=='' or $nom=='' or $prenom=='' or $telephone=='' or $email=='' or $droits=='') { $_SESSION['message']= "Merci de remplir tous les champs obligatoires";}
			
			//modification 
				
			if ($_SESSION['message']=='') 
			{ 
				if($modifpassword!='') { $modifpassword = cryptagemotdepasse($modifpassword); }
				
				if ($actif=='on') { $actif=1; } else { $actif=0;}
				$agent = new Agent(
					[
						'id'=>$id,
						'nom'=>$nom,
						'prenom'=>$prenom,
						'telephone'=>$telephone,
						'email'=>$email,
						'nocp'=>$nocp,
						'droits'=>$droits,
						'motdepasse'=>$modifpassword,
						'actif'=>$actif,
						'idroulement'=>$idroulement
					]);
				ModifierAgent($agent);
				$_SESSION['message']="Modification effectuée avec succes";

				viewGestionsite($id);
			}
			else //erreur sur un des champs
			{
				$titrepage = "Informations Agent";
				require('view/public/view_form_agent.php');
			}
		}
	/******* SUPPRESSION AGENT *******/
		else if (isset($_GET['supprimer'])) {
			echo "suppression";

			//récupération objet agent concerné
			$nocp = sanitizeString(trim($_POST['nocp']));
			$agent = returnAgent($nocp);
			
			SupprimerAgent($agent);
			SupprimerPropositions($agent);
			$_SESSION['message'] = "Suppression de " . $_POST['nom'] . " " . $_POST['prenom'] . " effectuée";
			viewGestionsite();
		}
	}

?>