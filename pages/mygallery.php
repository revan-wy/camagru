<?php //untested 

	//remove before flight
	//ini_set('display_errors', 'On');

	session_start();
	if ($_SESSION['logged_user'] === null)
		header("Location: ../index.php");

?>

<html>
	<head>
		<meta charset="utf-8" name="viewport" content="width=defice-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<link rel="stylesheet" href="../public/css/gallery.css">
		<link rel="stylesheet" href="../public/css/headerfooter.css">
		<title>Camagru Main Gallery</title>
	</head>
	<body>
		<?php include 'header.php'; ?>
		<main class="allgallery">
			<?php 
				require '../class/pictures.class.php';
				$pic = new Pictures("", "", $_SESSION['logged_user']);
				$nbpicbypage = 5;
				$page = isset($_GET['page']) ? $_GET['page'] : 1;
				$nbpic = $pic->nbPicturesByLogin();
				$nbpage = ceil($nbpic / $nbpicbypage);
				if ($nbpic == 0): ?>
					<p>Get your first pic (copy from earlier page)</p>
				<? elseif ($page > $nbpage || preg_match('/^[0-9]*$/', $page) == 0):
					echo '<script>location.replace("mygallery.php?page=1")</script>';
				else:
					$pics = $pic->getPicturesByPageByLogin((($page - 1) * $nbpibbypage), $nbpicbypage);
					require '../class/likes.class.php';
					require '../class/comments.class.php';
					foreach ($pics as $value):
						$pic_ic = $value['pic_id'];
						$user = $_SESSION['logged_user'];
						$like = new Likes($pic_id, $user);
						$liked = $like->getLike();
						$nblike = $like->nbLike();
						$comment = new Comments($pic_id, "", "");
						$comments = $comment->getComment;
				?>
				<div class="picgallery">
					<div class="login" id="login_<?= $pic_id?>"><?= $value['login']?></div>
					<img class="pic" id="pic_<?= $pic_id?>" src="data:image/jpeg;base64,<?= base64_encode($value['pic'])?>">
					<img class="deletepic" id="delete_<?= $pic_id?>" onclick="deletePicture(<?= $pic_id?>)" src="../public/img/delete.png">
					<div class="likeandcomment">
						<? if ($_SESSION['logged_user'] !== null): ?>
							<? if ($liked === false): ?>
								<button onclick="addLike(<?= $pic_id ?>)" class="like"><img id=like_<?= $pic_id ?> src="../public/img/like.png"/></button>
							<? else: ?>
								<button onclick="addLike(<?= $pic_id ?>)" class="like"><img id=like_<?= $pic_id ?> src="../public/img/like_red.png"></button>
							<? endif; ?>
						<? else: ?>
							<button class="like"><img src="../public/img/like.png"></button>
						<? endif; ?>
						<label for="new_comment_<?= $pic_id ?>" class="comment"><img id="comment_<?= $pic_id ?>" src="../public/img/comment.png"></label>
						<span class="nblike" id="nblike_<?= $pic_id ?>"><?= $nblike ?>Like</span>
					</div>
					<div id="firstcomment_<?= $pic_id ?>">
						<? foreach ($comments as $line): ?>
							<div class="allcomments"><b><?= $line['login'] ?></b><?= $line['comment'] ?></div>
						<? endforeach; ?>
					</div>
					<form method="post">
						<?php if ($_SESSION['logged_user'] !== null): ?>
							<input type="text" maxlength="255" onkeypress="{if (event.keyCode == 13) {event.preventDefault(); addComment(<?= $pic_id ?>, this, '<?= $user ?>')}}" class="inputcomment" id="new_comment_<?= $pic_id ?>" name="new_comment_<?= $pic_id ?>" placeholder="Add a comment">
						<? endif; ?>
					</form>
				</div>
					<? endforeach; ?>
					<div class="pages">
						<? if ($page != 1): ?>
							<a href="mygallery.php?page=<?= ($page - 1) ?>" class="previous">Previous</a>
						<? endif; ?>
						<span class="pagenumber"><b><?= $page ?></b></span>
						<? if ($page != $nbpage): ?>
							<a href="mygallery.php?page=<?= ($page + 1) ?>" class="next">Next</a>
						<? endif; ?>
					<? endif; ?>
					</div>
		</main>
		<footer></footer>
		<script type="text/javascript" src="../public/js/gallery.js"></script>
	</body>
</html>