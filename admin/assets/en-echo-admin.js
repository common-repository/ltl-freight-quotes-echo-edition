jQuery(document).ready(function () {
    // Common settings.
    jQuery('#en_connection_settings_api_key_echo').closest('table').attr('id', 'en_echo_connection_settings');
    jQuery('#en_quote_settings_rating_method_echo').closest('table').attr('id', 'en_echo_quote_settings');
    jQuery("#order_shipping_line_items .shipping .display_meta").css('display', 'none');

    // Weight threshold for LTL freight
    en_weight_threshold_limit();

    // Carriers Tab
    if (jQuery('.en_echo_carriers').length > 0) {
        // Making the function to check when no checkbox was checked.
        jQuery('.en_echo_carriers').next('.submit').find('.button-primary, .is-primary').on('click', function (event) {
            jQuery('.en_settings_message').remove();
            let en_echo_carrier = jQuery('.en_echo_carriers .en_echo_carrier').is(':checked');
            if (!en_echo_carrier) {
                let en_carrier_error_msg = 'Please select at least one carrier service.';
                jQuery('.subsubsub').next('.clear').after('<div class="notice notice-error en_settings_message"><p><strong>Error! </strong>' + en_carrier_error_msg + '</p></div>');
                jQuery('#en_settings_message').delay(200).animate({scrollTop: 0}, 1000);
                jQuery('html, body').animate({scrollTop: 0}, 'slow');
                return false;
            }
        });
    }

    jQuery("#en_quote_settings_handling_unit_weight_echo, #en_quote_settings_max_weight_handling_unit_echo").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)|| e.keyCode == 109) {
            // let it happen, don't do anything
            return;
        }
        
        // Ensure that it is a number and stop the keypress
        if ((e.keyCode === 190 || e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    
        if ((jQuery(this).val().indexOf('.') != -1) && (jQuery(this).val().substring(jQuery(this).val().indexOf('.'), jQuery(this).val().indexOf('.').length).length > 2)) {
            if (event.keyCode !== 8 && event.keyCode !== 46) { //exception
                event.preventDefault();
            }
        }
    });
        
    jQuery("#en_quote_settings_handling_unit_weight_echo, #en_quote_settings_max_weight_handling_unit_echo").keyup(function (e) {
        var val = jQuery(this).val();
        if (val.split('.').length - 1 > 1) {
            var newval = val.substring(0, val.length - 1);
            var countDots = newval.substring(newval.indexOf('.') + 1).length;
            newval = newval.substring(0, val.length - countDots - 1);
            jQuery(this).val(newval);
        }
    });

    // Quote Settings Tab
    if (jQuery('#en_echo_quote_settings').length > 0) {

        jQuery("#en_quote_settings_checkout_error_message_echo").closest('tr').addClass('en_quote_settings_ceme');
        jQuery("input[name='en_quote_settings_option_select_when_unable_retrieve_shipping_echo']").closest('tr').addClass('en_quote_settings_oswurse');

        // Always include lift gate delivery when a residential address is detected.
        if (!jQuery('#auto_residential_delivery_plan_auto_renew').length) {
            jQuery(".en_woo_addons_liftgate_with_auto_residential_echo").attr("disabled", true);
        }

        // Liftgate accessorials action perfrom on click
        jQuery(".liftgate_accessorial_action").on("click", function () {
            var id = jQuery(this).attr("id");
            if (id == "en_quote_settings_liftgate_delivery_echo") {
                jQuery("#echo_liftgate_delivery_as_option").prop({checked: false});
                jQuery("#en_woo_addons_liftgate_with_auto_residential").prop({checked: false});

            } else if (id == "echo_liftgate_delivery_as_option" ||
                id == "en_woo_addons_liftgate_with_auto_residential") {
                jQuery("#en_quote_settings_liftgate_delivery_echo").prop({checked: false});
            }
        });

        jQuery('#en_quote_settings_rating_method_echo').on('change', function () {
            en_echo_action_rating_method();
        });

        // On page load Action perform related Rating Method
        en_echo_action_rating_method();

        jQuery("#en_quote_settings_residential_delivery_echo," +
            "#en_quote_settings_availability_auto_residential_echo," +
            "#en_quote_settings_liftgate_delivery_echo," +
            "#echo_liftgate_delivery_as_option," +
            "#en_quote_settings_availability_liftgate_echo," +
            "#en_quote_settings_handling_unit_weight_echo," +
            "#en_quote_settings_max_weight_handling_unit_echo," +
            "#en_woo_addons_liftgate_with_auto_residential").closest('tr').addClass("en_quote_settings_sub_options");

        // Making the generic function regarding validation which will work for all text fields.
        jQuery('#en_echo_quote_settings').parents().find('.button-primary, .is-primary').on('click', function (event) {

            let en_validate_settings = {};
            let en_data_error = true;

            en_validate_settings['#en_quote_settings_handling_fee_echo'] = {
                'en_data_type': 'isNumeric',
                'en_after_decimal': 2,
                'en_add_percentage': true,
                'en_minus_sign': true,
                'en_max_length': false,
                'en_error_msg': 'Handling fee format should be 100.20 or 10% and only 2 digits are allowed after decimal point.',
            };

            en_validate_settings['#en_quote_settings_handling_unit_weight_echo'] = {
                'en_data_type': 'isNumeric',
                'en_after_decimal': 2,
                'en_add_percentage': false,
                'en_minus_sign': false,
                'en_max_length': false,
                'en_error_msg': 'Weight of Handling Unit format should be 100.20 or 10 and only 2 digits are allowed after decimal point.',
            };

            en_validate_settings['#en_quote_settings_max_weight_handling_unit_echo'] = {
                'en_data_type': 'isNumeric',
                'en_after_decimal': 2,
                'en_add_percentage': false,
                'en_minus_sign': false,
                'en_max_length': false,
                'en_error_msg': 'Maximum Weight per Handling Unit format should be 100.20 or 10 and only 2 digits are allowed after decimal point.',
            };

            jQuery('.en_settings_message').remove();

            jQuery.each(en_validate_settings, function (index, item) {

                let is_data = jQuery(index).val();

                let is_regex_after_decimal = typeof item.en_after_decimal !== undefined ? item.en_after_decimal : '';
                let is_regex_add_percentage = typeof item.en_add_percentage !== undefined && item.en_add_percentage ? '%?' : '';
                let is_regex_minus_sign = typeof item.en_minus_sign !== undefined && item.en_minus_sign ? '-?' : '';
                let is_regex_en_max_length = typeof item.en_max_length !== undefined && item.en_max_length ? item.en_max_length : 0;
                // let is_data_regex = typeof item.en_data_type !== undefined && item.en_data_type == 'isNumeric' ? '^' + is_regex_minus_sign + '\\d*(?:\\.?\\d{0,' + is_regex_after_decimal + '}?)' + is_regex_add_percentage + '$' : '';

                let is_data_regex = '';
                if (typeof item.en_data_type !== undefined) {
                    switch (item.en_data_type) {
                        case "isNumeric":
                            is_data_regex = '^' + is_regex_minus_sign + '\\d*(?:\\.?\\d{0,' + is_regex_after_decimal + '}?)' + is_regex_add_percentage + '$';
                            // is_data_regex = '^' + is_regex_minus_sign + '\\d+(?:\\.?\\d{0,' + is_regex_after_decimal + '}?)' + is_regex_add_percentage + '$';
                            break;
                        case "isNotEmpty":
                            is_data_regex = '^[0-9a-zA-Z_\\. ]+$';
                            is_data_regex = '^[0-9a-zA-Z_\\. ]{1,' + is_regex_en_max_length + '}$';
                            break;
                    }
                }

                let en_error_msg = typeof item.en_error_msg !== undefined ? item.en_error_msg : '';

                let is_data_valid = is_validate_regex(is_data, is_data_regex);
                if (!is_data_valid) {
                    en_data_error = false;
                    jQuery('.subsubsub').next('.clear').after('<div class="notice notice-error en_settings_message"><p><strong>Error! </strong>' + en_error_msg + '</p></div>');
                }
            });

            if (!en_data_error) {
                jQuery('#en_settings_message').delay(200).animate({scrollTop: 0}, 1000);
                jQuery('html, body').animate({scrollTop: 0}, 'slow');
                return false;
            }
        });
    }

    // Connection Settings Tab
    if (jQuery('#en_echo_connection_settings').length > 0) {
        jQuery('#en_connection_settings_api_key_echo').attr('title', 'Account API Key');
        jQuery('#en_connection_settings_account_number_echo').attr('title', 'Account Number');
        jQuery('#en_connection_settings_license_key_echo').attr('title', 'Eniture API Key');

        jQuery('#en_echo_connection_settings').before("<div class='en_warning_message'><p><b>Note!</b> You must have an LTL Freight enabled Echo account to use this application. If you do not have one, call 1-800-354-7993, or <a href='https://www.echo.com/' target='_blank' >register</a> online.</p></div>");

        jQuery('#wpfooter').hide();

        /**
         * Add en_location_error class on connection settings page
         */
        jQuery('#en_echo_connection_settings input[type="text"]').each(function () {
            if (jQuery(this).parent().find('.en_connection_error').length < 1) {
                jQuery(this).after('<span class="en_connection_error"></span>');
            }
        });

        //Append "Test connection" Btn
        jQuery('.en_echo_connection_settings .woocommerce-save-button').text('Save Changes');
        jQuery('.woocommerce-save-button').before('<button name="en_echo_test_connection" class="button-primary en_echo_test_connection is-primary components-button" id="en_echo_test_connection" type="submit" value="Test Connection">Test Connection</button>');

        jQuery('.en_echo_test_connection .button-primary, .en_echo_connection_settings .is-primary').on('click', function (event) {
            let validate = en_validate_input('#en_echo_connection_settings');

            if (validate === false) {
                return false;
            }

            if (event.target.id == 'en_echo_test_connection') {

                let postForm = {
                    'action': 'en_echo_test_connection',
                    'en_post_data': window.btoa(jQuery('#en_echo_connection_settings input').serialize()),
                };

                let params = {
                    en_ajax_loading_id: '#en_connection_settings_account_number_echo,#en_connection_settings_api_key_echo,#en_connection_settings_license_key_echo',
                };

                en_ajax_request(params, postForm, en_action_test_connection);

                return false;
            }
        });
    }
    /**
     * fdo va
     */
    jQuery('#fd_online_id_echo').click(function (e) {
        var postForm = {
            'action': 'echo_fd',
            'company_id': jQuery('#freightdesk_online_id').val(),
            'disconnect': jQuery('#fd_online_id_echo').attr("data")
        }
        var id_lenght = jQuery('#freightdesk_online_id').val();
        var disc_data = jQuery('#fd_online_id_echo').attr("data");
        if(typeof (id_lenght) != "undefined" && id_lenght.length < 1) {
            jQuery(".en_connection_message").remove();
            jQuery('.user_guide_fdo').before('<div class="notice notice-error en_connection_message"><p><strong>Error!</strong> FreightDesk Online ID is Required.</p></div>');
            return;
        }
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: postForm,
            beforeSend: function () {
                jQuery('#freightdesk_online_id').css('background',
                    'rgba(255, 255, 255, 1) url("' + EN_ECHO_DIR_FILE + '' +
                    '/admin/tab/location/assets/images/processing.gif") no-repeat scroll 50% 50%');
            },
            success: function (data_response) {
                if(typeof (data_response) == "undefined"){
                    return;
                }
                var fd_data = JSON.parse(data_response);
                jQuery('#freightdesk_online_id').css('background', '#fff');
                jQuery(".en_connection_message").remove();
                if((typeof (fd_data.is_valid) != 'undefined' && fd_data.is_valid == false) || (typeof (fd_data.status) != 'undefined' && fd_data.is_valid == 'ERROR')) {
                    jQuery('.user_guide_fdo').before('<div class="notice notice-error en_connection_message"><p><strong>Error! ' + fd_data.message + '</strong></p></div>');
                }else if(typeof (fd_data.status) != 'undefined' && fd_data.status == 'SUCCESS') {
                    jQuery('.user_guide_fdo').before('<div class="notice notice-success en_connection_message"><p><strong>Success! ' + fd_data.message + '</strong></p></div>');
                    window.location.reload(true);
                }else if(typeof (fd_data.status) != 'undefined' && fd_data.status == 'ERROR') {
                    jQuery('.user_guide_fdo').before('<div class="notice notice-error en_connection_message"><p><strong>Error! ' + fd_data.message + '</strong></p></div>');
                }else if (fd_data.is_valid == 'true') {
                    jQuery('.user_guide_fdo').before('<div class="notice notice-error en_connection_message"><p><strong>Error!</strong> FreightDesk Online ID is not valid.</p></div>');
                } else if (fd_data.is_valid == 'true' && fd_data.is_connected) {
                    jQuery('.user_guide_fdo').before('<div class="notice notice-error en_connection_message"><p><strong>Error!</strong> Your store is already connected with FreightDesk Online.</p></div>');

                } else if (fd_data.is_valid == true && fd_data.is_connected == false && fd_data.redirect_url != null) {
                    window.location = fd_data.redirect_url;
                } else if (fd_data.is_connected == true) {
                    jQuery('#con_dis').empty();
                    jQuery('#con_dis').append('<a href="#" id="fd_online_id_echo" data="disconnect" class="button-primary">Disconnect</a>')
                }
            }
        });
        e.preventDefault();
    });
    /**
     * When click on select all carriers checkbox
     */
    jQuery("#en_echo_total_carriers").on('click', function () {
        jQuery('.en_echo_carriers input:checkbox').not(this).prop('checked', this.checked);
    });

    /**
     * carrier checkbox
     */
    jQuery(".en_echo_carrier").on('click', function () {
        en_echo_carriers();
    });

    en_echo_carriers();

    // Product variants settings
    jQuery(document).on("click", '._nestedMaterials', function(e) {
        const checkbox_class = jQuery(e.target).attr("class");
        const name = jQuery(e.target).attr("name");
        const checked = jQuery(e.target).prop('checked');

        if (checkbox_class?.includes('_nestedMaterials')) {
            const id = name?.split('_nestedMaterials')[1];
            setNestMatDisplay(id, checked);
        }
    });

    // Callback function to execute when mutations are observed
    const handleMutations = (mutationList) => {
        let childs = [];
        for (const mutation of mutationList) {
            childs = mutation?.target?.children;
            if (childs?.length) setNestedMaterialsUI();
          }
    };
    const observer = new MutationObserver(handleMutations),
        targetNode = document.querySelector('.woocommerce_variations.wc-metaboxes'),
        config = { attributes: true, childList: true, subtree: true };
    if (targetNode) observer.observe(targetNode, config);

});

