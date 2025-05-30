<?php

namespace App\Controller;

use App\Model\Products;

class MainController
{

    public function main(): array
    {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location :/login');
        }

        $products = Products::getProducts();
        //print_r($products);

        return [
            'view' => 'main',
            'data' => [
                'products' => $products
            ]
        ];
    }

}

