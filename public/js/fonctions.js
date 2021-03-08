//Huit caractères au minimum, au moins une lettre et un chiffre:
function validationmotdepasse($motdepasse)
{
    if (/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test($motdepasse))
    { return (true); }
    return (false);
}

function ValidateEmail(mail) 
{
	if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(mail))
	{ return (true); }
	return (false);
}

//*****
//** VERIFICATION TELEPHONE 
//  10 chiffres, séparé ou non par un espace, un tiret, ou un point
//  ex: 0654258996 ou 06.54.25.89.96
//*****
function ValidateTelephone(telephone) 
{
	if ((/^0[1-9]([-. ]?[0-9]{2}){4}$/.test(telephone)))
	{return (true);}
	return (false);
}