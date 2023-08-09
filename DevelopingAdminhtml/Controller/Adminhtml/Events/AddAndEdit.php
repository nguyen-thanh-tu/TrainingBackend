<?php

namespace TrainingBackend\DevelopingAdminhtml\Controller\Adminhtml\Events;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;

class AddAndEdit extends \Magento\Customer\Controller\Adminhtml\Index implements HttpGetActionInterface
{
    /**
     * Customer edit action
     *
     * @return \Magento\Framework\View\Result\Page
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Events'));
        return $resultPage;
    }
}
