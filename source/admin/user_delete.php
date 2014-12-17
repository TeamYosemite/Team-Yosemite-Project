<?php
session_start();
include '../config.php';
include '../functions.php';
ifLoggedIn();

$id = $_GET['id'];

if(is_numeric($id)) {
	deleteUser($id);
}

header('Location: users_overview.php');
exit;