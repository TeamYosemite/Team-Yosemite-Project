<form method="POST">
	<input type="text" name="title" placeholder="Title..." />
	<textarea name="description" placeholder="Description..." ></textarea>
	<textarea name="content" placeholder="Content..." ></textarea>
	<input type="submit" value="Submit" name="submit"/>
</form>
<?php
session_start();
require '../functions.php';
ifLoggedIn();

include '../config.php';
if (isset($_POST['submit'])) {
    echo '76765';
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];
    $user = 'me'; // Session
    $sql = "INSERT INTO posts (post_title, post_description, post_content, post_author) VALUES ('$title', '$description', '$content', '$user')";
    try {
        $db->exec($sql);
    } catch (Exception $e) {
        echo $e;
    }
}