<?php

namespace app\Controller;

use app\Model\Basket;
use app\Model\User;

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

        return [
            'view' => 'baskets',
            'data' => [
                'userProducts' =>  $userProducts
            ]
        ];
    }

    public function addProducts(): void
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location :/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $errors = $this->isValidAddProduct($_POST);

            if(empty($errors)) {

                $userId = $_SESSION['user_id'];
                $productId = $_POST['product_id'];

                $addProduct = new Basket($userId, $productId);
                $addProduct->addProducts();

                header('Location: /basket');

            }
        }
    }
    public function delete(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            header('Location: /basket');
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            Basket::delete($_SESSION['id']);
        }
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
            print_r($_POST);
            Basket::deleteProduct($_SESSION['user_id'], $_POST['product_id']);

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

        if ($productId === null || $quantity === null || !is_numeric($quantity) || $quantity < 1) {
            header('Location: /basket');
            exit;
        } else {
            Basket::updateQuantity($userId,  $productId, $quantity);
        }

        header('Location: /basket');
        exit;
    }

    private function isValidAddProduct(array $data): array
    {
        $errors = [];
        if (!isset($data['product_id'])) {
            $errors['product_id'] = 'product_id is required';
        } else {
            $productId = $data['product_id'];
            if (empty($productId)) {
                $errors['product_id'] = 'product_id не может быть пустым';
            }
        }
        return $errors;
    }
}