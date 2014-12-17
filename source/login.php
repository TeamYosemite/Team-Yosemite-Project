<?php
session_start();
include "config.php";
include "functions.php";

$isError = false;
$errorMessage = '';

if (isset($_POST['submit'])) {
    $user_name = isset($_POST['username']) && $_POST['username'] != '' ? $_POST['username'] : '';
    $password = isset($_POST['password']) && $_POST['password'] != '' ? md5($_POST['password']) : '';

	try {
		validateUserData($user_name, $password);
		validateLogin($user_name, $password);
		
		$_SESSION['username'] = $user_name;
		$_SESSION['is_logged'] = true;
		
		header('Location: admin/');
		exit;
	} catch(Exception $e) {
        $isError = true;
        $errorMessage = $e->getMessage();
    }
}

include 'templates/header.php';
?>

<body class="loginForm">
	<?= $isError ? "<p class=\"error\">{$errorMessage}</p>" : null;?>
    <form method="post">
        <h1>Hello Stranger</h1>
        <input type="text" name="username" placeholder="Username"/>
        <input type="password" name="password" placeholder="Password"/>
        <input type="submit" name="submit" />
    </form>
</body>