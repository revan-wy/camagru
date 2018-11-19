<?php //untested

	//remove before flight
	ini_set('display_errors', 'On');

class Pictures {

	private $db;
	private $pic_id;
	private $pic;
	private $login;

	public function __construct($pic_id, $pic, $login) {
		try {
			require '../config/database.php';
			$this->db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pic_id = $pic_id;
			$this->pic = $pic;
			$this->login = $login;
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	public function getPicture() {
		try {
			$req = $this->db->prepare("SELECT * FROM `pictures` WHERE `login` = ? ORDER BY `date_created` DESC LIMIT 20");
			$res = $req->execute(array($this->login));
			$picture = $req->fetchAll(PDO::FETCH_ASSOC);
			return $picture;
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	public function addPicture() {
		try {
			date_default_timezone_set('Africa/Johannesburg');
			$date_created = date("Y-m-d H:i:s");
			$req = $this->db->prepare("INSERT INTO `pictures` (`login`,`pic`,`date_created`) VALUES (?, ?, ?)");
			$req->execute(array($this->login, $this->pic, $date_created));
			$req = $this->db->query("SELECT `pic_id` FROM `pictures` WHERE `login` = '".$this->login."' AND `date_created` = '".$date_created."'");
			$pic_id = $req->fetch(PDO::FETCH_ASSOC);
			return $pic_id;
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	public function getPicturesByPage($page, $nbpicbypage) {
		try {
			$req = $this->db->prepare("SELECT * FROM `pictures` ORDER BY `date_created` DESC LIMIT ".$page.", ".$nbpicbypage);
			$res = $req->execute();
			$pictures = $req->fetchAll(PDO::FETCH_ASSOC);
			return $picture;
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	public function getPicturesByPageByLogin($page, $nbpicbypage) {
		try {
			$req = $this->db->prepare("SELECT * FROM `pictures` WHERE `login` = ? ORDER BY `date_created` DESC LIMIT ".$page.", ".$nbpicbypage);
			$res = $req->execute(array($this->login));
			$picture = $req->fetchAll(PDO::FETCH_ASSOC);
			return $picture;
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	public function nbPictures() {
		try {
			$req = $this->db->query("SELECT count(*) FROM `pictures`");
			$nbpic = $req->fetchAll(PDO::FETCH_ASSOC);
			return $nbpic['count(*)'];
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	public function nbPicturesByLogin() {
		try {
			$req = $this->db->query("SELECT count(*) FROM `pictures` WHERE `login` = '".$this->login."'");
			$nbpic = $req->fetch(PDO::FETCH_ASSOC);
			return $nbpic['count(*)'];
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	public function deletePicture() {
		try {
			$req = $this->db->prepare("DELETE FROM `pictures` WHERE `pic_id` = ? AND `login` = ?");
			$req->execute(array($this->pic_id, $this->login));
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}
}

?>



































