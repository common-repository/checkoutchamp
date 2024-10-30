<?php

namespace CheckoutChamp\Includes\Functions;

use CheckoutChamp\Includes\Logger\LoggerManager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Functions_Loader
{
    public function __construct()
    {
        add_action('init', [$this, 'load_buttons']);
    }

    public function load_buttons()
    {
        try {
            add_action('woocommerce_before_mini_cart',   [$this, 'checkoutchamp_notice'], 20);
            add_action('woocommerce_cart_totals_before_order_total', [$this, 'checkoutchamp_notice'], 20);

            remove_action( 'woocommerce_proceed_to_checkout','woocommerce_button_proceed_to_checkout', 20);
            remove_action( 'woocommerce_proceed_to_checkout','checkoutchamp_checkout_button', 20);
            add_action( 'woocommerce_proceed_to_checkout', [$this,'checkoutchamp_checkout_button']  , 20);

            remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );
            add_action( 'woocommerce_widget_shopping_cart_buttons', [$this,'checkoutchamp_checkout_button'], 20 );

        } catch (\Throwable $th) {
            LoggerManager::log_error($th->getMessage(), __FILE__, __LINE__);
        }
    }

    public function checkoutchamp_notice($type){
      try {
        $general_options = get_option('checkout_champ_settings_general');
        $advanced_options = get_option('checkout_champ_settings_advanced');
        $base_url = isset($general_options['checkout_champ_url']) ? esc_url($general_options['checkout_champ_url']) : "https://test.com";

        $checkout_champ_max_product_per_order = isset($advanced_options['checkout_champ_max_product_per_order']) ? esc_attr($advanced_options['checkout_champ_max_product_per_order']) : 0;
        $checkout_champ_max_product_per_order_error_message = isset($advanced_options['checkout_champ_max_product_per_order_error_message']) ? esc_attr($advanced_options['checkout_champ_max_product_per_order_error_message']) : "";
        
        $checkout_champ_min_product_per_order = isset($advanced_options['checkout_champ_min_product_per_order']) ? esc_attr($advanced_options['checkout_champ_min_product_per_order']) : 0;
        $checkout_champ_min_product_per_order_error_message = isset($advanced_options['checkout_champ_min_product_per_order_error_message']) ? esc_attr($advanced_options['checkout_champ_min_product_per_order_error_message']) : "";
        
        $checkout_champ_min_amount_per_order = isset($advanced_options['checkout_champ_min_amount_per_order']) ? esc_attr($advanced_options['checkout_champ_min_amount_per_order']) : 0;
        $checkout_champ_min_amount_per_order_error_message = isset($advanced_options['checkout_champ_min_amount_per_order_error_message']) ? esc_attr($advanced_options['checkout_champ_min_amount_per_order_error_message']) : "";
        
        $checkout_champ_max_amount_per_order = isset($advanced_options['checkout_champ_max_amount_per_order']) ? esc_attr($advanced_options['checkout_champ_max_amount_per_order']) : 0;
        $checkout_champ_max_amount_per_order_error_message = isset($advanced_options['checkout_champ_max_amount_per_order_error_message']) ? esc_attr($advanced_options['checkout_champ_max_amount_per_order_error_message']) : "";

        $cart = WC()->cart;

        if($cart->is_empty()){
            return;
        }

        if($checkout_champ_max_product_per_order > 0){
            $cart_count = $cart->get_cart_contents_count();
            if($cart_count > $checkout_champ_max_product_per_order){
                echo '<div class="woocommerce-info">' . esc_html($checkout_champ_max_product_per_order_error_message) . '</div>';
            }
        }

        if($checkout_champ_min_product_per_order > 0){
            $cart_count = $cart->get_cart_contents_count();
            if($cart_count < $checkout_champ_min_product_per_order){
                echo '<div class="woocommerce-info">' . esc_html($checkout_champ_min_product_per_order_error_message) . '</div>';
            }
        }
    
        if($checkout_champ_min_amount_per_order > 0){
            $cart_total = $cart->get_cart_contents_total();
            if($cart_total < $checkout_champ_min_amount_per_order){
                echo '<div class="woocommerce-info">' . esc_html($checkout_champ_min_amount_per_order_error_message) . '</div>';
            }
        }

        if($checkout_champ_max_amount_per_order > 0){
            $cart_total = $cart->get_cart_contents_total();
            if($cart_total > $checkout_champ_max_amount_per_order){
                echo '<div class="woocommerce-info">' . esc_html($checkout_champ_max_amount_per_order_error_message) . '</div>';
            }
        }
    }catch (\Throwable $th) {
        LoggerManager::log_error($th->getMessage(), __FILE__, __LINE__);
    }
}

    public function checkoutchamp_checkout_button() {
        try {
            $general_options = get_option('checkout_champ_settings_general');
            $advanced_options = get_option('checkout_champ_settings_advanced');
            $base_url = isset($general_options['checkout_champ_url']) ? esc_url($general_options['checkout_champ_url']) : site_url();
            
            $checkout_champ_max_product_per_order = isset($advanced_options['checkout_champ_max_product_per_order']) ? esc_attr($advanced_options['checkout_champ_max_product_per_order']) : 0;
            $checkout_champ_max_product_per_order_error_message = isset($advanced_options['checkout_champ_max_product_per_order_error_message']) ? esc_attr($advanced_options['checkout_champ_max_product_per_order_error_message']) : "";
            
            $checkout_champ_min_product_per_order = isset($advanced_options['checkout_champ_min_product_per_order']) ? esc_attr($advanced_options['checkout_champ_min_product_per_order']) : 0;
            $checkout_champ_min_product_per_order_error_message = isset($advanced_options['checkout_champ_min_product_per_order_error_message']) ? esc_attr($advanced_options['checkout_champ_min_product_per_order_error_message']) : "";
            
            $checkout_champ_min_amount_per_order = isset($advanced_options['checkout_champ_min_amount_per_order']) ? esc_attr($advanced_options['checkout_champ_min_amount_per_order']) : 0;
            $checkout_champ_min_amount_per_order_error_message = isset($advanced_options['checkout_champ_min_amount_per_order_error_message']) ? esc_attr($advanced_options['checkout_champ_min_amount_per_order_error_message']) : "";
            
            $checkout_champ_max_amount_per_order = isset($advanced_options['checkout_champ_max_amount_per_order']) ? esc_attr($advanced_options['checkout_champ_max_amount_per_order']) : 0;
            $checkout_champ_max_amount_per_order_error_message = isset($advanced_options['checkout_champ_max_amount_per_order_error_message']) ? esc_attr($advanced_options['checkout_champ_max_amount_per_order_error_message']) : "";
            $cart = WC()->cart;
            $products = "";
            foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
                $product_id = $cart_item['product_id'];
                $variation_id = $cart_item['variation_id'];

                $checkout_champ_id = 0;
                if ($variation_id != 0) {
                    $checkout_champ_id = "EXT" . $variation_id;
                } else {
                    $checkout_champ_id = "EXT" . $product_id;
                }
                $quantity = $cart_item['quantity'];
                $products .= $checkout_champ_id . ":" . $quantity . ";";
            }
            $products = rtrim($products, ";");
            $checkout_champ_url = $base_url . "?products=" . $products;
            $disabled_class = "checkout-button-disabled";

            if ($checkout_champ_url) {
                $cart_count = $cart->get_cart_contents_count();
            
                if($checkout_champ_max_product_per_order > 0){
                    if($cart_count > $checkout_champ_max_product_per_order){
                        echo '<a href="'. esc_html(site_url()) . '/cart'.  '"class="checkout-button button alt wc-forward checkoutchamp-button-disabled">'  .   esc_html('Proceed to Checkout', 'woocommerce') . '</a>';
                        return;   
                    }
                }

                if($checkout_champ_min_product_per_order > 0){
                    $cart_count = $cart->get_cart_contents_count();
                    if($cart_count < $checkout_champ_min_product_per_order){    
                        echo '<a href="'. esc_html(site_url()) . '/cart'.  '"class="checkout-button button alt wc-forward checkoutchamp-button-disabled">'  .   esc_html('Proceed to Checkout', 'woocommerce') . '</a>';
                        return;
                    }
                }

                if($checkout_champ_min_amount_per_order > 0){
                    $cart_total = $cart->get_cart_contents_total();
                    if($cart_total < $checkout_champ_min_amount_per_order){    
                        echo '<a href="'. esc_html(site_url()) . '/cart'.  '"class="checkout-button button alt wc-forward checkoutchamp-button-disabled">'  .   esc_html('Proceed to Checkout', 'woocommerce') . '</a>';
                        return;
                    }
                }

                if($checkout_champ_max_amount_per_order > 0){
                    $cart_total = $cart->get_cart_contents_total();
                    if($cart_total > $checkout_champ_max_amount_per_order){
                        echo '<a href="'. esc_html(site_url()) . '/cart'.  '"class="checkout-button button alt wc-forward checkoutchamp-button-disabled">'  .   esc_html('Proceed to Checkout', 'woocommerce') . '</a>';
                        return;  
                    }
                }
                
            } 
            echo '<a href="'. esc_html($checkout_champ_url) .'" class="checkout-button button alt wc-forward">'  .  esc_html('Proceed to Checkout', 'woocommerce') . '</a>';
            return;
        }catch (\Throwable $th) {
            LoggerManager::log_error($th->getMessage(), __FILE__, __LINE__);
        } 
    }
}

