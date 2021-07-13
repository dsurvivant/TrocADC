$(function()
{
	/** PROPOSITIONS PAR DATE **/

	$('.sectionPropositions .detailProposition').hide();

	$('#cadrePrincipal').on('mouseenter', '.sectionPropositions .proposition', function()
		{
			$(this).css('background-color', 'lightgrey');
		});

	$('#cadrePrincipal').on('mouseleave', '.sectionPropositions .proposition',function()
	{
		$(this).css('background-color', 'white');
	});

	$('#cadrePrincipal').on('click','.sectionPropositions .proposition', function()
	{
		if($(this).hasClass('bg-dark'))
		{$(this).removeClass('bg-dark text-white');}
		else
		{$(this).addClass('bg-dark text-white');}

		$(this).next('.detailProposition').slideToggle();
	});

	/** MES PROPOSITIONS **/
		$('#mespropositions .infosproposition').hide();

		$('#mespropositions .proposition').click(function()
		{
			if($(this).hasClass('bg-dark'))
			{$(this).removeClass('bg-dark text-white');}
			else
			{$(this).addClass('bg-dark text-white');}
		
			$(this).next('.infosproposition').slideToggle();
		});

		//FILTRE AFFICHAGE ANCIENNES PROPOSITIONS
		$('#mespropositions .filtrepropositions').click(function()
		{
			//Couleurs des boutons
				$('.filtrepropositions').each(function() 
				{
					$(this).removeClass('bg-dark text-white');
				})
				$(this).addClass('bg-dark text-white');

				if ($(this).text() == 'Oui')
				{
					window.location.replace("index.php?page=mes propositions&actives");
				}

				if ($(this).text() == 'Non')
				{
					window.location.replace("index.php?page=mes propositions");
				}
		});

	//SELECT

		//select residence => liste des roulements de la résidence
			$('#formproposition').on('change', '#selectionresidence', function()
			{
				idresidence = $(this).val();
				
				//remplissage du select Roulement
				$.ajax({
					url: 'public/js/ajax/findroulements.php',
					type: 'POST',
					dataType: 'html',
					data: {idresidence: idresidence},
				})
				.done(function(data) {
					$('#ajaxroulement').html(data);
				})
				.always(function() {
					idroulement = $('#selectionroulement').val();
					//remplissage du select journee
					$.ajax({
						url: 'public/js/ajax/findjournees.php',
						type: 'POST',
						dataType: 'html',
						data: {idroulement: idroulement},
					})
					.done(function(data) {
						$('#ajaxjournees').html(data);
					})
				});
			});

		//select roulement => liste des journees du roulement
			$('#formproposition').on('change', '#selectionroulement', function()
			{
				idroulement = $(this).val();
				//remplissage du select journee
				$.ajax({
					url: 'public/js/ajax/findjournees.php',
					type: 'POST',
					dataType: 'html',
					data: {idroulement: idroulement},
				})
				.done(function(data) {
					$('#ajaxjournees').html(data);
				})
			});

});