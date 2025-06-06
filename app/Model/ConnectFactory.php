<?php

namespace app\Model;

use PDO;

class ConnectFactory
{
    private static PDO $conn;

    public static function connectDB(): PDO
    {
        if (isset(static::$conn)) {
            return static::$conn;
        }
        static::$conn = new PDO('pgsql:host=db; dbname=dbname',
            'dbuser', 'dbpwd');

        return static::$conn;
    }
}
