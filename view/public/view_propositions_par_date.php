<?php
if(!isset($datederecherche)){ $datederecherche = time();}
if(!isset($tabpropositions)){$tabpropositions = [];}


$mois = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
$currentmonth = date('n', $datederecherche) -1;
?>

<div class="container-fluid border border-secondary">
	<div class="row">
		<div class="col text-center">
			<span id="jourPropositions" class="mr-2 h4" style="color:#e91903"><?= date('j', $datederecherche). " " . $mois[$currentmonth] . " " . date('Y', $datederecherche) ?></span>
			
			<a href="index.php?page=ajout_proposition&jour=<?= $datederecherche ?>" class="float-right">
				<img src="public/images/icones/plus-16px.png" alt="ajout de proposition" title="Ajouter une proposition">
			</a>
		</div>
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

	if($nbproposition==0) 
	{?>
		<div class="row proposition" >
			<div class="col p-0  border text-center">Pas de propositions ce jour</div>
		</div>
	<?php
	}
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
			<div class="col p-0  border text-center"><?= $journee->getLieufs() ?> <img class="float-right m-1" src="public/images/icones/loupe1.png" alt="loupe" width="16px"></div>
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