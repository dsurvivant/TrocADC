$(function(){

	/**	CONNEXION **/

	//affichage de la fenêtre de connexion
	$('#btn_openformconnexion').click();

	//valider connexion
	$('#btn_connexion').click(function(e)
	{
		e.preventDefault();
		var erreur = false;
		//contrôle des champs
		$('#formconnexion input').each(function(){
			if ($(this).val().trim()=='')
			{
				$(this).css('border', 'solid 1px red');
				erreur = true;
			}
			else
			{
				$(this).css('border', 'solid 1px #ced4da');
			}
		});

		if (erreur==false){
			$('#formconnexion').submit();
		}
	});

}); //jquery