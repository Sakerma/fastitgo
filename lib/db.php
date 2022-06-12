<?php

require_once(dirname(__FILE__).'/../models/order.php');
require_once(dirname(__FILE__).'/../models/product.php');

/**
 * DB Helper
 *
 * Handle all the database stuff
 */
class Db
{
    /**
     * PDO connection
     */
    protected static $connection = null;

    protected static function connect()
    {
        if (is_null(static::$connection)) {
            static::$connection = new PDO(
                'mysql:host='.Config::$db_host.';dbname='.Config::$db_name,
                Config::$db_user,
                Config::$db_password,
                /*$driver_options*/NULL
            );
        }
    }

    public static function getOrders($status = null)
    {
        static::connect();

        $query = "
            SELECT orders.*, order_items.id as order_item_id, order_items.order_id, order_items.name, order_items.price, order_items.description, order_items.quantity
            FROM orders
            LEFT JOIN order_items ON orders.id = order_items.order_id";

        if (!is_null($status)) {
            $query .= " WHERE orders.status = ?";
        }

        $stm = static::$connection->prepare($query);
        if (!is_null($status)) {
            $stm->bindValue(1, $status);
        }

        $stm->execute();

        $orders = [];
        $items = $stm->fetchAll(PDO::FETCH_OBJ);

        foreach ($items as $item) {
            if (!isset($orders[$item->id])) {
                $orders[$item->id] = new Order(
                    $item->id,
                    $item->status,
                    $item->amount,
                    $item->firstname,
                    $item->lastname,
                    $item->email,
                    $item->street,
                    $item->zip,
                    $item->city,
                    []
                );
            }
            if ($item->order_item_id > 0) {
                $orders[$item->id]->addItem(new Product(
                    $item->order_item_id,
                    $item->name,
                    $item->description,
                    $item->price
                ));
            }
        }

        return array_values($orders);
    }

    public static function getOrder(int $id)
    {
        static::connect();

        $stm = static::$connection->prepare("
            SELECT orders.*, order_items.id as order_item_id, order_items.order_id, order_items.name, order_items.price, order_items.description, order_items.quantity
            FROM orders
            LEFT JOIN order_items ON orders.id = order_items.order_id
            WHERE orders.id = ?"
        );
        $stm->bindValue(1, $id);

        $stm->execute();

        $orders = [];
        $items = $stm->fetchAll(PDO::FETCH_OBJ);

        foreach ($items as $item) {
            if (!isset($orders[$item->id])) {
                $orders[$item->id] = new Order(
                    $item->id,
                    $item->status,
                    $item->amount,
                    $item->firstname,
                    $item->lastname,
                    $item->email,
                    $item->street,
                    $item->zip,
                    $item->city
                );
            }
            if ($item->order_item_id > 0) {
                $orders[$item->id]->addItem(new Product(
                    $item->order_item_id,
                    $item->name,
                    $item->description,
                    $item->price
                ));
            }
        }

        return current($orders);
    }

    public static function saveOrder(Order $order)
    {
        static::connect();

        if ($order->getId() > 0) {
            // existing order
            // delete linked products
            $stm = static::$connection->prepare("DELETE FROM order_items WHERE order_id = ?");
            $stm->bindValue(1, $order->getId());
            $stm->execute();

            // save order
            $stm = static::$connection->prepare("
                UPDATE orders
                SET status=?, amount=?, email=?, firstname=?, lastname=?, street=?, zip=?, city=?
                WHERE id=?"
            );
            $stm->bindValue(1, $order->getStatus());
            $stm->bindValue(2, $order->getAmount());
            $stm->bindValue(3, $order->getEmail());
            $stm->bindValue(4, $order->getFirstname());
            $stm->bindValue(5, $order->getLastname());
            $stm->bindValue(6, $order->getStreet());
            $stm->bindValue(7, $order->getZip());
            $stm->bindValue(8, $order->getCity());
            $stm->bindValue(9, $order->getId());
            $stm->execute();
        } else {
            // new order
            $stm = static::$connection->prepare("
                INSERT INTO orders(status, amount)
                VALUES(?, ?)"
            );
            $stm->bindValue(1, $order->getStatus());
            $stm->bindValue(2, $order->getAmount());
            $stm->execute();

            $order->setId(static::$connection->lastInsertId());
        }

        // insert linked products
        foreach ($order->getItems() as $item) {
            $stm = static::$connection->prepare("
                INSERT INTO order_items(order_id, name, price, description, quantity)
                VALUES (?, ?, ?, ?, 1)"
            );
            $stm->bindValue(1, $order->getId());
            $stm->bindValue(2, $item->getName());
            $stm->bindValue(3, $item->getPrice());
            $stm->bindValue(4, $item->getDescription());
            $stm->execute();
        }

        return $order;
    }

    public static function getProducts()
    {
        static::connect();

        $stm = static::$connection->prepare("SELECT * FROM products");
        $stm->execute();

        return array_map(function ($row) {
            return new Product(
                $row->id,
                $row->name,
                $row->description,
                $row->price
            );
        }, $stm->fetchAll(PDO::FETCH_OBJ));
    }

    public static function getProduct(int $id)
    {
        static::connect();

        $stm = static::$connection->prepare("
            SELECT * FROM products WHERE id = ?"
        );
        $stm->bindValue(1, $id);

        $stm->execute();

        $item = $stm->fetchObject();
        return new Product(
            $item->id,
            $item->name,
            $item->description,
            $item->price
        );
    }
}
