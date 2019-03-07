<?php
require_once('init.php');

if (!$user){
    header("Location: /");
}

$userID = $user['id'];
$projects = getProjects($link, $userID);
$tasks = getTasks($link, $userID);
$task = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task = $_POST;
    $required = ['name', 'project'];
    $dict = ['name' => 'Название задачи', 'project' => 'Проект', 'date' => 'Дата выполнения'];

    /**
     * Check required fields
     */
    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }

    /**
     * Check name field
     */
    if (strlen($task['name']) > 128) {
        $errors['name'] = 'Макисмальная длина имени задачи 128 символов';
    }

    /**
     * Check date field
     */
    if (empty($task['date'])) {
        $errors['date'] = 'Дата не выбрана';
    }
    elseif (empty($errors['date']) && strtotime($task['date']) < time()) {
        $errors['date'] = 'Выбранная дата меньше текущей';
    } else {
        $deadline = date_format(date_create($task['date']), 'Y-m-d');
    }

    $taskName = $task['name'];
    $projectName = $task['project'];

    /**
     * Add file
     */
    if (isset($_FILES)) {
        $tmpName = $_FILES['preview']['tmp_name'];
        $path = $_FILES['preview']['name'];
        move_uploaded_file($tmpName, 'uploads/' .$path);
        $file = $path;
    }

    /**
     * Add user to database
     */
    if (empty($errors)) {
        $projectID = get_project_id($link, $userID, $projectName);
        $resultTask = addTaskToDatabase($link, $taskName, $file, $deadline, $projectID);

        if ($resultTask) {
            header("Location: index.php");
        }
    }
}

$pageContent = includeTemplate('form-task.php', [
    'projects' => $projects,
    'task' => $task,
    'errors' => $errors,
]);

$layoutContent = includeTemplate('layout.php', [
    'content' => $pageContent,
    'tasks' => $tasks,
    'projects' => $projects,
    'title' => 'Дела в порядке',
    'user' => $user,
]);

print($layoutContent);
