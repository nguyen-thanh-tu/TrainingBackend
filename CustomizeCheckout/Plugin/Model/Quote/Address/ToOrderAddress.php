<?php

namespace TrainingBackend\CustomizeCheckout\Plugin\Model\Quote\Address;

use Magento\Quote\Model\Quote\Address;

class ToOrderAddress
{
    public function afterConvert(\Magento\Quote\Model\Quote\Address\ToOrderAddress $subject, $result, Address $object, $data = [])
    {
        $result->setData('delivery_time', $object->getDeliveryTime());
        return $result;
    }
}
