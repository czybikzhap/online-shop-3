<?php

namespace app\Controller;

use app\Model\Products;

class MainController
{

    public function main(): array
    {
        session_start();

        // Проверка на авторизацию
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        return [
            'view' => 'home/index', // Путь к представлению
            'data' => [
                'pageTitle' => 'Каталог товаров', // Заголовок страницы
            ]
        ];
    }

    public function catalog()
    {
        session_start();

        $products = Products::getProducts();

        // Параметры для шаблона
        return [
            'view' => 'catalog', // Путь к представлению
            'data' => [
                'pageTitle' => 'Каталог товаров', // Заголовок страницы
                'products' => $products, // Если переменная $products не существует, передаем пустой массив
            ]
        ];


    }

}

