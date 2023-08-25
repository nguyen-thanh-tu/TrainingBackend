<?php

namespace TrainingBackend\CustomizeCheckout\Plugin\Model\Quote;

class Address
{
    public function afterExportCustomerAddress(\Magento\Quote\Model\Quote\Address $subject, $result)
    {
        $result->setCustomAttribute('delivery_time', $subject->getDeliveryTime());
        return $result;
    }
}
