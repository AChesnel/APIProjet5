<?php
    
require_once('config.php');

MyConfiguration::start();

(isset($_GET['token'])) ? $token = $_GET['token'] : $token = null;
(isset($_GET['action'])) ? $action = $_GET['action'] : $action = null;


if($action == "login" || $action == "getBars" || $action == "createAccount") { // si login demandé pas de token exigé
	$router = new Router($action);
	$router->render();
} else {
	if(tokenManager::isValid($token)) {  // verifie si token valid
		$router = new Router($action);
		$router->render();
	} else {
		echo json_encode(array('Vous devez être identifié'));
	}
}