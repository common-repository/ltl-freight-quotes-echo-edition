<?php

/**
 * App Name details.
 */

namespace EnEchoConfig;

use EnEchoConnectionSettings\EnEchoConnectionSettings;
use EnEchoQuoteSettingsDetail\EnEchoQuoteSettingsDetail;

/**
 * Config values.
 * Class EnEchoConfig
 * @package EnEchoConfig
 */
if (!class_exists('EnEchoConfig')) {

    class EnEchoConfig
    {
        /**
         * Save config settings
         */
        static public function do_config()
        {
            define('EN_ECHO_PLAN', get_option('en_echo_plan_number'));
            !empty(get_option('en_echo_plan_message')) ? define('EN_ECHO_PLAN_MESSAGE', get_option('en_echo_plan_message')) : define('EN_ECHO_PLAN_MESSAGE', EN_ECHO_704);
            define('EN_ECHO_NAME', 'Echo');
            define('EN_ECHO_PLUGIN_URL', plugins_url());
            define('EN_ECHO_ABSPATH', ABSPATH);
            define('EN_ECHO_DIR', plugins_url(EN_ECHO_MAIN_DIR));
            define('EN_ECHO_DIR_FILE', plugin_dir_url(EN_ECHO_MAIN_FILE));
            define('EN_ECHO_FILE', plugins_url(EN_ECHO_MAIN_FILE));
            define('EN_ECHO_BASE_NAME', plugin_basename(EN_ECHO_MAIN_FILE));
            define('EN_ECHO_SERVER_NAME', self::en_get_server_name());

            define('EN_ECHO_DECLARED_ZERO', 0);
            define('EN_ECHO_DECLARED_ONE', 1);
            define('EN_ECHO_DECLARED_ARRAY', []);
            define('EN_ECHO_DECLARED_FALSE', false);
            define('EN_ECHO_DECLARED_TRUE', true);
            define('EN_ECHO_SHIPPING_NAME', 'echo');
            $weight_threshold = get_option('en_weight_threshold_lfq');
            $weight_threshold = isset($weight_threshold) && $weight_threshold > 0 ? $weight_threshold : 150;
            define('EN_ECHO_SHIPMENT_WEIGHT_EXCEEDS_PRICE', $weight_threshold);
            define('EN_ECHO_SHIPMENT_WEIGHT_EXCEEDS', get_option('en_plugins_return_LTL_quotes'));
	        define('EN_ECHO_ORDER_EXPORT_HITTING_URL', 'https://analytic-data.eniture.com/index.php');
            if (!defined('EN_ECHO_ROOT_URL'))
            {
                define('EN_ECHO_ROOT_URL', esc_url('https://eniture.com'));
            }
            define('EN_ECHO_ROOT_URL_PRODUCTS', EN_ECHO_ROOT_URL . '/products/');
            define('EN_ECHO_RAD_URL', EN_ECHO_ROOT_URL . '/woocommerce-residential-address-detection/');
            define('EN_ECHO_SUPPORT_URL', esc_url('https://support.eniture.com/'));
            define('EN_ECHO_DOCUMENTATION_URL', EN_ECHO_ROOT_URL . '/woocommerce-echo-ltl-freight');

            define('EN_ECHO_ROOT_URL_QUOTES', esc_url('https://ws065.eniture.com'));

            define('EN_ECHO_HITTING_API_URL', EN_ECHO_ROOT_URL_QUOTES . '/echo-logistics/quotes.php');
            define('EN_ECHO_ADDRESS_HITTING_URL', EN_ECHO_ROOT_URL_QUOTES . '/addon/google-location.php');
            define('EN_ECHO_PLAN_HITTING_URL', EN_ECHO_ROOT_URL_QUOTES . '/web-hooks/subscription-plans/create-plugin-webhook.php?');

            define('EN_ECHO_SET_CONNECTION_SETTINGS', wp_json_encode(EnEchoConnectionSettings::en_set_connection_settings_detail()));
            define('EN_ECHO_GET_CONNECTION_SETTINGS', wp_json_encode(EnEchoConnectionSettings::en_get_connection_settings_detail()));
            define('EN_ECHO_SET_QUOTE_SETTINGS', wp_json_encode(EnEchoQuoteSettingsDetail::en_echo_quote_settings()));
            define('EN_ECHO_GET_QUOTE_SETTINGS', wp_json_encode(EnEchoQuoteSettingsDetail::en_echo_get_quote_settings()));

            $en_app_set_quote_settings = json_decode(EN_ECHO_SET_QUOTE_SETTINGS, true);

            define('EN_ECHO_ALWAYS_ACCESSORIAL', wp_json_encode(EnEchoQuoteSettingsDetail::en_echo_always_accessorials($en_app_set_quote_settings)));
            define('EN_ECHO_ACCESSORIAL', wp_json_encode(EnEchoQuoteSettingsDetail::en_echo_compare_accessorial($en_app_set_quote_settings)));
        }

        /**
         * Get Host
         * @param string $url
         * @return type
         */
        static public function en_get_host($url)
        {
            $parse_url = parse_url(trim($url));
            if (isset($parse_url['host'])) {
                $host = $parse_url['host'];
            } else {
                $path = explode('/', $parse_url['path']);
                $host = $path[0];
            }
            return trim($host);
        }

        /**
         * Get Domain Name
         */
        static public function en_get_server_name()
        {
            global $wp;
            $wp_request = (isset($wp->request)) ? $wp->request : '';
            $url = home_url($wp_request);
            return self::en_get_host($url);
        }
    }
}
