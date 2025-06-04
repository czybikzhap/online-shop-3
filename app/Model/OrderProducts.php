<?php

namespace app\Model;

class OrderProducts
{
    private int $orderId;
    private int $productId;
    private int $quantity;


    public function __construct(int $orderId, int $productId, int $quantity)
    {
        $this->orderId= $orderId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }


    public function createOrderProducts()
    {
        $stmt = ConnectFactory::connectDB()->prepare("INSERT INTO order_products (order_id, product_id, quantity) 
                VALUES (:order_id, :product_id, :quantity)");
        $stmt->execute([
            'order_id' => $this->orderId,
            'product_id' => $this->productId,
            'quantity' => $this->quantity
        ]);

        return (int)ConnectFactory::connectDB()->lastInsertId();
    }


}