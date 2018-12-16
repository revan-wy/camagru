<header>
    <div class="headercontainer">
      <div class="title">Camagru</a></div>
      <nav>
        <? if ($_SESSION['logged_user'] !== null): ?>
          <a id="" href="webcam.php">Photobooth</a>
          <a id="" href="mygallery.php">My gallery</a>
          <a id="" href="gallery.php?page=1">Gallery</a>
          <a id="" href="logout.php">Log out</a>
        <? else: ?>
          <a id="" href="home.php">To log in</a>
        <? endif; ?>
      </nav>
    </div>
</header>
