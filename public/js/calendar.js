$(function(){
	var currentmonth='';

	//affichage initial du mois**/
	$('.months a').each(function() 
	{ if ($(this).hasClass('active')) 
		{ currentmonth = $(this).attr('id').replace('linkmonth','')-1;} 
	});

	var current=currentmonth + 1;

	//evenement click sur un mois de la liste
	//affichage du mois choisit

	$('.months a').click(function() 
	{
		var month = $(this).attr('id').replace('linkmonth','');
		if (month != current)
		{
			$('#month'+current).slideUp();
			$('#month'+month).slideDown();
			$('.months a').removeClass('active');
			$('.months a#linkmonth'+month).addClass('active');
			current=month;
		}
		return false;
	});


	//repliage du mois en cours
	$('#calendar .monthsupdown').click(function()
	{	
		m = "month" + current;
		$('.month').each(function() { if ($(this).attr('id')==m){$(this).slideToggle();} });
		if ($(this).attr('title')=="déplier")
		{
			$(this).attr('title','Replier');
			$(this).attr('src', 'public/images/icones/moins-16px.png');
			$(this).attr('alt', 'repliage calendrier');
		}
		else
		{
			$(this).attr('title','déplier');
			$(this).attr('src', 'public/images/icones/plus-16px.png');
			$(this).attr('alt', 'dépliage calendrier');
		}
		
	});
}); //jquery