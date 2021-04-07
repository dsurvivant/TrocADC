	
<?php 
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

