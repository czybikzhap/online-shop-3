<?php

namespace app\Controller;

use app\Model\Basket;
use app\Model\User;
use app\Services\BasketService;

class BasketController
{

    public function basket(): array
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
            'view' => 'baskets',
            'data' => [
                'totalCost' => $totalCost,
                'userProducts' =>  $userProducts
            ]
        ];
    }

    public function addProducts(): void
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $basketService = new BasketService();

            $userId = $_SESSION['user_id'];

            $errors = $basketService->addProduct($_POST, $userId);

            if (empty($errors)) {
                header('Location: /basket');
                exit;
            }

        }
    }

    public function delete(): void
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $userId = $_SESSION['user_id'];

            $basketService = new BasketService();
            $basketService->clearBasket($userId);
        }

        header('Location: /basket');
        exit;
    }

    public function deleteProduct(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        } else {
            header('Location: /basket');
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $userId = $_SESSION['user_id'];

            $deleteProduct = new BasketService();
            $deleteProduct->deleteProduct($userId, $_POST['product_id']);
        }
    }

    public function updateQuantity(): void
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $productId = $_POST['product_id'] ?? null;
        $quantity = $_POST['quantity'] ?? null;

        $basketService = new BasketService();

        $result = $basketService->updateQuantity(
            (int)$userId,
            (int)$productId,
            (int)$quantity
        );

        if (!empty($result['error'])) {
            $_SESSION['error'] = $result['error'];
        }

        header('Location: /basket');
        exit;
    }

}