<html> <!--untested -->
	<head>
		<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<title>Reset Password</title>
		<link rel="stylesheet" href="../public/css/home.css">
		<link rel="stylesheet" href="../public/css/headerfooter.css">
	</head>
	<body>
		<?php include 'header.php';?>
		<h2>Reset Your Camagru Password</h2>
		<form class="" action="#" method="post"><br />
			<input id="buttonforgot" class="button" type="submit" name="submit" value="OK">
		</form>
		<?php
			require '../class/users.class.php';
			if (!empty(htmlentities($_POST['login'])) && $_POST['submit'] == "OK") {
				$login = trim(htmlentities($_POST['login']));
				$db = new Users($login, "", "", "", "");
				$db->sendPassword();
				if ($db->message)
					echo '<p style="color:red;">'.$db->message.'</p>';
			}
		?>
	</body>
<html>