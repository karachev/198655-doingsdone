<?php
require_once('init.php');

if (!$user){
    header("Location: /");
}

$projects = getProjects($link, $userID);
$tasks = getTasks($link, $userID);
$errors = [];
$project = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project = $_POST;
    $required = ['name'];
    $dict = ['name' => 'Название проекта'];

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
    if (strlen($project['name']) > 128) {
        $errors['name'] = 'Макисмальная длина имени проекта 128 символов';
    }

    /**
     * Add project to database
     */
    if (empty($errors)) {
        $sql = 'INSERT INTO project (name, author_id) VALUES ("'. $project['name'] .'", "'. $user['id'] .'")';
        $resultTask = mysqli_query($link, $sql);
        if ($resultTask) {
            header("Location: index.php");
        }
    }
}

$pageContent = includeTemplate('form-project.php', [
    'projects' => $projects,
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
