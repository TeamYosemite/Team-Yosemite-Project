<?php
session_start();
include '../config.php';
include '../functions.php';
ifLoggedIn();
$isError = false;
$errorMessage = '';
if (isset($_POST['submit'])) {
    $postValid = false;
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];
    try {
        $postValid = isPostValid($_POST['title'], $_POST['description'], $_POST['content']);
    } catch(Exception $e) {
        $isError = true;
        $errorMessage = $e->getMessage();
    }

    if($postValid) {
        createPost($_POST['title'], $_POST['description'], $_POST['content'], $_SESSION['username'], time());
    }
}
if($isError) {
    echo "<p class=\"error\">{$errorMessage}</p>";
}
?>

<form method="POST">
    <input type="text" name="title" value="<?= $title;?>" placeholder="Title..." />
    <textarea name="description" value="<?= $description;?>" placeholder="Description..." ></textarea>
    <textarea name="content" value="<?= $content;?>" id="editor" placeholder="Content..."></textarea>
    <input type="submit" value="Submit" name="submit"/>
</form>

<script type="text/javascript" src="../scripts/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../scripts/loadEditor.js"></script>