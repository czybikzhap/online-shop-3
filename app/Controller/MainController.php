<?php

namespace app\Controller;

use app\Model\Products;
use app\Model\User;
use app\Services\ProductService;

class MainController
{

    public function main(): array
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        return [
            'view' => 'home/index',
            'data' => [
                'pageTitle' => 'Каталог товаров',
            ]
        ];
    }

    public function catalog()
    {
        session_start();

        $products = Products::getProducts();

        return [
            'view' => 'catalog',
            'data' => [
                'pageTitle' => 'Каталог товаров',
                'products' => $products,
            ]
        ];

    }

    public function editProduct()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location :/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $data = [
                'id' => $_POST['product_id'],
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'image_url' => $_POST['image_url'] ?? null // Если image_url не передан, будет null
            ];

            $updateProduct = new ProductService();
            $errors = $updateProduct->updateProduct($data);

            $products = Products::getProducts();

            return   [
                'view' => 'admin/updateCatalog',
                'data' => [
                    'errors' => $errors,
                    'products' => $products,
                ]
            ];

        }


    }


    public function deleteProduct()
    {
        session_start();

        $userId = $_SESSION['user_id'];

        $user = User::getUserById($userId);

        if ($user['role'] === 'admin') {

            if ($_SERVER['REQUEST_METHOD'] === "POST") {

                $productId = $_POST['product_id'];

                Products::deleteProduct($productId);

                $products = Products::getProducts();

                return   [
                    'view' => 'admin/updateCatalog',
                    'data' => [
                        'products' => $products,
                    ]
                ];

            }

        } else {

            require_once '../View/notFound.html';
        }



    }

}

