<?php
/**
 * CREER PAR JMT MAI 2021
 *
 * fichier ajax qui permet de trouver les résidences en fonction de l'idup
 *
 * Retourne le select html avec les résidences
 */
require("../../../model/config.php");
require("../../../classes/Residence.class.php");
require("../../../classes/ResidenceManager.class.php");

//
if (isset($_POST['idup'])) {$idup = $_POST['idup'];}
else { $idup ='';}

//liste des résidences correspondant à l'up
	$residence = new Residence(['idup'=>$idup]);
	$manager = new ResidenceManager($bdd);
	$residences = $manager->getListResidencesWithUp($residence);

//
	?>
		<div class="input-group-prepend mb-2"><span class="input-group-text">Résidence</span></div>
		<select id="selectionresidence" class="form-control" name="noresidence">
            <?php foreach ($residences as $residence): ?>
                <option value="<?= $residence->getId() ?>" > <?= $residence->getNomresidence() ?> </option>
            <?php endforeach; ?>
        </select>
