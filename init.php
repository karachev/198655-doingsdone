<?php
require_once 'functions.php';

$db = [
    'host' => '127.0.0.1',
    'user' => 'root',
    'password' => 'root1234',
    'database' => 'doingsdone'
];

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($link, "utf8");

if (!$link) {
    exit('Сайт временно не доступен');
}
