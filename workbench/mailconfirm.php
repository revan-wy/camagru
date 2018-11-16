<?php //untested and incomplete

	//remove before flight
	ini_set('display_errors', 'On');

	$headers = 'MIME-Version: 1.0'."\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1'."\n";
	$headers .= "From: camagru-noreply@student.wethinkcode.co.za\n";
	$mailbody = "<html><body>";
	$mailbody .= "<p>Hi,".$this->login."</p>";
	$mailbody .= "<p>Please confirm your new Camagru by clicking on the link below. The link will expire in 48 hours and you will have to register again.";
	$mailbody .= "<a href=http://".."></a></p>"



?>