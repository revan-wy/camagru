<?php

	//remove before flight
	ini_set('display_errors', 'On');

	$headers = 'MIME-Version: 1.0'."\n";
	$headers .= 'Content-type: text/html; charset=UTF-8'."\n";
	$headers .= "From: camagru-noreply@student.wethinkcode.co.za\n";
	$mailbody = "<html><body>";
	$mailbody .= "<p>Hi, ".$login_pic."</p>";
	$mailbody .= "<p>".$this->login." posted a new comment on your picture: \"".$this->comments."\"</p>";
	$mailbody .= "<p>Regards,</p>";
	$mailbody .= "<p>Camagru</p>";
	$mailbody .= "</body></html>";
	mail($email, "Camagru - New Comment", $mailbody, $headers);

?>