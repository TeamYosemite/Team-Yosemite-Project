<?php
session_start();

require 'functions.php';
ifLoggedIn();

if (isset($_SESSION)) {
    unset($_SESSION);
    session_unset();
    session_destroy();
}

header('Location: index.php');
exit;