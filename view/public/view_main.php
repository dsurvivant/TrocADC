	
<?php 
/**
 * ENTREE:
 * 
 * 	- $listepropositions : objets Propositions du jour et de l'up de l'agent
 * 	- $tabpropositions : multidimensionnel
 * 			[i][0] => Objet Proposotion du jour et de l'up au rang i
 * 			[i][1] => Objet Journee correspondant à la proposition
 * 			[i][2] => Objet Agent correspondant à la proposition
 * 	- $tabDernieresPropositions : idem que tableau $tabpropositions mais contient uniquement les dix dernières propositions de l'up
 * 	- $tabroulementsderecherche : contient la liste des roulements de recherche choisit par l'agent connecté => example (171,172,173)
 *
*/


if (isset($_SESSION['nocp']))
{	
	ob_start();
		?>
	<div class="container">

		<div class="row">
			<section  class="col-lg-6">
				<div id="calendar" class="mb-3">
					<?php require("view/public/calendar.php");  ?>

				</div>

				<div class="sectionPropositions">
					<?php require("view/public/view_propositions_par_date.php"); ?>

				</div>
			</section>

			<section class="col-lg-6">
				<div class="sectionPropositions">
					<?php require("view/public/view_dernieres_propositions.php"); ?>
				</div>
			</section>

		</div>

	</div>
<?php $main = ob_get_clean();

$titre = "trocADC - Calendrier";
require('view/public/template_main.php');
}	
?>

