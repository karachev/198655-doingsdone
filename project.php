<?php
require_once('init.php');

if (!$user){
    header("Location: /");
}

$projects = get_projects($link, $user_id);
$tasks = get_tasks($link, $user_id);
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
        $result_task = mysqli_query($link, $sql);
        if ($result_task) {
            header("Location: index.php");
        }
    }
}

$page_content = include_template('form-project.php', [
    'projects' => $projects,
    'errors' => $errors,
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'tasks' => $tasks,
    'projects' => $projects,
    'title' => 'Дела в порядке',
    'user' => $user,
]);

print($layout_content);
