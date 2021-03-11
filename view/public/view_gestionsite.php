<?php

//choix de l'onglet actif
if(isset($_GET['onglet'])) 
{ 
	switch ($_GET['onglet']) {
		case 'agents':
			$onglet = 1;
			break;
		case 'journees':
			$onglet = 2;
			break;
		case 'roulements':
			$onglet = 3;
			break;		
		default:
			$onglet = 1;
			break;
	}
}
else { $onglet=1; }
ob_start();
?>

<div class="container">


	<!-- LES ONGLETS -->

		<nav class="nav nav-pills">
		  <a class="nav-item nav-link <?php if($onglet==1){ echo "active";} ?>" href="#listeagents" data-toggle="pill">Agents</a>
		  <a class="nav-item nav-link <?php if($onglet==2){ echo "active";} ?>" href="#listejournees" data-toggle="pill">Journées</a>
		  <a class="nav-item nav-link <?php if($onglet==3){ echo "active";} ?>" href="#listeroulements" data-toggle="pill">Roulements</a>
		</nav>


	<!-- LES PANNEAUX -->

		<div class="tab-content">
			<!-- PANNEAU 1 - AGENTS - -->
			<div class="tab-pane fade <?php if($onglet==1){ echo "active show";} ?> mt-2" id="listeagents">
				<!-- liste des agents -->
				<table id="tableagents" class="table table-collapse table-hover">
					<thead class="thead-light" >
						<tr>
							<th class="d-none d-sm-table-cell border text-center p-1">id</th>
							<th class=" border text-center p-1">No CP</th>
							<th class=" border text-center p-1">Nom</th>
							<th class=" border text-center p-1">Prénom</th>
							<th class="d-none d-sm-table-cell border text-center p-1">Email</th>
							<th class="d-none d-sm-table-cell border text-center p-1">Téléphone</th>
							<th class="d-none d-sm-table-cell border text-center p-1">droits</th>
							<th class="d-none d-sm-table-cell border text-center p-1">Inscrit depuis</th>
							<th class="d-none d-sm-table-cell border text-center p-1">Activé</th>
							<th class="d-none d-sm-table-cell border text-center p-1">Rlt</th>
							<th class="d-none d-sm-table-cell border text-center p-1">Rés</th>
							<th class="d-none d-sm-table-cell border text-center p-1">Up</th>
						</tr>
					</thead>

					<tbody>
						<?php
							foreach ($agents as $agent):
								$dateinscription = date('j-m-Y', $agent->getDateinscription());
								?>
								<tr>
									<td class="d-none d-sm-table-cell border p-1"><?= $agent->getId(); ?></td>
									<td class=" border p-1"><?= $agent->getNocp(); ?></td>
									<td class=" border p-1"><?= $agent->getNom(); ?></td>
									<td class=" border p-1"><?= $agent->getPrenom(); ?></td>
									<td class="d-none d-sm-table-cell border p-1"><?= $agent->getEmail(); ?></td>
									<td class="d-none d-sm-table-cell border p-1"><?= $agent->getTelephone(); ?></td>
									<td class="d-none d-sm-table-cell border p-1"><?= $agent->getDroits(); ?></td>
									<td class="d-none d-sm-table-cell border p-1"><?= $dateinscription ?></td>
									<td class="d-none d-sm-table-cell border p-1"><?= $agent->getActif(); ?></td>
									<td class="d-none d-sm-table-cell border p-1"><?= $agent->getIdroulement(); ?></td>
									<td class="d-none d-sm-table-cell border p-1"></td>
									<td class="d-none d-sm-table-cell border p-1"></td>
								</tr>
						<?php endforeach; ?>
					</tbody>
				</table>			
			</div>

			<!-- PANNEAU 2 - JOURNEES - -->
			<div class="tab-pane fade <?php if($onglet==2){ echo "active show";} ?> mt-2" id="listejournees">
				<table id="tablejournees" class="table table-collapse table-hover">
					<thead class="thead-light" >
						<tr>
							<th class="d-none d-sm-table-cell border text-center p-1">id</th>
							<th class=" border text-center p-1">Roulement</th>
							<th class=" border text-center p-1">Journee</th>
							<th class=" border text-center p-1">Heure PS</th>
							<th class="d-none d-sm-table-cell border text-center p-1">Lieu FS</th>
							<th class="d-none d-sm-table-cell border text-center p-1">Heure FS</th>
							<th class="d-none d-sm-table-cell border text-center p-1">Lieu FS</th>
							<th class="d-none d-sm-table-cell border text-center p-1">Résidence</th>
							<th class="d-none d-sm-table-cell border text-center p-1">Up</th>
						</tr>
					</thead>

					<tbody>
						<?php
							foreach ($journees as $journee):?>
								<tr>
									<td class="d-none d-sm-table-cell border p-1"><?= $journee->getId(); ?></td>
									<td class=" border p-1"><?= $journee->getIdroulement(); ?></td>
									<td class=" border p-1"><?= $journee->getNomjournee(); ?></td>
									<td class=" border p-1"><?= $journee->getHeureps(); ?></td>
									<td class="d-none d-sm-table-cell border p-1"><?= $journee->getLieups(); ?></td>
									<td class="d-none d-sm-table-cell border p-1"><?= $journee->getHeurefs(); ?></td>
									<td class="d-none d-sm-table-cell border p-1"><?= $journee->getLieufs(); ?></td>
									<td class="d-none d-sm-table-cell border p-1">?</td>
									<td class="d-none d-sm-table-cell border p-1">?</td>
								</tr>
						<?php endforeach; ?>
					</tbody>
				</table>	
				<button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modalAjoutJournee" data-backdrop="static">Ajouter</button>
			</div>

			<!-- PANNEAU 3 - ROULEMENTS - -->
			<div class="tab-pane fade <?php if($onglet==3){ echo "active show";} ?> mt-2" id="listeroulements">
				<table id="tableroulements" class="table table-collapse table-hover">
					<thead class="thead-light" >
						<tr>
							<th class="d-none d-sm-table-cell border text-center p-1">id</th>
							<th class=" border text-center p-1">UP</th>
							<th class=" border text-center p-1">Etablissement</th>
							<th class=" border text-center p-1">No roulement</th>
							<th class="d-none d-sm-table-cell border text-center p-1">Résidence</th>
						</tr>
					</thead>

					<tbody>
						<?php
							foreach ($roulements as $roulement):?>
								<tr>
									<td class="d-none d-sm-table-cell border p-1"><?= $roulement->getId(); ?></td>
									<td class=" border p-1">?</td>
									<td class=" border p-1"><?= $roulement->getEtablissement(); ?></td>
									<td class=" border p-1"><?= $roulement->getNoroulement(); ?></td>
									<td class="d-none d-sm-table-cell border p-1">?</td>
								</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
</div>

<?php 

/** FENETRES MODALES */
	require('view/modals/modal_ajout_journee.php');

$main = ob_get_clean();

$titre = "trocADC -Gestion du site";
	require('view/public/template_main.php');
?>