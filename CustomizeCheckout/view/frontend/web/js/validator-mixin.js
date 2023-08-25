define([
    'jquery',
    'jquery/validate'
], function ($) {
    "use strict";

    return function (validator) {
        validator.addRule('custom-telephone', function (v, e) {
            if (/^[\+\-]?(\d+)?$/.test(v)) {
                $(this).removeClass('error');
                return true;
            } else {
                $(this).addClass('error');
                return false;
            }
        }, $.mage.__("Please enter a valid ..."));

        validator.addRule('delivery-time-validation', function (v, e) {
            const regex = /^(0?[0-9]|1[0-9]|2[0-3])h-(0?[0-9]|1[0-9]|2[0-3])h$/;
            if (regex.test(v)) {
                $(this).removeClass('error');
                return true;
            } else {
                $(this).addClass('error');
                return false;
            }
        }, $.mage.__("Format xh-yh. Ex: 14h-21h"));

        return validator;
    };
});
