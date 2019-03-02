<?php
require_once('init.php');

$data = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = $_POST;

    $required = ['email', 'password'];

    foreach ($required as $key) {

        if (empty($data[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }

    if (empty($errors['email']) and (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) or strlen($data['email']) > 128)) {
        $errors['email'] = 'E-mail введён некорректно';
    }


    if (empty($errors)) {
        $email = $data['email'];

        $sql = 'SELECT * FROM user WHERE email = "' . $email . '"';
        $res = mysqli_query($link, $sql);
        $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
        if ($user === null) {
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
$page_content = include_template('auth.php', [
    'data' => $data,
    'errors' => $errors
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Вход на сайт',
    'projects' => $projects,
]);

print($layout_content);