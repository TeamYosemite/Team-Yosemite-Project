<?php
session_start();
require '../functions.php';
ifLoggedIn();
require '../adminPanel.html';
?>
