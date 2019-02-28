<?php
require_once('init.php');

$data = [];
$errors = [];
if (!empty($_POST)) {
    $required = ['email', 'password'];
    // Обязательные поля
    foreach ($required as $key) {
        if (empty($data[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }
    // Проверка полей
    if (!empty($data['email'])) {
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'E-mail введён некорректно';
        }
        else {
            $email = mysqli_real_escape_string($link, $data['email']);
            $sql = 'SELECT * FROM user WHERE email = "' . $email . '"';
            $res = mysqli_query($link, $sql);
            $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
            if (empty($errors) and $user) {
                if (password_verify($data['password'], $user['password'])) {
                    $_SESSION['user'] = $user;
                    header("Location: index.php");
                }
                else {
                    $errors['password'] = 'Неверный пароль';
                }
            }
            else {
                $errors['email'] = 'Такой пользователь не найден';
            }
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