if (typeof is_validate_regex != 'function') {
    function is_validate_regex(is_data, is_data_regex) {
        return jQuery.trim(is_data).match(new RegExp(is_data_regex)) ? true : false;
    }
}
// Update plan
if (typeof en_update_plan != 'function') {
    function en_update_plan(input) {
        let action = jQuery(input).attr('data-action');
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: {action: action},
            success: function (data_response) {
                window.location.reload(true);
            }
        });
    }
}
/**
 * ==============================================================
 *  Carrier Tab
 * ==============================================================
 */

/**
 * click on carrier checkbox
 */
if (typeof en_action_test_connection != 'function') {
    function en_action_test_connection(params, response) {
        let en_message = '';
        let data = JSON.parse(response);
        let en_class_name = 'notice notice-error en_connection_message';
        jQuery('.en_connection_message').remove();
        let data_severity = typeof data.severity !== undefined ? data.severity : '';
        let data_severity_type = 'Error! ';

        switch (data_severity) {
            case 'SUCCESS':
                en_message = data.Message;
                data_severity_type = 'Success! ';
                en_class_name = 'notice notice-success en_connection_message';
                break;
            case 'ERROR':
                en_message = data.Message;
                break;
            default:
                en_message = 'Unknown error';
                break;
        }

        jQuery('.en_warning_message').after('<div class="' + en_class_name + '"><p><strong>' + data_severity_type + '</strong>' + en_message + '</p></div>');
    }
}

