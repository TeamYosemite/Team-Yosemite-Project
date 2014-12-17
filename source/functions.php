<?php

function isUserValid($name, $password) {
	if(!preg_match('/^[^\s][\w\d\s!\.,;#$?@%&\(\)]{2,50}$/', $name)) {
		throw new Exception('Please enter valid name!');
	}
	
	return true;
}

function getLastUserId() {
	global $db;
	
	$stmt = $db->prepare("SELECT `user_id` FROM `users` ORDER BY `user_id` DESC LIMIT 1");
    $stmt->execute();
    $id = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$last_id = $id[0];
	
	return $last_id;
}

function createUser($id, $name, $password) {
	global $db;

	$stmt = $db->prepare('INSERT INTO `users` (`user_id`, `user_name`, `user_password`) VALUES (:id, :name, :password)');
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->execute();
}

function deleteUser($id) {
	global $db;
	
	$stmt = $db->prepare("DELETE FROM `users` WHERE `user_id` = :id");
	$stmt->bindParam('id', $id, PDO::PARAM_INT);
	$stmt->execute();
}

function load_all_users()
{
	global $db;
	
	$users = [];
	
	$stmt = $db->prepare('SELECT * FROM `users`');
    $stmt->execute();
	
	while($row = $stmt->fetch()) {
		$users[] = $row;
	}
	
	return $users;
}

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

