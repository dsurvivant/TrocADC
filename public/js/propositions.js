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

	//changement roulement dans le select
	$('#selectionroulement').change(function(event) {
		noroulement = $(this).val();
		date = $('#currentdate').text();
		window.location.replace('index.php?page=ajout_proposition&jour=' + date +"&idroulement=" + noroulement);
	});

});