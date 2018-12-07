<?php

class Users {

  private $db;
  private $login;
  private $passwd;
  private $passwdVerif;
  private $email;
  private $token;
  public $message;

  public function __construct($login, $passwd, $passwdVerif, $email, $token) {
    try {
      require '../config/database.php';
      $this->db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->login = $login;
      $this->passwd = $passwd;
      $this->passwdVerif = $passwdVerif;
      $this->email = $email;
      $this->token = $token;
    }
    catch (Exception $e) {
      die('Error : ' . $e->getMessage());
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
      die('Error : ' . $e->getMessage());
    }
  }

  private function checkPassword() {
    if (strlen($this->passwd) > 255)
      return $this->message = "Your password must not exceed 30 characters.";
    if ($this->passwd != $this->passwdVerif)
      return $this->message = "Passwords are not the same.";
    if (!preg_match('/(?=.*[0-9])(?=.*[A-Za-z]).{7,30}/', $this->passwd))
      return $this->message = "Your password must be at least 7 characters long, including a letter and a number.";
  }

  private function checkNewUser() {
    if (strlen($this->login) > 30)
      return $this->message = "Your login must not exceed 30 characters.";
    $user = $this->getUser();
    if ($user)
      return $this->message = "this username is already used.";
    self::checkPassword();
    if ($this->message != null)
      return ;
    if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false)
      return $this->message = "Your email is not valid.";
  }

  public function sendConfirmationUser() {
    self::checkNewUser();
    if ($this->message)
      return ;
    $token = bin2hex(random_bytes(16));
    $pwrurl = "localhost:8080/camagru/pages/home.php?q=" . $token;
    date_default_timezone_set('Europe/Paris');
  	$date_creation = date("Y-m-d H:i:s");
    $token_expires = date("Y-m-d H:i:s", strtotime($date_creation . ' + 2 days'));
    try {
      $req = $this->db->prepare("INSERT INTO `users` (`login`, `mot_de_passe`, `email`, `date_creation`, `token`, `token_expires`) VALUES (?, ?, ?, ?, ?, ?)");
      $req->execute(array($this->login, hash('whirlpool', $this->passwd), $this->email, $date_creation, $token, $token_expires));
      $req = $this->db->prepare("DELETE FROM `users` WHERE `token_expires` < NOW() AND `confirm` = 0");
      $req->execute();
      require '../app/mailconfirm.php';
    }
    catch (Exception $e) {
      die('Error : ' . $e->getMessage());
    }
  }

  public function confirmUser() {
    try {
      $req = $this->db->prepare("SELECT * FROM `users` WHERE `token` = ?");
      $res = $req->execute(array($this->token));
      $user = $req->fetch(PDO::FETCH_ASSOC);
      if (!$user)
        return $this->message = "Your account has already been verified or the link has expired.";
      $req = $this->db->prepare("UPDATE `users` SET `confirm` = ?, `token` = ?, `token_expires` = ? WHERE `token` = ?");
      $req->execute(array(1, NULL, NULL, $this->token));
      $this->message = "Your account has been confirmed. welcome" . $user['login'] . " !";
    }
    catch (Exception $e) {
      die('Error : ' . $e->getMessage());
    }
  }

  public function connectUser() {
    try {
      $user = $this->getUser();
      if (!$user)
        return $this->message = "The user name entered does not belong to any account.";
      if ($user['confirm'] == 0)
        return $this->message = "Your account has not been validated yet. <br /> Please follow the link received by email.";
      if ($user['mot_de_passe'] != hash('whirlpool', $this->passwd))
        return $this->message = "Your password is incorrect.";
    }
    catch (Exception $e) {
      die('Error : ' . $e->getMessage());
    }
  }

  public function sendPassword() {
    try {
      $user = $this->getUser();
      if (!$user)
        return $this->message = "The user name entered does not belong to any account.";
      $email = $user['email'];
      $token = bin2hex(random_bytes(16));
      $pwrurl = "localhost:8080/camagru/pages/password.php?q=" . $token;
      date_default_timezone_set('Europe/Paris');
    	$date_creation = date("Y-m-d H:i:s");
      $token_expires = date("Y-m-d H:i:s", strtotime($date_creation . ' + 2 days'));
      $req = $this->db->prepare("UPDATE `users` SET `token` = ?, `token_expires` = ? WHERE `login` = ?");
      $req->execute(array($token, $token_expires, $this->login));
      $req = $this->db->prepare("UPDATE `users` SET `token` = ?, `token_expires` = ? WHERE `token_expires` < NOW() AND `confirm` = 1");
      $req->execute(array(NULL, NULL));
      require '../app/mailpassword.php';
    }
    catch (Exception $e) {
      die('Error : ' . $e->getMessage());
    }
  }

  public function resetPassword() {
    try {
      $req = $this->db->prepare("SELECT * FROM `users` WHERE `token` = ?");
      $res = $req->execute(array($this->token));
      $user = $req->fetch(PDO::FETCH_ASSOC);
      if (!$user)
        return $this->message = "The link has expired or has not been correctly followed.";
      self::checkPassword();
      if ($this->message != null)
        return ;
      $req = $this->db->prepare("UPDATE `users` SET `mot_de_passe` = ? WHERE `token` = ?");
      $req->execute(array(hash('whirlpool', $this->passwd), $this->token));
      $this->message = "Your password has been changed.";
    }
    catch (Exception $e) {
      die('Error : ' . $e->getMessage());
    }
  }
}
?>
