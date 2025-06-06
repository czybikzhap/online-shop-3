<?php

namespace app\Controller;

use app\Model\User;
use app\Services\BasketService;
use app\Services\OrderService;
use app\Validators\BasketValidator;

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

        $totalCost = new BasketService();
        $totalCost = $totalCost->totalCost($userId);

        return [
            'view' => 'orders',
            'data' => [
                'totalCost' => $totalCost,
                'userProducts' =>  $userProducts
            ]
        ];
    }

    public function order(): void
    {
        //print_r($_POST);
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $userId = $_SESSION['user_id'];
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';


            if (empty($phone) || empty($address)) {
                $_SESSION['error'] = 'Пожалуйста, заполните все поля';
                header('Location: /getOrders');
                exit;
            }

            $userProducts = User::userProducts($userId);
            $basketErrors = BasketValidator::validateBasket($userProducts);

            if (!empty($basketErrors)) {
                $_SESSION['error'] = $basketErrors;
                header('Location: /basket');
                exit;
            } else {

                $orderId = new OrderService();
                $orderId->createOrder($userId, $phone, $address);

            }
        }

       header('Location: /catalog');

    }

}