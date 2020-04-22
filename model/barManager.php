<?php


class barManager extends bddManager {
	

	/**
	 * get all bars
	 *
	 * fields returened : position, address, 
	 * @return Array()
	 */
	public function getBars()
	{
		$db = $this->db;


		// favoris
		$query = "SELECT COUNT(bar_pref) as total_fav, bar_pref as bar_id FROM `user` group by bar_pref ";
		$reqC = $db->prepare($query);
		$reqC->execute();
		$result= $reqC->fetchAll(PDO::FETCH_ASSOC); 

		foreach($result as $r) {
			$totalFav[$r['bar_id']] = $r['total_fav'];
		}


		// bars
		$req = $db->prepare('SELECT bar.*, COUNT(bar_likes.id) AS nblikes
							FROM bar 
							LEFT JOIN bar_likes ON bar.id = bar_likes.bar_id 
							GROUP BY bar.id');

		$req->execute();
		$datas = $req->fetchAll(PDO::FETCH_ASSOC); 


		$bars = array();
		foreach($datas as $data) {
			(isset($totalFav[$data['id']])) ? $nb = $totalFav[$data['id']] : $nb = 0;
			$data['bar_fav'] = $nb;
			$req = $db->prepare('SELECT * FROM comments WHERE bar_id = ' . $data['id']);
			$req ->execute();
			$comments = $req->fetchAll(PDO::FETCH_ASSOC);
			//if ($comments) {
				$data['comments'] = $comments;
			//}
			$bars[] = $data;
			
		}
		
		return $bars;
	}


}