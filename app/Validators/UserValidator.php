<?php

namespace app\Validators;

use app\Model\User;

class UserValidator
{
    public function isValidLogin(array $data): array
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

    public function isValidSignUp(array $data): array
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
                $userData = $user->getUserByEmail($email);
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

    public function isValidUpdateUser($data): array
    {
        $errors = [];

        if (!isset($data['password'])) {
            $errors['password'] = [];
        } else {
            $password = $data['password'];
            if (empty($password)) {
                $errors['password'] = 'password не может быть пустым';
            } elseif (strlen($password) < 2) {
                $errors['password'] = 'password должен содержать больше 2-х символов';
            }
        }

        $repeat_pwd = $data['repeat_pwd'];
        if (empty($repeat_pwd)) {
            $errors['repeat_pwd'] = 'password не может быть пустым';
        } elseif ($repeat_pwd !== $data['password']) {
            $errors['repeat_pwd'] = 'пароли не совадают';
        }

        return $errors;
    }

}