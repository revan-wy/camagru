<?php

	//remove before flight
	ini_set('display_errors', 'On');

	$headers = 'MIME-Version: 1.0'."\n";
	$headers .= 'Content-type: text/html; charset=UTF-8'."\n";
	$headers .= "From: camagru-noreply@student.wethinkcode.co.za\n";
	$mailbody = "<html><body>";
	$mailbody .= "<p>Hi, ".$this->login."</p>";
	$mailbody .= "<p>Please follow the link below to reset your Camagru password. The link will expire after 48 hours. </p>";
	$mailbody .= "<p><a href=http://".$pwrurl.">Click here</a></p>";
	$mailbody .= "<p>Regards, </p>";
	$mailbody .= "<p>Camagru</p>";
	$mailbody .= "</body></html>";

	if (mail($email, "Camagru - Reset Password", $mailbody, $headers))
		$this->message = "An email has been sent with a password reset link. ";
	else
		$this->message = "The reset link email could not be sent.";

?>