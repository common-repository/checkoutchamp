<?php

namespace CheckoutChamp\Includes;

use CheckoutChamp\Includes\Admin\Admin_Page_Loader;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class CheckoutChamp_Loader
{
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    3.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    3.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since   3.0.0
	 */
	public function __construct()
	{
		if (defined('CHECKOUTCHAMP_VERSION')) {
			$this->version = CHECKOUTCHAMP_VERSION;
		} else {
			$this->version = '3.0.0';
		}
		$this->plugin_name = 'CheckoutChamp';
		$this->define_admin_hooks();
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    3.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{
		$plugin_admin = new Admin_Page_Loader($this->get_plugin_name(), $this->get_version());
		$plugin_admin->load();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     3.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     3.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}
}
