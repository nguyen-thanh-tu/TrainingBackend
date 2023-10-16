<?php

namespace TrainingBackend\SalesOperations\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class SalesCreditMemoSaveBefore implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        $creditmemo = $observer->getEvent()->getCreditmemo();

        // Modify the grand total of the credit memo as needed
        $newGrandTotal = 100.00; // Set the desired grand total
        $creditmemo->setGrandTotal($newGrandTotal);
        $creditmemo->setBaseGrandTotal($newGrandTotal);

        // Ensure that other necessary calculations are adjusted accordingly, if applicable

        return $this;
    }
}

