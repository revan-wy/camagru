<?php //untested

//remove before flight
ini_set('display_errors', 'On');

class Users {
	private $db;
	private $login;
	private $passwd;
	private $passwdVerif;
	private $email;
	private $token;
	public $message;

	public function __construct($login, $passwd, $passwdVerif, $email, $token)
	{
		try {
			require '../config/database.php'; //file incomplete
			$this->db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->login = $login;
			$this->passwd = $passwd;
			$this->passwdVerif = $passwdVerif;
			$this->email = $email;
			$this->token = $token;
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	private function getUser() {
		try {
			$req = $this->db->prepare("SELECT * FROM `users` WHERE `login` = ?");
			$res = $req->execute(array($this->login));
			$user = $req->fetch(PDO::FETCH_ASSOC);
			return $user;
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	private function checkPassword() {
		if (strlen($this->passwd) > 255)
			return $this->message = "Passwords cannot exceed 30 characters.";
		if ($this->passwd != $this->passwdVerif)
			return $this->message = "The entered passwords do not match.";
		if (!preg_match('/(?=.*[0-9])(?=.*[A-Za-z]).{7,30}/', $this->passwd))
			return $this->message = "Password should be a minimum of seven characters, and contain at least one letter and one number.";
	}

	private function checkNewUser() {
		if (strlen($this->login) > 30)
			return $this->message = "User name cannot exceed 30 characters.";
		$user = $this->getUser();
		if ($user)
			return $this->message = "This user name is already in use.";
		self::checkPassword();
		if ($this->message != null)
			return ;
		if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false)
			return $this->message = "Email address is invalid.";
	}

	public function sendConfirmationUser() {
		self::checkNewUser();
		if ($this->message)
			return ;
		$token = bin2hex(random_bytes(16));
		$pwrurl = "localhost:8080/restarted/pages/home.php?q=".$token;
		date_default_timezone_set('Africa/Johannesburg');
		$date_created = date("Y-m-d H:i:s");
		$token_expires = date("Y-m-d H:i:s", strtotime($date_created.' + 2 days'));
		try {
			$req = $this->db->prepare("INSERT INTO `users` (`login`, `password`, `email`, `date_created`, `token`, `token_expires`) VALUES (?, ?, ?, ?, ?)");
			$req->execute(array($this->login, hash('whirlpool', $this->passwd), $this->email, $date_created, $token, $token_expires));
			$req = $this->db->prepare("DELETE FROM `users` WHERE `token_expires` < NOW() AND `confirm` = 0");
			$req->execute();
			require '../app/mailconfirm.php';
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	public function confirmUser() {
		try {
			$req = $this->db->prepare("SELECT * FROM `users` WHERE `token` = ?");
			$res = $req->execute(array($this->token));
			$user = $req->fetch(PDO::FETCH_ADDOC);
			if (!user)
				return $this->message = "Your account has already been verified or the link has expired.";
			$req = $this->db->prepare("UPDATE `users` SET `confirm` = ?, `token` = ?, `token_expires` = ? WHERE `token` = ?");
			$req->execute(array(1, NULL, NULL, $this->token));
			$this->message = "Your account has now been verified. Welcome, ".$user['login']."!";
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	public function connectUser() {
		try {
			$user = $this->getUser();
			if (!$user)
				return $this->message = "The entered user name is not associated with an account.";
			if ($user['confirm'] == 0)
				return $this->message = "This account has not yet been validated. <br/>Please follow the link that was sent via email.";
			if ($user['password'] != hash('whirlpool', $this->passwd))
				return $this->message = "The entered password is incorrect.";
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	public function sendPassword() {
		try {
			$user = $this->getUser();
			if (!$user)
				return $this->message = "The entered user name is not associated with an account.";
			$email = $user['email'];
			$token = bin2hex(random_bytes(16));
			$pwrurl = "localhost:8080/restarted/pages/password.php?q=".$token;
			date_default_timezone_set('Africa/Johannesburg');
			$date_created = date("Y-m-d H:i:s");
			$token_expires = date("Y-m-d H:i:s", strtotime($date_created.' + 2 days'));
			$req = $this->db->prepare("UPDATE `users` SET `token` = ?, `token_expires` = ? WHERE `login` = ?");
			$req->execute(array($token, $token_expires, $this->login));
			$req = $this->db->prepare("UPDATE `users` SET `token` = ?, `token_expires` = ? WHERE `token_expires` < NOW() AND `confirm` = 1");
			$req->execute(array(NULL, NULL));
			require '../app/mailpassword.php';
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	public function resetPassword() {
		try {
			$req = $this->db->prepare("SELECT * FROM `users` WHERE `token` = ?");
			$res = $req->execute(array($this->token));
			$user = $req->fetch(PDO::FETCH_ADDOC);
			if (!$user)
				return $this->message = "The link has expired or has not been correctly followed.";
			self::checkPassword();
			if ($this->message != null)
				return ;
			$req = $this->db->prepare("UPDATE `users` SET `password` = ? WHERE `token` = ?");
			$req->execute(array(hash('whirlpool', $this->passwd), $this->token));
			$this->message = "Password has been updated.";
		}
		catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}
}

?>

































