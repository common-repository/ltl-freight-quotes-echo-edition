<?php

namespace EnEchoDistance;

use EnEchoCurl\EnEchoCurl;

if (!class_exists('EnEchoDistance')) {

    class EnEchoDistance
    {

        static public function get_address($map_address, $en_access_level, $en_destination_address = [])
        {
            $post_data = array(
                'acessLevel' => $en_access_level,
                'address' => $map_address,
                'originAddresses' => $map_address,
                'destinationAddress' => (isset($en_destination_address)) ? $en_destination_address : '',
                'eniureLicenceKey' => get_option('en_connection_settings_license_key_echo'),
                'ServerName' => EN_ECHO_SERVER_NAME,
            );

            return EnEchoCurl::en_echo_sent_http_request(EN_ECHO_ADDRESS_HITTING_URL, $post_data, 'POST', 'Address');
        }

    }

}