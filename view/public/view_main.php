	
<?php 
if (isset($_SESSION['nocp']))
{	
	ob_start();
		?>
	<div id="containerMain" class="container-fluid">

		<div class="row">
			<div id="calendar" class="col-xs-12 col-lg-6">
				<?php require("view/public/calendar.php");  ?>

			</div>

			<section id="sectionPropositions" class="col-xs-12 col-lg-6">
				<?php require("view/public/view_propositions_par_date.php"); ?>

			</section>
		</div>

	</div>
<?php $main = ob_get_clean();

$titre = "trocADC - Calendrier";
require('view/public/template_main.php');
}	
?>

