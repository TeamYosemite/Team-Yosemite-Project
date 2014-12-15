<?php

include 'config.php';
include 'functions.php';

$currentPage = isset($_GET['page']) && $_GET['page'] != null ? $_GET['page'] : 1;
load_posts($db, $currentPage);

include 'templates/header.php';

?>

<body class="indexPage">

<header>
    <p>A blog about Beautiful Bulgaria</p>
</header>

<main class="clearfix">
    <aside>
    </aside>

    <article>
    </article>

    <article>
    </article>

    <article>
    </article>

    <article>
    </article>

</main>

<?php

include 'templates/footer.php';

?>