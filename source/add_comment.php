<?php

include 'config.php';
include 'functions.php';

if($_POST['submit']) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$comment = $_POST['comment'];
	$post_id = $_POST['post_id'];

	if(validComment($name, $email, $comment)) {
		createComment($name, $email, $comment, $post_id);
	}
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;