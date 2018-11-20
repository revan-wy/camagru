<?php //untested 

	//remove before flight
	//ini_set('display_errors', 'On');

	session_start();
	$comment = $_POST['comment'];
	$pic_id = $_POST['pic_id'];
	require '../class/comments.class.php';
	if ($comment !== null) {
		$com = new Comments($pic_id, $_SESSION['logged_user'], $comment);
		$com->addComment();
	}

?>