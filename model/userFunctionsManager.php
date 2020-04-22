<?php

class userFunctionsManager extends bddManager {

	public function envoyerCommentaire($identifiant, $commentaire, $bar)
	{
		$db = $this->db;

		$req = $db->prepare("INSERT INTO comments (id, author, comment, bar_id) VALUES (NULL, ?, ?, ?);");

		$req->execute(array($identifiant, $commentaire, $bar));
		$comment = $req->fetch(PDO::FETCH_ASSOC);
		return $comment;
	}

	public function didUserLikeBar($username, $bar_id)
	{
		$db = $this->db;

		$query = "SELECT * FROM bar_likes WHERE bar_id = $bar_id AND user_id = ".USER_ID;
		$req = $db->prepare($query);
		//$req->bindValue('bar_id', $bar_id);
		//$req->bindValue('username', $username);
		$req->execute();
		$result = $req->fetch(PDO::FETCH_ASSOC);
		return $result['user_id'];
	}

	public function UserLikeBar($username, $barId)
	{
		if($this->didUserLikeBar($username, $barId)) {
			$db = $this->db;

			$query = "DELETE FROM bar_likes WHERE bar_id = ".$barId." AND user_id = ".USER_ID; 
			$req = $db->prepare($query);
			$req->execute();
			return "B";
		} else {
			$db = $this->db;

			$query = "INSERT INTO bar_likes SET bar_id = ".$barId.", user_id = ".USER_ID; 
			$req = $db->prepare($query);
			$req->execute();
			return "A";
		}		
	}

}