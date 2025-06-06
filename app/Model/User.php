<?php

namespace app\Model;


class User
{
    private int $id;
    private string $name;
    private string $email;
    private string $hash;


    public function __construct(string $name, string $email, string $hash)
    {
        $this->name = $name;
        $this->email = $email;
        $this->hash = $hash;
    }

    public function createUser(): array|false
    {
        $stmt = ConnectFactory::connectDB()->prepare("INSERT INTO users (name, email, password) 
            VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $this->name, 'email' => $this->email, 'password' => $this->hash]);

        return $stmt->fetch();
    }

    public static function getUserByEmail(string $email): User|null
    {
        $stmt = ConnectFactory::connectDB()->prepare("SELECT * FROM users WHERE email = :email ");
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        $user = new User($data['name'], $data['email'], $data['password']);
        $user->setUserId($data['id']);

        return $user;
    }

    public static function getUserById(int $id): array|null
    {
        $stmt = ConnectFactory::connectDB()->prepare("SELECT * FROM users WHERE id = :id ");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return $data;
    }

    public static function updateUser(int $id, string $name, string $email, ?string $password = null): array
    {
        // Если пароль не передан, оставляем старый
        if ($password) {
            $query = "UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id";
        } else {
            $query = "UPDATE users SET name = :name, email = :email WHERE id = :id";
        }

        $stmt = ConnectFactory::connectDB()->prepare($query);

        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'id' => $id
        ]);

        return self::getUserById($id);
    }



    public static function userProducts($userId)
    {
        $stmt = ConnectFactory::connectDB()->prepare("SELECT 
            products.id, 
            products.name, 
            products.price, 
            products.image_url,
            baskets.quantity
            FROM baskets
            JOIN products ON products.id = baskets.product_id
            WHERE baskets.user_id = :user_id
        ");

        $stmt->execute(['user_id' => $userId]);
        $products = $stmt->fetchAll();

        return $products;
    }

    public function getPassword(): string
    {
        return $this->hash;
    }

    public function setUserId(int $id): int
    {
        return $this->id = $id;
    }

    public function getUserId(): int
    {
        return $this->id;
    }

}