<?php

namespace App\Model;

use PDO;

class Basket
{
    private int $id;
    private int $userId;
    private int $productId;

    private PDO $conn;

    public function __construct(int $userId, $productId)
    {
        $this->userId = $userId;
        $this->productId = $productId;

        $this->conn = ConnectFactory::connectDB();
    }

    public static function getBasket (int $userId): array|null
    {
        $stmt = ConnectFactory::connectDB()->prepare("SELECT * FROM baskets 
         WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $data;
    }


    public function AddProducts(): array
    {
        $stmt = $this->conn->prepare("INSERT INTO baskets (user_id, product_id, amount)
            VALUES (:user_id, :product_id, 1)
            ON CONFLICT (user_id, product_id) 
            DO UPDATE SET amount = baskets.amount + EXCLUDED.amount");
        $stmt->execute(['user_id' => $this->userId, 'product_id' => $this->productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    public static function delete (int $userId): void
    {
        $stmt = ConnectFactory::connectDB()->prepare('DELETE FROM baskets 
       WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $userId]);
    }

    public static function deleteProduct($userId, $productId): void
    {
        $stmt = ConnectFactory::connectDB()->prepare('DELETE FROM baskets 
       WHERE user_id = :user_id AND product_id = :product_id');
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }


}