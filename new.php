<?php
    require_once(dirname(__FILE__).'/lib/config.php');
    require_once(dirname(__FILE__).'/lib/db.php');
    require_once(dirname(__FILE__).'/lib/order.php');

    if (isset($_REQUEST['order_id'])) {
        $order = Db::getOrder((int)$_REQUEST['order_id']);
    } else {
        $order = OrderHelper::getCurrent();
    }
    $products = Db::getProducts();
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
    <link href="./assets/css/new.css" rel="stylesheet">
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
            <a href="./list.php" class="btn btn-primary navbar-new-button" type="button">
              <i class="bi-list-task"></i>
              Liste des commandes
            </a>
          </div>
        </nav>
        <div class="row">
            <div class="col col-12">
            <h1>Commande #<?= $order->getId() ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col col-9">
                <?php include_once('views/new_products.php') ?>
            </div>
            <div class="col col-3">
                <?php include_once('views/new_order.php') ?>
            </div>
        </div>
    </div>

  </body>
</html>
