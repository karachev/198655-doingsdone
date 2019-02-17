<?php
require_once('init.php');

// код SQL-запроса
$sql = 'SELECT name FROM project';
//
$result = mysqli_query($link, $sql);
if ($result) {
    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    print('На сайте ведутся технические работы');
}

$sql = 'SELECT * FROM task WHERE id = 1';

if ($res = mysqli_query($link, $sql)) {
    $tasks = mysqli_fetch_all($res, MYSQLI_ASSOC);
} else {
    print('На сайте ведутся технические работы22');
}

$page_content = include_template('index.php', [
    'tasks' => $tasks,
    'showCompleteTasks' => $showCompleteTasks
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'tasks' => $tasks,
    'projects' => $projects,
    'title' => 'Дела в порядке',
    'userName' => 'Константин'
]);

print($layout_content);
