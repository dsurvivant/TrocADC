<!DOCTYPE html>

<?php 
	ini_set('default_charset', 'utf-8');
	
	if (isset($_SESSION['nom'])) {$nom = $_SESSION['nom'];}
	else {$nom='menu';}

	if (isset($_SESSION['prenom'])) {$prenom = $_SESSION['prenom'];}
	else {$prenom='';}
?>

<html lang="fr">
<head>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
	<meta author="jmt">
	<meta name="description" content="Echange de journées de travail entre ADC">
	<meta name="robots" content="nofollow">

	<title><?= $titrepage ?></title>

	<link rel="stylesheet" type="text/css" href="public/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="public/css/date.css">
	<link rel="stylesheet" type="text/css" href="public/css/style.css">
	<link rel="stylesheet" type="text/css" href="public/css/admin.css">
	<!--<script src="https://kit.fontawesome.com/3f13d5366e.js" crossorigin="anonymous"></script>-->

</head>

<body>

	<div class="container-fluid">
		<nav class="row navbar navbar-dark bg-dark">

			<a href="index.php" class="navbar-brand">TrocADC</a>

			<ul class="navbar-nav">
	          <li class="nav-item dropdown">
	            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button"><?= $nom . " " . $prenom; ?></a>
	            <div class="dropdown-menu">
	            	<?php

	            		array_push($_SESSION['menu'], 'A propos...');

	            		foreach ($_SESSION['menu'] as $value) 
	            		{
	            			if($value == "A propos...")
	            			{
	            				?>
	            				<?php if(isset($_SESSION['droits'])):
	            						if($_SESSION['droits']==1):?>
	            							<a class="dropdown-item" href="index.php?page=gestionsite">Gestion du site</a>
	            				<?php
	            					  endif; 
	            						endif; ?>
	            				<span id="apropos" class="dropdown-item" data-toggle="modal" data-target="#modalAPropos">A propos...</span> 
	            				<?php
	            			}
	            			else 
	            			{
	            				?> <a class="dropdown-item" href="index.php?page=<?= strtolower(skip_accents($value)) ?>"><?=  $value ?></a> <?php
	            			}
	            		}
	            	?>
	            </div>
	          </li>
	        </ul>

		</nav>

		<section id="cadrePrincipal" class="row pt-2">
				<?= $main; ?>
		</section>
	</div>

<!-- *************** MODAL *********************-->
	 <?php require('view/modals/modal_a_propos.php'); ?>

	<!-- inclusion des libraries jQuery et jQuery UI (fichier principal et plugins) -->
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
	<script src="public/js/jquery/jquery-3.5.1.min.js"></script>
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>-->
	<script src="public/js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<!-- mes scripts -->
	<script src="public/js/fonctions.js"></script>
	<script src="public/js/calendar.js"></script>
	<script src="public/js/view_parametres.js"></script>
	<script src="public/js/propositions.js"></script>
	<script type="text/javascript" src="public/js/form_agent.js"></script>
	<script type="text/javascript" src="public/js/view_gestionsite.js"></script>

	<script type="text/javascript" src="public/js/bootstrap/bootstrap.min.js"></script>
</body>
</html>