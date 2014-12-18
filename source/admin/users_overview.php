<?php
session_start();
include '../config.php';
include '../functions.php';
ifLoggedIn();
?>
<html>
<head>
    <title>Admin panel - Users</title>
    <link rel="stylesheet" href="../styles/main.css" type="text/css"/>
	<meta charset="UTF-8" />
</head>
<body class="adminPanel">
	<ul class="menu">
		<li><a href="index.php">Dashboard</a></li>
		<li><a href="post_create.php">Create new post</a></li>
		<li><a href="users_overview.php">Users overview</a></li>
		<li><a href="../logout.php">Logout</a></li>
	</ul>
	<a href="user_create.php" ><h3> Create a new user</h3></a>
    <h3>Table of all users</h3>
	
	<table border="1">
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Password</th>
			<th colspan="3">Action</th>
		</tr>
		<?php
		$all_users = load_all_users();
		
		foreach($all_users as $user): ?>
			<tr>
				<td><?=$user['user_id']?></td>
				<td><?=$user['user_name']?></td>
				<td><?=$user['user_password']?></td>
				<td><a onclick="confirmDelete(<?=$user['user_id'];?>)" href="#">Remove</a></td>
			</tr>
		<?php endforeach;?>
	</table>
	
	<script type='text/javascript' src='../scripts/userDeleteConfirm.js'></script>
</body>
</html>