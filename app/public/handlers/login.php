<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $conn = new PDO('pgsql:host=db; dbname=dbname', 'dbuser', 'dbpwd');

    $email = $_POST['email'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $dbinfo = $stmt->fetch();
    $hash = $_POST['password'];

    $errors = isValidLogin($_POST, $conn);
    if (!empty($dbinfo['email']) && !(password_verify($dbinfo['password'], $hash))) {
        session_start();
        $_SESSION['id'] = $dbinfo['id'];
        //setcookie('user', $dbinfo['email'], time() + 3600); //авторизация с помощью куки
        header('Location:./main');

    } else {
        $errors['password'] = 'неверное имя пользователя или пароль';
    }

}

//if (isset($_COOKIE['user'])) {
  // header('Location: /main');
//}
require_once './views/login.phtml';
function isValidLogin(array $data, PDO $conn): array
{
    $errors = [];
    if (!isset($data['email'])) {
        $errors['email'] = 'email is required';
    } else {
        $email = $data['email'];
        if (empty($email)) {
            $errors['email'] = 'email не может быть пустым';
        }
    }
    if (!isset($data['password'])){
            $errors['password'] = 'password is required';
    } else {
        $password = $data['password'];
        if (empty($password)) {
            $errors['password'] = 'password не может быть пустым';
        }
    }

    return $errors;
}

