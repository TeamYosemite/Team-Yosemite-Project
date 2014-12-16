<?php
session_start();
include '../config.php';
include '../functions.php';
ifLoggedIn();

$isError = false;
$errorMessage = '';

$current_post = [
	'id' => '',
	'title' => '',
	'description' => '',
	'content' => '',
	'valid' => false
];

if(isset($_POST['submit'])) {
	$current_post['id'] = $_POST['id'];
	$current_post['title'] = $_POST['title'];
	$current_post['description'] = $_POST['description'];
	$current_post['content'] = $_POST['content'];

	try {
        $current_post['valid'] = isPostValid($current_post['title'], $current_post['description'], $current_post['content']);
    } catch(Exception $e) {
        $isError = true;
        $errorMessage = $e->getMessage();
    }

    if($current_post['valid']) {
        updatePost($current_post['id'], $current_post['title'], $current_post['description'], $current_post['content']);
		
		header('Location: adminPanel.php');
		exit();
    }
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$id = $_GET['id'];
	$post_data = load_post($id);
	
	$current_post['id'] = $post_data['post_id'];
	$current_post['title'] = $post_data['post_title'];
	$current_post['description'] = $post_data['post_description'];
	$current_post['content'] = $post_data['post_content'];
}
else {
	header('Location: adminPanel.php');
	exit;
}
?>

<?= $isError ? "<p class=\"error\">{$errorMessage}</p>" : null;?>
<form method="POST">
    <input type="text" name="title" value="<?= $current_post['title'];?>" placeholder="Title..." />
    <textarea name="description" placeholder="Description..." ><?= $current_post['description'];?></textarea>
    <textarea name="content" id="editor" placeholder="Content..."><?= $current_post['content'];?></textarea>
    <input type="hidden" name="id" value="<?= $current_post['id'];?>" />
    <input type="submit" value="Submit" name="submit"/>
</form>

<script type="text/javascript" src="../scripts/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../scripts/loadEditor.js"></script>