<?php

/**
 * Carriers show.
 */

namespace EnEchoCarriers;

/**
 * Show and update carriers.
 * Class EnEchoCarriers
 * @package EnEchoCarriers
 */
if (!class_exists('EnEchoCarriers')) {

    class EnEchoCarriers
    {

        /**
         * Show Carriers
         */
        static public function en_load()
        {
            self::en_save_carriers();
            $en_echo_carriers = EnEchoCarriers::en_echo_carriers();
            echo '<div class="en_echo_carriers">';
            echo '<form method="post">';
            echo force_balance_tags('<p>Identifies which carriers are included in the quote response, not what is displayed in the shopping cart. Identify what displays in the shopping cart in the Quote Settings. For example, you may include quote responses from all carriers, but elect to only show the cheapest three in the shopping cart.  <br> <br></p>');
            echo '<table>';
            echo '<tr>';
            echo force_balance_tags('<th>Carrier Name</th>');
            echo force_balance_tags('<th>Logo</th>');
            echo force_balance_tags('<th> <input type="checkbox" id="en_echo_total_carriers"> </th>');
            echo '</tr>';
            $en_checked_carriers = get_option('en_echo_carriers');
            $en_checked_carriers = (isset($en_checked_carriers) && strlen($en_checked_carriers) > 0) ? json_decode($en_checked_carriers, true) : [];

            foreach ($en_echo_carriers as $key => $value) {

                $en_echo_carrier = in_array($value['en_standard_carrier_alpha_code'], $en_checked_carriers) ? "checked='checked'" : '';

                echo '<tr>';
                echo '<td> ' . esc_attr($value['en_echo_carrier_name']) . ' </td>';
                echo '<td> <img alt="carriers"  src="' . esc_attr(EN_ECHO_DIR_FILE) . '/admin/tab/carriers/assets/' . esc_attr($value['en_echo_carrier_logo']) . '"> </td>';
                echo '<td> <input type="checkbox" class="en_echo_carrier" name="en_echo_carrier[]" value="' . esc_attr($value['en_standard_carrier_alpha_code']) . '" ' . $en_echo_carrier . '> </td>';
                echo '</tr>';
            }

            echo '</form>';
            echo '</table>';
            echo '</div>';
        }

        /**
         * Carriers Save Data
         */
        static public function en_save_carriers()
        {
            if (isset($_POST['en_echo_carrier']) && (!empty($_POST['en_echo_carrier']))) {
                $en_echo_carrier = array_map('sanitize_text_field', $_POST['en_echo_carrier']);
                update_option('en_echo_carriers', wp_json_encode($en_echo_carrier));

                echo "<script type='text/javascript'>
                window.location=document.location.href;
            </script>";
            }
        }

        /**
         * Carriers Data
         */
        static public function en_echo_carriers()
        {
            $carrier = [
                [
                    'en_standard_carrier_alpha_code' => 'PYLE',
                    'en_echo_carrier_name' => 'A. Duie Pyle, Inc.',
                    'en_echo_carrier_logo' => 'pyle.jpg'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'AACT',
                    'en_echo_carrier_name' => 'AAA Cooper',
                    'en_echo_carrier_logo' => 'AACT.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'ABFS',
                    'en_echo_carrier_name' => 'ABF Freight Systems',
                    'en_echo_carrier_logo' => 'ABFS.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'AVRT',
                    'en_echo_carrier_name' => 'Averitt Express, Inc.',
                    'en_echo_carrier_logo' => 'avrt.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'CENF',
                    'en_echo_carrier_name' => 'Central Freight Lines, Inc.',
                    'en_echo_carrier_logo' => 'cenf.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'CTI3',
                    'en_echo_carrier_name' => 'Central Transport International',
                    'en_echo_carrier_logo' => 'ctii.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'CLNI',
                    'en_echo_carrier_name' => 'Clear Lane Freight Systems, LLC',
                    'en_echo_carrier_logo' => 'clni.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'CNWY',
                    'en_echo_carrier_name' => 'XPO Logistics Freight, Inc.',
                    'en_echo_carrier_logo' => 'cnwy.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'DYLT',
                    'en_echo_carrier_name' => 'Daylight Transport',
                    'en_echo_carrier_logo' => 'dylt.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'DAFG',
                    'en_echo_carrier_name' => 'Dayton Freight Lines, Inc.',
                    'en_echo_carrier_logo' => 'DAFG.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'DPHE',
                    'en_echo_carrier_name' => 'Dependable Highway Express',
                    'en_echo_carrier_logo' => 'dphe.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'DOLR',
                    'en_echo_carrier_name' => 'DOT-Line Transportation',
                    'en_echo_carrier_logo' => 'dolr.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'EXLA',
                    'en_echo_carrier_name' => 'Estes Express',
                    'en_echo_carrier_logo' => 'exla.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'FXNL',
                    'en_echo_carrier_name' => 'FedEx Economy',
                    'en_echo_carrier_logo' => 'fxfe.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'FXFE',
                    'en_echo_carrier_name' => 'FedEx Priority',
                    'en_echo_carrier_logo' => 'fxfe.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'FWDA',
                    'en_echo_carrier_name' => 'Forward Air, Inc.',
                    'en_echo_carrier_logo' => 'fwdn.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'WARD',
                    'en_echo_carrier_name' => 'Ward Trucking, LLC',
                    'en_echo_carrier_logo' => 'ward.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'FCSY',
                    'en_echo_carrier_name' => 'Frontline Carrier System (USA) Inc.',
                    'en_echo_carrier_logo' => 'fcsy.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'HMES',
                    'en_echo_carrier_name' => 'Holland',
                    'en_echo_carrier_logo' => 'hmes.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'LKVL',
                    'en_echo_carrier_name' => 'LME INC.',
                    'en_echo_carrier_logo' => 'lkvl.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'MIDW',
                    'en_echo_carrier_name' => 'Midwest Motor Express, Inc.',
                    'en_echo_carrier_logo' => 'midw.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'NPME',
                    'en_echo_carrier_name' => 'New Penn Motor Express, Inc.',
                    'en_echo_carrier_logo' => 'npme.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'ODFL',
                    'en_echo_carrier_name' => 'Old Dominion Freight Line, Inc.',
                    'en_echo_carrier_logo' => 'ODFL.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'PITD',
                    'en_echo_carrier_name' => 'Pitt Ohio Express',
                    'en_echo_carrier_logo' => 'pitd.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'RJWI',
                    'en_echo_carrier_name' => 'RJW Transport, Inc.',
                    'en_echo_carrier_logo' => 'rjwi.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'UPGF',
                    'en_echo_carrier_name' => 'Tforce Freight, Inc.',
                    'en_echo_carrier_logo' => 'tforce.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'RETL',
                    'en_echo_carrier_name' => 'USF Reddaway, Inc.',
                    'en_echo_carrier_logo' => 'retl.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'RDFS',
                    'en_echo_carrier_name' => 'Roadrunner Dawes Freight Systems Inc.',
                    'en_echo_carrier_logo' => 'RDFS.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'RNLO',
                    'en_echo_carrier_name' => 'R and L Carriers',
                    'en_echo_carrier_logo' => 'rlca.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'SAIA',
                    'en_echo_carrier_name' => 'Saia Motor Freight Line',
                    'en_echo_carrier_logo' => 'SAIA.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'SEFL',
                    'en_echo_carrier_name' => 'Southeastern Freight Lines',
                    'en_echo_carrier_logo' => 'SEFL.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'SMTL',
                    'en_echo_carrier_name' => 'Southwestern Motor Transport Inc.',
                    'en_echo_carrier_logo' => 'smtl.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'UTPA',
                    'en_echo_carrier_name' => 'UNIS',
                    'en_echo_carrier_logo' => 'unis.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'WEXY',
                    'en_echo_carrier_name' => 'West End Express Co. Inc',
                    'en_echo_carrier_logo' => 'wexy.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'XGSI',
                    'en_echo_carrier_name' => 'Xpress Global Systems, Inc.',
                    'en_echo_carrier_logo' => 'xgsi.png'
                ],
                [
                    'en_standard_carrier_alpha_code' => 'RDWY',
                    'en_echo_carrier_name' => 'YRC - Freight',
                    'en_echo_carrier_logo' => 'rdwy.png'
                ],
            ];

            return $carrier;
        }

    }

}
