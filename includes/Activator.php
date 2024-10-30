<?php

namespace CheckoutChamp\Includes;


use CheckoutChamp\Includes\Logger\LoggerManager;


if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Activator
{

    public static function activate()
    {
        try {

        } catch (\Throwable $th) {
            LoggerManager::log($th->getMessage(), __FILE__, __LINE__);

        }
    }
}