/**
 * When click on carriers checkbox
 */
if (typeof en_echo_carriers != 'function') {
    function en_echo_carriers() {
        if (jQuery('.en_echo_carrier:checked').length == jQuery('.en_echo_carrier').length) {
            jQuery('#en_echo_total_carriers').prop('checked', true);
        } else {
            jQuery('#en_echo_total_carriers').prop('checked', false);
        }
    }
}

/**
 * ==============================================================
 *  Quote Settings Tab
 * ==============================================================
 */

/**
 * Action perform related Rating Method
 */
if (typeof en_echo_action_rating_method != 'function') {
    function en_echo_action_rating_method() {
        let en_rating_method = jQuery('#en_quote_settings_rating_method_echo').val();
        let en_selecter_number_of_options = jQuery('#en_quote_settings_number_of_options_echo');
        let en_selecter_custom_label = jQuery('#en_quote_settings_custom_label_echo');
        let en_rating_method_desc = 'Displays a least expensive option.';
        let en_label_as_desc = 'What the user sees during checkout, e.g "Freight" leave blank to display the carrier name.';
        jQuery('#en_quote_settings_number_of_options_echo').next('.description').text('Number of options to display in the shopping cart.');

        switch (en_rating_method) {
            case 'Cheapest':
                en_selecter_number_of_options.closest('tr').hide();
                en_selecter_custom_label.closest('tr').show();
                en_rating_method_desc = 'Displays a least expensive option.';
                break;

            case 'cheapest_options':
                en_selecter_number_of_options.closest('tr').show();
                en_selecter_custom_label.closest('tr').hide();
                en_rating_method_desc = 'Displays a list of a specified number of least expensive options.';
                break;

            case 'average_rate':
                jQuery('#en_quote_settings_number_of_options_echo').next('.description').text('Number of options to include in the calculation of the average.');
                en_selecter_number_of_options.closest('tr').show();
                en_selecter_custom_label.closest('tr').show();
                en_rating_method_desc = 'Displays a single rate based on an average of a specified number of least expensive options.';
                en_label_as_desc = 'What the user sees during checkout, e.g "Freight" leave blank to display the "Freight".';
                break;
        }

        jQuery('#en_quote_settings_custom_label_echo').next('.description').text(en_label_as_desc);
        jQuery('#en_quote_settings_custom_label_echo').attr('maxlength', 50);
        jQuery('#en_quote_settings_rating_method_echo').next('.description').text(en_rating_method_desc);
    }
}

