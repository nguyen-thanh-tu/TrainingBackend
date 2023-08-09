<?php

namespace TrainingBackend\DevelopingAdminhtml\Controller\Adminhtml\Event;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use TrainingBackend\DevelopingAdminhtml\Model\MassRegistrationProducer;

class MassEvent extends Action
{
    private $massRegistrationProducer;
    private $resultPageFactory;

    public function __construct
    (
        Context $context,
        MassRegistrationProducer $massRegistrationProducer,
        PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->massRegistrationProducer = $massRegistrationProducer;
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $params = $this->getRequest()->getParams();
        $customerIds = explode(',', $params['customer_ids']);
        foreach ($customerIds as $customerId) {
            $this->massRegistrationProducer->sendMassRegistrationMessage($customerId, $params['sechedule_id'], $params['note']);
        }
        $this->messageManager->addSuccessMessage(__('Mass registration messages sent.'));
        $this->_redirect('*/*/');
    }
}
