/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'ko',
    'Magento_Checkout/js/model/cart/totals-processor/default',
    'Magento_Checkout/js/model/shipping-rate-processor/new-address',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/cart/cache',
    'Magento_Ui/js/modal/alert',
    'Magento_Ui/js/modal/confirm',
    'jquery',
    'mage/translate',
    'jquery-ui-modules/widget',
    'mage/validation'
], function (ko, defaultTotal, defaultProcessor, quote, cartCache, alert, confirm, $, $t) {
    'use strict';

    $.widget('mage.updateShoppingCart', {
        options: {
            validationURL: '',
            submitURL: '',
            eventName: 'updateCartItemQty',
            updateCartActionContainer: '',
            isCartHasUpdatedContent: false
        },

        /** @inheritdoc */
        _create: function () {
            this._on(this.element, {
                'submit': this.onSubmit
            });
            this._on('[data-role=cart-item-qty]', {
                'change': function () {
                    this.isCartHasUpdatedContent = true;
                }
            });
            this._on('#shopping-cart-table', {
                'click div.action.action-delete': this.onDeleteItem
            });
            this._on('ul.pages-items', {
                'click a': function (event) {
                    if (this.isCartHasUpdatedContent) {
                        event.preventDefault();
                        this.changePageConfirm($(event.currentTarget).attr('href'));
                    }
                }
            });
        },

        /**
         * Show the confirmation popup
         * @param nextPageUrl
         */
        changePageConfirm: function (nextPageUrl) {
            confirm({
                title: $t('Are you sure you want to leave the page?'),
                content: $t('Changes you made to the cart will not be saved.'),
                actions: {
                    confirm: function () {
                        window.location.href = nextPageUrl;
                    }
                },
                buttons: [{
                    text: $t('Cancel'),
                    class: 'action-secondary action-dismiss',
                    click: function (event) {
                        this.closeModal(event);
                    }
                }, {
                    text: $t('Leave'),
                    class: 'action-primary action-accept',
                    click: function (event) {
                        this.closeModal(event, true);
                    }
                }]
            });
        },

        /**
         * Delete Item in cart.
         *
         * @param {Event} event
         * @return {Boolean}
         */
        onDeleteItem: function (event) {
            var datapost = $.parseJSON(event.currentTarget.attributes.datapost.nodeValue);
            var datadalete = datapost.data;
            $.extend(datadalete, {
                'form_key': $.mage.cookies.get('form_key')
            });
            $.ajax({
                url: datapost.action,
                data: datadalete,
                type: 'post',
                dataType: 'json',
                context: this,
            })
                .done(function (response) {
                    if (response.success) {
                        this.continueUpdate();
                    } else {
                        console.log(response);
                    }
                })
                .fail(function () {});
        },

        /**
         * Prevents default submit action and calls form validator.
         *
         * @param {Event} event
         * @return {Boolean}
         */
        onSubmit: function (event) {
            var action = this.element.find(this.options.updateCartActionContainer).val();

            if (!this.options.validationURL || action === 'empty_cart') {
                return true;
            }

            if (this.isValid()) {
                event.preventDefault();
                this.validateItems(this.options.validationURL, this.element.serialize());
            }

            return false;
        },

        /**
         * Validates requested form.
         *
         * @return {Boolean}
         */
        isValid: function () {
            return this.element.validation() && this.element.validation('isValid');
        },

        /**
         * Validates updated shopping cart data.
         *
         * @param {String} url - request url
         * @param {Object} data - post data for ajax call
         */
        validateItems: function (url, data) {
            $.extend(data, {
                'form_key': $.mage.cookies.get('form_key')
            });

            $.ajax({
                url: url,
                data: data,
                type: 'post',
                dataType: 'json',
                context: this,

                /** @inheritdoc */
                beforeSend: function () {
                    $(document.body).trigger('processStart');
                },

                /** @inheritdoc */
                complete: function () {
                    $(document.body).trigger('processStop');
                }
            })
                .done(function (response) {
                    if (response.success) {
                        this.continueUpdate(data);
                    } else {
                        this.onError(response);
                    }
                })
                .fail(function () {
                    this.submitForm();
                });
        },

        continueUpdate: function (data) {
            $.ajax({
                url: this.options.submitURL,
                data: data,
                type: 'post',
                dataType: 'json',
                context: this,
            })
                .done(function (response) {
                    if (response.success) {
                        var type = quote.shippingAddress().getType();
                        var processors = {};
                        processors.default = defaultProcessor;
                        if (processors[type]) {
                            processors[type].getRates(quote.shippingAddress());
                        } else {
                            processors.default.getRates(quote.shippingAddress());
                        }
                        cartCache.set('totals',null);
                        defaultTotal.estimateTotals();
                        $('.cart > .item').remove();
                        $(response.data).insertAfter('#shopping-cart-table > thead');
                    } else {
                        console.log(response);
                    }
                })
                .fail(function () {
                    this.submitForm();
                });
        },

        /**
         * Form validation succeed.
         */
        onSuccess: function () {
            $(document).trigger('ajax:' + this.options.eventName);
            this.submitForm();
        },

        /**
         * Form validation failed.
         */
        onError: function (response) {
            var that = this,
                elm,
                responseData = [];

            try {
                responseData = JSON.parse(response['error_message']);
            } catch (error) {
            }

            if (response['error_message']) {
                try {
                    $.each(responseData, function (index, data) {

                        if (data.itemId !== undefined) {
                            elm = $('#cart-' + data.itemId + '-qty');
                            elm.val(elm.attr('data-item-qty'));
                        }
                        response['error_message'] = data.error;
                    });
                } catch (e) {}
                alert({
                    content: response['error_message'],
                    actions: {
                        /** @inheritdoc */
                        always: function () {
                            that.submitForm();
                        }
                    }
                });
            } else {
                this.submitForm();
            }
        },

        /**
         * Real submit of validated form.
         */
        submitForm: function () {
            this.element
                .off('submit', this.onSubmit)
                .on('submit', function () {
                    $(document.body).trigger('processStart');
                })
                .trigger('submit');
        }
    });

    return $.mage.updateShoppingCart;
});
