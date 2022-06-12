<?php
require_once(dirname(__FILE__).'/lib/config.php');
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>FastItGo</title>

    <style>
        html, body, * {
            font-family: Verdana, Helvetica;
        }
    </style>
  </head>
  <body>

    <div style="text-align: center">
        <h1>Nous vous remercions pour votre commande</h1>
        <a style="background: #6565FF; padding: 20px; border: 1px solid #2c2c2c; color: #FFF; font-weight: bold; text-decoration: none; margin: 20px auto; display: block; max-width: 400px;" href="<?= Config::$base ?>/order.php?id=<?= $order->getId() ?>" >Cliquez ici pour procéder au paiement</a>
    </div>

  </body>
</html>
