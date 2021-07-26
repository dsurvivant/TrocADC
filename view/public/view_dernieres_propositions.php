<?php
	/**
	 * creer par jmt mars 2021
	 *
	 * ENTREE
	 *  - $tabDernieresPropositions : contient les 10 dernieres propositions, à chaque ligne du tableau, 
	 * 		on a les clés dateproposition, commentaires, nomjournee, heureps, heurefs, lieups, lieufs, nom, prenom, telephone, email, displayname, displaymail
	 * 
	 * 	- - $tabroulements: Tableau des roulements=>[i]['id']=id du roulement [i]['libelle']=libelle rlt
	 */
	
$datedujour = new DateTime("now");

?>
<div class="container-fluid border border-secondary m-1">
	<h4 class="col text-danger text-center">10 Dernières propositions</h4>
	
	<div class="row head">
		<div class="col p-0 border text-center">Date</div>
		<div class="col p-0 border text-center">Jnée</div>
		<div class="col p-0 border text-center">Rlt</div>
		<div class="col p-0 border text-center">PS</div>
		<div class="col p-0 border text-center">FS</div>
	</div>

	<?php
	
	foreach ($tabDernieresPropositions as $value) 
	{
		$dateproposition = new DateTime($value['dateproposition']);
		$heureps = new DateTime($value['heureps']);
		$heurefs = new DateTime($value['heurefs']);

		$idroulement = $value['idroulement'];
		//libellé du roulement
		foreach ($tabroulements as $val) 
		{
			if($val['id']==$idroulement) {$libelle = $val['libelle'];}
		}
		?>
		<div class="row proposition" >
			<div class="col p-0  border text-center"><?= $dateproposition->format('d-m-Y') ?></div>
			<div class="col p-0  border text-center"><?= $value['nomjournee']; ?></div>
			<div class="col p-0  border text-center"><?= $libelle; ?></div>
			<div class="col p-0  border text-center"><?= $heureps->format('H:i') . " " . $value['lieups']; ?></div>
			<div class="col p-0  border text-center"><?= $heurefs->format('H:i') . " " . $value['lieufs']; ?> <img class="float-right m-1" src="public/images/icones/loupe1.png" alt="loupe" width="16px"></div>
		</div>

		<div class="row detailProposition">
			<div class="m-1 p-2 border bg-info">
				<!-- Coordonnees de l'agent -->
				<p>
					<?php 
						if($value['displayname'] == 1) { echo $value['nom'] . " " . $value['prenom'] . "<br>"; }
						echo $value['telephone'] . "<br>";
						if($value['displaymail'] == 1) { echo $value['email'] . "<br>"; }

						//findId($id);
					?>	
				</p>
			</div>

			<div class="m-1 p-2 border bg-danger">
				<span><?= $value['commentaires'] ?></span>
			</div>
		</div>			
	<?php	
	}
	?>			
</div>