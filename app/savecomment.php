<?php //untested 

	//remove before flight
	ini_set('display_errors', 'On');

	$headers = getallheaders();
	/*if ($headers["Content-type"] == "application/x-www-form-urlencoded") {
		$stuff = json_decode(file_get_contents("php://input"), true);
		var_dump($stuff);
	}*/
	session_start();
	$comment = $_POST['comment'];
	$pic_id = $_POST['pic_id'];
	//debug_to_console($comment);
	require '../class/comments.class.php';
	if ($comment !== null) {
		$com = new Comments($pic_id, $_SESSION['logged_user'], $comment);
		$com->addComment();
	}
	//$com->setPicId($pic_id);
	echo $com->login;
?>

<?
// <!--<script>
// 	function debug_to_console($data) {
// 		$output = $data;
// 		if ( is_array( $output ) )
// 			$output = implode( ',', $output);
// 		console.log(Debug Objects: " . $output . "' );
// 		//echo "renzo";
// 	}
//</script>-->
?>