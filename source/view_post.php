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

<body class="indexPage">
	<header>
		<a href="index.php">A blog about beautiful Bulgaria</a>
	</header>
	
	<main class="clearfix">
		<article class="main-post">
			<h1 class="title"><?= addslashes($post['post_title']);?></h1>
			<p class="meta">
				<span class="clock"><?= date('D, j M Y', $post['post_dateCreated']);?></span> / 
				<span class="user"><?= addslashes($post['post_author']);?></span> / 
				<span class="comments"><?= countPostComments($post['post_id']);?> comments</span>
			</p>
		
			<h2 class="description"><?= addslashes($post['post_description']);?></h2>
			<div class="content"><?= addslashes($post['post_content']);?></div>
			
			<p class="meta">
				<span class="tags"><?= addslashes(implode(', ', load_tags($post['post_id'])));?></span> /
				<span class="views"><?= $post['post_timesSeen'];?></span>
			</p>
		</article>
	
		<article>
		
		<h4 class="comments-count"><?= count($comments);?> comment(s):</h4>
		
		<?php foreach($comments as $comment): ?>
				<div class="comment">
					<div id="comment-header">
						<span class="name"><?= $comment['comment_name'];?></span>
						<span class="published"><?= date('D, j M Y, H:i:s', $comment['comment_dateCreated']);?></span>
					</div>
					<p><?= $comment['comment_content'];?></p>
				</div>
		<?php endforeach; ?>
	
			<form method="post" action="add_comment.php" class="add-comment">
				<input type="text" name="name" placeholder="Your name">
				<input type="text" name="email" placeholder="E-mail">
				<textarea name="comment"></textarea>
				<input type="hidden" value="<?= $post_id;?>" name="post_id">
				<input type="submit" name="submit">
			</form>
		</article>
	</main>
</body>

<?php

include 'templates/footer.php';