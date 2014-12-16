<?php

include 'config.php';
include 'functions.php';
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

include 'templates/footer.php';

?>