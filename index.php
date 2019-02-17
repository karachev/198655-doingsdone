<?php
require_once('init.php');

// код SQL-запроса
$sql = 'SELECT name, id FROM project WHERE author_id = 1';
$resultProjects = mysqli_query($link, $sql);

if ($resultProjects) {
    $projects = mysqli_fetch_all($resultProjects, MYSQLI_ASSOC);
} else {
    print('На сайте ведутся технические работы');
}

$sql = 'SELECT task.id, date_create, date_done, status, task.name, file, deadline, project_id, author_id   FROM task INNER JOIN project ON project.id = task.project_id WHERE author_id = 1;';
$resultTasks = mysqli_query($link, $sql);

if ($resultTasks) {
    $tasks = mysqli_fetch_all($resultTasks, MYSQLI_ASSOC);
} else {
    print('На сайте ведутся технические работы');
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
