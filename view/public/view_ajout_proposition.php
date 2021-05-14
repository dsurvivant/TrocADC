<?php
  ob_start();

if (isset($_GET['jour']))
{
	$mois = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
  	$currentdate = $_GET['jour'];

 	$currentmonth = date('n', $currentdate) -1;

 	$idup = $_SESSION['idup']; // uniquement l'up de l'agent
	$idresidence = $_SESSION['idresidence']; //par défaut
  	$idroulement = $_SESSION['idroulement']; //par défaut
?>
	
	<div class="container" id="ajoutproposition">
		 <div class="row text-center"><h4 class="col"><?= date('j', $currentdate). " " . $mois[$currentmonth] . " " . date('Y', $currentdate) ?></h4></div>
      	<!-- champ caché pour js -->
      	<div id="currentdate" class="d-none"><?= $currentdate ?></div>
  
      	<div class="row text-danger text-center p-1"><h3 id="message_form_proposition" class="col"><?= $_SESSION['message']; ?></h3></div>

		<!-- LES ONGLETS -->
			<nav class="nav nav-pills">
			  <a class="nav-item nav-link active" href="#journeesroulements" data-toggle="pill">Journée en roulement</a>
			  <a class="nav-item nav-link" href="#journeesfac" data-toggle="pill">Journée FAC</a>
			</nav>

		<!-- LES PANNEAUX -->

			<div class="tab-content">
				<!-- PANNEAU 1 - Journées en roulement - -->
				<div class="tab-pane fade active show mt-2" id="journeesroulements">
					<?php  include("view/forms/form_ajout_proposition.php"); ?>
				</div>

				<!-- PANNEAU 1 - Journées FAC -->
				<div class="tab-pane fade mt-2" id="journeesfac">
					<?php include("view/forms/form_ajout_journee.php"); ?>
				</div>
			</div>			
	</div>
<?php

$main = ob_get_clean();

$titre = "trocADC - Ajout proposition";
require('view/public/template_main.php');

}
else
{
  $_SESSION['menu'] = array('calendrier', 'parametres', 'deconnexion');
  throw new Exception("Impossible d'afficher la page demandée");
}
?>