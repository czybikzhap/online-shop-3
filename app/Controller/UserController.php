<?php

namespace app\Controller;

use app\Model\User;
use app\Validators\UserValidator;

class UserController
{
    public function  login (): array
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $errors = new UserValidator();
            $errors = $errors->isValidLogin($_POST);

            if (empty($errors)) {

                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';

                $user = User::getUserByEmail($email);

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

    public function register(): array
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $errors = new UserValidator();
            $errors = $errors->isValidSignUp($_POST);

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


    public function getProfile()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];

        $user = User::getUserById($userId);

        return [
            'view' => 'userProfile/profile',
            'data' => [
                'user' => $user,
            ]
        ];

    }

    public function editProfile()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];

        $user = User::getUserById($userId);

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $errors = new UserValidator();
            $errors = $errors->isValidUpdateUser($_POST);

            if (empty($errors)) {

                $name = $_POST['name'] ?? '';
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';

                $hash = password_hash($password, PASSWORD_DEFAULT);

                $user = User::updateUser($userId, $name, $email, $hash);

            } else {

                return   [
                    'view' => 'userProfile/editProfile',
                    'data' => [
                        'user' => $user,
                        'errors' => $errors,
                    ]
                ];
            }

            return   [
                'view' => 'userProfile/editProfile',
                'data' => [
                    'user' => $user,
                ]
            ];
        }

        return   [
            'view' => 'userProfile/editProfile',
            'data' => [
                'user' => $user,
            ]
        ];
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