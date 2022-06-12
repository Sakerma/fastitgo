<?php
    require_once(dirname(__FILE__).'/lib/config.php');
    require_once(dirname(__FILE__).'/lib/db.php');

    $order = Db::getOrder($_REQUEST['id']);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="SNIR-2022">
    <meta name="generator" content="Hugo 0.98.0">
    <title>FastItGo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <!-- Favicons -->
    <link rel="icon" href="./assets/images/favicon.ico">
    <meta name="theme-color" content="#BE27DD">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
    </style>


    <!-- Custom styles for this template -->
    <link href="./assets/css/order.css" rel="stylesheet">
  </head>
  <body>

    <div class="container">
        <nav class="navbar navbar-expand-lg bg-light">
          <div class="container-fluid">
            <a class="navbar-brand" href="#">FastItGo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            </div>
          </div>
        </nav>
        <div class="row">
            <div class="col col-12 mt-3">
                <h3>Votre commande</h3>
            </div>
        </div>
        <div class="row">
            <div class="col col-12">
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
                    <div class="order-amount">
                        <?= $order->getStatusText() ?>
                    </div>
                </div>
            </div>
            <div class="form mt-3">
                <h3>Vos informations</h3>
                <form method="POST" action="<?= Config::$base.'/router.php?controller=order&action=setPaid' ?>">
                    <input type="hidden" name="orderId" value="<?= $order->getId() ?>" />
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-3">
                              <label for="email" class="form-label">Email</label>
                              <input name="order[email]" type="email" class="form-control" id="email" value="<?= $order->getEmail() ?>">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-3">
                              <label for="firstname" class="form-label">Prénom</label>
                              <input name="order[firstname]" type="firstname" class="form-control" id="firstname" value="<?= $order->getFirstname() ?>">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-3">
                              <label for="lastname" class="form-label">Nom</label>
                              <input name="order[lastname]" type="lastname" class="form-control" id="lastname" value="<?= $order->getLastname() ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-3">
                              <label for="street" class="form-label">Adresse</label>
                              <input name="order[street]" type="street" class="form-control" id="street" value="<?= $order->getStreet() ?>">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-3">
                              <label for="zip" class="form-label">Code postal</label>
                              <input name="order[zip]" type="zip" class="form-control" id="zip" value="<?= $order->getZip() ?>">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-3">
                              <label for="city" class="form-label">Ville</label>
                              <input name="order[city]" type="city" class="form-control" id="city" value="<?= $order->getCity() ?>">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-credit-card"></i>
                        <?= $order->getStatus() === 'pending' ? 'Payer ma commande' : 'Mettre à jour mes informations' ?>
                    </button>
                </form>
            </form>
        </div>
    </div>

  </body>
</html>
