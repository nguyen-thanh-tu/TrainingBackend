/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'Magento_Ui/js/modal/confirm',
    'mage/translate'
], function ($, confirm) {
    'use strict';

    /**
     * @param {String} url
     * @returns {jQuery}
     */
    function getForm(url) {
        return $('<form>', {
            'action': url,
            'method': 'POST'
        }).append($('<input>', {
            'name': 'form_key',
            'value': window.FORM_KEY,
            'type': 'hidden'
        }));
    }

    $(document).on('click', '#order-view-cancel-button', function () {
        var options = {
            type: 'popup',
            responsive: true,
            innerScroll: true,
            title: $.mage.__('Plase Confirm reason to cancal this order'),
            buttons: [{
                text: $.mage.__('Cancal'),
                'class': 'action-primary',
                /** @inheritdoc */
                click: function () {
                    $("#popup-modal-main-cancel-order").modal(options).modal('closeModal');
                }
            },{
                text: $.mage.__('Comfirm'),
                'class': 'action-primary',
                /** @inheritdoc */
                click: function () {
                    $('#popup-modal-main-cancel-order').submit();
                }
            }]
        };
        $("#popup-modal-main-cancel-order").modal(options).modal('openModal');

        return false;
    });

    $(document).on('click', '#order-view-hold-button', function () {
        var url = $('#order-view-hold-button').data('url');

        getForm(url).appendTo('body').trigger('submit');
    });

    $(document).on('click', '#order-view-unhold-button', function () {
        var url = $('#order-view-unhold-button').data('url');

        getForm(url).appendTo('body').trigger('submit');
    });
});
