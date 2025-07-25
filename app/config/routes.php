<?php

use app\Controller\AdminController;
use app\Controller\BasketController;
use app\Controller\MainController;
use app\Controller\UserController;
use app\Controller\OrderController;

return [
    '/register' => [UserController::class, 'register'],
    '/login' => [UserController::class, 'login'],
    '/getProfile' => [UserController::class, 'getProfile'],
    '/editProfile' => [UserController::class, 'editProfile'],
    '/main' => [MainController::class, 'main'],
    '/catalog' => [MainController::class, 'catalog'],
    '/basket' => [BasketController::class, 'basket'],
    '/addProduct' => [BasketController::class, 'addProducts'],
    '/logout' => [UserController::class, 'logout'],
    '/updateQuantity' => [BasketController::class, 'updateQuantity'],
    '/deleteProductInBasket' => [BasketController::class, 'deleteProductInBasket'],
    '/delete' => [BasketController::class, 'delete'],
    '/getOrders' => [OrderController::class, 'getOrders'],
    '/order' => [OrderController::class, 'order'],
    '/admin' => [AdminController::class, 'dashboard'],
    '/updateCatalog' => [AdminController::class, 'updateCatalog'],
    '/editProduct' => [MainController::class, 'editProduct'],
    '/deleteProduct' => [MainController::class, 'deleteProduct']

];