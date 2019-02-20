<?php
require_once('init.php');

$user_id = 1;

$projects = get_projects($link, $user_id);
$tasks = get_tasks($link, $user_id);
$project_id = NULL;

if (isset($_GET['project_id'])) {
    $project_id = (int) $_GET['project_id'];
    if (!has_project_id($project_id, $projects)) {
        http_response_code(404);
        exit();
    }
}

$page_content = include_template('index.php', [
    'tasks' => (!empty($project_id)) ? get_tasks_for_current_project($link, $user_id, $project_id) : $tasks,
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
