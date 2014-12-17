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
			<p>A blog about Beautiful Bulgaria</p>
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
		<p>Nothing found</p>
	<?php
	}
	else {
	?>
			<?php foreach($posts as $post):?>
				<article>
					<h3><a href="view_post.php?id=<?= $post['post_id'];?>"><?= $post['post_title'];?></a></h3>
					<p><?= $post['post_description'];?></p>
					<p>Tags: <?= implode(', ', load_tags($post['post_id']));?></p>
					<p><a href="view_post.php?id=<?= $post['post_id'];?>">Read more</a></p>
					<p>Posted on <?= date('d-m-Y H:i:s', $post['post_dateCreated']);?></p>
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