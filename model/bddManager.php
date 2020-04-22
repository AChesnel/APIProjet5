<?php



abstract class bddManager
{
	protected $db;

	public function __construct()
	{
		 try
	    {           
	     	$db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD);
	    }
	    catch(Exception $e)
	    {
	        die('Erreur : '.$e->getMessage());
	    }
	    $this->db = $db;
	}

	public static function createdb()
	{
	
	 try
	    {           
	     	$db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD);
	    }
	    catch(Exception $e)
	    {
	        die('Erreur : '.$e->getMessage());
	    }
	     return $db;

	}


}