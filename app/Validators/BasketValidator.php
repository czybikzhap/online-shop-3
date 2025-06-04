<?php

namespace app\Validators;

class BasketValidator
{
    public static function validateAddProduct(array $data): array
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

    public static function validateQuantity($quantity): bool
    {
        return is_numeric($quantity) && $quantity > 0;
    }

    public static function validateQuantityUpdate(mixed $productId, mixed $quantity): bool
    {
        return isset($productId, $quantity)
            && is_numeric($productId)
            && is_numeric($quantity)
            && (int)$quantity > 0;
    }

}