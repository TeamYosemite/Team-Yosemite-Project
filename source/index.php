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
				<h3><a href="view_post.php?id=<?= $post['post_id'];?>"><?= $post['post_title'];?></a></h3>
				<p><?= $post['post_description'];?></p>
				<p>Tags: <?= implode(', ', load_tags($post['post_id']));?></p>
				<p><a href="view_post.php?id=<?= $post['post_id'];?>">Read more</a></p>
				<p>Posted on <?= date('d-m-Y H:i:s', $post['post_dateCreated']);?></p>
			</article>
		<?php endforeach;?>
	</main>

	<?php
		$totalPages = $data['totalPages'];
		$previouslink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';
		$nextlink = ($page < $totalPages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $totalPages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';
	?>
	<div id="paging">
		<p>
			<?= $previouslink;?>
			Page <?= $page;?> of <?= $totalPages;?>
			<?= $nextlink;?>
		</p>
	</div>
<?php

include 'templates/footer.php';