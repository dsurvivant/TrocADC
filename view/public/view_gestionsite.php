<?php

/**
 * @param   $idroulement contient la référence roulement affiché par défaut
 */

//roulement par défaut
if(!isset($idroulement)) {$idroulement = $_SESSION['idroulement'];}
//selection de la ligne journee
if (!isset($idjournee)) {$idjournee='';}
//selection de la ligne residence
if (!isset($idresidence)) {$idresidence='';}
//up
$idup = 2;


//choix de l'onglet actif
if(isset($onglet)) 
{ 
	switch ($onglet) {
		case 'agents':
			$onglet = 1;
			break;
		case 'journees':
			$onglet = 2;
			break;
		case 'roulements':
			$onglet = 3;
			break;
		case 'residences':
			$onglet = 4;
			break;
		case 'up':
			$onglet = 5;
			break;
		default:
			$onglet = 1;
			break;
	}
}
else { $onglet = 1;}

if (isset($_SESSION['message'])) { $message = $_SESSION['message']; }
else { $message = ''; }
ob_start();
?>

<div id="gestionsite" class="container">
	<?= $id; ?>
	
	<h2 class="col-12 jumbotron p-2 text-center lead">Gestion du site</h2>

	<h4 class="col-12 text-danger text-center p-2"><?= $message ?></h4>

	<!-- LES ONGLETS -->

		<nav class="nav nav-pills">
		  <a class="nav-item nav-link <?php if($onglet==1){ echo "active";} ?>" href="#listeagents" data-toggle="pill">Agents</a>
		  <a class="nav-item nav-link <?php if($onglet==2){ echo "active";} ?>" href="#listejournees" data-toggle="pill">Journées</a>
		  <a class="nav-item nav-link <?php if($onglet==3){ echo "active";} ?>" href="#listeroulements" data-toggle="pill">Roulements</a>
		  <a class="nav-item nav-link <?php if($onglet==4){ echo "active";} ?>" href="#listeresidences" data-toggle="pill">Résidences</a>
		  <a class="nav-item nav-link <?php if($onglet==5){ echo "active";} ?>" href="#listeup" data-toggle="pill">UP</a>
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
								<tr <?php if($id==$agent->getId()) { echo "class='text-danger'"; } ?> >
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
				<form action="" class="container">
					<div class="row">
						<div class="col-md-4 border p-2">
							<!-- liste UP -->
							<div class="input-group">
								<div class="input-group-prepend mb-2"><span class="input-group-text">UP</span></div>
			                    <select id="selectionup" class="form-control" name="noup" disabled>
			                        <option value="">UP Paris Est</option> 
			                    </select>
							</div>

							<!-- liste résidence -->
							<div class="input-group">
								<div class="input-group-prepend mb-2"><span class="input-group-text">Résidence</span></div>
			                    <select id="selectionresidence" class="form-control" name="noresidence" disabled>
			                       <option value="">Paris Est Transilien</option>
			                    </select>
							</div>

							<!-- liste roulement -->
							<div class="input-group">
								<div class="input-group-prepend mb-2"><span class="input-group-text">Roulement</span></div>
			                    <select id="selectionroulement" class="form-control" name="noroulement">
			                        <?php foreach ($roulements as $roulement):
					                    if($roulement->getId()==$idroulement){$selected="selected";}
					                    else {$selected='';}
					                    ?>
					                    <option value="<?= $roulement->getId(); ?>" <?= $selected ?> ><?= $roulement->getNoroulement(); ?></option> 
					                <?php endforeach; ?>
			                    </select>
							</div>

							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAjoutJournee" data-backdrop="static">Ajouter</button>
						</div>

						<div class="col-md-8 border p-2">
							<table class="table table-collapse table-hover">
								<thead class="thead-light" >
									<tr>
										<th id="enteteid" class="d-none d-sm-table-cell border text-center p-1">id</th>
										<th id="entetejournee" class=" border text-center p-1">Journee</th>
										<th class=" border text-center p-1">Heure PS</th>
										<th class="d-none d-sm-table-cell border text-center p-1">Lieu PS</th>
										<th class="d-none d-sm-table-cell border text-center p-1">Heure FS</th>
										<th class="d-none d-sm-table-cell border text-center p-1">Lieu FS</th>
										<th class="d-none d-sm-table-cell border text-center p-1"></th>
									</tr>
								</thead>

								<tbody>
									<?php
										foreach ($journees as $journee):
											//surbrilance ligne
											if($journee->getId()==$idjournee) { $surbrillance = "class=bg-warning";}
											else { $surbrillance=''; }
											//affichage des journées du roulement choisi
											if($journee->getIdroulement() == $idroulement) {
											?>
											<tr <?= $surbrillance ?> >
												<td class="idday d-none d-sm-table-cell border text-center p-1"><?= $journee->getId(); ?></td>
												<td class="nameday border text-center p-1"><?= $journee->getNomjournee(); ?></td>
												<td class=" border text-center p-1"><?= $journee->getHeureps(); ?></td>
												<td class="d-none d-sm-table-cell border text-center p-1"><?= $journee->getLieups(); ?></td>
												<td class="d-none d-sm-table-cell border text-center p-1"><?= $journee->getHeurefs(); ?></td>
												<td class="d-none d-sm-table-cell border text-center p-1"><?= $journee->getLieufs(); ?></td>
												<td class="d-none d-sm-table-cell border text-center p-1">
													<a id="deleteday" href="index.php?page=gestionsites&deleteday&idjournee=<?= $journee->getId(); ?>">
													<img src="public/images/icones/drop.png" alt="supprimer journée" title="supprimer" width="20px">
													</a>
												</td>
											</tr>
									<?php } endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</form>
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
		
		<!-- PANNEAU 4 - RESIDENCES - -->
			<div class="tab-pane fade <?php if($onglet==4){ echo "active show";} ?> mt-2" id="listeresidences">
				<form  method="post" action="index.php?page=gestionsite" class="container">
					<div class="row">
						<div class="col-md-4 border p-2">
							<!-- liste UP -->
							<div class="input-group">
								<div class="input-group-prepend mb-2"><span class="input-group-text">UP</span></div>
			                    <select id="selectionup" class="form-control" name="noup">
			                        <option value="2">UP Paris Est</option> 
			                    </select>
							</div>

							<div class="pt-3">
								<input id="newresidence" class="form-control" type="text" name="newresidence" placeholder="ajout d'une residence" required>
								<input type="submit" class="btn btn-secondary py-1 mt-2 float-right" value="Ajouter">
							</div>
						</div>

						<div class="col-md-8 border p-2">
							<table class="table table-collapse table-hover">
								<thead class="thead-light" >
									<tr>
										<th id="enteteid" class="d-none d-sm-table-cell border text-center p-1">id</th>
										<th id="entetejournee" class=" border text-center p-1">Journee</th>
										<th class="d-none d-sm-table-cell border text-center p-1"></th>
									</tr>
								</thead>

								<tbody>
									<?php
										foreach ($residences as $residence):
											//surbrilance ligne
											if($residence->getId()==$idresidence) { $surbrillance = "class=bg-warning";}
											else { $surbrillance=''; }
											//affichage des résidences de l'up choisi
											if($residence->getIdup() == $idup) {
											?>
											<tr <?= $surbrillance ?> >
												<td class="idresidence d-none d-sm-table-cell border text-center p-1"><?= $residence->getId(); ?></td>
												<td class="nameresidence border text-center p-1"><?= $residence->getNomresidence(); ?></td>
												<td class="d-none d-sm-table-cell border text-center p-1">
													<a id="deleteresidence" href="index.php?page=gestionsite&deleteresidence&idresidence=<?= $residence->getId(); ?>">
													<img src="public/images/icones/drop.png" alt="supprimer journée" title="supprimer" width="20px">
													</a>
												</td>
											</tr>
									<?php } endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</form>
			</div>
	
		<!-- PANNEAU 5 - UP - -->
			<div class="tab-pane fade <?php if($onglet==5){ echo "active show";} ?> mt-2" id="listeup">
				<form  method="post" action="index.php?page=gestionsite" class="container">
					<div class="row">
						<div class="col-md-4 border p-2">
							<div class="pt-3">
								<input id="newup" class="form-control" type="text" name="newup" placeholder="ajout up" required>
								<input type="submit" class="btn btn-secondary py-1 mt-2 float-right" value="Ajouter">
							</div>
						</div>

						<div class="col-md-8 border p-2">
							<table class="table table-collapse table-hover">
								<thead class="thead-light" >
									<tr>
										<th id="enteteid" class="d-none d-sm-table-cell border text-center p-1">id</th>
										<th id="enteteup" class=" border text-center p-1">UP</th>
										<th class="d-none d-sm-table-cell border text-center p-1"></th>
									</tr>
								</thead>

								<tbody>
									<?php
										foreach ($ups as $up):
											//surbrilance ligne
											if($up->getId()==$idup) { $surbrillance = "class=bg-warning";}
											else { $surbrillance=''; }
											?>
											<tr <?= $surbrillance ?> >
												<td class="idup d-none d-sm-table-cell border text-center p-1"><?= $up->getId(); ?></td>
												<td class="nameup border text-center p-1"><?= $up->getNomup(); ?></td>
												<td class="d-none d-sm-table-cell border text-center p-1">
													<a id="deleteup" href="index.php?page=gestionsite&deleteup&idup=<?= $up->getId(); ?>">
													<img src="public/images/icones/drop.png" alt="supprimer journée" title="supprimer" width="20px">
													</a>
												</td>
											</tr>
									<?php  endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</form>
			</div>
	</div>
</div>

<?php 

/** FENETRES MODALES */
	//ajout d'une journée
	require('view/modals/modal_ajout_journee.php');

$main = ob_get_clean();

$titre = "trocADC -Gestion du site";
	require('view/public/template_main.php');
?>