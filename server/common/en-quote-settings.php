<?php

/**
 * App Name settings.
 */

namespace EnEchoQuoteSettingsDetail;

/**
 * Get and save settings.
 * Class EnEchoQuoteSettingsDetail
 * @package EnEchoQuoteSettingsDetail
 */
if (!class_exists('EnEchoQuoteSettingsDetail')) {

    class EnEchoQuoteSettingsDetail
    {
        static public $en_echo_accessorial = [];

        /**
         * Set quote settings detail
         */
        static public function en_echo_get_quote_settings()
        {
            $accessorials = [];
            $en_settings = json_decode(EN_ECHO_SET_QUOTE_SETTINGS, true);
            $en_settings['liftgate_delivery_option'] == 'yes' ? $accessorials['accessorials'][] = 'LIFTGATEREQUIRED' : "";
            $en_settings['liftgate_delivery'] == 'yes' ? $accessorials['accessorials'][] = 'LIFTGATEREQUIRED' : "";
            $en_settings['residential_delivery'] == 'yes' ? $accessorials['accessorials'][] = 'RESIDENTIALDELIVERY' : "";
            $accessorials['handlingUnitWeight'] = $en_settings['handling_unit_weight'];
            $accessorials['maxWeightPerHandlingUnit'] = $en_settings['max_weight_handling_unit'];

            return $accessorials;
        }

        /**
         * Set quote settings detail
         */
        static public function en_echo_always_accessorials()
        {
            $accessorials = [];
            $en_settings = self::en_echo_quote_settings();
            $en_settings['liftgate_delivery'] == 'yes' ? $accessorials[] = 'L' : "";
            $en_settings['residential_delivery'] == 'yes' ? $accessorials[] = 'R' : "";

            return $accessorials;
        }

        /**
         * Set quote settings detail
         */
        static public function en_echo_quote_settings()
        {
            $enable_carriers = get_option('en_echo_carriers');
            $enable_carriers = (isset($enable_carriers) && strlen($enable_carriers) > 0) ?
                json_decode($enable_carriers, true) : [];
            $rating_method = get_option('en_quote_settings_rating_method_echo');
            $quote_settings_label = get_option('en_quote_settings_custom_label_echo');

            $quote_settings = [
                'transit_days' => get_option('en_quote_settings_show_delivery_estimate_echo'),
                'own_freight' => get_option('en_quote_settings_own_arrangment_echo'),
                'own_freight_label' => get_option('en_quote_settings_text_for_own_arrangment_echo'),
                'total_carriers' => get_option('en_quote_settings_number_of_options_echo'),
                'rating_method' => (strlen($rating_method)) > 0 ? $rating_method : "Cheapest",
                'en_settings_label' => ($rating_method == "average_rate" || $rating_method == "Cheapest") ? $quote_settings_label : "",
                'handling_unit_weight' => get_option('en_quote_settings_handling_unit_weight_echo'),
                'max_weight_handling_unit' => get_option('en_quote_settings_max_weight_handling_unit_echo'),
                'handling_fee' => get_option('en_quote_settings_handling_fee_echo'),
                'enable_carriers' => $enable_carriers,
                'liftgate_delivery' => get_option('en_quote_settings_liftgate_delivery_echo'),
                'liftgate_delivery_option' => get_option('echo_liftgate_delivery_as_option'),
                'residential_delivery' => get_option('en_quote_settings_residential_delivery_echo'),
                'liftgate_resid_delivery' => get_option('en_woo_addons_liftgate_with_auto_residential'),
                'custom_error_message' => get_option('en_quote_settings_checkout_error_message_echo'),
                'custom_error_enabled' => get_option('en_quote_settings_option_select_when_unable_retrieve_shipping_echo'),
                'handling_weight' => get_option('en_quote_settings_handling_unit_weight_echo'),
                'maximum_handling_weight' => get_option('en_quote_settings_max_weight_handling_unit_echo'),
            ];

            return $quote_settings;
        }

        /**
         * Get quote settings detail
         * @param array $en_settings
         * @return array
         */
        static public function en_echo_compare_accessorial($en_settings)
        {
            self::$en_echo_accessorial[] = ['S'];
            $en_settings['liftgate_delivery_option'] == 'yes' ? self::$en_echo_accessorial[] = ['L'] : "";

            return self::$en_echo_accessorial;
        }

    }

}