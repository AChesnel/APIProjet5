<?php

/**
 *
 *
 */
class Myconfiguration
{


	public static function start() 
	{
		ini_set('display_errors','on');
		error_reporting(E_ALL);
		session_start();

		// ajotuer les commentaires

		spl_autoload_register(array(__CLASS__, 'autoload'));


		Myconfiguration::initParams();

	}

	private static function initParams() {

		$path_root =  "C:\wamp64\www\apiprojet5"; // défini le chemin fixe des dossiers.

		define('ROOT', $path_root.'/'); 
		define('CONTROLLER', ROOT.'controller/'); 
		define('MODEL', ROOT.'app/');
		define('APP', ROOT.'model/');


		define('DB_HOST', 'localhost'); // Ajouter le mot de passe / login  / table name
		define('DB_NAME', 'projet5');
		define('DB_USER', 'root');
		define('DB_PASSWORD', '');

	}

	private static function autoload($class){

		if(file_exists(CONTROLLER.$class.'.php')) {
			require_once(CONTROLLER.$class.'.php');
		}
		if(file_exists(MODEL.$class.'.php')) {
			require_once(MODEL.$class.'.php');
		}
		if(file_exists(APP.$class.'.php')) {
			require_once(APP.$class.'.php');
		}


	}

}