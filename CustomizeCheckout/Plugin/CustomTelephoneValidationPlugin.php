<?php

namespace TrainingBackend\CustomizeCheckout\Plugin;

class CustomTelephoneValidationPlugin
{
    /**
     * Validate telephone input value.
     *
     * @param \Magento\Ui\Component\Form\Element\Input $subject
     * @param string $result
     * @return string
     */
    public function afterProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor $subject, $result, $jsLayout)
    {
        $result['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['component'] = 'TrainingBackend_CustomizeCheckout/js/view/shipping';

        $result['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['telephone']['validation'] = [
            'required-entry' => true,
            'custom-telephone' => true
        ];

        $result['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['delivery_time'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
                'tooltip' => [
                    'description' => 'Format xh-yh. Ex: 14h-21h',
                ],
            ],
            'dataScope' => 'shippingAddress.custom_attributes.delivery_time',
            'label' => __('Desired Delivery Time'),
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [
                'delivery-time-validation' => true
            ],
            'sortOrder' => 25,
            'id' => 'delivery-time',
        ];

        return $result;
    }
}
