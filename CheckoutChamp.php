<?php

/**
 *
 * @link              https://checkoutchamp.com
 * @since             4.0.0
 * @package           CheckoutChamp
 *
 * @wordpress-plugin
 * Plugin Name:       CheckoutChamp
 * Plugin URI:        https://checkoutchamp.com/plugin/woo
 * Description:       Give Your WooCommerce Store An Unfair Advantage With Checkout Champ.
 * Version:           4.0.0
 * Author: <a href="https://checkoutchamp.com">CheckoutChamp</a>
 * Author URI:        https://checkoutchamp.com
 * License:           GPLv3 or later
 * Text Domain:       CheckoutChamp
 */


namespace CheckoutChamp;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';



use CheckoutChamp\Includes\CheckoutChamp_Loader;
use CheckoutChamp\Includes\Functions\Functions_Loader;
use CheckoutChamp\Includes\Logger\LoggerManager;

use CheckoutChamp\Includes\Routes\Routes_loader;
use CheckoutChamp\Includes\Activator;
use CheckoutChamp\Includes\Deactivator;


define("CHECKOUTCHAMP_VERSION", "4.0.0");
define("CHECKOUTCHAMP_DIR", plugin_dir_path(__FILE__));

try {

	$plugin =  new CheckoutChamp_Loader();
	$functions = new Functions_Loader();

	register_activation_hook(__FILE__, function () {
		Activator::activate();
	});
	register_deactivation_hook(__FILE__, function () {
		Deactivator::deactivate();
	});
} catch (\Throwable $th) {
	LoggerManager::log($th->getMessage(), __FILE__, __LINE__);

	add_action('admin_notices', function () {
?>
		<div class="notice notice-error is-dismissible">
			<p>Checkout Champ Plugin is not working properly. Please contact the plugin author.</p>
		</div>
<?php
	});
}
