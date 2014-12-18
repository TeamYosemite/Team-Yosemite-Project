<?php
session_start();
include '../config.php';
include '../functions.php';
ifLoggedIn();
?>
<html>
<head>
    <title>Admin panel</title>
    <link rel="stylesheet" href="../styles/main.css" type="text/css"/>
	<meta charset="UTF-8" />
</head>
<body class="adminPanel">
    <h1>Hello, <?= $_SESSION['username'];?>! Welcome to Admin Panel.</h1><!--User-->

	<ul class="menu">
		<li><a href="index.php">Dashboard</a></li>
		<li><a href="post_create.php">Create new post</a></li>
		<li><a href="users_overview.php">Users overview</a></li>
		<li><a href="../logout.php">Logout</a></li>
	</ul>
	
    <h3>Table of all posts</h3>
	
	<table border="1">
		<tr>
			<th>Title</th>
			<th>Date added</th>
			<th>Time added</th>
			<th colspan="3">Action</th>
		</tr>
		<?php
		$all_posts = load_all_posts();
		
		foreach($all_posts as $post): ?>
			<tr>
				<td><?=$post['post_title']?></td>
				<td><?=date('d-m-Y', $post['post_dateCreated']);?></td>
				<td><?=date('H:i:s', $post['post_dateCreated']);?></td>
				<td><a href="post_edit.php?id=<?=$post['post_id'];?>">Edit</a></td>
				<td><a onclick="confirmDelete(<?=$post['post_id'];?>)" href="#">Remove</a></td>
				<td><a href="../view_post.php?id=<?=$post['post_id'];?>">View</a></td>
			</tr>
		<?php endforeach;?>
	</table>
	
	<script type='text/javascript' src='../scripts/postDeleteConfirm.js'></script>
</body>
</html>
