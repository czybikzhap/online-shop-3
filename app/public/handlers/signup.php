<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $conn = new PDO('pgsql:host=db; dbname=dbname', 'dbuser', 'dbpwd');

    $errors = isValidSignUp($_POST, $conn);

    if (empty($errors)) {
        session_start();
        header('Location: /login');

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repeat_pwd = $_POST['repeat_pwd'];

        $password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

        $stmt = $conn->prepare("SELECT * FROM users WHERE name = :name");
        $stmt->execute(['name' => $name]);
        $dbinfo = $stmt->fetch();

        print_r('id - ' . $dbinfo['id']);
        echo '<br>';
        print_r('name - ' . $dbinfo['name']);
        echo '<br>';
        print_r('email - ' . $dbinfo['email']);
        echo '<br>';
        print_r('password - ' . $dbinfo['password']);
    }
}

require_once "./views/signup.phtml";
function isValidSignUp(array $data, PDO $conn): array
{
    $errors = [];

    if (!isset($data['name'])) {
        $errors['name'] = 'name is required';
    } else {
        $name = $data['name'];
        if (empty($name)) {
            $errors['name'] = 'name не может быть пустым';
        } elseif (strlen($name) < 2) {
            $errors['name'] = 'name должен содержать больше 2-х символов';
        }
    }


    if (!isset($data['email'])){
        $errors['email'] = 'email is required';
    } else {
        $email = $data['email'];
        if (empty($email)){
            $errors['email'] = 'email не может быть пустым';
        } elseif (strlen($email) < 2) {
            $errors['email'] = 'email должен содержать больше 2-х символов';
        } else {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email ");
            $stmt->execute(['email' => $email]);
            $userData = $stmt->fetch();
            if (!empty($userData['email'])) {
                $errors['email'] = 'пользователь с таким адресом электронной почты уже зарегистрирован';
            }
        }
    }

    if (!isset($data['password'])){
        $errors['password'] = 'password is required';
    } else {
        $password = $data['password'];
        if (empty($password)) {
            $errors['password'] = 'password не может быть пустым';
        } elseif (strlen($password) < 2) {
            $errors['password'] = 'password должен содержать больше 2-х символов';
        }
    }

    if (!isset($data['repeat_pwd'])){
        $errors['repeat_pwd'] = 'password is required';
    } else {
        $repeat_pwd = $data['repeat_pwd'];
        if (empty($repeat_pwd)) {
            $errors['repeat_pwd'] = 'password не может быть пустым';
        } elseif ($repeat_pwd !== $data['password']) {
            $errors['repeat_pwd'] = 'пароли не совадают';
        }
    }
    return $errors;
}