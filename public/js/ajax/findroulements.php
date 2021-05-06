<?php
/**
 * CREER PAR JMT MAI 2021
 *
 * fichier ajax qui permet de trouver les roulements en fonctins de l'id résidence
 *
 * Retourne le select html contenant les roulements
 */
require("../../../classes/Roulement.class.php");
require("../../../classes/RoulementsManager.class.php");

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
