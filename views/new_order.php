<div class="order">
    <div class="order-name">
        Commande #<?= $order->getId() ?>
    </div>
    <div class="order-products">
        <?php if (count($order->getItems()) > 0) : ?>
            <?php foreach ($order->getItems() as $i => $item) : ?>
            <div class="order-product">
                <div class="order-product-name">
                    <?= utf8_encode($item->getName()) ?>
                </div>
                <div class="order-product-price">
                    <?= number_format($item->getPrice() / 100, 2) ?>&euro;
                </div>
                <div class="order-product-remove">
                    <a href="<?= Config::$base ?>/router.php?controller=order&action=removeItem&orderId=<?= $order->getId() ?>&index=<?= $i ?>">
                        <i class="bi bi-trash fs-5 text-danger"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
        <div class="order-no-product-text">
            Aucun produit dans cette commande
        </div>
        <?php endif; ?>
    </div>
    <div class="order-amount">
        TOTAL: <?= number_format($order->getAmount() / 100, 2) ?> &euro;
    </div>
    <?php if (count($order->getItems()) > 0) : ?>
    <form class="order-validate" method="POST" action="<?= Config::$base ?>/router.php?controller=order&action=setPending&orderId=<?= $order->getId() ?>">
        <div class="input-group mb-3">
            <input type="email" name="email" value="<?= $order->getEmail() ?>" class="form-control" placeholder="Email du client" aria-label="Recipient's username" aria-describedby="button-addon2">
            <button class="btn btn-success btn-lg" type="submit">
                <i class="bi bi-bag-check"></i>
                Valider
            </button>
        </div>
    </form>
    <?php endif; ?>
</div>
