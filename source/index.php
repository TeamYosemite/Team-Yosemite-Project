<?php

include 'config.php';
<<<<<<< HEAD
include 'functions.php';
=======

$currentPage = isset($_GET['page']) && $_GET['page'] != null ? $_GET['page'] : 1;

>>>>>>> db7922e95803d63917a12e1b379612c65f041cbb
include 'templates/header.php';

?>

<body class="indexPage">

<header>
    <p>A blog about Beautiful Bulgaria</p>
</header>

<<<<<<< HEAD
<?php

$currentPage = isset($_GET['page']) && $_GET['page'] != null ? $_GET['page'] : 1;
load_posts($db, $currentPage);

?>

=======
>>>>>>> db7922e95803d63917a12e1b379612c65f041cbb
<?php
include 'functions.php';
load_posts($db, $currentPage);
include 'templates/footer.php';

?>