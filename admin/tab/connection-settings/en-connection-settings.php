<?php

/**
 * Test connection details.
 */

namespace EnEchoConnectionSettings;

/**
 * Add array for test connection.
 * Class EnEchoConnectionSettings
 * @package EnEchoConnectionSettings
 */
if (!class_exists('EnEchoConnectionSettings')) {

    class EnEchoConnectionSettings
    {

        static $get_connection_details = [];

        /**
         * Connection settings template.
         * @return array
         */
        static public function en_load()
        {
            echo '<div class="en_echo_connection_settings">';
            
            $start_settings = [
                'en_connection_settings_start_echo' => [
                    'name' => __('', 'woocommerce-settings-echo'),
                    'type' => 'title',
                    'id' => 'en_connection_settings_echo',
                ],
            ];

            // App Name Connection Settings Detail
            $eniture_settings = self::en_set_connection_settings_detail();

            $end_settings = [
                'en_connection_settings_end_echo' => [
                    'type' => 'sectionend',
                    'id' => 'en_connection_settings_end_echo'
                ]
            ];

            $settings = array_merge($start_settings, $eniture_settings, $end_settings);

            return $settings;
        }

        /**
         * Connection Settings Detail
         * @return array
         */
        static public function en_get_connection_settings_detail()
        {
            $connection_request = self::en_static_request_detail();
            $en_request_indexing = json_decode(EN_ECHO_SET_CONNECTION_SETTINGS, true);
            foreach ($en_request_indexing as $key => $value) {
                $saved_connection_detail = get_option($key);
                $connection_request[$value['eniture_action']] = $saved_connection_detail;
                strlen($saved_connection_detail) > 0 ?
                    self::$get_connection_details[$value['eniture_action']] = $saved_connection_detail : '';
            }

            add_filter('en_echo_reason_quotes_not_returned', [__CLASS__, 'en_echo_reason_quotes_not_returned'], 99, 1);

            return $connection_request;
        }

        /**
         * Saving reasons to show proper error message on the cart or checkout page
         * When quotes are not returning
         * @param array $reasons
         * @return array
         */
        static public function en_echo_reason_quotes_not_returned($reasons)
        {
            return empty(self::$get_connection_details) ? array_merge($reasons, [EN_ECHO_711]) : $reasons;
        }

        /**
         * Static Detail Set
         * @return array
         */
        static public function en_static_request_detail()
        {
            return
                [
                    'serverName' => EN_ECHO_SERVER_NAME,
                    'platform' => 'WordPress',
                    'carrierType' => 'LTL',
                    'carrierName' => 'echoLogistics',
                    'carrierMode' => 'pro',
                    'requestVersion' => '2.0',
                    'requestKey' => time(),
                ];
        }

        /**
         * Connection Settings Detail Set
         * @return array
         */
        static public function en_set_connection_settings_detail()
        {
            return
                [
                    'en_connection_settings_api_key_echo' => [
                        'eniture_action' => 'apiKey',
                        'name' => __('Account API Key ', 'woocommerce-settings-echo'),
                        'type' => 'text',
                        'desc' => __('', 'woocommerce-settings-echo'),
                        'id' => 'en_connection_settings_api_key_echo'
                    ],
                    'en_connection_settings_account_number_echo' => [
                        'eniture_action' => 'accountNumber',
                        'name' => __('Account Number ', 'woocommerce-settings-echo'),
                        'type' => 'text',
                        'desc' => __('', 'woocommerce-settings-echo'),
                        'id' => 'en_connection_settings_account_number_echo'
                      ],
                    'en_connection_settings_license_key_echo' => [
                        'eniture_action' => 'licenseKey',
                        'name' => __('Eniture API Key ', 'woocommerce-settings-echo'),
                        'type' => 'text',
                        'desc' => __('Obtain a Eniture API Key from <a href="' . EN_ECHO_ROOT_URL_PRODUCTS . '" target="_blank" >eniture.com </a>', 'woocommerce-settings-echo'),
                        'id' => 'en_connection_settings_license_key_echo'
                    ],
                ];
        }

    }

}