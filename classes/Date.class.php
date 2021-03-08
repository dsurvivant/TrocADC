<?php

/**
 * 
 */
class Date
{
	
	public $days = array('Lundi', 'Mardi', 'Mercerdi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
	public $months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');

	/**
	 * [getAll description]
	 * @param  [type] $year [description]
	 * @return [type]       [description]
	 */
	function getAll($year)
	{
		$r = array();

		$date = new DateTime($year . "-01-01");
		while ($date->format('Y') < $year+1)
		{
			$y = $date->format('Y'); //année sur 4 chiffres
			$m = $date->format('n'); //mois de 1 à 12
			$d = $date->format('j'); // jour du mois de 1 à 31
			$w = $date->format('N'); // jour de la semaine 1(lundi) à 7 (dimanche)

			$r[$m][$d] = $w;
			$date->modify('+1 Day');
		}
		return $r;
	}

}