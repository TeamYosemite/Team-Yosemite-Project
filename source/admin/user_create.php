<?php
session_start();
include '../config.php';
include '../functions.php';
ifLoggedIn();

$isError = false;
$errorMessage = '';
$isValidUser = false;

if (isset($_POST['submit'])) {
    $user_name = isset($_POST['username']) && $_POST['username'] != '' ? $_POST['username'] : '';
    $password = isset($_POST['password']) && $_POST['password'] != '' ? md5($_POST['password']) : '';

	try {
        $isValidUser = isUserValid($user_name, $password);
    } catch(Exception $e) {
        $isError = true;
        $errorMessage = $e->getMessage();
    }
	
    if($isValidUser) {
		$user_id = getLastUserId();
		$user_id = $user_id['user_id'];
		$user_id = $user_id + 1;
        createUser($user_id, $user_name, $password);
		
		header('Location: users_overview.php');
		exit;
    }
}

?>
<html>
<head>
    <title>Admin panel - Users</title>
    <link rel="stylesheet" href="../styles/main.css" type="text/css"/>
</head>
<body class="adminPanel">
    <h1>Hello, <?= $_SESSION['username'];?>! Welcome to Admin Panel.</h1><!--User-->
	
    <h3>Create user</h3>
	<?= $isError ? "<p class=\"error\">{$errorMessage}</p>" : null;?>
    <form method="post" class="loginForm">
        <input type="text" name="username" placeholder="Username"/>
        <input type="password" name="password" placeholder="Password"/>
        <input type="submit" name="submit" />
    </form>
</body>
</body>
</html>