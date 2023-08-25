let config = {
    "config": {
        "mixins": {
            'Magento_Ui/js/lib/validation/validator': {
                'TrainingBackend_CustomizeCheckout/js/validator-mixin': true
            }
        }
    },
    "map": {
        '*': {
            'Magento_Checkout/js/model/shipping-rate-processor/new-address':'TrainingBackend_CustomizeCheckout/js/model/shipping-rate-processor/new-address',
            'Magento_Checkout/js/model/shipping-save-processor/default':'TrainingBackend_CustomizeCheckout/js/model/shipping-save-processor/default'
        }
    }
};
