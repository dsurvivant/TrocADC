<?php

/**
 * CREE PAR JMT MARS 2021
 * 
 */

/**
 * [viewAjouterjournee ajoute une journee de roulement à la table journee.]
 * Entree - OBLIGATOIRE - : noroulement, nomjournee, heureps, lieups, heurefs, lieufs en POST
 * @return [type] [Retour sur la page gestion de site sur onglet journee (view_gestionsite.php&onglet=journees)]
 */
function viewAjouterjournee()
{
	if (isset($_POST['noroulement']) and isset($_POST['nomjournee']) and isset($_POST['heureps']) and isset($_POST['lieups']) and isset($_POST['heurefs']) and isset($_POST['lieufs']))
	{
		//sécurisation des champs
		$noroulement = sanitizeString(trim($_POST['noroulement']));
		$nomjournee = sanitizeString(trim($_POST['nomjournee']));
		$heureps = sanitizeString(trim($_POST['heureps']));
		$lieups = sanitizeString(trim($_POST['lieups']));
		$heurefs = sanitizeString($_POST['heurefs']);
		$lieufs = sanitizeString($_POST['lieufs']);

		$idjournee = Ajouterjournee($noroulement, $nomjournee, $heureps, $heurefs, $lieups, $lieufs);

		header('location:index.php?page=gestionsite&onglet=journees&idroulement=' . $noroulement . "&idjournee=" . $idjournee);
	}
}

/**
 * - Récupère la liste des objets agents dans $agents
 * - Récupère la liste des objets journees dans $journees
 * - Récupère la liste des objets roulements dans $roulements
 * @param  string $id [facultatif: permet de mettre la ligne correspondant à l'id en rouge]
 * @return affiche la page view_gestionsite.php
 */
function viewGestionsite($id='')
{
	//suppression d'une journee roulement
	if(isset($_GET['deleteday']) and isset($_GET['idjournee']))
	{
		$idjournee = sanitizeString(trim($_GET['idjournee']));
		supprimerJournee($idjournee);
		$_SESSION['message']="Journée supprimée !";
	}

	//récupération des listes agents, journees, roulements si administrateur
	$agents = ListeAgents();
	$journees = ListeJournees(); 
	$roulements = ListeRoulements();
	$residences = ListeResidences();

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