/**
 * Eniture Validation Form JS
 */
if (typeof en_validate_input != 'function') {
    function en_validate_input(form_id) {
        let has_err = true;
        jQuery(form_id + " input[type='text']").each(function () {

            let input = jQuery(this).val();
            let response = en_validate_string(input);
            let errorText = jQuery(this).attr('title');
            let optional = jQuery(this).data('optional');

            let en_error_element = jQuery(this).parent().find('.en_location_error,.en_connection_error');
            jQuery(en_error_element).html('');

            optional = (optional === undefined) ? 0 : 1;
            errorText = (errorText != undefined) ? errorText : '';

            if ((optional == 0) && (response == false || response == 'empty')) {
                errorText = (response == 'empty') ? errorText + ' is required.' : 'Invalid input.';
                jQuery(en_error_element).html(errorText);
            }
            has_err = (response != true && optional == 0) ? false : has_err;
        });
        return has_err;
    }
}

/**
 * Validate Input String
 */
if (typeof en_validate_string != 'function') {
    function en_validate_string(string) {
        if (string == '')
            return 'empty';
        else
            return true;

    }
}

/**
 * Variable exist
 */
if (typeof en_is_var_exist != 'function') {
    function en_is_var_exist(index, item) {
        return typeof item[index] != 'undefined' ? true : false;
    }
}

