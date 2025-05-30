<?php

namespace App\Controller;

use App\Model\Basket;

class BasketController
{

    public function basket(): array
    {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location :/login');
        }
        $userId = $_SESSION['id'];

        $basket = Basket::getBasket($userId);

        return [
            'view' => 'baskets',
            'data' => [
                'basket' => $basket,
            ]
        ];
    }

    public function addProducts(): void
    {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location :/login');
        } else {
            header("Location: /main");
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $errors = $this->isValidAddProduct($_POST);

            if(empty($errors)) {

                $userId = $_SESSION['id'];
                $productId = $_POST['product_id'];

                $addProduct = new Basket($userId, $productId);
                $addProduct->AddProducts();

            }
        }
    }
    public function delete(): void
    {
        session_start();
        if (!isset($_SESSION['id'])) {
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
        if (!isset($_SESSION['id'])) {
            header('Location: /login');
        } else {
            header('Location: /basket');
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            print_r($_POST);
            Basket::deleteProduct($_SESSION['id'], $_POST['product_id']);

        }
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