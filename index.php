<?php
require_once('init.php');

if (!$user){
    $pageContent = includeTemplate('guest.php', []);

    $layoutContent = includeTemplate('layout.php', [
        'content' => $pageContent,
        'title' => 'Дела в порядке',
        'user' => false,
        'userName' => ''
    ]);

    print($layoutContent);
    exit();
}

$projects = getProjects($link, $userID);
$tasks = getTasks($link, $userID);
$projectID = NULL;

if (isset($_GET['project_id'])) {
    $projectID = (int) $_GET['project_id'];
    if (!hasProjectID($projectID, $projects)) {
        http_response_code(404);
        exit();
    }
}

$taskID = NULL;

if (isset($_GET['task_id'])) {
    $taskID = (int) $_GET['task_id'];
    $taskStatus = (int) $_GET['check'];
    $sql = 'UPDATE task SET status = "'. $taskStatus .'" WHERE id = "' . $taskID . '" ';
    $result = mysqli_query($link, $sql);
    if ($result) {
        header("Location: index.php");
        exit();
    }
}

$showCompleted = NULL;

if (isset($_GET['show_completed']) && (int) $_GET['show_completed'] !== 0) {
    $tasks = getDoneTasks($link, $userID);
} else {
    $tasks = getTasks($link, $userID);
}

$tasksFilter = 'all';
if (isset($_GET['task_switch'])) {
    $tasksFilter = $_GET['task_switch'];

    switch ($tasksFilter) {
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
$showCompleted = (int) $_GET['show_completed'];

$pageContent = includeTemplate('index.php', [
    'tasks' => (!empty($projectID)) ? getTasksForCurrentProject($link, $userID, $projectID) : $tasks,
    'showCompleteTasks' => $showCompleted,
    'tasksFilter' => $tasksFilter,
]);

$layoutContent = includeTemplate('layout.php', [
    'content' => $pageContent,
    'tasks' => $tasks,
    'projects' => $projects,
    'user' => $user,
    'title' => 'Дела в порядке',
]);
//
print($layoutContent);
