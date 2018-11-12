<?php //untested and incomplete

	//remove before flight
	ini_set('display_errors', 'On')

	session_start();
	require_once '../class/users.class.php'; //file incomplete

?>

<html>
	<head>
		<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<link rel="stylesheet" href="../public/css/home.css"> <!--file incomplete-->
		<link rel="stylesheet" href="../public/css/headerfooter.css"> <!--file incomplete-->
		<title>Camagru Login2</title>
	</head>
	<body>
		<h1 class=title id=maintitle>Camagru</h1>
		<div class="login">
			<h2>Log In</h2>
			<form class="" action="#" method="post">
				User Name<br /><input type="text" name="login" value=""><br />
				Password<br /><input type="password" name="passwd" value=""><br /><br />
				<input class="button" type="submit" name="submit" value="OK">
			</form>
			<a href="forgot.php" id="forgot">Forgot Password?</a> <!--file incomplete-->
		</div>
		<?php
			if (isset($_POST['login']) and isset($_POST['passwd']))
			{
				if (!empty(htmlentities($_POST['login'])) and !empty(htmlentities	($_POST['passwd'])) and $_POST['submit'] == "OK")
				{
					$login = trim(htmlentities($_POST['login']));
					$passwd = htmlentities($_POST['passwd']);
					$db = new Users($login, $passwd, "", "", "");
					$db->connectUser();
					if ($db->message)
						echo '<div style="color:red;">'.$db->message.'</div>';
					else
					{
						$_SESSION['logged_user'] = $login;
						echo '<script> location.replace(../index.php); </script>';
					}
				}
			}
		?>

	</body>
</html>