<?php

/**
 * App Name load classes.
 */

namespace EnEchoLoad;

use EnEchoConfig\EnEchoConfig;
use EnEchoCreateLTLClass\EnEchoCreateLTLClass;
use EnEchoCsvExport\EnEchoCsvExport;
use EnEchoLocationAjax\EnEchoLocationAjax;
use EnEchoMessage\EnEchoMessage;
use EnEchoOrderRates\EnEchoOrderRates;
use EnEchoOrderScript\EnEchoOrderScript;
use EnEchoOrderWidget\EnEchoOrderWidget;
use EnEchoPlans\EnEchoPlans;
use EnEchoWarehouse\EnEchoWarehouse;
use EnEchoTestConnection\EnEchoTestConnection;

/**
 * Load classes.
 * Class EnEchoLoad
 * @package EnEchoLoad
 */
if (!class_exists('EnEchoLoad')) {

    class EnEchoLoad
    {
        /**
         * Load classes of App Name plugin
         */
        static public function Load()
        {
            new EnEchoMessage();
            new EnEchoPlans();
            EnEchoConfig::do_config();
            new \EnEchoCarrierShippingRates();

            if (is_admin()) {
                new EnEchoCreateLTLClass();
                new EnEchoWarehouse();
                new EnEchoTestConnection();
                new EnEchoLocationAjax();
                new EnEchoOrderWidget();
                new EnEchoOrderRates();
                new EnEchoOrderScript();
                new \EnEchoProductNestingDetail();
                !class_exists('EnCsvExport') && new EnEchoCsvExport();
            }
        }

    }

}
