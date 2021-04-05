<?php
	/**
	 * creer par jmt mars 2021
	 *
	 * cette page doit avoir en entree le tableau 'tabDernieresPropositions' qui
	 * contient les 10 dernieres propositions ainsi que la journee et l'agent de chaque proposition
	 */
	
$datedujour = new DateTime("now");
?>
<div class="container-fluid border border-secondary m-1">
	<h4 class="col text-danger text-center">Dernières propositions</h4>
	
	<div class="row head">
		<div class="col p-0 border text-center">Date</div>
		<div class="col p-0 border text-center">Jnée</div>
		<div class="col p-0 border text-center">PS</div>
		<div class="col p-0 border text-center">LIEU</div>
		<div class="col p-0 border text-center">FS</div>
		<div class="col p-0 border text-center">LIEU</div>
	</div>

	<?php
	//rappel: tabDernieresPropositions[[$proposition,$journee,$agent]]
	$nbproposition = count($tabDernieresPropositions);
	for($i=0;$i<$nbproposition;$i++):
		$proposition = $tabDernieresPropositions[$i][0];
		$journee = $tabDernieresPropositions[$i][1];
		$agent = $tabDernieresPropositions[$i][2];

		$dateproposition= new DateTime($proposition->getDateproposition());

	?>

		<div class="row proposition" >
			<div class="col p-0  border text-center"><?= $dateproposition->format('d/m/Y'); ?></div>
			<div class="col p-0  border text-center"><?= $journee->getNomjournee(); ?></div>
			<div class="col p-0  border text-center"><?= $journee->getHeureps(); ?></div>
			<div class="col p-0  border text-center"><?= $journee->getLieups(); ?></div>
			<div class="col p-0  border text-center"><?= $journee->getHeurefs(); ?></div>
			<div class="col p-0  border text-center"><?= $journee->getLieufs(); ?> <img class="float-right m-1" src="public/images/icones/loupe1.png" alt="loupe" width="16px"></div>
		</div>

		<div class="row detailProposition">
			<div class="m-1 p-2 border bg-info">
				<!-- Coordonnees de l'agent -->
				<p>
					<?php 
						if($agent->getDisplayname() == 1) { echo $agent->getNom() . " " . $agent->getPrenom() . "<br>"; }
						echo $agent->getTelephone() . "<br>";
						if($agent->getDisplaymail() == 1) { echo $agent->getEmail() . "<br>"; }

						//findId($id);
					?>	
				</p>
			</div>

			<div class="m-1 p-2 border bg-danger">
				<span><?= $proposition->getCommentaires() ?></span>
			</div>
		</div>
	<?php 
	endfor;?>
							
</div>