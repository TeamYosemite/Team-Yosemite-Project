<?php

function load_posts($page) {
	global $db;
	
	$posts = [];

	$postsCount = $db->query('SELECT COUNT(post_id) FROM posts')->fetchColumn();
	$postsLimit = 5;
	$allPages = ceil($postsCount / $postsLimit);
	
	if(!is_numeric($page) || $page <= 0 || $page > $allPages) {
		header('Location: index.php');
		exit;
	}
	
	$offset = ($page - 1) * $postsLimit;
	$stmt = $db->prepare('SELECT `post_id`, `post_title`, `post_description`, `post_author`, `post_dateCreated`, `post_timesSeen` FROM posts ORDER BY post_id DESC LIMIT :limit OFFSET :offset');
    $stmt->bindParam(':limit', $postsLimit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
	
	while($row = $stmt->fetch()) {
		$posts[] = $row;
	}
	
	return [ 'posts' => $posts, 'totalPages' => $allPages ];
}

function load_post($id) {
	global $db;

	$stmt = $db->prepare("SELECT * FROM `posts` WHERE `post_id` = :post_id");
    $stmt->bindParam('post_id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if(count($post) == 0) {
		throw new Exception('There is no such post!');
	}
	
	return $post[0];
}

function ifLoggedIn(){
   if(!(isset($_SESSION['is_logged'])) || $_SESSION['is_logged'] == false) {
        header('Location: ../index.php');
    }
}

function isPostValid($title, $description, $content) {
	if(!preg_match('/^[^\s][\w\d\s!\.,;#$?@%&\(\)]{2,50}$/', $title)) {
		throw new Exception('Please enter valid title!');
	}
	
	if(!preg_match('/^[^\s][\w\d\s!\.,;#$?@%&\(\)]{2,255}$/', $description)) {
		throw new Exception('Please enter valid description!');
	}
	
	if(!preg_match('/^.{2,3000}$/', $content)) {
		throw new Exception('Please enter valid content!');
	}
	
	return true;
}

function createPost($title, $description, $content, $author, $time) {
	global $db;

	$stmt = $db->prepare('INSERT INTO `posts` (`post_title`, `post_description`, `post_content`, `post_author`, `post_dateCreated`) VALUES (:title, :description, :content, :author, :dateCreated)');
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':author', $author, PDO::PARAM_STR);
    $stmt->bindParam(':dateCreated', $time, PDO::PARAM_INT);
    $stmt->execute();
}

function deletePost($id) {
	global $db;
	
	$stmt = $db->prepare("DELETE FROM `posts` WHERE `post_id` = :id");
	$stmt->bindParam('id', $id, PDO::PARAM_INT);
	$stmt->execute();
}

function updatePost($id, $title, $description, $content) {
	global $db;
	
	$stmt = $db->prepare('UPDATE `posts` SET `post_title` = :title, `post_description` = :description, `post_content` = :content WHERE `post_id` = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->execute();
}

function validateUserData($user_name, $password) {
	if(!preg_match('/^[a-zA-Z0-9_-]{3,32}$/', $user_name)) {
		throw new Exception('Please enter valid username!');
	}
	
	if(!preg_match('/^.{3,32}$/', $password)) {
		throw new Exception('Please enter valid password!');
	}
}

function validateLogin($user_name) {
	global $db;

	$stmt = $db->prepare("SELECT `user_id`, `user_password` FROM `users` WHERE `user_name` = :user_name");
    $stmt->bindParam('user_name', $user_name, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if(count($user) == 0) {
		throw new Exception('There is no such user!');
	}
	
	if($password != $user['user_password']) {
		throw new Exception('Wrong password!');
	}
}