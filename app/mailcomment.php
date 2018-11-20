<?php //untested

	//remove before flight
	//ini_set('display_errors', 'On');

	$headers = 'MIME-Version: 1.0'."\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1'."\n";
	$headers .= "From: camagru-noreply@student.wethinkcode.co.za\n";
	$mailbody = "<html><body>";
	$mailbody .= "<p>Hi, ".$login_pic."</p>";
	$mailbody .= "<p>".$this->login." posted a new comment on your picture: \"".$this->comment."\"</p>";
	$mailbody .= "<p>Regards,</p>";
	$mailbody .= "<p>Camagru</p>";
	$mailbosy .= "</body></html>";
	mail($email, "Camagru - New Comment", $mailbody, $headers);

?>