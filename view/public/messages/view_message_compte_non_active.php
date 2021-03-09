<?php ob_start() ?>

<div class="container">
	<div class="row">
		<h3 class='jumbotron'>Ce compte n'est pas activé.<br> Soit il est en attente d'activation soit il a été désactivé par l'administrateur<br>Merci de vous rapprocher de l'administration en cas de problème (trocADC@yahoo.com)</h3>

		<div class="text-center col-12"><a class="btn-info text-white p-2" href="index.php">Retour</button></a>
	</div>
</div>
<?php $main = ob_get_clean();

$titre = "Activation";
require('view/public/template_main.php');
?>