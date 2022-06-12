<?php
/**
 * Main app router
 */

require_once(dirname(__FILE__).'/lib/config.php');
require_once(dirname(__FILE__).'/lib/db.php');
require_once(dirname(__FILE__).'/lib/email.php');
require_once(dirname(__FILE__).'/lib/order.php');

$controller = array_key_exists('controller', $_REQUEST) ? $_REQUEST['controller'] : null;
$action = array_key_exists('action', $_REQUEST) ? $_REQUEST['action'] : null;

if (empty($controller) || empty($action)) {
    redirect();
}

if ($controller === 'order') {
    switch ($action) {
        case 'addItem':
            $orderId = array_key_exists('orderId', $_REQUEST) ? $_REQUEST['orderId'] : null;
            $productId = array_key_exists('productId', $_REQUEST) ? $_REQUEST['productId'] : null;
            return addOrderItem($orderId, $productId);
        case 'removeItem':
            $orderId = array_key_exists('orderId', $_REQUEST) ? $_REQUEST['orderId'] : null;
            $index = array_key_exists('index', $_REQUEST) ? $_REQUEST['index'] : null;
            return removeOrderItem($orderId, $index);
        case 'setPending':
            $orderId = array_key_exists('orderId', $_REQUEST) ? $_REQUEST['orderId'] : null;
            $email = array_key_exists('email', $_REQUEST) ? $_REQUEST['email'] : null;
            return setOrderPending($orderId, $email);
        case 'setPaid':
            $orderId = array_key_exists('orderId', $_REQUEST) ? $_REQUEST['orderId'] : null;
            $orderData = array_key_exists('order', $_REQUEST) ? $_REQUEST['order'] : null;
            return setOrderPaid($orderId, $orderData);
        case 'setInDelivery':
            $orderId = array_key_exists('orderId', $_REQUEST) ? $_REQUEST['orderId'] : null;
            return setOrderInDelivery($orderId);
        case 'setDelivered':
            $orderId = array_key_exists('orderId', $_REQUEST) ? $_REQUEST['orderId'] : null;
            return setOrderDelivered($orderId);
    }
}

redirect();

function addOrderItem($orderId, $productId)
{
    $order = Db::getOrder($orderId);
    if (!$order) {
        redirect();
    }

    $product = Db::getProduct($productId);
    if (!$product) {
        redirect();
    }

    $order->addItem($product);
    Db::saveOrder($order);

    redirect(Config::$base.'/new.php');
}

function removeOrderItem($orderId, $index)
{
    $order = Db::getOrder($orderId);
    if (!$order) {
        redirect();
    }

    $order->removeItem($index);
    Db::saveOrder($order);

    redirect(Config::$base.'/new.php');
}

function setOrderPending($orderId, $email)
{
    $order = Db::getOrder($orderId);
    if (!$order) {
        redirect();
    }

    $order->setEmail($email)->setPending();
    Db::saveOrder($order);

    EmailHelper::sendOrderEmail($order, $email);

    OrderHelper::releaseCurrent();
    redirect(Config::$base.'/list.php');
}

function setOrderPaid($orderId, $orderData)
{
    $order = Db::getOrder($orderId);
    if (!$order) {
        redirect();
    }

    $order
        ->setEmail($orderData['email'])
        ->setFirstname($orderData['firstname'])
        ->setLastname($orderData['lastname'])
        ->setStreet($orderData['street'])
        ->setZip($orderData['zip'])
        ->setCity($orderData['city'])
        ->setPaid();

    Db::saveOrder($order);
    redirect(Config::$base.'/order.php?id='.$orderId);
}

function setOrderInDelivery($orderId)
{
    $order = Db::getOrder($orderId);
    if (!$order) {
        redirect();
    }

    $order->setInDelivery();
    Db::saveOrder($order);

    redirect(Config::$base.'/delivery.php');
}

function setOrderDelivered($orderId)
{
    $order = Db::getOrder($orderId);
    if (!$order) {
        redirect();
    }

    $order->setDelivered();
    Db::saveOrder($order);

    redirect(Config::$base.'/delivery.php');
}

function redirect($target = '/')
{
    header('Location: '.$target);
    exit();
}
