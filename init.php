<?php
require_once 'mysql_helper.php';
require_once 'functions.php';

session_start();
$user = !empty($_SESSION['user']) ?  $_SESSION['user'] : [];
$userID = !empty($user['id']) ? $user['id'] : '';

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
