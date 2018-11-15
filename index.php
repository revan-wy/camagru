<?php //untested and incomplete

//remove before flight
ini_set('display_errors', 'On');
session_start();
if (!isset($_SESSION['logged_user']))
{
	require_once('config/setup.php');
	header("Location: pages/home.php"); //file incomplete
}
else
	header("Location: pages/webcam.php"); //file incomplete

?>