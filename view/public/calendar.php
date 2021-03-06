<?php 
/**
 * ENTREE:
 * 
 * 	- $listepropositions : objets Propositions du jour et de l'up de l'agent
 * 	- $tabpropositions : multidimensionnel
 * 			[i][0] => Objet Proposotion du jour et de l'up au rang i
 * 			[i][1] => Objet Journee correspondant à la proposition
 * 			[i][2] => Objet Agent correspondant à la proposition
 * 	- $tabDernieresPropositions : idem que tableau $tabpropositions mais contient uniquement les dix dernières propositions de l'up
 * 	- $tabroulementsderecherche : contient la liste des roulements de recherche choisit par l'agent connecté => example (171,172,173)
 * 	- $tabroulements: Tableau des roulements=>[i]['id']=id du roulement [i]['libelle']=libelle rlt
 * 
*/
if (isset($_SESSION['nocp']))
{
	if(isset($_SESSION['idup'])) { $idup=$_SESSION['idup'];}
		else{$idup='';}

	//choix de la date affichée au calendrier
	if (isset($_GET['choixdate'])) //ex: 15 aout 2021
		{ 
			$choixdate = $_GET['choixdate']; 
			$year =date('Y', $choixdate); //ex: 2021
			$currentmonth = date('n', $choixdate); // ex: 8
			$currentday = date('j', $choixdate); // ex: 15
			$datedujour = date('j M Y', $choixdate); // ex: 15 Aug 2021
		}
	else 
		{ 
			if (isset($_GET['year']))
			{
				$year = $_GET['year'];
				$currentmonth = 1;
				$currentday  = 1;
				$datedujour = "1 Jan " . $year;
			}
			else
			{
				$year = date('Y');
				$currentmonth = date('n');
				$currentday  = date('j');
				$datedujour = date('j M Y');
			}
			
		}
	
	$date = new Date();
	$dates = $date->getAll($year);
	?>

	<div class="border border-secondary p-2">
		<div class="periods">
				<div class="text-center">
					<?php if($year>2021) 
					{?>
						<a id="previousyear"  class="h3" href="index.php?page=calendrier&year=<?php echo $year - 1; ?>"> <</a>
					 <?php
					}
					else { $year = 2021;}
					?>
					
					<span class="year text-center h3" style="color:#e91903"><?= $year ?></span>
					<a id="nextyear"  class="h3" href="index.php?page=calendrier&year=<?php echo $year + 1; ?>">> </a>
					<img class="monthsupdown" src="public/images/icones/moins-16px.png" title="replier" alt="repliage calendrier">
				</div>
				<div class="months mb">
					<div class="text-justify">
						<?php foreach ($date->months as $id=>$value) 
						{
							//Le mois de la date choisie sera en surbrillance
							if ($id+1 == $currentmonth):?>
								<span><a class="linkmonth active" href="#" id="linkmonth<?= $id+1 ?>"><?= utf8_encode(substr(utf8_decode($value),0,3)) ?></a></span>
							<?php else: ?>
								<span><a class="linkmonth" href="#" id="linkmonth<?= $id+1 ?>"><?= utf8_encode(substr(utf8_decode($value),0,3)) ?></a></span>
							<?php
							endif;
						} ?>
					</div>
				</div>

				<!--<button class="btn btn-primary rounded-circle font-weight-bold"	>+</button>-->
		</div>

		<!-- Tableau du mois -->
		<?php 
		foreach ($dates as $m => $days) 
		{?>
			<div class="month container-fluid <?php if($m!=$currentmonth){ echo "hidemonth";} ?>" id="month<?= $m ?>">
				<div class="row">
					<?php foreach ($date->days as $d): ?>
						<div class="head col border p-1 text-center"><?= substr($d,0,2) ?></div>				
					<?php endforeach; ?>
				</div>


				<div class="row">
					<?php $end = end ($days); 
						foreach ($days as $d => $w): ?>
													
							<?php $time = strtotime("$year-$m-$d"); ?>

							<?php if ($d==1 and $w!=1):
									$i=0;
									$y=$w-1;
									while ($i<$y) {
										$i++;
										?><div class="col border p-0"></div><?php
									}
									 
								 endif;

							$dateducalendrier = date('j M Y', $time);
							if($datedujour == $dateducalendrier) {$surligne ="today"; }
							else {$surligne ='';} ?>

							<a href="index.php?page=calendrier&choixdate=<?= $time ?>" class="day col p-0 border text-center <?= $surligne ?>" id="<?= $time ?>">
								<?php echo $d . "<br>"; 
								
								//VIGNETTE NOMBRE DE PROPOSITIONS
									//liste des propositions de l'up classés par date asc
									$manager = new PropositionsManager($bdd);//$propositions = $manager->getListPropositionsByDate();
									$up = new Up(['id'=>$idup]);
									$resultats = $manager->getListPropositionsByDateAndUp($up);
									

									$i=0;
									foreach ($resultats as $resultat) 
									{
										//		
										if($resultat['dateproposition'] == date('Y-m-d', $time))
										{ 
											$idroulement = $resultat['idroulement'];

											//que les roulements de recherche
											if(in_array($idroulement, $tabroulementsderecherche)) 
											{//compteur vignette
											$i++;}
										}
									}
									if($i!=0) { echo "<span class='badge badge-danger'>" . $i . "</span>"; }
									else {echo '<br>';}?>
							</a>
															
										
							<?php if ($w==7):?>
				</div>

				<div class="row">
					
					<?php endif; ?>
							<?php endforeach; ?>
							<?php if ($end!=7):
									$i=0;
									$y=7-$end;
									while ( $i < $y) 
									{
										$i++
										?><div class="col border p-0"></div><?php
									}
								endif; ?>
				</div>
			</div>
		<?php
		}?>
	</div><?php
}
?>
