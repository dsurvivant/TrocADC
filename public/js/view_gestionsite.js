/**
 *	- AJOUTER JOURNNEE
 *  - Supprimer journee
 *  - Supprimer un roulement
 *  - Supprimer une rédidence
 *  - Supprimer une UP
 *  - double click sur ligne agent ==> fiche agent
 *  - Gestion des select
 *  - click sur entetes: journee, id
 */
$(function()
{
	/***
	/** Ajouts/suppressions
	/***	**/
		$('#formajouterjournee #annulerajoutjournee').click(function(e){
			e.preventDefault();
			$('#btncloseajoutjournnee').click();
		});

		//AJOUTE UNE JOURNEE
		$('#formajouterjournee #ajouterjournee').click(function(e) {
			e.preventDefault();
			
			var error = false;

			//controle des champs
			$('#formajouterjournee input').each(function()
			{
				
				if($(this).val().trim()=='')
				{ 
					$(this ).css("border", "solid 1px #e55039");
					error = true;
				}
				else {  $(this ).css("border", "solid 1px #ced4da");}
			}) 

			//soumission formulaire
			if (error == false) { $('#formajouterjournee').submit(); }		
		});

		//SUPRIMER UNE JOURNEE
		$('#gestionsite #deleteday').click(function(e) {
			e.preventDefault();
			reponse = confirm("Confirmer la suppression de journée " + $(this).closest('tr').find('.nameday').html());

			//suppression
			if(reponse) 
			{ 
				roulement = $('#selectionroulement').val();
				idjournee =  $(this).closest('tr').find('.idday').html();

				adresse= "index.php?page=gestionsite&deleteday&idroulement=" + roulement + "&idjournee=" + idjournee;
				window.location.replace(adresse);
			}
		});

		//SUPRIMER UN ROULEMENT
		$('#gestionsite #deleteroulement').click(function(e) {
			e.preventDefault();
			reponse = confirm("Confirmer la suppression du roulement  " + $(this).closest('tr').find('.nameroulement').html());

			//suppression
			if(reponse) 
			{ 
				idroulement =  $(this).closest('tr').find('.idroulement').html();
				idup=$('#selectionUpOngletroulements').val(); 
				idresidence = $('#selectionResidenceOngletroulements').val();
				adresse= "index.php?page=gestionsite&deleteroulement&idup=" + idup + "&idroulement=" + idroulement + "&idresidence=" + idresidence;
				window.location.replace(adresse);
			}
		});

		//SUPRIMER UNE RESIDENCE
		$('#gestionsite #deleteresidence').click(function(e) {
			e.preventDefault();
			reponse = confirm("Confirmer la suppression de la résidence de  " + $(this).closest('tr').find('.nameresidence').html());

			//suppression
			if(reponse) 
			{ 
				idresidence =  $(this).closest('tr').find('.idresidence').html();
				idup = $('#selectionUpOngletresidences').val();

				adresse= "index.php?page=gestionsite&deleteresidence&idresidence=" + idresidence + "&idup=" + idup;
				window.location.replace(adresse);
			}
		});

		//SUPRIMER UNE UP
		$('#gestionsite #deleteup').click(function(e) {
			e.preventDefault();
			reponse = confirm("Confirmer la suppression de l'up de  " + $(this).closest('tr').find('.nameup').html());

			//suppression
			if(reponse) 
			{ 
				idup =  $(this).closest('tr').find('.idup').html();

				adresse= "index.php?page=gestionsite&deleteup&idup=" + idup;
				window.location.replace(adresse);
			}
		});

	/***
	/** FICHE AGENT
	/***	**/
	$('#tableagents tr').dblclick(function()
	{
		id = $(this).find('td:first').text();
		//$('#cadrePrincipal').load('view/forms/form_agent.php');
		window.location.replace('index.php?page=ficheagent&id=' + id);
	});

	/***
	/** GESTION DES SELECT
	/***  */

		//select up des différents onglets
			$('#gestionsite #selectionUpOngletresidences').change(function()
			{
				idup = $(this).val();
				window.location.replace('index.php?page=gestionsite&onglet=residences&idup=' + idup);
			});

			$('#gestionsite #selectionUpOngletroulements').change(function()
			{
				idup = $(this).val();
				window.location.replace('index.php?page=gestionsite&onglet=roulements&idup=' + idup);
			});

		//select residence
			$('#gestionsite #selectionResidenceOngletroulements').change(function()
			{
				idup = $('#selectionUpOngletroulements').val();
				idresidence = $(this).val();
				window.location.replace('index.php?page=gestionsite&onglet=roulements&idup=' + idup + '&idresidence=' + idresidence);
			});
		//select roulement
		$('#gestionsite #selectionroulement').change(function()
		{
			noroulement = $(this).val();
			window.location.replace('index.php?page=gestionsite&onglet=journees&idroulement=' + noroulement);
		});

	/***
	/** CLIC SUR ENTETE
	/*** */
	$('#gestionsite #entetejournee').click(function(event) {
		alert("en cours");
	});


	$('#gestionsite #enteteid').click(function(event) {
		alert("en cours");
	});
}); //fin jquery