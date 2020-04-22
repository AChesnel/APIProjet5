<?php

class Router
{

	private $action;
	private $routes = array(
								'getBars'       => array('controller' => 'Frontend', 'method' => 'getBars'),
								'getUsers'      => array('controller' => 'Frontend', 'method' => 'getUsers'),
								'login'         => array('controller' => 'Frontend', 'method' => 'login'),
								'sendComment'   => array('controller' => 'Frontend', 'method' => 'sendComment'),
								'barLikedCheck' => array('controller' => 'Frontend', 'method' => 'barLikedCheck'),
								'likeBar'       => array('controller' => 'Frontend', 'method' => 'likeBar'),
								'createAccount' => array('controller' => 'Frontend', 'method' => 'createAccount')
	);

	public function __construct($action) {
		$this->action = $action;
	}

	public function render()
	{

		if(  key_exists($this->action, $this->routes)   ) {
		   $controller = new $this->routes[$this->action]['controller']();
		   $method     = $this->routes[$this->action]['method'];
		   (isset($this->routes[$this->action]['firewall'])) ? $firewall = 1 : $firewall = 0;
		  if($firewall == 1) {
		        if( isset($_SESSION['logged'] ) && $_SESSION['logged'] == true) {
		            $controller->$method();
		        } else {
		            echo 'non autorisé';
		        }
		   } else {
		        $controller->$method();
		   }

		} else {
		    echo 'page 404';
		}
	}
}