<?php //untested 

	//remove before flight
	//ini_set('display_errors', 'On');

	session_start();
	if (session_destroy())
		header("Location: ../index.php");

?>