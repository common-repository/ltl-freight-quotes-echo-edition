<?php

/**
 * All App Name messages
 */

namespace EnEchoMessage;

/**
 * Messages are relate to errors, warnings, headings
 * Class EnEchoMessage
 * @package EnEchoMessage
 */
if (!class_exists('EnEchoMessage')) {

    class EnEchoMessage
    {

        /**
         * Add all messages
         * EnEchoMessage constructor.
         */
        public function __construct()
        {
            if (!defined('EN_ECHO_ROOT_URL'))
            {
                define('EN_ECHO_ROOT_URL', esc_url('https://eniture.com'));
            }
            define('EN_ECHO_STANDARD_PLAN_URL', EN_ECHO_ROOT_URL . '/plan/woocommerce-echo-ltl-freight/');
            define('EN_ECHO_ADVANCED_PLAN_URL', EN_ECHO_ROOT_URL . '/plan/woocommerce-echo-ltl-freight/');
            define('EN_ECHO_SUBSCRIBE_PLAN_URL', EN_ECHO_ROOT_URL . '/plan/woocommerce-echo-ltl-freight/');
            define('EN_ECHO_700', "You are currently on the Trial Plan. Your plan will be expire on ");
            define('EN_ECHO_701', "You are currently on the Basic Plan. The plan renews on ");
            define('EN_ECHO_702', "You are currently on the Standard Plan. The plan renews on ");
            define('EN_ECHO_703', "You are currently on the Advanced Plan. The plan renews on ");
            define('EN_ECHO_704', "Your currently plan subscription is inactive <a href='javascript:void(0)' data-action='en_echo_get_current_plan' onclick='en_update_plan(this);'>Click here</a> to check the subscription status. If the subscription status remains 
                inactive. Please activate your plan subscription from <a target='_blank' href='" . EN_ECHO_SUBSCRIBE_PLAN_URL . "'>here</a>");

            define('EN_ECHO_705', "<a target='_blank' class='en_plan_notification' href='" . EN_ECHO_STANDARD_PLAN_URL . "'>
                        Standard Plan required
                    </a>");
            define('EN_ECHO_706', "<a target='_blank' class='en_plan_notification' href='" . EN_ECHO_ADVANCED_PLAN_URL . "'>
                        Advanced Plan required
                    </a>");
            define('EN_ECHO_707', "Please verify credentials at connection settings panel.");
            define('EN_ECHO_708', "Please enter valid US or Canada zip code.");
            define('EN_ECHO_709', "Success! The test resulted in a successful connection.");
            define('EN_ECHO_710', "Zip code already exists.");
            define('EN_ECHO_711', "Connection settings are missing.");
            define('EN_ECHO_712', "Shipping parameters are not correct.");
            define('EN_ECHO_713', "Origin address is missing.");
            define('EN_ECHO_714', '<a href="javascript:void(0)" data-action="en_echo_get_current_plan" onclick="en_update_plan(this);">Click here</a> to refresh the plan');
        }

    }

}