<?php

require_once(dirname(__FILE__).'/../lib/db.php');
require_once(dirname(__FILE__).'/../models/order.php');

/**
 * Order Helper
 *
 * Handle all the database stuff
 */
class OrderHelper
{
    /**
     * @var Order
     */
    protected static $current = null;

    public static function getCurrent()
    {
        if (is_null(static::$current)) {
            session_start();
            if (array_key_exists('order_id', $_SESSION)) {
                static::$current = Db::getOrder((int)$_SESSION['order_id']);
            } else {
                $order = new Order();
                Db::saveOrder($order);

                static::$current = $order;
                $_SESSION['order_id'] = $order->getId();
            }
        }

        return static::$current;
    }

    public static function releaseCurrent()
    {
        session_start();
        if (array_key_exists('order_id', $_SESSION)) {
            unset($_SESSION['order_id']);
        }

        static::$current = null;
    }
}
