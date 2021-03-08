<?php
//
//michemuche62
//recup sur halliday.fr
//janvier 2021

     //////
    // MOT DE PASSE - function validationmotdepasse ($motdepasse)
    //////
    //
    //fonction de validation de mot de passe : reçois en paramètre le mot de passe
    //renvoie true si les critères sont respectés , false dans le cas contraire
    //
        //
        //Huit caractères au minimum, au moins une lettre et un chiffre:
        function validationmotdepasse($motdepasse)
        {
            if (preg_match("#^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$#", $motdepasse))
            { return true; }
            return false;
        }
        //Huit caractères au moins, au moins une lettre, un chiffre et un caractère spécial:
        function validationmotdepasse2($motdepasse)
        {
            if (preg_match("#^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$#", $motdepasse))
            { return true; }
            return false;
        }

        //Huit caractères au minimum, au moins une lettre majuscule, une lettre minuscule et un chiffre:
        function validationmotdepasse3($motdepasse)
        {
            if (preg_match("#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$", $motdepasse))
            { return true; }
            return false;
        }

        //Huit caractères au moins, au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial:
        function validationmotdepasse4($motdepasse)
        {
            if (preg_match("#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$#", $motdepasse))
            { return true; }
            return false;
        }
        //Huit et dix caractères au minimum, au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial:
        function validationmotdepasse5($motdepasse)
        {
            if (preg_match("#^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$#", $motdepasse))
            { return true; }
            return false;
        }
    //-----------------------------------------------------------------------------------------------------------------------------------

    //=====
    //== VERIFICATION SYNTAXE EMAIL
    //=====
    function validationemail($email)
        {
            if (preg_match ("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#",$email))
                { return true;}
            return false;
        }

    //-----------------------------------------------------------------------------------------------------------------------------------

    //*****
    //** VERIFICATION TELEPHONE 
    //  10 chiffres, séparé ou non par un espace, un tiret, ou un point
    //  ex: 0654258996 ou 06.54.25.89.96
    //*****
    function validationtelephone($telephone)
        {
            $valide = false; //non valide par défaut
            if (preg_match ("#^0[1-9]([-. ]?[0-9]{2}){4}$#",$telephone))
                { return true; }
             return false;
        }
    //-----------------------------------------------------------------------------------------------------------------------------------

    //////
    // SECURISATION DES SAISIS OU RETOURS BDD AVANT AFFICHAGE OU INSERTION BDD
    //////
    //sécurise les saisis formulaires ou lors de l'affichage issu d'une base de données
         function sanitizeString($var)
        {
            //If (get_magic_quotes_gpc()) $var = stripslashes($var) ;
            $var = strip_tags($var) ;
            $var = htmlentities($var) ;
            Return $var ;
        }

    //-----------------------------------------------------------------------------------------------------------------------------------

    //*****
    //** CRYPTAGE MOT DE PASSE
    //*****

        function cryptagemotdepasse($mdp)
        {
            // On prends la longueur de la chaine
            $code = strlen($mdp);
            // On fait quelques opérations
            $code = (($code * 6)*($code/4))*2;
            // Le premier sel
            $sel = "&Johnny&";
            // Le deuxième sel
            $sel2 = "#Hallyday#";
            // On termine en beauté avec quelques hashs
            $texte_hash = sha1($sel.$mdp.$sel2);
            $texte_hash_2 = md5($texte_hash.$sel2);

            // On assemble tout ça pour obtenir une chaine de 82 caractères
            $final = $texte_hash.$texte_hash_2;
            // On supprime 2 caractère pour brouiller les pistes (ici 5 et 7)
            substr($final , 5, 7);
            // On finit par tout mettre en majuscule
            $final = strtoupper($final);

            //retout du cryptage
            return $final;
        }

    //*****
    //** RETRAIT DES ACCENTS
    //*****
        
        function skip_accents( $str, $charset='utf-8' ) 
        {
 
            $str = htmlentities( $str, ENT_NOQUOTES, $charset );
            
            $str = preg_replace( '#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str );
            $str = preg_replace( '#&([A-za-z]{2})(?:lig);#', '\1', $str );
            $str = preg_replace( '#&[^;]+;#', '', $str );
            
            return $str;
        }

    //*****
    //** RETRAIT DES CARACTERES SPECIAUX: < > : " / \ | ? *
    //** Pour les noms de fichiers       
    //*****        
    function nettoyerChaine($string) {
        $caractères_interdit = array ("<",">",":","/","\\","|","?","*","\"");
        $string = str_replace($caractères_interdit, '', $string);
        return $string;
    }

    //*****
    //** DATE AU FORMAT JJ/MM/YYYY
    //** le jour et/ou le mois peuvent être donné(s) avec un seul chiffre
    //**
    //**    testDate( '21/11/1999' ); // -> true
    //**    testDate( '3/9/2008' ); // -> true
    //**    testDate( 'a/04/2003' ); // -> false
    //**    testDate( '28-01-2000' ); // -> false
    //**    testDate( '99/13/1978' ); // -> true
    //*****
    function testDate($date)
    {
        return preg_match("#^[0-9]{1,2}/[0-9]{1,2}/[0-9]{4}$#",$date);
    }

    //****
    //** date jj/mm//aaaa en yyyy-mm-dd
    //****
    function dateconv($date){
        $date = explode('/',$date);
        $date = array_reverse($date);
        $date = implode('-',$date);
        return "$date";
    }

    //****
    //** date yyyy-mm-dd ou jj/mm//aaaa
    //****
    function dateconv2($date){
        $date = explode('-',$date);
        $date = array_reverse($date);
        $date = implode('/',$date);
        return "$date";
    }

    //****
    //** Convertit une date ou un timestamp en français
    //** Le premier paramètre est le même que pour la fonction strtotime(). Le second paramètre est le format désiré, comme dans la fonction date().
    //** Exemples:
    //**    Affiche quelque chose comme : dimanche 8 juillet 2018: echo dateToFrench("now" ,"l j F Y");
    //**    Affiche : mardi 11 septembre 2001: echo dateToFrench("2001-09-11",'l j F Y');
    //**    Affiche : dimanche 10 septembre 2000: echo dateToFrench("10 September 2000",'l j F Y');
    //****
    
    function dateToFrench($date, $format) 
    {
        $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $french_days = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche');
        $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
        return str_replace($english_months, $french_months, str_replace($english_days, $french_days, date($format, strtotime($date) ) ) );
    }

    /**
     * string_r de $vars
     */
    function dd(...$vars)
    {
        foreach ($vars as $var) {
            echo "<pre>";
            print_r($var);
            echo "</pre>";
        }
    }

    /**
     * page d'erreur
     * @return [type] [description]
     */
    function e404()
    {
        require 'views/404.php';
        exit();
    }
?>
