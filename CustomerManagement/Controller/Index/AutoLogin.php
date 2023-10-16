<?php

namespace TrainingBackend\CustomerManagement\Controller\Index;

use Magento\Framework\App\Action\Action;

class AutoLogin extends Action
{
    protected $customerCollection;
    protected $customerModel;
    protected $customerSession;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollection,
        \Magento\Customer\Model\CustomerFactory $customerModel,
        \Magento\Customer\Model\Session $customerSession
    )
    {
        parent::__construct($context);

        $this->customerCollection = $customerCollection;
        $this->customerModel = $customerModel;
        $this->customerSession = $customerSession;
    }

    public function execute()
    {
        $k = $this->getRequest()->getParam('k');
        $id = $this->getRequest()->getParam('k');
        if(!$this->customerSession->isLoggedIn())
        {
            $collection = $this->customerCollection->create();
            $collection->addAttributeToFilter('entity_id', base64_decode($k));
            if($collection->getSize())
            {
                $customer_id = $collection->getFirstItem()->getId();
                $customer = $this->customerModel->create()->load($customer_id);
                $this->customerSession->setCustomerAsLoggedIn($customer);
            }
        }
        return $this->_redirect('customermanagement/index/detail', ['id' => base64_decode($id)]);
    }
}
