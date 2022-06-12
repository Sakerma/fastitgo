<?php
    require_once(dirname(__FILE__).'/lib/config.php');
    require_once(dirname(__FILE__).'/lib/db.php');

    $orders = array_merge(
        Db::getOrders('new'),
        Db::getOrders('pending'),
        Db::getOrders('paid'),
        Db::getOrders('delivery')
    );
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
    <link href="./assets/css/list.css" rel="stylesheet">
  </head>
  <body>

    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg bg-light">
          <div class="container-fluid">
            <a class="navbar-brand" href="#">FastItGo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            </div>
            <a href="./new.php" class="btn btn-primary navbar-new-button" type="button">
              <i class="bi-bag-plus"></i>
              Nouvelle commande
            </a>
          </div>
        </nav>
        <div class="row">
            <div class="col col-12">
                <h1>Commandes en cours</h1>
                <?php if (empty($orders)) : ?>
                <h3>Aucune commande en cours</h3>
                <?php else: ?>
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Statut</th>
                        <th>Nb. élém.</th>
                        <th>Client</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                    <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td><?= $order->getId() ?></td>
                        <td><?= $order->getStatusText() ?></td>
                        <td><?= count($order->getItems()) ?></td>
                        <td>
                            <div>
                                <strong>
                                    <?= $order->getFirstname() ?>
                                    <?= $order->getLastname() ?>
                                </strong>
                            </div>
                            <div>
                                <?= $order->getEmail() ?>
                            </div>
                            <div>
                                <?= $order->getStreet() ?>
                                <?= $order->getZip() ?>
                                <?= $order->getCity() ?>
                            </div>
                        </td>
                        <td><?= number_format($order->getAmount() / 100, 2) ?> €</td>
                        <td>
                            <?php if (in_array($order->getStatus(), ['paid', 'delivery', 'completed'])) : ?>
                            <a href="<?= Config::$base ?>/order.php?id=<?= $order->getId() ?>" class="btn btn-info">
                                <i class="bi bi-eye"></i>
                                Voir
                            </a>
                            <?php endif; ?>
                            <?php if (in_array($order->getStatus(), ['new', 'pending'])) : ?>
                            <a href="<?= Config::$base ?>/new.php?order_id=<?= $order->getId() ?>" class="btn btn-warning">
                                <i class="bi bi-pencil"></i>
                                Modifier
                            </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        setInterval(function() {
            window.location.reload();
        }, 10000);
    </script>
  </body>
</html>
