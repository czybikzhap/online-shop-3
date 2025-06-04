<?php

namespace app\Services;

use app\Model\Orders;
use app\Model\OrderProducts;
use app\Model\Basket;
use app\Model\ConnectFactory;

class OrderService
{
    public function createOrder(int $userId, string $phone, string $address): int|false
    {
        $db = ConnectFactory::connectDB();

        try {
            $db->beginTransaction();

            // Создаем заказ
            $order = new Orders($userId, $phone, $address);
            if (!$order->createOrder()) {
                throw new \Exception('Ошибка при создании заказа');
            }

            // Получаем ID последнего вставленного заказа
            $orderId = (int)$db->lastInsertId();

            // Получаем товары из корзины
            $basket = Basket::getBasket($userId);
            if (empty($basket)) {
                throw new \Exception('Корзина пуста');
            }

            // Добавляем товары в заказ
            foreach ($basket as $item) {
                $orderProducts = new OrderProducts($orderId, $item['product_id'], $item['quantity']);
                if (!$orderProducts->createOrderProducts()) {
                    throw new \Exception('Ошибка при добавлении товара в заказ');
                }
            }

            // Очищаем корзину
            Basket::delete($userId);

            $db->commit();

            return $orderId;

        } catch (\Exception $e) {
            $db->rollBack();
            error_log('Ошибка создания заказа: ' . $e->getMessage());
            return false;
        }
    }
}