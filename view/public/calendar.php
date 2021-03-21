<?php 
if (isset($_SESSION['nocp']))
{
	//choix de la date affichée au calendrier
	if (isset($_GET['choixdate'])) 
		{ 
			$choixdate = $_GET['choixdate']; 
			$year =date('Y', $choixdate);
			$currentmonth = date('n', $choixdate); 
			$currentday = date('j', $choixdate);
			$datedujour = date('j M Y', $choixdate);
		}
	else 
		{ 
			$year = date('Y');
			$currentmonth = date('n');
			$currentday  = date('j');
			$datedujour = date('j M Y');
		}
	
	$date = new Date();
	$dates = $date->getAll($year);
	?>


	<div class="periods">
			<div class="text-center">
				<span class="year text-center h3" style="color:#e91903"><?= $year ?></span>
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
							//récupération du nb de propositions du jour
							$propositions = ListePropositions();
							$i=0;
							foreach ($propositions as $proposition) 
							{
								if($proposition->getDateproposition() == date('Y-m-d', $time)){ $i++;}
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
	}
}
?>
