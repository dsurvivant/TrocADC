<?php

if(!isset($datederecherche)){ $datederecherche = time();}
if(!isset($tabpropositions)){$tabpropositions = [];}


$mois = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
$currentmonth = date('n', $datederecherche) -1;
?>

<div class="container-fluid">
	<div class="row">

		<h4 id="jourPropositions" class="mr-2"><?= date('j', $datederecherche). " " . $mois[$currentmonth] . " " . date('Y', $datederecherche) ?></h4>
		
		<a href="index.php?page=ajout_proposition&jour=<?= $datederecherche ?>">
			<img src="public/images/icones/plus-16px.png" alt="ajout de proposition" title="Ajouter une proposition">
		</a>
	</div>

	<div class="row head">
		<div class="col p-0 border text-center">Jnée</div>
		<div class="col p-0 border text-center">PS</div>
		<div class="col p-0 border text-center">LIEU</div>
		<div class="col p-0 border text-center">FS</div>
		<div class="col p-0 border text-center">LIEU</div>
	</div>

	<?php
	//rappel: tabpropositions[[$proposition,$journee,$agent]]
	$nbproposition = count($tabpropositions);
	for($i=0;$i<$nbproposition;$i++):
		$proposition = $tabpropositions[$i][0];
		$journee = $tabpropositions[$i][1];
		$agent = $tabpropositions[$i][2]
	?>

		<div class="row proposition" >
			<div class="col p-0  border text-center"><?= $journee->getNomjournee() ?></div>
			<div class="col p-0  border text-center"><?= $journee->getHeureps() ?></div>
			<div class="col p-0  border text-center"><?= $journee->getLieups() ?></div>
			<div class="col p-0  border text-center"><?= $journee->getHeurefs() ?></div>
			<div class="col p-0  border text-center"><?= $journee->getLieufs() ?> <img class="float-right" src="public/images/icones/loupe1.png" alt="loupe" width="16px"></div>
		</div>

		<div class="row detailProposition">
			<div class="m-1 p-2 border bg-info">
				<!-- Coordonnees de l'agent -->
				<p>
					<?php 
						echo $agent->getNom() . " " . $agent->getPrenom() . "<br>";
						echo $agent->getTelephone() . "<br>";
						echo $agent->getEmail() . "<br>";

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