function load_all_posts() {
	global $db;
	
	$posts = [];
	
	$stmt = $db->prepare('SELECT * FROM `posts` ORDER BY post_id DESC');
    $stmt->execute();
	
	while($row = $stmt->fetch()) {
		$posts[] = $row;
	}
	
	return $posts;
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

function load_tags($post_id) {
	global $db;

	$stmt = $db->prepare("SELECT tags.tag_name FROM tags INNER JOIN posts_tags ON posts_tags.tag_id = tags.tag_id WHERE posts_tags.post_id = :post_id");
    $stmt->bindParam('post_id', $post_id, PDO::PARAM_INT);
    $stmt->execute();
    $row_tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$tags = [];
	
	foreach($row_tags as $tag) {
		$tags[] = $tag['tag_name'];
	}
	
	return $tags;
}

function load_posts_by_tags($tags) {
	global $db;
	
	$posts = [];
	
	foreach($tags as $tag) {
		$stmt = $db->prepare("SELECT *
		FROM (`posts`)
		LEFT JOIN `posts_tags` ON `posts_tags`.`post_id` = `posts`.`post_id`
		LEFT JOIN `tags` ON `posts_tags`.`tag_id` = `tags`.`tag_id`
		WHERE `tag_name` LIKE :tag_name");
		$stmt->bindParam('tag_name', $tag, PDO::PARAM_STR);
		$stmt->execute();
		$row_posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		if(!empty($row_posts)) {
			foreach($row_posts as $post) {
				$posts[] = $post;
			}
		}
	}
	
	return $posts;
}

function load_comments($post_id) {
	global $db;

	$stmt = $db->prepare("SELECT * FROM comments  WHERE comment_postid = :post_id ORDER BY `comment_dateCreated` DESC");
    $stmt->bindParam('post_id', $post_id, PDO::PARAM_INT);
    $stmt->execute();
    $row_comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$comments = [];
	
	foreach($row_comments as $comment) {
		$comments[] = $comment;
	}
	
	return $comments;
}

function ifLoggedIn(){
   if(!(isset($_SESSION['is_logged'])) || $_SESSION['is_logged'] == false) {
        header('Location: ../index.php');
    }
}

function isPostValid($title, $description, $content, $tags) {
	if(!preg_match('/^[^\s][\w\d\s!\.,;#$?@%&\(\)]{2,50}$/', $title)) {
		throw new Exception('Please enter valid title!');
	}
	
	if(!preg_match('/^[^\s][\w\d\s!\.,;#$?@%&\(\)]{2,255}$/', $description)) {
		throw new Exception('Please enter valid description!');
	}
	
	if(strlen($content) == 0) {
		throw new Exception('Please enter valid content!');
	}
	
	if(count($tags) == 0 || $tags[0] == '') {
		throw new Exception('Please enter at least one tag!');
	}
	
	foreach($tags as $tag) {
		if(!preg_match('/^[a-zA-Z0-9_-]{1,32}$/', trim($tag))) {
			throw new Exception('Please enter valid tags!');
		}
	}
	
	return true;
}

function getLastPostId() {
	global $db;
	
	$stmt = $db->prepare("SELECT `post_id` FROM `posts` ORDER BY `post_id` DESC LIMIT 1");
    $stmt->execute();
    $id = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$last_id = $id[0];
	
	return $last_id;
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

function updatePostView($post_id, $views) {
	global $db;
	
	$stmt = $db->prepare('UPDATE `posts` SET `post_timesSeen` = :views WHERE `post_id` = :post_id');
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->bindParam(':views', $views, PDO::PARAM_INT);
    $stmt->execute();
}

function createTags($tags, $post_id) {
	global $db;
	
	foreach($tags as $tag) {
		$stmt = $db->prepare('INSERT INTO `tags` (`tag_name`) VALUES (:tagName)');
		$stmt->bindParam(':tagName', trim($tag), PDO::PARAM_STR);
		$stmt->execute();
		
		$tag_id = $db->lastInsertId();
		
		$stmt = $db->prepare('INSERT INTO `posts_tags` (`tag_id`, `post_id`) VALUES (:tagId, :postId)');
		$stmt->bindParam(':tagId', $tag_id, PDO::PARAM_INT);
		$stmt->bindParam(':postId', $post_id, PDO::PARAM_INT);
		$stmt->execute();
	}
}

function updateTags($tags, $post_id) {
	deleteTags($tags, $post_id);
	createTags($tags, $post_id);
}

function deleteTags($tags, $post_id) {
	global $db;
	
	$stmt = $db->prepare('SELECT * FROM `posts_tags` WHERE `post_id` = :post_id');
	$stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
	$stmt->execute();
	
	$tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($tags as $tag) {
		$stmt = $db->prepare('DELETE FROM `tags` WHERE `tag_id` = :tag_id');
		$stmt->bindParam(':tag_id', $tag['tag_id'], PDO::PARAM_INT);
		$stmt->execute();
	}
	
	$stmt = $db->prepare('DELETE FROM `posts_tags` WHERE `post_id` = :post_id');
	$stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
	$stmt->execute();
}

function createComment($name, $email, $content, $post_id) {
	global $db;
	
	$date_created = time();
	
	$stmt = $db->prepare("INSERT INTO comments (comment_name, comment_email, comment_content, comment_postId, comment_dateCreated) VALUES (:name, :email, :content, :post_id, :date_created)");
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':email', $email, PDO::PARAM_STR);
	$stmt->bindParam(':content', $content, PDO::PARAM_STR);
	$stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
	$stmt->bindParam(':date_created', $date_created, PDO::PARAM_INT);
	$stmt->execute();
}

function validComment($name, $email, $comment) {
	if(strlen($name) == 0) {
		return false;
	}
	
	if(strlen($email) == 0) {
		return false;
	}
	
	if(strlen($comment) == 0) {
		return false;
	}
	

	return true;
}

function validateUserData($user_name, $password) {
	if(!preg_match('/^[a-zA-Z0-9_-]{3,32}$/', $user_name)) {
		throw new Exception('Please enter valid username!');
	}
	
	if(!preg_match('/^.{3,32}$/', $password)) {
		throw new Exception('Please enter valid password!');
	}
}

function validateLogin($user_name, $password) {
	global $db;

	$stmt = $db->prepare("SELECT `user_id`, `user_password` FROM `users` WHERE `user_name` = :user_name");
    $stmt->bindParam('user_name', $user_name, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if(count($user) == 0) {
		throw new Exception('There is no such user!');
	}
	
	if($password != $user[0]['user_password']) {
		throw new Exception('Wrong password!');
	}
}