<?php
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=trocadc','root','',array(PDO::MYSQL_ATTR_INIT_COMMAND=> 'SET NAMES UTF8'));	
		/**
		$host='hallidz62.mysql.db';
		$db='hallidz62';
		$user='hallidz62';
		$pw='Ayddacnathof5';
		$bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pw, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));**/
	}
	catch(PDOException $e)
	{
		echo 'Base de donnees en vacances';
		exit();
	}