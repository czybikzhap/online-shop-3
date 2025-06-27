<?php

namespace app\Validators;

class ProductValidator
{
    public static function validateProduct(array $data): array
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = 'Название не может быть пустым.';
        }

        if (empty($data['description'])) {
            $errors['description'] = 'Описание не может быть пустым.';
        }

        if (!isset($data['price']) || !is_numeric($data['price']) || $data['price'] < 0) {
            $errors['price'] = 'Цена должна быть положительным числом.';
        }

        return $errors;

    }

}