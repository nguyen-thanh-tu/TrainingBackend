<?php

namespace TrainingBackend\DevelopingAdminhtml\Controller\Adminhtml\Events;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use TrainingBackend\DevelopingAdminhtml\Model\EventFactory;

class Delete extends Action
{
    /**
     * @var EventFactory
     */
    protected $eventFactory;

    /**
     * Save constructor.
     *
     * @param Context $context
     * @param EventFactory $eventFactory
     */
    public function __construct(
        Context      $context,
        EventFactory $eventFactory
    )
    {
        parent::__construct($context);
        $this->eventFactory = $eventFactory;
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        if (!$data) {
            return $this->_redirect('customer/index/index');
        }

        try {
            if (!empty($data['id'])) {
                $merchantModel = $this->eventFactory->create()->load($data['id']);
                $merchantModel->delete();
            }

            // Display success message
            $this->messageManager->addSuccessMessage(__('Event has been deleted.'));
        } catch (\Exception $e) {
            // Display error message
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        // Redirect back to grid
        return $this->_redirect('customer/index/index');
    }
}
