<?php
require_once('functions.php');
require_once('data.php');

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
