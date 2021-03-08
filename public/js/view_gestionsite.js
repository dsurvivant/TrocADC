/**
 *   - vérification des champs non vide
 *   - vérification format duree et mis en forme auto des durees
 */
$(function()
{
	$('#formajouterjournee #annulerajoutjournee').click(function(e){
		e.preventDefault();
		$('#btncloseajoutjournnee').click();
	});

	//champs non vide
	$('#formajouterjournee #ajouterjournee').click(function(e) {
		e.preventDefault();
		
		var error = false;

		//controle des champs
		$('#formajouterjournee input').each(function()
		{
			
			if($(this).val().trim()=='')
			{ 
				$(this ).css("border", "solid 1px red");
				error = true;
			}
			else {  $(this ).css("border", "solid 1px #ced4da");}
		}) 

		//soumission formulaire
		if (error == false) { $('#formajouterjournee').submit(); }		
	});

}); //fin jquery