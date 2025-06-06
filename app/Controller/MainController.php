<?php

namespace app\Controller;

use app\Model\Products;

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

    public function getAdminCatalog()
    {


    }

}

