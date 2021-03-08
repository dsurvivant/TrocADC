<?php ob_start() ?>

<div class="container">
	<div class="row">
		<h1 class="col-12 bg-info text-white p-3 text-center ">Infos</h1>

		<p class="col-12 text-center m-2">Application WEB d'échanges de journées, de tournées entre ADC <br>
		Dans le respect de la règlementation RH. <br>
		En cours de développement <br>
		Prochainement disponible .
		</p>

		<div class="text-center col-12"><a class="btn-info text-white p-2" href="index.php">Retour</button></a>
	</div>
</div>
<?php $main = ob_get_clean();

$titre = "trocADC - Calendrier";
require('view/public/template_main.php');
?>