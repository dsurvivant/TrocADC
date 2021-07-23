
<?php

/**
 * ENTREE:
 * 
 * 	- $listepropositions : objets Propositions du jour et de l'up de l'agent
 * 	- $tabpropositions : multidimensionnel
 * 			[i][0] => Objet Proposotion du jour et de l'up au rang i
 * 			[i][1] => Objet Journee correspondant à la proposition
 * 			[i][2] => Objet Agent correspondant à la proposition
 * 	- $tabDernieresPropositions : idem que tableau $tabpropositions mais contient uniquement les dix dernières propositions de l'up
 * 	- $tabroulementsderecherche : contient la liste des roulements de recherche choisit par l'agent connecté => example (171,172,173)
 * 	- $tabroulements: Tableau des roulements=>[i]['id']=id du roulement [i]['libelle']=libelle rlt
*/

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
		<div class="col p-0 border text-center">Rlt</div>
		<div class="col p-0 border text-center">PS</div>
		<div class="col p-0 border text-center">FS</div>
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
		$agent = $tabpropositions[$i][2];

		$idroulement = $journee->getIdroulement();

		foreach ($tabroulements as $value) 
		{
			if($value['id']==$idroulement) {$libelle = $value['libelle'];}
		}

		//que les roulements de recherche
		if(in_array($idroulement, $tabroulementsderecherche)):
			//conversion format horaire
			$heureps = new DateTime($journee->getHeureps());
			$heurefs = new DateTime($journee->getHeurefs());
	?>
		<!-- AFFICHAGE DE LA PROPOSITION -->
			<div class="row proposition" >
				<div class="col p-0  border text-center"><?= $journee->getNomjournee(); ?></div>
				<div class="col p-0  border text-center"><?= $libelle ?></div>
				<div class="col p-0  border text-center"><?= $heureps->format('H:i') . " " . $journee->getLieups();  ?></div>
				<div class="col p-0  border text-center"><?= $heurefs->format('H:i') . " " . $journee->getLieufs(); ?><img class="float-right m-1" src="public/images/icones/loupe1.png" alt="loupe" width="16px"></div>
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
		<!-- FIN AFFICHAGE PROPOSITION -->
	<?php 
	endif;endfor;?>
							
</div>