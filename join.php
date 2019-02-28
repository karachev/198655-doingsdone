<?php
require_once('init.php');

$data = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = $_POST;

    $required = ['email', 'password', 'name'];
    $dict = ['email' => 'E-mail', 'password' => 'Пароль', 'name' => 'Имя'];
    $errors = [];

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
    if (strlen($data['name']) > 128) {
        $errors['name'] = 'Макисмальная длина имени 128 символов';
    }

    /**
     * Check email field
     */
    if (strlen($data['email']) > 128) {
        $errors['email'] = 'Макисмальная длина имени 128 символов';
    }

    /**
     * Check password field
     */
    if (strlen($data['password']) > 64) {
        $errors['password'] = 'Пароль не может быть длиннее 64 символов';
    }

    /**
     * Check email field in database
     */
    if (!empty($data['email'])) {
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'E-mail введён некорректно';
        }
        $res = getUserByMail($link, $data['email']);
        if (count($res) > 0) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        }
    }

    /**
     * Password encryption
     */
    if (!empty($data['password'])) {
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
    }

    /**
     * Add user to database
     */
    if (empty($errors)) {
        $sql = 'INSERT INTO user (date_registration, email, name, password) VALUES (NOW(), "' . $data['email'] . '", "' . $data['name'] . '", "' . $password . '")';
        $result = mysqli_query($link, $sql);
        if ($result) {
            header("Location: index.php");
        }
    }
}

$page_content = include_template('register.php', [
    'data' => $data,
    'errors' => $errors,
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Дела в порядке',
]);

print($layout_content);
