<?php
include 'config.php';
include 'functions.php';
if (isset($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM posts WHERE post_id = :id");
    $stmt->bindParam('id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetchAll();
    var_dump($row);
}
?>