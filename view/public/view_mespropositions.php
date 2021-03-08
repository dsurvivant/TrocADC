<?php ob_start() ?>

<div id="mespropositions" class="container">
	<div class="row">
		<h4 class="col bg-dark text-white p-2 text-center" > Mes propositions</h4>
	</div>

	<div class="row">
		<h5 class="col text-danger text-center"><?= $_SESSION['message']; ?></h5>
	</div>

	<div class="row head">
		<div class="col p-0 border text-center">Jnée</div>
		<div class="col p-0 border text-center">PS</div>
		<div class="col p-0 border text-center">LIEU</div>
		<div class="col p-0 border text-center">FS</div>
		<div class="col p-0 border text-center">LIEU</div>
		<div class="col p-0 border text-center">Proposée le</div>
	</div>


	<?php
	//rappel: tabpropositions[[$proposition,$journee,$agent]]
	$nbproposition = count($tabpropositions);
	for($i=0;$i<$nbproposition;$i++):
		$proposition = $tabpropositions[$i][0];
		$journee = $tabpropositions[$i][1];
		$datecreation = new DateTime( $proposition->getDatecreation());
		$dateproposition = new DateTime( $proposition->getDateproposition());

		$ps = new DateTime( $journee->getHeureps());
		$ps = $ps->format('G:i');

		$fs = new DateTime( $journee->getHeurefs());
		$fs = $fs->format('G:i');
	?>

		<div class="row proposition" >
			<div class="col p-0  border text-center"><?= $journee->getNomjournee(); ?></div>
			<div class="col p-0  border text-center"><?= $ps; ?></div>
			<div class="col p-0  border text-center"><?= $journee->getLieups(); ?></div>
			<div class="col p-0  border text-center"><?= $fs ?></div>
			<div class="col p-0  border text-center"><?= $journee->getLieufs(); ?></div>
			<div class="col p-0  border text-center"><?= $dateproposition->format('d-m-Y'); ?></div>
		</div>

		<div class="row infosproposition">
			<div class="col p-4 border bg-light">
				<p class="float-right">Crée le : <?= $datecreation->format('d-m-Y'); ?></p>
				<br>
				<?= $proposition->getCommentaires(); ?>
				<br>
				<div class="float-right">
					<a href="index.php?page=modifier_proposition&idproposition=<?= $proposition->getId();?>&idjournee=<?= $journee->getId(); ?>&dateproposition=<?= strtotime($proposition->getDateproposition()); ?>"><button class="btn btn-primary">Modifier</button></a>

					<a href="index.php?page=mes propositions&supprimer=<?= $proposition->getId(); ?>"><button class="btn btn-danger">Supprimer</button></a>
				</div>
			</div>
		</div>
	<?php 
	endfor;?>	

</div>


<?php $main = ob_get_clean();

$titre = "trocADC - Mes propositions";
require('view/public/template_main.php');
?>