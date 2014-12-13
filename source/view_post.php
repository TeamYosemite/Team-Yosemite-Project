<?php
include 'config.php';
if (isset($_GET['id'])):
    $id = $_GET['id'];
    $stmt = $db->prepare("SELECT * FROM posts WHERE post_id = :id");
    $stmt->bindParam('id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row = $row[0];

    $users = $db->prepare("SELECT * FROM users  WHERE user_id = :uid");
    $users->bindParam('uid', $row['post_author'], PDO::PARAM_STR);
    $users->execute();
    $user = $users->fetchAll();
    $user = $user[0][1];
?>
<!DOCTYPE>
<html>
<head>
    <title><?=$row['post_title']?></title>
</head>
<body>
    <h1><?=$row['post_title']?></h1>
    <h2><?=$row['post_description']?></h2>
    <div><?=$row['post_content']?></div>
    <div>Published on <?=date('d/m/y') ?></div>
    <div>Author: <?=$user?></div>
</body>
</html>
<?php
    endif;
?>