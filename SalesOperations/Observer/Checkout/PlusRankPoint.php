<?php

namespace TrainingBackend\SalesOperations\Observer\Checkout;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class PlusRankPoint implements ObserverInterface
{
    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customer;

    /**
     * @param \Magento\Customer\Model\CustomerFactory $customer
     */
    public function __construct
    (
        \Magento\Customer\Model\CustomerFactory $customer,
    )
    {
        $this->customer = $customer;
    }

    public function execute(Observer $observer)
    {
        $customer = $this->customer->create()->load($observer->getOrder()->getCustomerId());
        $customer->setRankPoint((int)$customer->getRankPoint() + (int)$observer->getOrder()->getGrandTotal());
        $customer->save();
    }
}
