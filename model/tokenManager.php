<?php


class tokenManager {
	

	public static function isValid($token)
	{
		$db = bddManager::createdb();


		$req = $db->prepare('SELECT * FROM token WHERE token_key = :token_key');
		$req->bindParam('token_key', $token);
		$req->execute();
		if(!$result = $req->fetch(PDO::FETCH_ASSOC)) return false;
		define('USER_ID', $result['user_id']);
		return true;
	}

	public static function createToken($token, $user_id)
	{
		$db = bddManager::createdb();

		$req = $db->prepare('DELETE * FROM token WHERE user_id = :user_id'); 
		$req->bindParam('user_id', $user_id);
		$req->execute();

		$req = $db->prepare('INSERT INTO token SET token_key = :token_key, user_id = :user_id, created_at = NOW()');
		$req->bindValue(':token_key', $token);
		$req->bindParam('user_id', $user_id);
		$req->execute();

	}


}