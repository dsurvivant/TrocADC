<?php 
if (isset($_SESSION['nocp']))
{?>
	<div class="periods">
			<h3 class="year col-lg-12"><?= $year ?></h3>

			<div class="months mb-2">
				<div class="text-justify">
					<?php foreach ($date->months as $id=>$value) {?>
					<span><a class="linkmonth" href="#" id="linkmonth<?= $id+1 ?>"><?= utf8_encode(substr(utf8_decode($value),0,3)) ?></a></span>
					<?php } ?>
				</div>
			</div>

			<!--<button class="btn btn-primary rounded-circle font-weight-bold"	>+</button>-->
	</div>

	<!-- Tableau du mois -->
	<?php 
	foreach ($dates as $m => $days) 
	{?>
		<div class="month" id="month<?= $m ?>">
			<table class="table table-bordered">
				<thead class="thead-light">
					<tr>
					<?php foreach ($date->days as $d): ?>
					<th><?= substr($d,0,3) ?></th>
					<?php endforeach; ?>
					</tr>
				</thead>

				<tbody>
					<tr>
					<?php $end = end ($days); 
					foreach ($days as $d => $w): ?>
												
						<?php $time = strtotime("$year-$m-$d"); ?>

						<?php if ($d==1 and $w!=1):?> 
									<td colspan="<?= $w-1; ?>"></td> 
						<?php endif;?>
		
						<td id="<?= date('j M Y', $time); ?>">
							<div class=""><?= $d; ?></div>

								<!-- hjkhkjhkhkjh -->
						</td>
														
									
						<?php if ($w==7):?>
					</tr>

					<tr>

							<?php endif; ?>
					<?php endforeach; ?>
						<?php if ($end!=7):?> <td colspan="<?= 7-$end; ?>"></td><?php endif; ?>
					</tr>
				</tbody>
			</table>
		</div>
	<?php
	}
}
?>
