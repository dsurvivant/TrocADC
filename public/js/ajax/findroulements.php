<?php
/**
 * CREER PAR JMT MAI 2021
 *
 * fichier ajax qui permet de trouver les roulements en fonctins de l'id résidence
 *
 * Retourne le select format html contenant les roulements
 */
require("../../../model/config.php");
require("../../../classes/Roulement.class.php");
require("../../../classes/RoulementsManager.class.php");

if (isset($_POST['idresidence'])) {$idresidence = $_POST['idresidence'];}
else { $idresidence ='';}

//liste des résidences correspondant à l'up
	$roulement = new Roulement(['idresidence'=>$idresidence]);
	$manager = new RoulementsManager($bdd);
	$roulements = $manager->getListRoulementWithResidence($roulement);

//
	?>
		<div class="input-group-prepend mb-2"><span class="input-group-text">Roulement</span></div>
        <select id="selectionroulement" class="form-control" name="noroulement">
        	<?php foreach ($roulements as $roulement):?>
            	<option value="<?= $roulement->getId(); ?>" ><?= $roulement->getNoroulement(); ?></option> 
            <?php endforeach; ?>
        </select>
