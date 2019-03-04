<?php
require_once('init.php');

$data = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = $_POST;
    $required = ['email', 'password'];

    /**
     * Check required fields
     */
    foreach ($required as $key) {
        if (empty($data[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }

    /**
     * Check email field
     */
    if (empty($errors['email']) and (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) or strlen($data['email']) > 128)) {
        $errors['email'] = 'E-mail введён некорректно';
    }

    /**
     * Check user in database
     */
    if (empty($errors)) {


        $user = getUserByMail($link, $data['email'])[0];

        if (empty($user)) {
            $errors['email'] = 'Такой пользователь не найден';
        }
        elseif (password_verify($data['password'], $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: index.php");
            exit();
        }
        else {
            $errors['password'] = 'Неверный пароль';
        }
    }
}
$pageContent = includeTemplate('auth.php', [
    'data' => $data,
    'errors' => $errors
]);
$layoutContent = includeTemplate('layout.php', [
    'content' => $pageContent,
    'title' => 'Вход на сайт',
    'projects' => $projects,
]);

print($layoutContent);