<?php

include 'config.php';
include 'functions.php';

$currentPage = isset($_GET['page']) && $_GET['page'] != null ? $_GET['page'] : 1;
load_posts($db, $currentPage);