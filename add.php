<?php
require_once('init.php');

$user_id = 1;

$projects = get_projects($link, $user_id);
$tasks = get_tasks($link, $user_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task = $_POST;
    $task['date'] = NULL;

    $required = ['name', 'project'];
    $dict = ['name' => 'Название задачи', 'project' => 'Проект', 'date' => 'Дата выполнения'];
    $errors = [];

    // Проверка обязательных полей
    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }

    // Проверка поля имя
    if (empty($errors['name']) && strlen($task['name']) > 128) {
        $errors['name'] = 'Макисмальная длина имени задачи 128 символов';
    }

    // Проверка поля даты
    if (empty($task['date'])) {
        $deadline = 'null';
    }
    elseif (empty($errors['date']) && strtotime($task['date']) < time()) {
        $errors['date'] = 'Выбранная дата меньше текущей';
    }
    else {
        $deadline = '"' . $task['date'] . '"';
    }

    // Загрузка файла
    if (is_uploaded_file($_FILES['preview']['tmp_name'])) {
        $tmp_name = $_FILES['preview']['tmp_name'];
        $path = uniqid();
        move_uploaded_file($tmp_name, 'uploads/' . $path);
        $file = $path;
    }
    else {
        $file = '';
    }

    if (empty($errors)) {
        $sql = 'INSERT INTO task (date_create, date_done, status, name, deadline, project_id)
        VALUES (NOW(), NULL, 0, "' . $task['name'] .'", NULL, 1)';
        $result_task = mysqli_query($link, $sql);
        if ($result_task) {
            header("Location: index.php");
        }
    }
}

$page_content = include_template('form-task.php', [
    'projects' => $projects,
    'tasks' => $tasks,
    'errors' => $errors,
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'tasks' => $tasks,
    'projects' => $projects,
    'title' => 'Дела в порядке',
    'userName' => 'Константин'
]);

print($layout_content);
