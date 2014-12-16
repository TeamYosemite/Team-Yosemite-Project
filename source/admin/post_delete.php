<?php
session_start();
require '../functions.php';
ifLoggedIn();
require '../config.php';

$post = $db->prepare("DELETE FROM posts WHERE post_id = :id");
$post->bindParam('id', $_GET['id'], PDO::PARAM_INT);
$post->execute();
header('Location: adminPanel.php')
?>