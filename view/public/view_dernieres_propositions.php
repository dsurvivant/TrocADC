<?php
	/**
	 * creer par jmt mars 2021
	 *
	 * ENTREE
	 *  $tabDernieresPropositions : contient les 10 dernieres propositions, à chaque ligne du tableau, 
	 * 		on a les clés dateproposition, commentaires, nomjournee, heureps, heurefs, lieups, lieufs, nom, prenom, telephone, email, displayname, displaymail
	 */
	
$datedujour = new DateTime("now");
?>
<div class="container-fluid border border-secondary m-1">
	<h4 class="col text-danger text-center">Dernières propositions</h4>
	
	<div class="row head">
		<div class="col p-0 border text-center">Date</div>
		<div class="col p-0 border text-center">Jnée</div>
		<div class="col p-0 border text-center">PS</div>
		<div class="col p-0 border text-center">LIEU</div>
		<div class="col p-0 border text-center">FS</div>
		<div class="col p-0 border text-center">LIEU</div>
	</div>

	<?php
	
	foreach ($tabDernieresPropositions as $value) 
	{?>
		<div class="row proposition" >
			<div class="col p-0  border text-center"><?= $value['dateproposition'] ?></div>
			<div class="col p-0  border text-center"><?= $value['nomjournee']; ?></div>
			<div class="col p-0  border text-center"><?= $value['heureps']; ?></div>
			<div class="col p-0  border text-center"><?= $value['lieups']; ?></div>
			<div class="col p-0  border text-center"><?= $value['heurefs']; ?></div>
			<div class="col p-0  border text-center"><?= $value['lieufs']; ?> <img class="float-right m-1" src="public/images/icones/loupe1.png" alt="loupe" width="16px"></div>
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