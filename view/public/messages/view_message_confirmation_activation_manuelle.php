<?php ob_start() ?>

<div class="container">
	<div class="row">
		<p class="col-12 border bg-dark text-white text-center p-3">			
			Merci pour ton inscription. <br><br>
			La demande d'activation a bien été prise en compte. <br>
			Ce compte sera validé dans les 24 heures. Un message de confirmation d'activation te sera adressé (sms ou mail). <br>
		</p>

		<p class="col-12 border bg-secondary text-center text-white p-3">
			RAPPEL: Seuls les agents du 171 PE sont autorisés à cette application pour le moment. <br>
			Cette appli est actuellement en test par ces agents.
		</p>

		<div class="text-center col-12"><a class="btn-secondary text-white p-2" href="index.php">Retour</button></a>
	</div>
</div>
<?php $main = ob_get_clean();

$titre = "Activation";
require('view/public/template_main.php');
?>