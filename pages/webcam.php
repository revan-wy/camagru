<?php //untested 

	//remove before flight
	ini_set('display_errors', 'On');

	session_start();
	if ($_SESSION['logged_user'] === null)
		header("Location: ../index.php");

?>

<html>
	<head>
		<meta charset="utf-8" name="viewport" content="width=device-width, inital-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<link rel="stylesheet" href="../public/css/webcam.css">
		<link rel="stylesheet" href="../public/css/headerfooter.css">
		<title>Camagru</title>
	</head>
	<body>
		<?php include 'header.php'; ?>
		<div class="allwebcam">
			<main class="webcampreview">
				<div class="webcam" id="column1">
					<video id="video"></video><br />
					<button id="startbutton">Shutter, go!</button>
					<button id="img1" style=background-color:#f2f2f2><img src="../public/img/image1.png" width=100/></button>
					<button id="img2" style=background-color:#f2f2f2><img src="../public/img/image2.png" width=100/></button>
					<button id="img3" style=background-color:#f2f2f2><img src="../public/img/image3.png" width=100/></button>
					<p>
						OR<br />
						Upload a picture<br /><span id="alinea">(jpeg, png | max 1.5 Mo)</span>
					</p>
					<label class="file" title="">
						<input type="file" accept="image/*" name="uploadpic" id="uploadpic" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/,''))"/>
					</label>
					<input id="uploadsubmitbutton" type="submit" value="Merge Images" name="submit">
				</div>
				<div class="preview">
					<canvas id="canvas"></canvas><br />
					<button id="savebutton">Save</button>
				</div>
			</main><br />
			<aside id="side">
				<?php
					require '../class/pictures.class.php';
					$pic = new Pictures("", "", $_SESSION['logged_user']);
					$res = $pic->getPicture();
					foreach ($res as $value): ?>
						<div class="displaypic">
							<img class="minipic" src="data:image/jpeg;base64,<?= base64_encode($value['pic']) ?>"/>
							<img class="deletepic" id="delete_<?= $value['pic_id'] ?>" onclick="deletePicture(<?= $value['pic_id'] ?>)" src="../public/img/delete.png"/>
						</div>
					<? endforeach; ?>
			</aside>
			<script type="application/javascript" src="../public/js/webcam.js"></script>
		</div>
		<footer></footer>
	</body>
</html>