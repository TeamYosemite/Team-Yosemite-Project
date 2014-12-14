<?php
function load_posts($db) {
	$stmt = $db->query('SELECT `post_id`, `post_title`, `post_description`, `post_author`, `post_dateCreated`, `post_timesSeen` FROM posts');
	while($row = $stmt->fetch()) {
	$dateCreated = new DateTime($row['post_dateCreated']);
	?>
		<article>

			<h3><a href="view_post.php?id=<?= $row['post_id'];?>"><?= $row['post_title'];?></a></h3>
			<p><?= $row['post_description'];?>'</p>
			<p><a href="view_post.php?id=<?= $row['post_id'];?>">Read more</a></p>
			<p>Posted on <?= $dateCreated->format('d-m-Y H:i:s');?></p>
		</article>
	<?php
	}
}