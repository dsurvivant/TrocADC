$(function(){

	/***
	/** CADRE INFOS
	/** Soumission du formulaire si champs valident */
	/** **/
	$('#btnSaveInfos').click(function(e){
		e.preventDefault();
		//*******************************//
		/**** vérification des champs
		//*******************************/
		var telephone = $('#telephone').val().trim();
		var email = $('#email').val().trim();
		var errortelephone = false;
		var erroremail = false;
						
		//verif telephone
		if (!(ValidateTelephone(telephone)))
		{ 
			$('#telephone').css('border','solid 1px red');
			$('#telephone').next('span').text('Numéro de téléphone non valable');
			errortelephone = true;
		}
		else
		{ 
			$('#telephone').css('border','solid 1px lightgrey');
			$('#telephone').next('span').text('');
			errortelephone = false;
		}

		if(!ValidateEmail(email))
		{ 
			$('#email').css('border','solid 1px red');
			$('#email').next('span').text('Mail non valable');
			erroremail = true;
		}
		else
		{ 
			$('#email').css('border','solid 1px lightgrey');
			$('#email').next('span').text(''); 
			erroremail = false;
		}

		//*******************************//
		/**** TRAITEMENT DES INFOS
		//*******************************/

		if ((erroremail == false) && (errortelephone == false))
		{
			$('#formMesInfos').submit();
		}

	});

	/***
	/** CADRE MOT DE PASSE
	/** Soumission du formulaire si champs valident */
	/** **/
	$('#btnModifPassword').click(function(e) 
	{
		e.preventDefault();

		$('#errormdp').html('');
		
		//*******************************//
		/**** vérification des champs
		//*******************************/
		var password = $('#password').val().trim();
		var newpassword = $('#newpassword').val().trim();
		var confirmpassword = $('#confirmpassword').val().trim();
		
		if (password!='' && newpassword!='' && confirmpassword!='')
		{
			if (newpassword!=confirmpassword)
			{
				$('#newpassword').css('border','solid 1px red');
				$('#confirmpassword').css('border','solid 1px red');
				$('#errormdp').prepend('Les mots de passe sont différents');
				$('#errormdp').css('display','block');
			}
			else
			{
				$('#newpassword').css('border','solid 1px lightgrey');
				$('#confirmpassword').css('border','solid 1px lightgrey');
				$('#errormdp').css('display','none');

				$('#formModifPassword').submit();
			}
		}
		else
		{
			$('#errormdp').prepend('Remplir tous les champs avant modification');
			$('#errormdp').css('display','block');
		}
	});

	/***
	/** CADRE FILTRES */
	$('#inputname').change(function(event) 
	{
		if($(this).prop('checked')==true){ checkname=1;}
		else { checkname = 0;}

		$.ajax({
			url: 'index.php?page=parametres',
			type: 'POST',
			data: {
					filtrename: "filtrename",
					checkname: checkname,
				},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});	
	});

	$('#inputmail').change(function(event) 
	{
		if($(this).prop('checked')==true){ checkmail=1;}
		else { checkmail = 0;}

		$.ajax({
			url: 'index.php?page=parametres',
			type: 'POST',
			data: {
					filtremail: "filtremail",
					checkmail: checkmail,
				},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});

});