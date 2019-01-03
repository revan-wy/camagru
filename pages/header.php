<header> 
	<div class="headercontainer">
		<div class="title">
<?=			'Camagru';?>
		</div>
		<nav>
<? 			if (isset($_SESSION['active_user'])):?>
					<a id="" href="webcam.php">Photobooth</a>
					<a id="" href="mygallery.php">My&nbsp;Gallery</a>
					<a id="" href="gallery.php?page=1">Main&nbsp;Gallery</a>
					<a id="" href="logout.php">Log&nbsp;Out</a>
<?			else:?>
					<a id="" href="home.php">Log&nbsp;In</a>
<?			endif;?>
		</nav>
	</div>
</header>