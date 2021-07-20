<?php 
/**
 * PARAMETRES D ENTREES:
 * 		- $agents: liste des objets Agents
 * 		- $ups: liste des objets Up
 * 		- $residences: liste des objets Residences
 * 		- $roulements: liste des objets Roulements
 * 		- $tabroulementsderecherche: tableau qui contient les roulements de recherche
 */

if (isset($_SESSION['nocp']))
{		
	$nom = $_SESSION['nom'];
	$prenom = $_SESSION['prenom'];
	$nocp = $_SESSION['nocp'];
	$telephone = $_SESSION['telephone'];
	$email = $_SESSION['email'];
	$droits = $_SESSION['droits'];
	//$password = $_SESSION['password'];
	$dateinscription = $_SESSION['dateinscription'];
	$idup = $_SESSION['idup'];
	$idresidence = $_SESSION['idresidence'];
	$idroulement = $_SESSION['idroulement'];
	if($_SESSION['displayname']==1){$displayname="checked";}
	else {$displayname='';}
	if($_SESSION['displaymail']==1){$displaymail="checked";}
	else {$displaymail='';}
	/**$residence = $_SESSION['idresidence'];**/

	$mois = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
	ob_start();
	//***********************************************************************

?>

<div id="containerParametres" class="container">
		
	<section class="row mt-3 text-center">
		<div class="col p-3 border border-rounded border-secondary text-secondary shadow">
			<span class="h4" ><?= $nom . " " . $prenom ?></span>
			<br>
			<span>Inscrit depuis le <?= date('j', $dateinscription) . " " . $mois[date('n', $dateinscription)-1] . " " . date('Y', $dateinscription); ?></span>
		</div>
	</section>

	<!-- bloc de messages -->
	<div class="row">
		<div class="col-12 text-danger text-center p-1"><?= $_SESSION['message']; ?></div>
	</div>
		
	<div class="row align-items-start">
		<!------------------------>
		<!--	CADRE MES INFOS -->
		<!------------------------>
					
			<section  class = "col-sm-6 border border-secondary p-0 m-1">
				<div class="card-header text-center bg-secondary text-white">Mes infos</div>

				<div class="card-body">
					<form id="formMesInfos" method="post" action="index.php?page=parametres">
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text text-secondary">No CP</span></div>
							<input type="text" class="form-control" id="nocp" name="nocp" readonly value="<?= $nocp ?>" >
						</div>
						<br>

						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text text-secondary">Tel</span></div>
							<input type="text" class="form-control" maxlength="14" id="telephone" name="telephone" value="<?= $telephone ?>" >
							<span class="col-12 help text-danger text-center"></span>
						</div>
						<br>

						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text text-secondary">Email</span></div>
							<input type="mail" class="form-control" id="email" name="email"  value="<?= $email ?>" >
							<span class="col-12 help text-danger text-center"></span>
						</div>
							<br>

						<!-- liste UP -->
							<div class="input-group">
								<div class="input-group-prepend mb-2"><span class="input-group-text">UP</span></div>
			                    <select id="selectionup" class="form-control" name="noup">
			                        <?php foreach ($ups as $up):
					                    if($up->getId()==$idup){$selected="selected";}
					                    else {$selected='';}
					                    ?>
			                        	<option value="<?= $up->getId(); ?>" <?= $selected ?>> <?= $up->getnomup(); ?> </option>
			                        <?php endforeach; ?> 
			                    </select>
							</div>
							<br>

						<!-- liste résidence -->
							<div id="ajaxresidence" class="input-group">
								<div class="input-group-prepend mb-2"><span class="input-group-text">Résidence</span></div>
			                    <select id="selectionresidence" class="form-control" name="noresidence">
			                       <?php foreach ($residences as $residence):
			                       		if($residence->getIdup()==$idup): //uniquement les résidences de l'up
						                    if($residence->getId()==$idresidence){$selected="selected";}
						                    else {$selected='';}
						                    ?>
				                       		<option value="<?= $residence->getId() ?>" <?= $selected ?> > <?= $residence->getNomresidence() ?> </option>
				                       	<?php endif; endforeach; ?>
			                    </select>
							</div>
							<br>

						<!-- liste roulement -->
							<div id="ajaxroulement" class="input-group">
								<div class="input-group-prepend mb-2"><span class="input-group-text">Roulement</span></div>
			                    <select id="selectionroulement" class="form-control" name="noroulement">
			                        <?php foreach ($roulements as $roulement):
						                if($roulement->getIdresidence()==$idresidence): //uniquement les roulements de la résidence
						                    if($roulement->getId()==$idroulement){$selected="selected";}
						                    else {$selected='';}
						                    ?>
					                    <option value="<?= $roulement->getId(); ?>" <?= $selected ?> ><?= $roulement->getNoroulement(); ?></option> 
					                <?php endif; endforeach; ?>
			                    </select>
							</div>
							<br>

					</form>
				</div>

				<div class="card-footer text-right">
					<button type="submit" form="formMesInfos" id="btnSaveInfos" class="btn btn-secondary btn-sm btn-block bg-secondary text-white">Sauvegarder</button>
				</div>
			</section>
				
		<!--------------------------->
		<!--	CADRE MOT DE PASSE -->
		<!--------------------------->
					
			<section class = "col-sm border border-secondary p-0 m-1">
				<div class="card-header text-center bg-secondary text-white">Mot de passe</div>
				<div class="card-body">
					<form id="formModifPassword" method="post" action="index.php?page=parametres">
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text text-secondary">MDP Actuel</span></div>
							<input type="password" class="form-control" id="password" name="password" >
						</div>
						<br>

						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text text-secondary ">Nouveau MDP</span></div>
							<input type="password" class="form-control" id="newpassword" name="newpassword">
						</div>
						<br>

						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text text-secondary">Confirmer MDP</span></div>
							<input type="password" class="form-control" id="confirmpassword" name="confirmpassword">
						</div>
					</form>
					<br>
					<p id="errormdp" class="text-center" style="display: none;color:white;background-color: red;border-radius: 5px;"></p>
				</div>

				<div class="card-footer text-right">
					<button  type="submit" form="formModifPassword" id="btnModifPassword" class="btn btn-secondary btn-sm btn-block bg-secondary text-white">Modifier Mot de passe</button>
				</div>
			</section>
	</div>

	<!--------------------------->
	<!--	FILTRES			   -->
	<!--------------------------->
	<div class="row">
		<section  class = "col-12 border border-secondary p-2 m-1">
				<div class="card-header text-center bg-secondary text-white mb-3">Filtres</div>

				<div class="card-body border">
					 <div class="container-fluid">
					 	<div class="row justify-content-around">
							<div class="col-12 col-md-5 border p-0 mt-1">
								<div class="h4 bg-secondary text-white text-center pb-1">Divers</div>

								<form id="formfiltres" method="post" class="p-1">
								    <div class="form-check ">
								    	<input form="formfiltres" id="inputname" name="inputname" class="form-check-input" type="checkbox" value="on" <?= $displayname ?>>
								    	<label class="form-check-label" for="inputname">Nom et Prénom visible</label>
								    </div>

								    <div class="form-check">
								    	<input form="formfiltres" id="inputmail" name="inputmail" class="form-check-input" type="checkbox" value="on" <?= $displaymail ?>>
								    	<label class="form-check-label" for="inputmail">Email visible</label>
								    </div>
							    </form>


							    <div class="lead px-1 mt-3">Eléments que je souhaite laisser visibles aux autres</div>
							</div>

						    <div class="col-12 col-md-6 border p-0 mt-1">
						    	<div class="h4 bg-secondary text-white text-center pb-1">Roulements souhaités </div>

							    <form id="formfiltresRoulements" method="post" class="p-1">
								    <?php
								    	?><div class="container"><div class="row justify-content-around"><?php
									    	foreach ($residences as $residence)
									    	{
									    		if ($residence->getIdup()==$idup)
									    		{
										    		?><div class="border col col-md-3 p-0 ml-1 mt-2"><?php
										    			//affiche la résidence
										    			echo "<p class='text-center border-bottom bg-dark text-white'>" . $residence->getNomresidence() . "</p>";

											    		?><div class="text-center"><?php
											    			foreach($roulements as $roulement)
											    			{
											    				if ($roulement->getIdresidence()==$residence->getId())
											    				{
											    					$idroulement = $roulement->getId();
											    					//recherche si le roulement est un roulement de recherche par défaut
											    					if(in_array($idroulement, $tabroulementsderecherche)) {$recherche="checked";}
											    					else {$recherche="";}

											    					?>
											    						<div class="form-check">
																	    	<input form="formfiltresRoulements" name="<?= $idroulement; ?>" class="inputroulement form-check-input" type="checkbox" <?= $recherche ?>>
																	    	<!-- affiche le roulement -->
																	    	<label class="form-check-label"><?= $roulement->getNoroulement(); ?></label>
																	    </div>
											    					<?php
											    					//echo $roulement->getNoroulement() . "<br>";
											    				}
											    			}
										    		?></div></div><?php
									    		}
									    	}
									    ?></div></div><?php
								    ?>
							    </form>

							    <div class="lead px-1 mt-3">Seuls les propositions des roulements sélectionnés apparaitront</div>
							</div>
						</div>
					</div>
				</div>

		</section>
	</div>
</div>

	<?php
	$main = ob_get_clean(); 


	$titre = "trocADC - Paramètres";
	require('view/public/template_main.php');
}

?>