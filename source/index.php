<?php

include 'config.php';

$currentPage = isset($_GET['page']) && $_GET['page'] != null ? $_GET['page'] : 1;

include 'templates/header.php';

?>

<body class="indexPage">

<header>
    <p>A blog about Beautiful Bulgaria</p>
</header>

<?php
include 'functions.php';
load_posts($db, $currentPage);
include 'templates/footer.php';

?>