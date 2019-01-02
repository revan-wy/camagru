<header> 
	<div class="headercontainer">
		<div class="title">
<?=			'Camagru';?>
		</div>
		<nav>
<? 			if (isset($_SESSION['logged_user'])):
				//if ($_SESSION['logged_user'] !== null):?>
					<a id="" href="webcam.php">Photobooth</a>
					<a id="" href="mygallery.php">My Gallery</a>
					<a id="" href="gallery.php?page=1">Main Gallery</a>
					<a id="" href="logout.php">Log Out</a>
<?			else:?>
					<a id="" href="home.php">Log In</a>
<?			endif;?>
		</nav>
	</div>
</header>