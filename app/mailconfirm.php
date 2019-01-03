<?php

	//remove before flight
	ini_set('display_errors', 'On');

	$headers = 'MIME-Version: 1.0'."\n";
	$headers .= 'Content-type: text/html; charset=UTF-8'."\n";
	$headers .= "From: camagru-noreply@student.wethinkcode.co.za\n";
	$mailbody = "<html><body>";
	$mailbody .= "<p>Hi, ".$this->login."</p>";
	$mailbody .= "<p>To activate your Camagru account, please follow the link below. This link will expire after 48 hours.</p>";
	$mailbody .= "<p><a href=http://".$pwrurl.">Click here</a></p>";
	$mailbody .= "<p>Regards,</p>";
	$mailbody .= "<p>Camagru</p>";
	$mailbody .= "</body></html>";

	if (mail($this->email, "Camagru - Account Activation", $mailbody, $headers))
		$this->message = "An activation email has been sent to the address you provided.";
	else
		return $this->message = "Activation email could not be sent.";

?>