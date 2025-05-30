<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location :/login');
}

$userId = $_SESSION['id'];

$conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');
$basket = $conn->prepare("SELECT * FROM baskets WHERE user_id = :user_id");
$basket->execute(['user_id' => $userId]);
$basket = $basket->fetchAll();
print_r($basket);
echo '<br>';



require_once "./views/baskets.phtml";

