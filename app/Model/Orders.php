<?php

namespace app\Model;

class Orders
{

    private int $userId;
    private string $phone;
    private string $address;


    public function __construct(int $userId, string $phone, string $address)
    {
        $this->userId = $userId;
        $this->phone = $phone;
        $this->address = $address;
    }


    public function createOrder(): int
    {
        $stmt = ConnectFactory::connectDB()->prepare("INSERT INTO orders (user_id, phone, address) 
            VALUES (:user_id, :phone, :address)");

        $stmt->execute(['user_id' => $this->userId, 'phone' => $this->phone, 'address' => $this->address]);

        return (int)ConnectFactory::connectDB()->lastInsertId();

    }

}