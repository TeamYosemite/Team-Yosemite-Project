<?php
session_start();
include "../config.php";
if (isset($_POST['submit'])) {
    $userName = $_POST['username'];
    $password = md5($_POST['password']);

    $users = $db->prepare("SELECT * FROM users WHERE user_name = :name");
    $users->bindParam('name', $userName, PDO::PARAM_STR);
    $users->execute();
    $user = $users->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['is_logged'] = false;


    if (count($user) > 0) {
        for ($u = 0; $u < count($user); $u++) {
            if ($user[$u]['user_name'] === $userName && $user[$u]['user_password'] === $password) {
                $_SESSION['username'] = $userName;
                $_SESSION['is_logged'] = true;
                header('Location: adminPanel.php');
            } else {
                header('Location: ../index.php');
            }
        }
    } else {
        header('Location: ../index.php');
    }
}
?>