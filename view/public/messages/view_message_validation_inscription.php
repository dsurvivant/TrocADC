<?php ob_start() ?>

<div class="container">
	<div class="row">
		<h2 class="col-12 bg-dark p-3 text-center text-white ">Validation inscription</h2>

		<p class="col-12 text-center m-2">
			Merci de vérifier votre boite mail afin de finaliser l'inscription sur ce site.
		</p>

		<div class="text-center col-12"><a class="btn-secondary text-white p-2" href="index.php">Retour</button></a>
	</div>
</div>
<?php $main = ob_get_clean();

$titre = "Inscription";
require('view/public/template_main.php');
?>