<?php

namespace TrainingBackend\CustomizeCheckout\Plugin;

use Magento\Quote\Api\CartRepositoryInterface;

class ShippingInformationManagement
{
    public $cartRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository
    ) {
        $this->cartRepository = $cartRepository;
    }

    public function beforeSaveAddressInformation(\Magento\Checkout\Model\ShippingInformationManagement $subject, $cartId, $addressInformation)
    {
        $quote = $this->cartRepository->getActive($cartId);
        $shippingAddress = $quote->getShippingAddress();
        $extensionAttributes = $addressInformation->getShippingAddress()->getExtensionAttributes();
        $shippingAddress->setDeliveryTime($extensionAttributes->getDeliveryTime());
        $shippingAddress->setCustomAttribute('delivery_time', $extensionAttributes->getDeliveryTime());
        $shippingAddress->save();
        $quote->setDeliveryTime($extensionAttributes->getDeliveryTime());
        $this->cartRepository->save($quote);
        return [$cartId, $addressInformation];
    }
}
