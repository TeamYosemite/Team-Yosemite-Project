<?php
session_start();
include '../config.php';
include '../functions.php';
ifLoggedIn();

$isError = false;
$errorMessage = '';

$current_post = [
	'title' => '',
	'description' => '',
	'content' => '',
	'tags' => [],
	'valid' => false
];

if (isset($_POST['submit'])) {
    $current_post['title'] = $_POST['title'];
    $current_post['description'] = $_POST['description'];
    $current_post['content'] = $_POST['content'];
    $current_post['tags'] = explode(',', $_POST['tags']);
	
    try {
        $current_post['valid'] = isPostValid($current_post['title'], $current_post['description'], $current_post['content'], $current_post['tags']);
    } catch(Exception $e) {
        $isError = true;
        $errorMessage = $e->getMessage();
    }
	
    if($current_post['valid']) {
        createPost($current_post['title'], $current_post['description'], $current_post['content'], $_SESSION['username'], time());
		
		$post_id = getLastPostId();
		$post_id = $post_id['post_id'];
        createTags($current_post['tags'], $post_id);
		
		header('Location: index.php');
		exit;
    }
}
?>

<?= $isError ? "<p class=\"error\">{$errorMessage}</p>" : null;?>
<form method="POST">
    <input type="text" name="title" value="<?= $current_post['title'];?>" placeholder="Title..." />
    <textarea name="description" placeholder="Description..."><?= $current_post['description'];?></textarea>
    <textarea name="content" id="editor" placeholder="Content..."><?= $current_post['content'];?></textarea>
    <textarea name="tags" placeholder="tag1, tag2"><?= implode(',', $current_post['tags']);?></textarea>
    <input type="submit" value="Submit" name="submit"/>
</form>

<script type="text/javascript" src="../scripts/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../scripts/loadEditor.js"></script>