/**
 * Ajax common resource
 * @param params.en_ajax_loading_id The loading Path Id
 * @param params.en_ajax_disabled_id The disabled Path Id
 * @param params.en_ajax_loading_msg_btn The message show on button during load
 */
if (typeof en_ajax_request != 'function') {
    function en_ajax_request(params, data, call_back_function) {

        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: data,
            beforeSend: function () {

                (typeof params.en_ajax_loading_id != 'undefined' &&
                    params.en_ajax_loading_id.length > 0) ?
                    jQuery(params.en_ajax_loading_id).css('background',
                        'rgba(255, 255, 255, 1) url("' + EN_ECHO_DIR_FILE + '' +
                        '/admin/tab/location/assets/images/processing.gif") no-repeat scroll 50% 50%') : "";

                (typeof params.en_ajax_disabled_id != 'undefined' &&
                    params.en_ajax_disabled_id.length > 0) ?
                    jQuery(params.en_ajax_disabled_id).prop({disabled: true}) : "";

                (typeof params.en_ajax_loading_msg_btn != 'undefined' &&
                    params.en_ajax_loading_msg_btn.length > 0) ?
                    jQuery(params.en_ajax_loading_msg_btn).addClass('spinner_disable').val("Loading ..") : "";

                (typeof params.en_ajax_loading_msg_ok_btn != 'undefined' &&
                    params.en_ajax_loading_msg_ok_btn.length > 0) ?
                    jQuery(params.en_ajax_loading_msg_ok_btn).addClass('spinner_disable').text("Loading ..") : "";
            },
            success: function (response) {
                (typeof params.en_ajax_loading_id != 'undefined' &&
                    params.en_ajax_loading_id.length > 0) ?
                    jQuery(params.en_ajax_loading_id).removeAttr('style') : "";

                (typeof params.en_ajax_disabled_id != 'undefined' &&
                    params.en_ajax_disabled_id.length > 0) ?
                    jQuery(params.en_ajax_disabled_id).prop({disabled: false}) : "";

                (typeof params.en_ajax_loading_msg_btn != 'undefined' &&
                    params.en_ajax_loading_msg_btn.length > 0) ?
                    jQuery(params.en_ajax_loading_msg_btn).removeClass('spinner_disable').val("Save") : "";

                (typeof params.en_ajax_loading_msg_ok_btn != 'undefined' &&
                    params.en_ajax_loading_msg_ok_btn.length > 0) ?
                    jQuery(params.en_ajax_loading_msg_ok_btn).removeClass('spinner_disable').text("Ok") : "";

                return call_back_function(params, response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
}

// Weight threshold for LTL freight
if (typeof en_weight_threshold_limit != 'function') {
    function en_weight_threshold_limit() {
        // Weight threshold for LTL freight
        jQuery("#en_weight_threshold_lfq").keypress(function (e) {
            if (String.fromCharCode(e.keyCode).match(/[^0-9]/g) || !jQuery("#en_weight_threshold_lfq").val().match(/^\d{0,3}$/)) return false;
        });

        jQuery('#en_plugins_return_LTL_quotes').on('change', function () {
            if (jQuery('#en_plugins_return_LTL_quotes').prop("checked")) {
                jQuery('tr.en_weight_threshold_lfq').css('display', 'contents');
            } else {
                jQuery('tr.en_weight_threshold_lfq').css('display', 'none');
            }
        });

        jQuery("#en_plugins_return_LTL_quotes").closest('tr').addClass("en_plugins_return_LTL_quotes_tr");
        // Weight threshold for LTL freight
        var weight_threshold_class = jQuery("#en_weight_threshold_lfq").attr("class");
        jQuery("#en_weight_threshold_lfq").closest('tr').addClass("en_weight_threshold_lfq " + weight_threshold_class);

        // Weight threshold for LTL freight is empty
        if (jQuery('#en_weight_threshold_lfq').length && !jQuery('#en_weight_threshold_lfq').val().length > 0) {
            jQuery('#en_weight_threshold_lfq').val(150);
        }
    }
}
if (typeof setNestedMaterialsUI != 'function') {
    function setNestedMaterialsUI() {
        const nestedMaterials = jQuery('._nestedMaterials');
        const productMarkups = jQuery('._en_product_markup');
        
        if (productMarkups?.length) {
            for (const markup of productMarkups) {
                jQuery(markup).attr('maxlength', '7');

                jQuery(markup).keypress(function (e) {
                    if (!String.fromCharCode(e.keyCode).match(/^[0-9.%-]+$/))
                        return false;
                });
            }
        }

        if (nestedMaterials?.length) {
            for (let elem of nestedMaterials) {
                const className = elem.className;

                if (className?.includes('_nestedMaterials')) {
                    const checked = jQuery(elem).prop('checked'),
                        name = jQuery(elem).attr('name'),
                        id = name?.split('_nestedMaterials')[1];
                    setNestMatDisplay(id, checked);
                }
            }
        }
    }
}

if (typeof setNestMatDisplay != 'function') {
    function setNestMatDisplay (id, checked) {
        
        jQuery(`input[name="_nestedPercentage${id}"]`).attr('min', '0');
        jQuery(`input[name="_nestedPercentage${id}"]`).attr('max', '100');
        jQuery(`input[name="_nestedPercentage${id}"]`).attr('maxlength', '3');
        jQuery(`input[name="_maxNestedItems${id}"]`).attr('min', '0');
        jQuery(`input[name="_maxNestedItems${id}"]`).attr('max', '100');
        jQuery(`input[name="_maxNestedItems${id}"]`).attr('maxlength', '3');

        jQuery(`input[name="_nestedPercentage${id}"], input[name="_maxNestedItems${id}"]`).keypress(function (e) {
            if (!String.fromCharCode(e.keyCode).match(/^[0-9]+$/))
                return false;
        });

        jQuery(`input[name="_nestedPercentage${id}"]`).closest('p').css('display', checked ? '' : 'none');
        jQuery(`select[name="_nestedDimension${id}"]`).closest('p').css('display', checked ? '' : 'none');
        jQuery(`input[name="_maxNestedItems${id}"]`).closest('p').css('display', checked ? '' : 'none');
        jQuery(`select[name="_nestedStakingProperty${id}"]`).closest('p').css('display', checked ? '' : 'none');
    }
}