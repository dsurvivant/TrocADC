
<?php
	/**
	 * créé par jmt janvier 2021
	 */
	session_start();

	require ('model/model.php');
	require ('model/fonctions.php');
	require ('controller/controller_connexion.php');
	require ('controller/controller_main.php');
	require ('controller/controller_admin.php');
	
	$_SESSION['message']='';
	$_SESSION['menu']=array();

	/* AFFICHAGE DES ERREURS PHP */
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	try 
	{
		if  (isset($_GET['page']))
		{
			switch ($_GET['page']) 
			{
			 	case 'connexion':
			 		demandeConnexion();
			 		break;
			 	case 'deconnexion':
			 		session_destroy();
			 		viewConnection();
			 		break;
			 	case 'calendrier':
			 		menu('Calendrier');
			 		viewMain();
			 		break;
			 	case 'mes propositions':
			 		menu('Mes propositions');
			 		viewMespropositions();
			 		break;
			 	case 'inscription':
			 		viewInscription();
			 		break;
			 	case 'parametres':
			 		//page accessible uniquement si connect
			 		if(isset($_SESSION['nocp']))
			 			{
			 				menu('Paramètres');
			 				viewParametres();
			 			}
			 		else { viewConnection(); }
			 		break;
			 	case 'ficheagent':
			 		menu('');
			 		if(isset($_SESSION['droits']))
			 		{
				 		if ($_SESSION['droits']==1){ viewFicheAgent(); }
				 		else { viewMain();}
				 	}
				 	else 
				 	{ 
				 		menu('Calendrier');
				 		viewMain();
				 	}
			 		break;
			 	case 'ajout_proposition':
			 		menu('');
			 		viewAjouterProposition();
			 		break;
			 	case 'modifier_proposition':
			 		menu('');
			 		viewModifierProposition();
			 		break;
			 	case 'gestionsite':
			 		if(isset($_SESSION['droits']))
			 		{
			 			if($_SESSION['droits']==1)
			 			{ 
			 				menu('');
			 				//viewgestionsite();
			 				viewGestionsite();
			 			}
			 			else 
			 			{ 
			 				menu('Calendrier');
			 				viewmain(); 
			 			}
			 		}
			 		else 
			 		{
			 			menu('Calendrier');
			 		 	viewmain();
			 		}
			 		break;
			 	case 'ajouterjournee':
			 		if(isset($_SESSION['droits']))
			 		{
			 			if($_SESSION['droits']==1)
			 			{ 
			 				menu('');
			 				//viewgestionsite();
			 				viewAjouterjournee();
			 			}
			 			else 
			 			{ 
			 				menu('Calendrier');
			 				viewmain(); 
			 			}
			 		}
			 		else 
			 		{
			 			menu('Calendrier');
			 		 	viewmain();
			 		}
			 		break;
			 	default:
			 		if(isset($_SESSION['nocp']))
			 		{
			 			menu('Calendrier');
			 			viewMain();
			 		}
			 		else
			 		{viewConnection();}
			 	//feuille calendrier
			 	break;
			}
		}
		elseif (isset($_SESSION['nocp'])) 
		{
			menu('Calendrier');
			viewMain();
		}
		else
		{
			viewConnection();
		}
	
	} catch (Exception $e) 
	{
		$errormessage = $e->getMessage();
		require('view/404.php');
	}

	
?>
