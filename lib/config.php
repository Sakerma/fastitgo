<?php

require_once(dirname(__FILE__).'/../models/order.php');
require_once(dirname(__FILE__).'/../models/product.php');

/**
 * Config Helper
 *
 * Handle all the configuration stuff
 */
class Config
{
    // routes base
    public static $base = 'https://b-alidra.com/fastitgo';

    // database
    public static $db_host = 'localhost';
    public static $db_user = 'fastitgo';
    public static $db_password = '';
    public static $db_name = 'fastitgo';

    // emails
    public static $emailDsn = 'gmail+smtp://fastitgodev@gmail.com:Fastitgo123456@smtp.gmail.com?verify_peer=0';
    public static $emailHost = 'smtp.gmail.com';
    public static $emailUser = 'fastitgodev';
    public static $emailPassword = 'Fastitgo123456';
    public static $emailFromEmail = 'fastitgodev@gmail.com';
    public static $emailFromName = 'FastItGo';
}
