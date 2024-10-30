<?php

namespace CheckoutChamp\Includes;
use CheckoutChamp\Includes\Logger\LoggerManager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Deactivator
{
    public static function deactivate()
    {
        try {
            // Supprimer les options de réglages enregistrées pour "General"
            delete_option('checkout_champ_settings_general');
            
            // Supprimer les options de réglages enregistrées pour "Advanced"
            delete_option('checkout_champ_settings_advanced');

            // Supprimer également les sections si nécessaire
            unregister_setting('checkout_champ_settings_general', 'checkout_champ_settings_general');
            unregister_setting('checkout_champ_settings_advanced', 'checkout_champ_settings_advanced');
            
            // Supprimer les sections et champs enregistrés
            remove_action('admin_menu', array('CheckoutChamp\Includes\Admin\Partials\CheckoutChamp_Home', 'admin_menu'));
            remove_action('admin_init', array('CheckoutChamp\Includes\Admin\Partials\CheckoutChamp_Home', 'register_settings'));

        } catch (\Throwable $th) {
            LoggerManager::log($th->getMessage(), __FILE__, __LINE__);
        }
    }
}
