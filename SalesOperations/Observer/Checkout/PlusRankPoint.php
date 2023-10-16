<?php

namespace TrainingBackend\SalesOperations\Observer\Checkout;

use Magenest\LiveStreaming\Api\StreamManagementInterface;
use Magenest\LiveStreaming\Observer\Report\AbstractReportObserver;
use Magento\Framework\Event\Observer;

class PlusRankPoint extends AbstractReportObserver
{
    protected $customer;

    public function __construct
    (
        \Magenest\LiveStreaming\Observer\EventSaver $eventSaver,
        \Magenest\LiveStreaming\Helper\ReportHelper $reportHelper,
        \Magenest\LiveStreaming\Api\StreamReportManagementInterface $streamReportManagement,
        StreamManagementInterface $streamManagementInterface,
        \Magento\Customer\Model\CustomerFactory $customer,
    )
    {
        $this->customer = $customer;
        parent::__construct($eventSaver, $reportHelper, $streamReportManagement, $streamManagementInterface);
    }

    public function execute(Observer $observer)
    {
        $customer = $this->customer->create()->load($observer->getOrder()->getCustomerId());
        $customer->setRankPoint((int)$customer->getRankPoint() + (int)$observer->getOrder()->getGrandTotal());
        $customer->save();
    }
}
