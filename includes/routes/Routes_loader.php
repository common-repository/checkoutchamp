<?php

namespace CheckoutChamp\Includes\Routes;

use CheckoutChamp\utils\CheckoutChamp_state;
use CheckoutChamp\Includes\Logger\LoggerManager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Routes_loader
{

    public function __construct()
    {
        add_action('rest_api_init', array($this, 'register_routes'));
    }

    public function register_routes()
    {
       
    }

}
