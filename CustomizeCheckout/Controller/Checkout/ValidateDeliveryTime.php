<?php

namespace TrainingBackend\CustomizeCheckout\Controller\Checkout;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class ValidateDeliveryTime extends Action
{
    protected $jsonResultFactory;

    public function __construct(
        Context     $context,
        JsonFactory $jsonResultFactory
    )
    {
        parent::__construct($context);
        $this->jsonResultFactory = $jsonResultFactory;
    }

    public function execute()
    {
        $response = ['error' => false, 'message' => 'Delivery time is valid'];

        $deliveryTime = $this->getRequest()->getParam('custom_attributes')['delivery_time'];

        // Thực hiện validate khung giờ ở đây
        if (!$this->validateDeliveryTime($deliveryTime)) {
            $response = ['error' => true, 'message' => 'Invalid delivery time. Please use format HH:mm-HH:mm'];
        }

        $result = $this->jsonResultFactory->create();
        $result->setData($response);

        return $result;
    }

    private function validateDeliveryTime($time)
    {
        return preg_match('/^(0?[0-9]|1[0-9]|2[0-3])h-(0?[0-9]|1[0-9]|2[0-3])h$/', $time);
    }
}

