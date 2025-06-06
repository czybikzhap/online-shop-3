<?php

namespace app\Services;

use app\Model\Basket;
use app\Model\User;
use app\Validators\BasketValidator;

class BasketService
{

    public function totalCost(int $userId): int
    {
        $userProducts = User::userProducts($userId);

        $totalCost = 0;

        foreach ($userProducts as $userProduct) {
            $cost = $userProduct['quantity'] * $userProduct['price'];
            $totalCost += $cost;
        }

        return $totalCost;

    }

    public function addProduct(array $data, int $userId): array
    {
        $errors = BasketValidator::validateAddProduct($data);

        if (!empty($errors)) {
            return $errors;
        }

        $productId = $data['product_id'];

        $basket = new Basket($userId, $productId);
        $basket->addProducts();

        return $errors;
    }


    public function clearBasket(int $userId): void
    {
        Basket::delete($userId);
    }

    public function deleteProduct($userId, $data)
    {
        Basket::deleteProduct($userId, $data);
    }

    public function updateQuantity(int $userId, int $productId, int $quantity): array
    {

        if (!BasketValidator::validateQuantityUpdate($productId, $quantity)) {
            return ['error' => 'Некорректное количество или ID товара'];
        }

        Basket::updateQuantity($userId, $productId, $quantity);

        return [];
    }




}