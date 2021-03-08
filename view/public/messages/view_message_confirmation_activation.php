<?php ob_start() ?>

<div class="container">
	<div class="row">
		<h3 class='jumbotron'>Votre compte vient d'être activé.<br> Bienvenue sur trocadc.fr<br>Merci de vous reconnecter pour profiter des services du site</h3>

		<div class="text-center col-12"><a class="btn-info text-white p-2" href="index.php">Retour</button></a>
	</div>
</div>
<?php $main = ob_get_clean();

$titre = "Activation";
require('view/public/template_main.php');
?>