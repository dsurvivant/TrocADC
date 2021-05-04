<?php
/**
 * CREER PAR JMT MAI 2021
 *
 * fichier ajax qui permet de trouver les résidences en fonction de l'idup
 *
 * Retourne le select html avec les résidences
 */
require("../../../classes/Residence.class.php");
require("../../../classes/ResidenceManager.class.php");

try{
		$bdd = new PDO('mysql:host=localhost;dbname=trocadc','root','',array(PDO::MYSQL_ATTR_INIT_COMMAND=> 'SET NAMES UTF8'));	
		/**
		$host='hallidz62.mysql.db';
		$db='hallidz62';
		$user='hallidz62';
		$pw='Ayddacnathof5';
		$bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pw, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));**/
	}
	catch(PDOException $e)
	{
		echo 'Base de donnees en vacances';
		exit();
	}
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
		<select id="selectionresidenceinscription" class="form-control" name="noresidence">
            <?php foreach ($residences as $residence): ?>
                <option value="<?= $residence->getId() ?>" > <?= $residence->getNomresidence() ?> </option>
            <?php endforeach; ?>
        </select>
