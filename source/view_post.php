<?php

include 'config.php';
include 'functions.php';
include 'templates/header.php';

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
	$post_id = $_GET['id'];
	$post = '';
	$comments = [];
	$tags = [];
	
	try {
		$post = load_post($post_id);
		$comments = load_comments($post_id);
		$tags = load_tags($post_id);
		updatePostView($post_id, $post['post_timesSeen'] + 1);
	}
	catch(Exception $e) {
		header('Location: index.php');
		exit;
    }
}
else {
	header('Location: index.php');
	exit;
}
?>

<body class="viewPost">
	<section id="post">
		<h1 class="title"><?= $post['post_title'];?></h1>
		<h2 class="description"><?= $post['post_description'];?></h2>
		<div class="content"><?= $post['post_content'];?></div>
		
		<p class="published">Published on <?= date('d/m/y', $post['post_dateCreated']);?></p>
		<p class="author">Author: <?= $post['post_author'];?></p>
		<p class="tags">Tags: <?= implode(', ', $tags);?></p>
		<p class="visits">Visits: <?= $post['post_timesSeen'];?></p>
	</section>
	
	<?php foreach($comments as $comment): ?>
			<article>
				<p class="name"><?= $comment['comment_name'];?></p>
				<p class="published"><?= date('d-m-Y H:i:s', $comment['comment_dateCreated']);?></p>
				<p class="content"><?= $comment['comment_content'];?></p>
			</article>
	<?php endforeach; ?>
	
	<form method="post" action="add_comment.php">
		<input type="text" name="name" placeholder="Your name">
		<input type="text" name="email" placeholder="E-mail">
		<textarea name="comment"></textarea>
		<input type="hidden" value="<?= $post_id;?>" name="post_id">
		<input type="submit" name="submit">
	</form>
</body>

<?php

include 'templates/footer.php';