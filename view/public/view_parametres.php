<?php 
if (isset($_SESSION['nocp']))
{		
	$nom = $_SESSION['nom'];
	$prenom = $_SESSION['prenom'];
	$nocp = $_SESSION['nocp'];
	$telephone = $_SESSION['telephone'];
	$email = $_SESSION['email'];
	$droits = $_SESSION['droits'];
	$password = $_SESSION['password'];
	$dateinscription = $_SESSION['dateinscription'];
	$idroulement = $_SESSION['idroulement'];
	if($_SESSION['displayname']==1){$displayname="checked";}
	else {$displayname='';}
	if($_SESSION['displaymail']==1){$displaymail="checked";}
	else {$displaymail='';}
	/**$residence = $_SESSION['idresidence'];**/

	ob_start();
	//***********************************************************************
?>
<div id="containerParametres" class="container">
		
	<section class="row mt-3 text-center">
		<span class="col p-3 border border-rounded border-secondary text-secondary h4 shadow"><?= $nom . " " . $prenom ?></span>
	</section>

	<!-- bloc de messages -->
	<div class="row">
		<div class="col-12 text-danger text-center p-1"><?= $_SESSION['message']; ?></div>
	</div>
		
	<div class="row align-items-start">
		<!------------------------>
		<!--	CADRE MES INFOS -->
		<!------------------------>
					
			<section  class = "col-sm-6 border border-secondary p-0 m-1">
				<div class="card-header text-center bg-secondary text-white">Mes infos</div>

				<div class="card-body">
					<form id="formMesInfos" method="post" action="index.php?page=parametres">
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text text-secondary bg-white">No CP</span></div>
							<input type="text" class="form-control" id="nocp" name="nocp" readonly value="<?= $nocp ?>" >
						</div>
						<br>

						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text text-secondary bg-white">Tel</span></div>
							<input type="text" class="form-control" maxlength="14" id="telephone" name="telephone" value="<?= $telephone ?>" >
							<span class="col-12 help text-danger text-center"></span>
						</div>
						<br>

						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text text-secondary bg-white">Email</span></div>
							<input type="mail" class="form-control" id="email" name="email"  value="<?= $email ?>" >
							<span class="col-12 help text-danger text-center"></span>
						</div>
							<br>

						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text text-secondary bg-white">Roulement</span></div>
							<input type="text" class="form-control" maxlength="5" id="roulement" name="idroulement" value="171" readonly >
						</div>
						<br>

						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text text-secondary bg-white">Résidence</span></div>
							<input type="text" class="form-control" maxlength="30" id="residence" name="residence" value="Paris Est" readonly>
						</div>
						<br>

						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text text-secondary bg-white">Inscrit depuis</span></div>
							<input type="text" class="form-control" id="dateinscription" name="dateinscription" readonly value="<?= date('j-m-Y', $dateinscription); ?>" >
						</div>
					</form>
				</div>

				<div class="card-footer text-right">
					<button type="submit" form="formMesInfos" id="btnSaveInfos" class="btn btn-secondary btn-sm btn-block bg-secondary text-white">Sauvegarder</button>
				</div>
			</section>
				
		<!--------------------------->
		<!--	CADRE MOT DE PASSE -->
		<!--------------------------->
					
			<section class = "col-sm border border-secondary p-0 m-1">
				<div class="card-header text-center bg-secondary text-white">Mot de passe</div>
				<div class="card-body">
					<form id="formModifPassword" method="post" action="index.php?page=parametres">
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text text-secondary bg-white">MDP Actuel</span></div>
							<input type="password" class="form-control" id="password" name="password" >
						</div>
						<br>

						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text text-insecondaryfo bg-white">Nouveau MDP</span></div>
							<input type="password" class="form-control" id="newpassword" name="newpassword">
						</div>
						<br>

						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text text-secondary bg-white">Confirmer MDP</span></div>
							<input type="password" class="form-control" id="confirmpassword" name="confirmpassword">
						</div>
					</form>
					<br>
					<p id="errormdp" class="text-center" style="display: none;color:white;background-color: red;border-radius: 5px;"></p>
				</div>

				<div class="card-footer text-right">
					<button  type="submit" form="formModifPassword" id="btnModifPassword" class="btn btn-secondary btn-sm btn-block bg-secondary text-white">Modifier Mot de passe</button>
				</div>
			</section>
	</div>


	<div class="row">
		<section  class = "col-12 border border-secondary p-2 m-1">
				<div class="card-header text-center bg-secondary text-white mb-3">Filtres</div>

				<div class="card-body">
					 <form id="formfiltres" method="post">
					    <div class="form-check">
					    	<input form="formfiltres" id="inputname" name="inputname" class="form-check-input" type="checkbox" value="on" <?= $displayname ?>>
					    	<label class="form-check-label" for="inputname">Nom et Prénom visible</label>
					    </div>

					    <div class="form-check">
					    	<input form="formfiltres" id="inputmail" name="inputmail" class="form-check-input" type="checkbox" value="on" <?= $displaymail ?>>
					    	<label class="form-check-label" for="inputmail">Email visible</label>
					    </div>
				    </form>
				</div>
		</section>
	</div>
</div>

	<?php
	//************************************************************************
	$main = ob_get_clean(); 


	$titre = "trocADC - Paramètres";
	require('view/public/template_main.php');
}
	?>