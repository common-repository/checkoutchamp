<?php

namespace CheckoutChamp\Includes\Admin\Partials;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class CheckoutChamp_Home
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function register_settings()
    {
        register_setting('checkout_champ_settings_general', 'checkout_champ_settings_general');

        register_setting('checkout_champ_settings_advanced', 'checkout_champ_settings_advanced');

        add_settings_section(
            'checkout_champ_section_general',
            'Checkout Champ General Settings',
            array($this, 'section_callback_general'),
            'checkout_champ_general'
        );

        add_settings_section(
            'checkout_champ_section_advanced',
            'Checkout Champ Advanced Settings',
            array($this, 'section_callback_advanced'),
            'checkout_champ_advanced'
        );

        add_settings_field(
            'checkout_champ_url',
            'Checkout Page URL',
            array($this, 'render_field'),
            'checkout_champ_general',
            'checkout_champ_section_general',
            ['field_key' => 'checkout_champ_url', 'field_type' => 'text', 'option_name' => 'checkout_champ_settings_general']
        );

        $advanced_fields = [
            'checkout_champ_max_product_per_order' => ['label' => 'Max Products Per Order', 'type' => 'number'],
            'checkout_champ_max_product_per_order_error_message' => ['label' => 'Error message for products number exceeded', 'type' => 'text'],
            'checkout_champ_min_product_per_order' => ['label' => 'Min Products Per Order', 'type' => 'number'],
            'checkout_champ_min_product_per_order_error_message' => ['label' => 'Error message for products number below', 'type' => 'text'],
            'checkout_champ_min_amount_per_order' => ['label' => 'Min Amount Per Order', 'type' => 'number'],
            'checkout_champ_min_amount_per_order_error_message' => ['label' => 'Error message for amount below', 'type' => 'text'],
            'checkout_champ_max_amount_per_order' => ['label' => 'Max Amount Per Order', 'type' => 'number'],
            'checkout_champ_max_amount_per_order_error_message' => ['label' => 'Error message for amount exceeded', 'type' => 'text'],
        ];

        foreach ($advanced_fields as $field_key => $field_data) {
            add_settings_field(
                $field_key,
                $field_data['label'],
                array($this, 'render_field'),
                'checkout_champ_advanced',
                'checkout_champ_section_advanced',
                ['field_key' => $field_key, 'field_type' => $field_data['type'], 'option_name' => 'checkout_champ_settings_advanced']
            );
        }
    }

    public function render_field($args)
    {
        $option_name = $args['option_name'];
        $options = get_option($option_name);
        $field_key = $args['field_key'];
        $field_type = $args['field_type'];
        $value = isset($options[$field_key]) ? esc_attr($options[$field_key]) : '';

        if ($value === '') {
            if ($field_type === 'number') {
                $value = 0;
            } elseif ($field_type === 'text') {
                $value = '';
            }
        }

        echo '<input type="' . esc_attr($field_type) . '" name="' . esc_attr($option_name) . '[' . esc_attr($field_key) . ']" value="' . esc_attr($value) . '">';
    }

    public function section_callback_general()
    {
        echo '<p>' . __('Configurez l\'URL pour Checkout Champ.', 'textdomain') . '</p>';
    }

    public function section_callback_advanced()
    {
        echo '<p>' . __('Configurez les autres paramètres avancés.', 'textdomain') . '</p>';
    }

    public function admin_menu()
    {
        $icon_base64 = "PD94bWwgdmVyc2lvbj0iMS4wIiBzdGFuZGFsb25lPSJubyI...";
        $icon_data_uri = 'data:image/svg+xml;base64,' . $icon_base64;

        add_menu_page(
            'Checkout Champ',
            'Checkout Champ',
            'manage_options',
            'checkout_champ',
            array($this, 'options_page'),
            $icon_data_uri,
            4
        );
    }

    public function options_page()
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';
?>

        <div class="wrap">
            <div class="checkout-champ-container">
                <div class="image-container">
                    <img class="CCR_img" src="https://checkout-api.com/assets/checkout_champ_logo.png" alt="checkout champ logo" />
                </div>
                <div class="checkout-champ-nav">
                    <a href="?page=checkout_champ&tab=general" class="checkout-champ-nav-tab <?php echo $active_tab === 'general' ? 'checkout-champ-nav-active' : ''; ?>"><?php _e('General', 'textdomain'); ?></a>
                    <a href="?page=checkout_champ&tab=advanced" class="checkout-champ-nav-tab <?php echo $active_tab === 'advanced' ? 'checkout-champ-nav-active' : ''; ?>"><?php _e('Advanced', 'textdomain'); ?></a>
                </div>


                <form class="column" method="post" action="options.php" style="margin-top: 0;">
                    <?php
                    if ($active_tab === 'general') {
                        settings_fields('checkout_champ_settings_general');
                    ?>

                        <div class="row" style="display: flex; flex-direction: column;">
                            <label for="checkout_champ_url">Enter the URL of your CheckoutChamp checkout page. This link will direct customers to complete their purchases securely.</label>
                            <input style="width: 700px; margin-top: 10px;align-self: baseline;" type="text" name="checkout_champ_settings_general[checkout_champ_url]" value="<?php echo esc_attr(get_option('checkout_champ_settings_general')['checkout_champ_url']); ?>">
                        </div>


                        <div class="submit">
                            <?php submit_button(); ?>
                        </div>
                    <?php

                    } else {
                        settings_fields('checkout_champ_settings_advanced');
                    ?>
                        <table class="checkout-champ-advanced">
                            <thead>
                                <tr>
                                    <th>Parameters</th>
                                    <th>Count</th>
                                    <th>Error message</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Max Products Per Order</td>
                                    <td><input type="number" name="checkout_champ_settings_advanced[checkout_champ_max_product_per_order]" value="<?php echo esc_attr(get_option('checkout_champ_settings_advanced')['checkout_champ_max_product_per_order']); ?>"></td>
                                    <td><input type="text" name="checkout_champ_settings_advanced[checkout_champ_max_product_per_order_error_message]" value="<?php echo esc_attr(get_option('checkout_champ_settings_advanced')['checkout_champ_max_product_per_order_error_message']); ?>"></td>
                                </tr>
                                <tr>
                                    <td>Min Products Per Order</td>
                                    <td><input type="number" name="checkout_champ_settings_advanced[checkout_champ_min_product_per_order]" value="<?php echo esc_attr(get_option('checkout_champ_settings_advanced')['checkout_champ_min_product_per_order']); ?>"></td>
                                    <td><input type="text" name="checkout_champ_settings_advanced[checkout_champ_min_product_per_order_error_message]" value="<?php echo esc_attr(get_option('checkout_champ_settings_advanced')['checkout_champ_min_product_per_order_error_message']); ?>"></td>
                                </tr>
                                <tr>
                                    <td>Min Amount Per Order</td>
                                    <td><input type="number" name="checkout_champ_settings_advanced[checkout_champ_min_amount_per_order]" value="<?php echo esc_attr(get_option('checkout_champ_settings_advanced')['checkout_champ_min_amount_per_order']); ?>"></td>
                                    <td><input type="text" name="checkout_champ_settings_advanced[checkout_champ_min_amount_per_order_error_message]" value="<?php echo esc_attr(get_option('checkout_champ_settings_advanced')['checkout_champ_min_amount_per_order_error_message']); ?>"></td>
                                </tr>
                                <tr>
                                    <td>Max Amount Per Order</td>
                                    <td><input type="number" name="checkout_champ_settings_advanced[checkout_champ_max_amount_per_order]" value="<?php echo esc_attr(get_option('checkout_champ_settings_advanced')['checkout_champ_max_amount_per_order']); ?>"></td>
                                    <td><input type="text" name="checkout_champ_settings_advanced[checkout_champ_max_amount_per_order_error_message]" value="<?php echo esc_attr(get_option('checkout_champ_settings_advanced')['checkout_champ_max_amount_per_order_error_message']); ?>"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="submit">
                            <?php submit_button(); ?>
                        </div>
                    <?php

                    }

                    ?>
                </form>
            </div>
        </div>
<?php
    }
}
