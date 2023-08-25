<?php

namespace TrainingBackend\CustomizeCheckout\Model\Quote\Address;

class CustomAttributeList extends \Magento\Quote\Model\Quote\Address\CustomAttributeList
{
    /**
     * Retrieve list of quote address custom attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        return ['delivery_time' => 'delivery_time'];
    }
}
