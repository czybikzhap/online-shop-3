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


}