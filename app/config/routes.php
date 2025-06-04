<?php

use app\Controller\BasketController;
use app\Controller\MainController;
use app\Controller\UserController;
use app\Controller\OrderController;

return [
    '/register' => [UserController::class, 'register'],
    '/login' => [UserController::class, 'login'],
    '/main' => [MainController::class, 'main'],
    '/catalog' => [MainController::class, 'catalog'],
    '/basket' => [BasketController::class, 'basket'],
    '/addProduct' => [BasketController::class, 'addProducts'],
    '/logout' => [UserController::class, 'logout'],
    '/updateQuantity' => [BasketController::class, 'updateQuantity'],
    '/deleteProduct' => [BasketController::class, 'deleteProduct'],
    '/delete' => [BasketController::class, 'delete'],
    '/getOrders' => [OrderController::class, 'getOrders'],
    '/order' => [OrderController::class, 'order']

];