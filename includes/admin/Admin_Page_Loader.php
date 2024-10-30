<?php

namespace CheckoutChamp\Includes\Admin;

use CheckoutChamp\Includes\Admin\Partials\CheckoutChamp_Home;
use CheckoutChamp\Includes\Logger\LoggerManager;
use CheckoutChamp\Includes\Admin\Partials\Contact\CheckoutChamp_Contact;


if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Admin_Page_Loader
{

    /**
     * The ID of this plugin.
     *
     * @since    3.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    3.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    3.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function load()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_cummon_styles'));
        $this->plugin_menu();
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    3.0.0
     */
    public function enqueue_admin_styles()
    {
        wp_enqueue_style('checkoutchamp-home', plugin_dir_url(__FILE__) . 'css/Checkoutchamp_home.css', array(), $this->version + time(), 'all');
        wp_enqueue_style('checkoutchamp-contact', plugin_dir_url(__FILE__) . 'css/Checkoutchamp_contact.css', array(), $this->version + time(), 'all');
    }

    public function enqueue_cummon_styles()
    {
        wp_enqueue_style('checkoutchamp-cummon', plugin_dir_url(__FILE__) . 'css/Checkoutchamp_buttons.css', array(), $this->version + time(), 'all');
    }

    public function plugin_menu()
    {
        new CheckoutChamp_Home();
        new CheckoutChamp_Contact();
    }
}
