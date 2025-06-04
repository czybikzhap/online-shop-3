<?php

namespace app\Controller;

use app\Model\User;

class UserController
{
    public function  login (): array
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $errors = $this->isValidLogin($_POST);

            if (empty($errors)) {

                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';

                $user = User::getUser($email);

                if (!empty($user) && (password_verify($password, $user->getPassword()))) {
                    session_start();
                    $_SESSION['user_id'] = $user->getUserId();
                    header('Location:./main');
                    exit;
                } else {
                    $errors['password'] = 'неверное имя пользователя или пароль';
                }
            }
        }
        return [
            'view' => 'auth/login',
            'data' => [
                'email' => $email ?? '',
                'errors' => $errors
            ]
        ];
    }
    private function isValidLogin(array $data): array
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
    public function register(): array
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $errors = $this->isValidSignUp($_POST);
            if (empty($errors)) {
                session_start();

                $name = $_POST['name'] ?? '';
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';

                $hash = password_hash($password, PASSWORD_DEFAULT);

                $user = new User($name, $email, $hash);

                $user->createUser();

                header('Location: /login');
            }
        }
        return [
            'view' => 'auth/register',
            'data' => [
                'name' => $name ?? '',
                'email' => $email ?? '',
                'errors' => $errors
            ]
        ];
    }
    private function isValidSignUp(array $data): array
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
        if (!isset($data['email'])) {
            $errors['email'] = 'email is required';
        } else {
            $email = $data['email'];
            if (empty($email)) {
                $errors['email'] = 'email не может быть пустым';
            } elseif (strlen($email) < 2) {
                $errors['email'] = 'email должен содержать больше 2-х символов';
            } else {
                $user = new User( $_POST['name'],  $email, $_POST['password']);
                $userData = $user->getUser($email);
                if (!empty($userData)) {
                    $errors['email'] = 'пользователь с таким адресом электронной почты уже зарегистрирован';
                }
            }
        }
        if (!isset($data['password'])) {
            $errors['password'] = 'password is required';
        } else {
            $password = $data['password'];
            if (empty($password)) {
                $errors['password'] = 'password не может быть пустым';
            } elseif (strlen($password) < 2) {
                $errors['password'] = 'password должен содержать больше 2-х символов';
            }
        }
        if (!isset($data['repeat_pwd'])) {
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
    public function logout (): void
    {
        session_start();
        unset($_SESSION['user_id']);

        session_destroy();

        header('Location: /login');
        exit;
    }
}