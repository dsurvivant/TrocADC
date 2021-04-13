/**
 *	- AJOUTER JOURNNEE
 *  - Supprimer journee
 *  - double click sur ligne agent ==> fiche agent
 *  - click sur entetes: journee, id
 */
$(function()
{
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

			adresse= "index.php?page=gestionsite&onglet=journees&deleteday&idroulement=" + roulement + "&idjournee=" + idjournee;
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