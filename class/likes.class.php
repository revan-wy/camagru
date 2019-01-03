<?php 

	//remove before flight
	ini_set('display_errors', 'On');

class Likes {

	private $db;
	private $pic_id;
	private $login;

	public function __construct($pic_id, $login) {
		try {
			require '../config/database.php';
			$this->db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pic_id = $pic_id;
			$this->login = $login;
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	public function getLike() {
		try {
			$req = $this->db->prepare("SELECT * FROM `likes` WHERE `pic_id` = ? AND `login` = ?");
			$res = $req->execute(array($this->pic_id, $this->login));
			return $req->fetch(PDO::FETCH_ASSOC);
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	public function addLike() {
		try {
			date_default_timezone_set('Africa/Johannesburg');
			$date_created = date("Y-m-d H:i:s");
			$req = $this->db->prepare("INSERT INTO `likes` (`pic_id`, `login`, `date_created`) VALUES (?, ?, ?)");
			$req->execute(array($this->pic_id, $this->login, $date_created));
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	public function nbLike() {
		try {
			$req = $this->db->query("SELECT count(*) FROM `likes` WHERE `pic_id` = $this->pic_id");
			$nblike = $req->fetch(PDO::FETCH_ASSOC);
			return $nblike['count(*)'];
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	public function deleteLike() {
		try {
			$req = $this->db->prepare("DELETE FROM `likes` WHERE `pic_id` = ? AND `login` = ?");
			$req->execute(array($this->pic_id, $this->login));
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	public function deleteAllLikes() {
		try {
			$req = $this->db->prepare("DELETE FROM `likes` WHERE `pic_id` = ?");
			$req->execute(array($this->pic_id));
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}
}

?>































