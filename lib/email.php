<?php

require_once(dirname(__FILE__).'/../vendor/autoload.php');
require_once(dirname(__FILE__).'/../lib/config.php');
require_once(dirname(__FILE__).'/../models/order.php');
require_once(dirname(__FILE__).'/../models/product.php');

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

/**
 * Email Helper
 *
 * Handle all the email stuff
 */
class EmailHelper
{
    public static function sendOrderEmail(Order $order, string $email)
    {
        ob_start();
        include(dirname(__FILE__).'/../email.php');
        $content = ob_get_contents();
        ob_end_clean();

        // Set content-type header for sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // Additional headers 
        $headers .= 'From: '.Config::$emailFromName.'<'.COnfig::$emailFromEmail.'>' . "\r\n";

        return mail(
            $email,
            'Votre commande',
            $content,
            $headers
        );
    }

    public static function _sendOrderEmail(Order $order, string $email)
    {
        $transport = Transport::fromDsn(Config::$emailDsn);
        $mailer = new Mailer($transport);

        $email = (new Email())
            ->from(Config::$emailFromEmail)
            ->to($email)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $result = $mailer->send($email);

        return $result;
    }
}
