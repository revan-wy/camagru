<html> 
	<head>
		<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<title>Send Reset Link</title>
		<link rel="stylesheet" href="../public/css/home.css">
		<link rel="stylesheet" href="../public/css/headerfooter.css">
	</head>
	<body>
		<?php include 'header.php';?>
		<h2>Forgot Your Camagru Password?</h2>
		<form class="" action="#" method="post">
		User Name<br /><input type="text" name="login" value=""><br />
			<input id="buttonforgot" class="button" type="submit" name="submit" value="Send Reset Link">
		</form>
		<?php
			require '../class/users.class.php';
			if (isset($_POST['submit']))
				if ($_POST['submit'] == "Send Reset Link")
					if (!empty(htmlentities($_POST['login']))) {
						$login = trim(htmlentities($_POST['login']));
						$db = new Users($login, "", "", "", "");
						$db->sendPassword();
						if ($db->message)
							echo '<p style="color:red;">'.$db->message.'</p>';
					}
		?>
		<footer></footer>
	</body>
</html>