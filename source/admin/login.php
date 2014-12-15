<?php
include "../config.php";
if (isset($_POST['submit'])) {
    $userName = $_POST['username'];
    $password = crypt($_POST['password'], CRYPT_STD_DES);

    $users = $db->prepare("SELECT * FROM users");
    $users->bindParam('uid', $row['post_author'], PDO::PARAM_STR);
    $users->execute();
    $user = $users->fetchAll(PDO::FETCH_ASSOC);
    var_dump($user);
    for ($i = 0; $i < count($user); $i++) {
        $data = $user[$i];
        if ($data['user_name'] === $userName && $data['user_password'] === $password) {
            $_SESSION['username'] = $userName;
            header('Location: adminPanel.php');
        }
    }
    header('Location: ../formLogin.html');
}
?>