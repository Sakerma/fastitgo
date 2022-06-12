<div class="row">
    <?php foreach ($products as $product) : ?>
    <div class="col col-sm-3 new-product">
        <a href="<?= Config::$base ?>/router.php?controller=order&action=addItem&orderId=<?= $order->getId() ?>&productId=<?= $product->getId() ?>">
            <div class="new-product-name">
                <?= utf8_encode($product->getName()) ?>
            </div>
            <div class="new-product-price">
                <?= number_format($product->getPrice() / 100, 2) ?> &euro;
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>
