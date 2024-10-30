<?php
/**
 * Plugin Name: LTL Freight Quotes - Echo Edition
 * Plugin URI: https://eniture.com/products/
 * Description: Dynamically retrieves your negotiated shipping rates from Echo and displays the results in the WooCommerce shopping cart.
 * Version: 1.1.4
 * Author: Eniture Technology
 * Author URI: http://eniture.com/
 * Text Domain: eniture-technology
 * License: GPLv2 or later
 * WC requires at least: 6.4
 * WC tested up to: 9.2.3
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

require_once 'vendor/autoload.php';

define('EN_ECHO_MAIN_DIR', __DIR__);
define('EN_ECHO_MAIN_FILE', __FILE__);

add_action('before_woocommerce_init', function () {
    if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
    }
});

if (empty(\EnEchoGuard\EnEchoGuard::en_check_prerequisites('Echo', '5.6', '4.0', '2.3'))) {
    require_once 'en-install.php';
}

/**
 * Load scripts for Echo Freight json tree view
 */
if (!function_exists('en_jtv_script_echo')) {
    function en_jtv_script_echo()
    {
        wp_register_style('json_tree_view_style_echo', plugin_dir_url(__FILE__) . 'admin/tab/logs/en-json-tree-view/en-jtv-style.css');
        wp_register_script('json_tree_view_script_echo', plugin_dir_url(__FILE__) . 'admin/tab/logs/en-json-tree-view/en-jtv-script.js', ['jquery'], '1.0.0');
        wp_enqueue_style('json_tree_view_style_echo');
        wp_enqueue_script('json_tree_view_script_echo', [
            'en_tree_view_url' => plugins_url(),
        ]);
    }
    add_action('admin_init', 'en_jtv_script_echo');
}

// Woocommerce rest api for plan update.
add_action('rest_api_init', function () {
    register_rest_route('en_update_plan_carrier_65', '/v1', array(
        'permission_callback' => '__return_true',
        'methods' => 'GET',
        'callback' => 'en_echo_freight_update_plan',
    ));

    /**
     * Get eniture updated plans.
     * @param array $request
     * @return array|void
     */
    function en_echo_freight_update_plan($request)
    {
        $carrier = $request->get_param('carrier');
        $pakg_group = $request->get_param('pakg_group');
        $pakg_duration = $request->get_param('pakg_duration');
        $expiry_date = $request->get_param('expiry_date');
        $plan_type = $request->get_param('plan_type');
        $pakg_price = $request->get_param('pakg_price');
        if ($carrier == '65') {
            if ($pakg_price == '0') {
                $pakg_group = '0';
            }
            $expiry_date .= EN_ECHO_714;
            switch ($pakg_group) {
                case 3:
                    $plan_message = EN_ECHO_703 . $expiry_date;
                    break;
                case 2:
                    $plan_message = EN_ECHO_702 . $expiry_date;
                    break;
                case 1:
                    $plan_message = EN_ECHO_701 . $expiry_date;
                    break;
                case 0:
                    $plan_message = EN_ECHO_700 . $expiry_date;
                    break;
                default:
                    $plan_message = EN_ECHO_704;
                    break;
            }

            update_option('en_echo_plan_message', "$plan_message .");
            update_option('en_echo_plan_number', "$pakg_group");
            update_option('en_echo_plan_expire_days', "$pakg_duration");
            update_option('en_echo_plan_expire_date', "$expiry_date");
            update_option('en_echo_store_type', "$plan_type");
        }
    }
});

add_filter('en_suppress_parcel_rates_hook', 'supress_parcel_rates');
if (!function_exists('supress_parcel_rates')) {
    function supress_parcel_rates() {
        $exceedWeight = get_option('en_plugins_return_LTL_quotes') == 'yes';
        $supress_parcel_rates = get_option('en_suppress_parcel_rates') == 'suppress_parcel_rates';
        return ($exceedWeight && $supress_parcel_rates);
    }
}

/**
 * Remove Option For Echo
 */
if (!function_exists('en_echo_deactivate_plugin')) {
    function en_echo_deactivate_plugin($network_wide = null)
    {
        if ( is_multisite() && $network_wide ) {
            foreach (get_sites(['fields'=>'ids']) as $blog_id) {
                switch_to_blog($blog_id);
                $eniture_plugins = get_option('EN_Plugins');
                $plugins_array = json_decode($eniture_plugins, true);
                $plugins_array = !empty($plugins_array) && is_array($plugins_array) ? $plugins_array : array();
                $key = array_search('echi', $plugins_array);
                if ($key !== false) {
                    unset($plugins_array[$key]);
                }
                update_option('EN_Plugins', json_encode($plugins_array));
                restore_current_blog();
            }
        } else {
            $eniture_plugins = get_option('EN_Plugins');
            $plugins_array = json_decode($eniture_plugins, true);
            $plugins_array = !empty($plugins_array) && is_array($plugins_array) ? $plugins_array : array();
            $key = array_search('echi', $plugins_array);
            if ($key !== false) {
                unset($plugins_array[$key]);
            }
            update_option('EN_Plugins', json_encode($plugins_array));
        }
    }
}