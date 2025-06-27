<?php

namespace app\Model;

use PDO;

class Products
{

    public static function getProducts (): array
    {
        return ConnectFactory::connectDB()->query("SELECT * FROM products")
            ->fetchAll(PDO::FETCH_ASSOC);

    }

    public static function updateProduct(int $id, string $name, string $description, int $price, ?string $image_url = null): bool
    {
        if ($image_url) {
            $query = "UPDATE products 
                        SET name = :name, description = :description, price = :price, image_url = :image_url 
                            WHERE id = :id";
        } else {
            $query = "UPDATE products SET name = :name, description = :description, price = :price WHERE id = :id";
        }

        $stmt = ConnectFactory::connectDB()->prepare($query);

        $data = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'id' => $id
        ];

        if ($image_url !== null) {
            $data['image_url'] = $image_url;
        }

        return $stmt->execute($data);

    }

    public static function deleteProduct(int $productId)
    {
        $stmt = ConnectFactory::connectDB()->prepare('DELETE FROM products WHERE id = :product_id');

        $stmt->execute(['product_id' => $productId]);
        
    }


}