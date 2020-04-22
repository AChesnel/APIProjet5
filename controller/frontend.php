<?php

class Frontend {

	/**
	 * return all bars
	 * @Route(url = '/getData')
	 */
	public function getBars()
	{
		$manager = new barManager();

		$bars = $manager->getBars();

		$myJSON = json_encode($bars);

		echo $myJSON;

	}


	public function login()
	{
		if ($_POST['identifiant'] && $_POST['password']) {

			$identifiant = $_POST['identifiant'];
			$password    =	$_POST['password'];

			$manager = new userManager();
			$data = $manager->auth($identifiant, $password);

			if (isset($user['token'])) {
				$_SESSION['user'] = $identifiant;
				$_SESSION['token'] = $data['token'];
			} 
			
			echo json_encode($data);
		}
		
	}

	public function sendComment()
	{
		if ($_POST['identifiant'] && $_POST['commentaire']) {
			
			$identifiant = $_POST['identifiant'];
			$commentaire = $_POST['commentaire'];
			$bar         = $_POST['barId'];

			$manager = new userFunctionsManager();
			$comment = $manager->envoyerCommentaire($identifiant, $commentaire, $bar);
		}
	}


	public function barLikedCheck()
	{
		if($_GET['username'] && $_GET['barId']) {
			$username = $_GET['username'];
			$barId    = $_GET['barId'];

			$manager = new userFunctionsManager();
			$user_id = $manager->didUserLikeBar($username, $barId);

			echo json_encode($user_id);
		}
	}

	public function likeBar()
	{
		if($_GET['username'] && $_GET['barId']) {
			$username = $_GET['username'];
			$barId    = $_GET['barId'];

			$manager = new userFunctionsManager();
			$addBarLike = $manager->UserLikeBar($username, $barId);

			echo json_encode($addBarLike);
		} else {
			echo json_encode("No user, no bar");
		}
	}

	public function createAccount()
	{
		if($_POST['identifiant'] && $_POST['password'] && $_POST['password2'] && $_POST['email']) {
			$identifiant = $_POST['identifiant'];
			$password    = md5($_POST['password']);
			$password2   = md5($_POST['password2']);
			$email       = $_POST['email'];

			$manager = new userManager();
			$isPostValid = $manager->newAccountPostDataCheck($identifiant, $password, $password2, $email);
			if($isPostValid == 1){
				$compte = $manager->newAccount($identifiant, $password, $email);

				echo json_encode($compte);
			}
		}

	}
}