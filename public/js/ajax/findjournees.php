<?php
/**
 * CREER PAR JMT MAI 2021
 *
 * fichier ajax qui permet de trouver les résidences en fonction de l'idup
 *
 * Retourne le select html avec les résidences
 */
require("../../../classes/Journee.class.php");
require("../../../classes/JourneesManager.class.php");

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
if (isset($_POST['idroulement'])) {$idroulement = $_POST['idroulement'];}
else { $idroulement ='';}

//liste des journees correspondant au roulement
	$journee = new Journee(['idroulement'=>$idroulement]);
	$manager = new JourneesManager($bdd);
	$journees = $manager->getListJourneessWithRoulement($journee);

//
	?>
		<div class="input-group-prepend mb-2"><span class="input-group-text">Journées</span></div>
		<select id="selectionjournee" class="form-control" name="idjournee">
            <?php foreach ($journees as $journee): 
            	$heureps = new DateTime($journee->getHeureps());
                $heurefs = new DateTime($journee->getHeurefs());
            	?>
                <option value="<?= $journee->getId(); ?>"><?= $journee->getNomjournee() . " " . $heureps->format('H\hi') . " " . $journee->getLieups() . " - " . $heurefs->format('H\hi') . " " . $journee->getLieufs(); ?></option>
            <?php endforeach; ?>
        </select>