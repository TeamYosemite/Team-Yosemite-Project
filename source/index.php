<?php

include 'config.php';
include 'functions.php';
include 'templates/header.php';

?>

<body class="indexPage">
	<header>
		<a href="index.php">A blog about beautiful Bulgaria</a>
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
			
			<h3 class="meta">Blog archive</h3>
			<ul class="posts-archive" class="years">
			<?php
			$posts_archive = load_post_archive();
			foreach($posts_archive as $year => $year_posts):
			?>
				<li><span class="years"><?= $year;?></span>
					<ul class="months">
					<?php foreach($year_posts as $month => $month_posts):?>
						<li>
							<a href="javascript: toggleChildren('<?= $year . '-' . $month;?>');"><?= $month;?></a> (<?= count($month_posts);?>)
							<ul id="<?= $year . '-' . $month;?>" class="month-posts">
							<?php foreach($month_posts as $post):?>
								<li><a href="view_post.php?id=<?= $post['post_id'];?>"><?= $post['post_title'];?></a></li>
							<?php endforeach;?>
							</ul>
						</li>
					<?php endforeach;?>
					</ul>
				</li>
			<?php endforeach;?>
			</ul>
			
			<h3 class="meta">Tags frequency</h3>
			<div class="tags-frequency">
			<?php
				$tags_grequency = load_tags_frequency();
				
				foreach($tags_grequency['tags'] as $tag => $frequency):
					$percent = floor(($frequency / $tags_grequency['totalCounter']) * 100);
					$class = '';
					
					switch ($percent) {
						case $percent < 10:
							$class = 'smallest';
							break;
						case $percent >= 10 and $percent < 20:
							$class = 'small';
							break;
						case $percent >= 20 and $percent < 30:
							$class = 'medium';
							break;
						case $percent >= 30 and $percent < 40:
							$class = 'large';
							break;
						default:
							$class = 'largest';
							break;
					}
				?>
					<a href="search.php?search=<?= $tag;?>" class="<?= $class;?>"><?= $tag;?></a>
				<?php endforeach; ?>
			</div>
		</aside>
		<?php foreach($data['posts'] as $post):?>
			<article>
				<h3 class="title"><?= addslashes($post['post_title']);?></h3>
				<p class="meta">
					<span class="clock"><?= date('D, j M Y', $post['post_dateCreated']);?></span> / 
					<span class="user"><?= addslashes($post['post_author']);?></span> / 
					<span class="comments"><?= countPostComments($post['post_id']);?> comments</span>
				</p>
				<p class="description"><?= addslashes($post['post_description']);?></p>
				<a href="view_post.php?id=<?= $post['post_id'];?>" class="read-more">Read more</a>
				<p class="meta"><span class="tags"><?= addslashes(implode(', ', load_tags($post['post_id'])));?></span></p>
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
	<script type="text/javascript" src="scripts/archivePosts.js"></script>
<?php

include 'templates/footer.php';