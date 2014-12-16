<?php
session_start();
require '../functions.php';
ifLoggedIn();
require '../config.php';
if (isset($_POST['submit'])) {
    $comments = $db->prepare("INSERT INTO comments (comment_name, comment_email, comment_content, comment_postId) VALUES (:authorP,:emsil, :comment, :id) ");
    $comments->execute(array(':authorP'=>$_POST['name'],
    ':emsil'=>$_POST['email'],
    ':comment'=>$_POST['comment'],
    ':id'=>$_POST['id']));
}
