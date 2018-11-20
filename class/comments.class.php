<?php //untested 

	//remove before flight
	//ini_set('display_errors', 'On');

class Comments {

	private $db;
	private $pic_id;
	private $login;
	private $comments;

	public function __construct($pic_id, $login, $comment) {
		try {
			require '../config/database.php';
			$this->db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->$pic_id = $pic_id;
			$this->login = $login;
			$this->comment = $comment;
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	public function getComment() {
		try {
			$req = $this->db->prepare("SELECT * FROM `comments` WHERE `pic_id` = ?");
			$res = $req->execute(array($this->pic_id));
			return $req->fetchAll(PDO::FETCH_ASSOC);
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	private function sendMailComment() {
		try {
			$req = $this->db->prepare("SELECT `login` FROM `pictures` WHERE `pic_id` = ?");
			$res = $req->execute(array($this->pic_id));
			$pic = $req->fecth(PDO::FETCH_ASSOC);
			$email = $user['email'];
			require '../app/mailcomment.php';
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	public function addComment() {
		try {
			date_default_timezone_set('Africa/Johannesburg');
			$date_created = date("Y-m-d H:i:s");
			$req = $this->db->prepare("INSERT INTO `comments` (`pic_id`, `comment`, `login`, `date_created`) VALUES (?, ?, ?, ?)");
			$req->execute(array($this->pic_id, $this->comment, $this->login, $date_created));
			self::sendMailComment();
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	public function deleteAllComment() {
		try {
			$req = $this->db->prepare("DELETE FROM `comments` WHERE `pic_id` = ?");
			$req->execute(array($this->pic_id));
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

}

?>































