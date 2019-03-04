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

$projects = getProjects($link, $userID);
$tasks = getTasks($link, $userID);
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
    $tasks = getDoneTasks($link, $userID);
} else {
    $tasks = getTasks($link, $userID);
}

$tasks_filter = 'all';
if (isset($_GET['task_switch'])) {
    $tasks_filter = $_GET['task_switch'];

    switch ($tasks_filter) {
        case 'all':
            $tasks = getTasks($link, $userID);
            break;
        case 'today' :
            $filterDate = date("y.m.d", strtotime('today'));
            $tasks = getFilterTaskWithDate($link, $userID, $filterDate);
            break;
        case 'tomorrow':
            $filterDate = date("y.m.d", strtotime('+1 day'));
            $tasks = getFilterTaskWithDate($link, $userID, $filterDate);
            break;
        case 'overdue':
            $filterDate = date("y.m.d", strtotime('today'));
            $tasks = getOverdueTasks($link, $userID, $filterDate);
            break;
    }
}
$show_completed = (int) $_GET['show_completed'];

$page_content = include_template('index.php', [
    'tasks' => (!empty($project_id)) ? getTasksForCurrentProject($link, $userID, $project_id) : $tasks,
    'showCompleteTasks' => $show_completed,
    'tasksFilter' => $tasks_filter,
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
