<?php

namespace TrainingBackend\DevelopingAdminhtml\Controller\Adminhtml\Event;

use Magento\Backend\App\Action\Context;
use Magento\Customer\Controller\Adminhtml\Index\AbstractMassAction;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use Magento\Eav\Model\Entity\Collection\AbstractCollection;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;
use Magento\Ui\Component\MassAction\Filter;

class MassRegister extends AbstractMassAction
{
    /** @var Registry  */
    protected $_coreRegistry;

    public function __construct
    (
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        Registry $coreRegistry
    )
    {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $filter, $collectionFactory);
    }

    protected function massAction(AbstractCollection $collection)
    {
        $this->_coreRegistry->register('customer_ids', $collection->getAllIds());
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
