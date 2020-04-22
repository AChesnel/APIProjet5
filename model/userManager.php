<?php


class userManager extends bddManager {
	

	public function auth($identifiant, $password)
	{
		$db = $this->db;

		$req = $db->prepare('SELECT * FROM user WHERE username = :identifiant');
		$req->bindValue('identifiant', $identifiant);
		$req->execute();
		if(!$datas = $req->fetch(PDO::FETCH_ASSOC)) return array('message' => 'user inexistant');

		if(md5($password) !== $datas['password']) return array('message' => 'mot de passe incorrect');

		$datas['token'] = md5($identifiant);

	 	tokenManager::createToken($datas['token'], $datas['id']);

	 	$datas['message'] = 'token cree';
	 	unset($datas['password']);
	 	return $datas;

	}


	public function newAccount($identifiant, $password, $email)
	{
		$db = $this->db;

		$req = $db->prepare("INSERT INTO user (id, username, password, bar_pref, email, role) VALUES (NULL, ?, ?, NULL, ?, 'user');");
		$req->execute(array($identifiant, $password, $email));
		return true;
	}

	public function isUsernameTaken($identifiant)
	{
		$db = $this->db;

		$req = $db->prepare("SELECT * FROM user WHERE username = :username");
		$req->execute(array(':username' => $identifiant));
		
		$datas = $req->fetch(PDO::FETCH_ASSOC); 

	    return $datas;
	}

	public function isEmailTaken($email)
	{
		$db = $this->db;

		$req = $db->prepare("SELECT * FROM user WHERE email = :email");
		$req->execute(array(':email' => $email));
		
		$datas = $req->fetch(PDO::FETCH_ASSOC); 

	    return $datas;
	}

	public function newAccountPostDataCheck($identifiant, $password, $password2, $email)
	{

		$user = $this->isUsernameTaken($identifiant);
		if($user){
			$message = "Nom d'utilisateur déjà existant";
		}

		$user = $this->isEmailTaken($email);
		if($user){
			$message = "Un compte est déjà associé à cet e-mail";
		}

		if($password != $password2){
			$message = "Les mots de passes ne sont pas identiques";
		}

		if(isset($message)){
			return false;
		} else {
			return true;
		}
	}


}