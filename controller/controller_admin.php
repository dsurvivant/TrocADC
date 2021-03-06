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
    global $tabtri;
    
    //options d'affichages (onglet,journee,residence roulement) par defaut
        $idjournee = '';
        $idroulement = $_SESSION['idroulement'];
        $idresidence=$_SESSION['idresidence'];
        $idup=$_SESSION['idup'];
    //changement
        if (isset($_GET['onglet'])) { $onglet = $_GET['onglet']; }
        if (isset($_GET['idroulement'])) { $idroulement = $_GET['idroulement']; }
        
        if ( (isset($_GET['idup']))  and (!isset($_GET['deleteup'])) ) 
            { 
                $idup = $_GET['idup'];
                if ( isset($_GET['idresidence']) )  
                { 
                    $idresidence = $_GET['idresidence']; 
                    //roulement par défaut
                    if (!isset($_GET['idroulement']))
                    {
                        $roulement = new Roulement(['idresidence'=>$idresidence]);
                        $manager = new RoulementsManager($bdd);
                        $roulements = $manager->getListRoulementWithResidence($roulement);
                        if(!empty($roulements)){ $idroulement=$roulements[0]->getId();}
                        else {$idroulement='';}
                    }
                }   
                else
                {
                    //résidence par défaut
                    $residence = new Residence(['idup'=>$_GET['idup']]);
                    $manager = new ResidenceManager($bdd);
                    $residences = $manager->getListResidencesWithUp($residence);

                    if(!empty($residences))
                    {
                        $idresidence = $residences[0]->getId(); 
                        
                        //roulement par défaut
                        $roulement = new Roulement(['idresidence'=>$idresidence]);
                        $manager = new RoulementsManager($bdd);
                        $roulements = $manager->getListRoulementWithResidence($roulement);
                        
                        if(!empty($roulements)) { $idroulement=$roulements[0]->getId();}
                        else {$idroulement = '';}
                        
                    }
                    else
                    {
                        $idresidence = '';
                        $idroulement = '';
                    }
                }
            }
    
    //ajout d'une journée
    if (isset($_POST['noup']) and isset($_POST['noresidence']) and  isset($_POST['noroulement']) and isset($_POST['nomjournee']) and isset($_POST['heureps']) and isset($_POST['lieups']) and isset($_POST['heurefs']) and isset($_POST['lieufs']))
    {

        //sécurisation des champs
        $idup = sanitizeString(trim($_POST['noup'])) ;
        $idresidence = sanitizeString(trim($_POST['noresidence'])) ;
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
    //suppression d'une résidence
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

    //récupération des listes agents, journees, roulements, historique connexion si administrateur
        $manageragents = new AgentsManager($bdd);
        $agents = $manageragents->getListAgentsNomAsc();
    //liste des journees
        $managerjournees = new JourneesManager($bdd);
        $journees = $managerjournees->getListJournee();
    //liste des roulements
        $managerroulements = new RoulementsManager($bdd);
        $roulements = $managerroulements->getListRoulements(); 
    //liste des résidences
        $managerresidences = new ResidenceManager($bdd);
        $residences = $managerresidences->getListResidencesId();
    //liste des up
        $managerup = new UpManager($bdd);
        $ups = $managerup->getListUpId();
    //historique de connexion
        $managerhistorique = new HistoriqueconnexionsManager($bdd);
        $historiqueconnexions = $managerhistorique->getListHistoriqueconnexionByDate();
    //
    if (!isset($_SESSION['tabTriHistorique'])) { $_SESSION['tabTriHistorique'] = array("id"=>"asc", "nom"=>"asc", "date"=>"asc");}

    //création d'un tableau détaillé historique de connexion (nom prenom agent en clair à la place de l'idagent)
        $tabhistoriqueconnexions = [];
        $i = 0;
        foreach ($historiqueconnexions as $historiqueconnexion)
        {
            $idconnexion = $historiqueconnexion->getId();
            $dateconnexion = $historiqueconnexion->getDateconnexion();
            $idagent = $historiqueconnexion->getIdagent();
            $agent = new Agent(['id'=>$idagent]);
            $manageragents->findIdAgent($agent);
            $nomagent = $agent->getNom();
            $prenomagent = $agent->getPrenom();

            array_push($tabhistoriqueconnexions, array('id'=>$idconnexion, 'nomagent'=>ucfirst($nomagent) . " " . ucfirst($prenomagent), 'date'=>$dateconnexion));
        }
       
    //choix du tri du tableau $tabhistoriqueconnexions (par id, agent ou date de connexion)
        if(isset($_GET['tri'])) { $tri = $_GET['tri'];}
        else { $tri = 'date';}

        switch ($tri) 
        {
        //tri par id d'historique
            case 'id': 
                $columns = array_column($tabhistoriqueconnexions, 'id');
                if ( $_SESSION['tabTriHistorique']['id'] == "asc") //tri id par ordre descendant
                {
                    $_SESSION['tabTriHistorique']['id'] = "desc";
                    array_multisort($columns, SORT_DESC, $tabhistoriqueconnexions);
                }
                else //tri id par ordre croissant
                {
                    $_SESSION['tabTriHistorique']['id'] = "asc";
                    array_multisort($columns, SORT_ASC, $tabhistoriqueconnexions);
                }
                break;
        //tri par nom d'agent
            case 'agent':
                $columns = array_column($tabhistoriqueconnexions, 'nomagent');
                
                if ( $_SESSION['tabTriHistorique']['nom'] == "asc") //tri agent par nom decroissant
                {
                    $_SESSION['tabTriHistorique']['nom'] = "desc";
                    array_multisort($columns, SORT_DESC, SORT_STRING, $tabhistoriqueconnexions);
                }
                else //tri id par nom croissant
                {
                    $_SESSION['tabTriHistorique']['nom'] = "asc";
                    array_multisort($columns, SORT_ASC, SORT_STRING, $tabhistoriqueconnexions);
                }
                break;
        //tri par date
            case 'date':
                $columns = array_column($tabhistoriqueconnexions, 'date');
                if ( $_SESSION['tabTriHistorique']['date'] == "asc") //tri id par nom decroissant
                {
                    $_SESSION['tabTriHistorique']['date'] = "desc";
                    array_multisort($columns, SORT_DESC, $tabhistoriqueconnexions);
                }
                else //tri id par nom croissant
                {
                    $_SESSION['tabTriHistorique']['date'] = "asc";
                    array_multisort($columns, SORT_ASC, $tabhistoriqueconnexions);
                }
                break;
            default: // par date du plus récent au plus ancien
                 
                break;
        }

    
    //REINITIALISATION DES ROULEMENTS DE RECHERCHE (appeler par ajax)
    if(isset($_POST['initroulements']))
    {
        //remis à zéro de la table roulements de recherche
        $manager = new RoulementsderechercheManager($bdd);
        $manager->erase();
        //affectation par défaut pour chaque agent
        foreach ($agents as $agent) 
        {
            $noagent = $agent->getId();
            $noroulement = $agent->getIdroulement();

            $rltrecherche = new Roulementsderecherche(
                    [
                        'idagent'=>$noagent,
                        'idroulement'=>$noroulement
                    ]);
            $manager->add($rltrecherche);
        }
        exit;
    }

    $titrepage = "Gestion";

    //header("location:index.php?page=gestionsite");
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

            //recherche de la residence
            $roulement = new Roulement(['id'=>$idroulement]);
            $manager = new RoulementsManager($bdd);
            $manager->findIdRoulement($roulement);
            $idresidence = $roulement->getIdresidence();

            //recherche de l'up
            $residence = new Residence(['id'=>$idresidence]);
            $manager = new ResidenceManager($bdd);
            $manager->findResidenceById($residence);
            $idup = $residence->getIdup();

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
                $idup = sanitizeString(trim($_POST['noup']));
                $idresidence = sanitizeString(trim($_POST['noresidence']));
                $idroulement = sanitizeString(trim($_POST['noroulement']));
            
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

                    //Si changement d'up , mis à jour des roulements de recherche
                        if($idup !=  $_SESSION['idup'])
                        {
                            updateRoulementsrechercheAgent($agent);
                        }

                    //cas particulier ou la modif se fait sur l'agent déjà connecté
                    //il faut remmettre les variables de session à jour
                        if( $nocp == $_SESSION['nocp'] )
                        {
                            $_SESSION['idup'] = $idup;
                            $_SESSION['idresidence'] = $idresidence;
                            $_SESSION['idroulement'] = $idroulement;
                        }
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
        else if (isset($_GET['supprimer'])) 
        {
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