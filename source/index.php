<?php

include 'config.php';
include 'functions.php';

$currentPage = isset($_GET['page']) && $_GET['page'] != null ? $_GET['page'] : 1;

include 'templates/header.php';

?>

<body class="indexPage">

<header>
    <p>A blog about Beautiful Bulgaria</p>
</header>

<?php

$currentPage = isset($_GET['page']) && $_GET['page'] != null ? $_GET['page'] : 1;
load_posts($db, $currentPage);

?>

<?php
load_posts($db, $currentPage);
include 'templates/footer.php';

?>