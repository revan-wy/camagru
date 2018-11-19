<?php //untested and incomplete

	//remove before flight
	ini_set('display_errors', 'On');

	session_start();
	if ($_SESSION['logged_user'] === null)
		header("Location: ../index.php");

?>

<html>
	<head>
		<meta>
	</head>
</html>