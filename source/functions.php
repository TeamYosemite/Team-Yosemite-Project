<?php
function load_posts($db, $currentPage) {
	$postsCount = $db->query('SELECT COUNT(post_id) FROM posts')->fetchColumn();
	$postsLimit = 5;
	$allPages = ceil($postsCount / $postsLimit);
	
	if(!is_numeric($currentPage) || $currentPage <= 0 || $currentPage > $allPages) {
		header('Location: index.php');
		exit;
	}
	
	$offset = ($currentPage - 1) * $postsLimit;
	$stmt = $db->prepare('SELECT `post_id`, `post_title`, `post_description`, `post_author`, `post_dateCreated`, `post_timesSeen` FROM posts ORDER BY post_id DESC LIMIT :limit OFFSET :offset');
    $stmt->bindParam(':limit', $postsLimit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

	while($row = $stmt->fetch()) {
	$dateCreated = new DateTime($row['post_dateCreated']);
	?>
		<article>

			<h3><a href="view_post.php?id=<?= $row['post_id'];?>"><?= $row['post_title'];?></a></h3>
			<p><?= $row['post_description'];?>'</p>
			<p><a href="view_post.php?id=<?= $row['post_id'];?>">Read more</a></p>
			<p>Posted on <?= $dateCreated->format('d-m-Y H:i:s');?></p>
		</article>
		<hr />
	<?php
	}
	
    $previouslink = ($currentPage > 1) ? '<a href="?page=1" title="First page">&laquo;</a> <a href="?page=' . ($currentPage - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

    $nextlink = ($currentPage < $allPages) ? '<a href="?page=' . ($currentPage + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $allPages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';
?>
	<div id="paging">
		<p>
			<?= $previouslink;?>
			Page <?= $currentPage;?> of <?= $allPages;?>
			<?= $nextlink;?>
		</p>
	</div>
<?php	
}