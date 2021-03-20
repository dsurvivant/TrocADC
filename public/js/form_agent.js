$(function(){
	$('.help').hide();

	/** SOUMISSION DU FORMULAIRE D'INSCRIPTION **/
	$('#btn_valider_inscription').click(function(e)
	{
		e.preventDefault();

		$(this).attr('disabled', 'disabled');
		$('body').css('cursor', 'wait');
		/***
		/** VERIFICATION DES SAISIS	
		/***		**/

		var erreur = false;
		var telephone = $('#input_telephone').val().trim();
		var email = $('#input_email').val().trim();
		var password = $('#input_password').val().trim();
		var confirmpassword = $('#input_confirmpassword').val().trim();

		//champs vident
		$('#formagent input').each(function()
		{
			if($(this).val().trim()=='')
			{ 
				$(this ).css("border", "solid 1px red");
				$('#message_form_agent').html("Merci de remplir correctement tous les champs");
				erreur = true;
			}
			else {  $(this ).css("border", "solid 1px #ced4da");}
		}) 

		//verif telephone
		if (!(ValidateTelephone(telephone)))
		{ 
			$('#input_telephone').css('border','solid 1px red');
			$('#input_telephone').next('.help').slideDown();
			erreur = true;
		}
		else
		{ 
			$('#input_telephone').css('border','solid 1px lightgrey');
			$('#input_telephone').next('.help').slideUp();
		}

		if(!ValidateEmail(email))
		{ 
			$('#input_email').css('border','solid 1px red');
			$('#input_email').next('.help').slideDown();
			erreur = true;
		}
		else
		{ 
			$('#email').css('border','solid 1px lightgrey');
			$('#input_email').next('.help').slideUp();
		}

		if(password!=confirmpassword)
		{
			$('#input_confirmpassword').css('border','solid 1px red');
			$('#input_confirmpassword').next('.help').slideDown();
			erreur = true;
		}
		else
		{ 
			$('#input_confirmpassword').css('border','solid 1px lightgrey');
			$('#input_confirmpassword').next('.help').slideUp();
		}
			

		//soumission formulaire
		if (erreur == false) 
		{
			$('#formagent').submit();
		}
		else
		{
			$('body').css('cursor', 'auto');
			$('#btn_valider_inscription').removeAttr('disabled');
		}	
	});

	/** SOUMISSION DU FORMULAIRE MODIFIER AGENT **/
	$('#btn_modifier_agent').click(function(e)
	{
		e.preventDefault();
		/***
		/** VERIFICATION DES SAISIS	
		/***		**/

		var erreur = false;
		var telephone = $('#input_telephone').val().trim();
		var email = $('#input_email').val().trim();
		var password = $('#input_password').val().trim();
		var confirmpassword = $('#input_confirmpassword').val().trim();

		//champs vident
		$('#formagent .verifmodif').each(function()
		{
			if($(this).val().trim()=='')
			{ 
				$(this ).css("border", "solid 1px red");
				$('#message_form_agent').html("Merci de remplir correctement tous les champs");
					erreur = true;
			}
			else {  $(this ).css("border", "solid 1px #ced4da");}
		}) 

		//verif telephone
		if (!(ValidateTelephone(telephone)))
		{ 
			$('#input_telephone').css('border','solid 1px red');
			$('#input_telephone').next('.help').slideDown();
			erreur = true;
		}
		else
		{ 
			$('#input_telephone').css('border','solid 1px lightgrey');
			$('#input_telephone').next('.help').slideUp();
		}

		if(!ValidateEmail(email))
		{ 
			$('#input_email').css('border','solid 1px red');
			$('#input_email').next('.help').slideDown();
			erreur = true;
		}
		else
		{ 
			$('#email').css('border','solid 1px lightgrey');
			$('#input_email').next('.help').slideUp();
		}

		if(password!=confirmpassword)
		{
			$('#input_confirmpassword').css('border','solid 1px red');
			$('#input_confirmpassword').next('.help').slideDown();
			erreur = true;
		}
		else
		{ 
			$('#input_confirmpassword').css('border','solid 1px lightgrey');
			$('#input_confirmpassword').next('.help').slideUp();
		}
			

		//soumission formulaire
		if (erreur == false) 
		{
			$('#formagent').attr('action', 'index.php?page=ficheagent&modifier');
			$('#formagent').submit();
		}	
	});

	//bouton de suppression. Ne supprime pas avant confirmation
	$('#btn_supprimer_agent').click(function(e)
	{
		e.preventDefault();

		$('#formagent').css('background-color','#e55039');
		$('#form_boutons').css('display', 'none');
		$('#btn_confirmer_suppression').css('display','block');
	});

	//bouton de confirmation de suppression
	$('#btn_confirmer_suppression').click(function(e)
	{
		e.preventDefault();
		$('#formagent').attr('action', 'index.php?page=ficheagent&supprimer');
		$('#formagent').submit();
	});

}) // jquery