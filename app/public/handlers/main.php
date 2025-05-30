<?php

session_start();
if (!isset($_SESSION['id'])) {
    header('Location :/login');
}
//print_r($_SESSION['id']);

//print_r($_COOKIE['user']);
$conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');
$products = $conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
//print_r($products);

require_once "./views/main.phtml";



