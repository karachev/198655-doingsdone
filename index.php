<?php
require_once('init.php');

if (!$user){
    $page_content = include_template('guest.php', []);

    $layout_content = include_template('layout.php', [
        'content' => $page_content,
        'title' => 'Дела в порядке',
        'user' => false,
        'userName' => ''
    ]);

    print($layout_content);
    exit();
}

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

$task_id = NULL;

if (isset($_GET['task_id'])) {
    $task_id = (int) $_GET['task_id'];
    $task_status = (int) $_GET['check'];
    $sql = 'UPDATE task SET status = "'. $task_status .'" WHERE id = "' . $task_id . '" ';
    $result = mysqli_query($link, $sql);
    if ($result) {
        header("Location: index.php");
        exit();
    }
}

$show_completed = NULL;

if (isset($_GET['show_completed']) && (int) $_GET['show_completed'] !== 0) {
    $tasks = getDoneTasks($link, $user_id);
} else {
    $tasks = get_tasks($link, $user_id);
}

$show_completed = (int) $_GET['show_completed'];

$page_content = include_template('index.php', [
    'tasks' => (!empty($project_id)) ? get_tasks_for_current_project($link, $user_id, $project_id) : $tasks,
    'showCompleteTasks' => $show_completed
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'tasks' => $tasks,
    'projects' => $projects,
    'user' => $user,
    'title' => 'Дела в порядке',
]);
//
print($layout_content);
