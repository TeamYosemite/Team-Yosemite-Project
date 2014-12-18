<?php

include 'config.php';
include 'functions.php';
include 'templates/header.php';

if(isset($_GET['search']) && $_GET['search'] != null) {
	$searchTags = explode(' ', $_GET['search']);
	
	$posts = load_posts_by_tags($searchTags);
	?>
	<body class="indexPage">
		<header>
			<a href="index.php">A blog about beautiful Bulgaria</a>
		</header>
		<main class="clearfix">
			<h3>Searching for: <?= $_GET['search'];?></h3>
			<aside>
				<form method="GET" action="search.php" id="search">
					<input type="text" name="search" value="<?= $_GET['search'];?>" placeholder="Search..." />
					<input type="submit" value="Search" />
				</form>
			</aside>
	<?php
	if(empty($posts)) {
	?>
		<article><p>Nothing found</p></p>
	<?php
	}
	else {
	?>
			<?php foreach($posts as $post):?>
				<article>
					<h3 class="title"><?= addslashes($post['post_title']);?></h3>
					<p class="meta">
						<span class="clock"><?= date('D, j M Y', $post['post_dateCreated']);?></span> / 
						<span class="user"><?= addslashes($post['post_author']);?></span> / 
						<span class="comments"><?= countPostComments($post['post_id']);?> comments</span>
					</p>
					<p class="description"><?= addslashes($post['post_description']);?></p>
					<a href="view_post.php?id=<?= $post['post_id'];?>" class="read-more">Read more</a>
					<p class="meta">Tags: <?= addslashes(implode(', ', load_tags($post['post_id'])));?></p>
				</article>
			<?php endforeach;?>
	<?php
	}
	?>
		</main>
	<?php
}
else {
	header('Location: index.php');
	exit;
}

include 'templates/footer.php';