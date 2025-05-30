<?php

use App\Controller\BasketController;
use App\Controller\MainController;
use App\Controller\UserController;

return [
    '/signup' => [UserController::class, 'signup'],
    '/login' => [UserController::class, 'login'],
    '/main' => [MainController::class, 'main'],
    '/basket' => [BasketController::class, 'basket'],
    '/addProduct' => [BasketController::class, 'addProducts'],
    '/logout' => [UserController::class, 'logout'],
    '/deleteProduct' => [BasketController::class, 'deleteProduct'],
    '/delete' => [BasketController::class, 'delete']

];