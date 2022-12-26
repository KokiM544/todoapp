<?php

session_start();

define('DSN','mysql:host=localhost;dbname=todo_app;chaset=utf8mb4');
define('DB_USER', 'phpappuser');//root
define('DB_PASS', 'phpapppass');//ryudai2531
// define('SITE_URL', 'http://'. $_SERVER['HTTP_HOST'] . '/work/public/');
define('SITE_URL', 'http://'. $_SERVER['HTTP_HOST'] . '/todos/todoapp/public/');

require_once(__DIR__ . '/functions.php');