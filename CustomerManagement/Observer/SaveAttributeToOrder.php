<?php

namespace TrainingBackend\CustomerManagement\Observer;

use Magento\Framework\Event\Observer;

class SaveAttributeToOrder implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();

        // Set the custom attribute value for the order
        $order->setIsRestoreSavedCart($quote->getIsRestoreSavedCart());

        return $this;
    }

}
