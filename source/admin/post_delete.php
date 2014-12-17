<?php
session_start();
include '../config.php';
include '../functions.php';
ifLoggedIn();

$id = $_GET['id'];

if(is_numeric($id)) {
	deletePost($id);
}

header('Location: index.php');
exit;