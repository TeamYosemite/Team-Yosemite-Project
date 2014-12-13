<?php
define('DBHOST', 'localhost');
define('DBPORT', '8080');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'yosemite_blog');

$db = new PDO('mysql:host=' . DBHOST . ';dbport=' . DBPORT . ';dbname=' . DBNAME, DBUSER, DBPASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

date_default_timezone_set('Europe/Sofia');