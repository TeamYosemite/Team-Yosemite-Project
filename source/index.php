<?php

include 'config.php';
include 'functions.php';
include 'templates/header.php';

?>

<body class="indexPage">
	<header>
		<p>A blog about Beautiful Bulgaria</p>
	</header>

	<?php
		$page = isset($_GET['page']) && $_GET['page'] != null ? $_GET['page'] : 1;
		$data = load_posts($page);
	?>

	<main class="clearfix">
		<aside>
			<form method="GET" action="search.php" id="search">
				<input type="text" name="search" placeholder="Search..." />
				<input type="submit" value="Search" />
			</form>
		</aside>
		<?php foreach($data['posts'] as $post):?>
			<article>
				<h3 class="title"><?= htmlentities($post['post_title']);?></h3>
				<p class="meta">
					<span class="clock"><?= date('D, j M Y', $post['post_dateCreated']);?></span> / 
					<span class="user"><?= htmlentities($post['post_author']);?></span> / 
					<span class="comments"><?= countPostComments($post['post_id']);?> comments</span>
				</p>
				<p class="description"><?= htmlentities($post['post_description']);?></p>
				<a href="view_post.php?id=<?= $post['post_id'];?>" class="read-more">Read more</a>
				<p class="meta">Tags: <?= htmlentities(implode(', ', load_tags($post['post_id'])));?></p>
			</article>
		<?php endforeach;?>

		<?php
			$totalPages = $data['totalPages'];
			$previouslink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';
			$nextlink = ($page < $totalPages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $totalPages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';
		?>
		<article id="paging">
			<p>
				<?= $previouslink;?>
				<span>Page <?= $page;?> of <?= $totalPages;?></span>
				<?= $nextlink;?>
			</p>
		</article>
	</main>
<?php

include 'templates/footer.php';