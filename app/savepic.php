<?php //untested

	//remove before flight
	ini_set('display_errors', 'On');

	session_start();
	$rawpic = $_POST['pic'];
	$pic = base64_decode($rawpic);
	require '../class/pictures.class.php';
	$db = new Pictures("", $pic, $_SESSION['logged_user']);
	$pic_id = $db->addPicture();
	echo json_encode($pic_id);

?>