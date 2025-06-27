<?php

namespace app\Controller;

use app\Model\Products;
use app\Model\User;

class AdminController {
    public function dashboard()
    {
        session_start();

        $userId = $_SESSION['user_id'];

        $user = User::getUserById($userId);

        if ($user['role'] === 'admin') {

            return [
                'view' => 'admin/dashboard',
                'data' => [
                    'user' => $user,
                ]
            ];

        } else {

            require_once '../View/notFound.html';

        }

    }


    public function updateCatalog()
    {
        session_start();

        $userId = $_SESSION['user_id'];

        $user = User::getUserById($userId);

        $products = Products::getProducts();

        if ($user['role'] === 'admin') {

            return [
                'view' => 'admin/updateCatalog',
                'data' => [
                    'user' => $user,
                    'products' => $products
                ]
            ];

        } else {

            require_once '../View/notFound.html';
        }


    }
}