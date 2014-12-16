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

    $posts = $db->prepare("SELECT * FROM comments  WHERE comment_postid = :postid");
    $posts->bindParam('postid', $row['post_id'], PDO::PARAM_STR);
    $posts->execute();
    $posts = $posts->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE>
<html>
<head>
    <title><?=$row['post_title']?></title>
</head>
<body class="viewPost">
    <h1><?=$row['post_title']?></h1>
    <h2><?=$row['post_description']?></h2>
    <div><?=$row['post_content']?></div>
    <div>Published on <?=date('d/m/y') ?></div>
    <div>Author: <?=$user?></div>
    <div>Visits: <?=$row['post_timesSeen']?></div>
<?php
    for ($p = 0; $p < count($posts); $p++) {
        $comment = $posts[$p]['comment_content'];
        echo "<section>";
        echo "<div>$comment</div>";
        echo "</section>";
    }
?>

</body>
</html>
<?php
    $visits = $row['post_timesSeen'] + 1;
    endif;

$stmt = $db->prepare("UPDATE posts SET post_timesSeen =:visits WHERE post_id = :id");
$stmt->bindParam('visits', $visits, PDO::PARAM_STR);
$stmt->bindParam('id', $id, PDO::PARAM_STR);
$stmt->execute();


?>