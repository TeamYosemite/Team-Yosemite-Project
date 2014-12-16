<table border="1">
    <tr>
        <th>Title</th>
        <th>Date added</th>
        <th>Time added</th>
        <th colspan="3">Action</th>
    </tr>
<?php
session_start();
require '../functions.php';
ifLoggedIn();
require '../adminPanel.html';
require '../config.php';

$post = $db->prepare("SELECT * FROM posts");
$post->execute();
$rowP = $post->fetchAll(PDO::FETCH_ASSOC);

for ($r = 0; $r < count($rowP); $r++):
    $rowData = $rowP[$r];
?>
    <tr>
        <td><?=$rowData['post_title']?></td>
        <td><?=date('d-m-Y', strtotime($rowData['post_dateCreated']))?></td>
        <td><?=date('H:i:s', strtotime($rowData['post_dateCreated']))?></td>
        <td><a href="post_edit.php?id=<?=$rowData['post_id']?>">Edit</a></td>
        <td><a onclick="confirmDelete()" href="#">Remove</a></td>
        <td><a href="../view_post.php?id=<?=$rowData['post_id']?>">View</a></td>
    </tr>

    <script>
        function confirmDelete(){
            var check = confirm('Delete post?');
            console.log(check);
            if (check) {
                window.location = 'post_delete.php?id=<?=$rowData['post_id']?>'
            }
        }
    </script>
<?php
    endfor;
?>
</table>
