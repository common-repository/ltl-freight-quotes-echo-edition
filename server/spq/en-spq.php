<?php

/**
 * Small package quotes of cart items.
 */

namespace EnEchoSPQ;

if (!class_exists('EnEchoSPQ')) {

    class EnEchoSPQ
    {

        /**
         * Small package quotes triggered.
         * @param array $action
         * @return boolean
         */
        static public function en_echo_on_basis_spq($action)
        {
            return true;
        }

        /**
         * Small package quotes of cart items.
         * @param array $package
         * @param array $small_package
         * @return array
         */
        static public function en_small_package_quotes($package, $small_package)
        {
            $en_small_package_quotes = $en_class_name_spq_triggered = [];
            if (!empty($small_package)) {
                $en_plugins = json_decode(get_option('EN_Plugins'), EN_ECHO_DECLARED_TRUE);
                foreach ($en_plugins as $en_index => $en_plugin) {
                    $en_class_name_spq = 'WC_' . $en_plugin;
                    if (class_exists($en_class_name_spq) && !in_array($en_class_name_spq, $en_class_name_spq_triggered)) {
                        $en_class_name_spq_triggered[] = $en_class_name_spq;
                        $en_class_name_spq_obj = new $en_class_name_spq();
                        $package['itemType'] = 'ltl';
                        $package['en_shipments'] = $small_package;
                        $en_class_name_spq_response = $en_class_name_spq_obj->calculate_shipping($package);
                        $en_small_package_quotes = empty($en_small_package_quotes) ? $en_class_name_spq_response : array_merge($en_small_package_quotes, $en_class_name_spq_response);
                        add_filter('en_echo_on_basis_spq', [__CLASS__, 'en_echo_on_basis_spq']);
                    }
                }

                $en_small_package_quotes = (!empty($en_small_package_quotes)) ?
                    array_slice(array_values(en_sorting_asce_order($en_small_package_quotes)), 0, 1) : [];
            }

            return $en_small_package_quotes;
        }
    }
}