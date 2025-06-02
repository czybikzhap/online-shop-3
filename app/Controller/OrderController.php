<?php

namespace app\Controller;

use app\Model\User;

class OrderController
{
    public function getOrders()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location :/login');
            exit;
        }

        $userId = $_SESSION['user_id'];

        $userProducts = User::userProducts($userId);

        return [
            'view' => 'orders',
            'data' => [
                'userProducts' =>  $userProducts
            ]
        ];
    }

}