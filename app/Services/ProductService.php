<?php

namespace app\Services;

use app\Model\Products;
use app\Validators\ProductValidator;

class ProductService
{
    public function updateProduct(array $data)
    {
        $errors = ProductValidator::validateProduct($data);

        if (!empty($errors)) {
            return $errors;
        } else {
            Products::updateProduct($data['id'], $data['name'], $data['description'], $data['price']);
        }

        return $errors;

    }

}