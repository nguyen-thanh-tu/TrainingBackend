<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace TrainingBackend\EAV\Controller\Adminhtml\Merchant;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Controller\ResultFactory;
use TrainingBackend\EAV\Model\ResourceModel\Merchant\CollectionFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;

/**
 * Mass Delete action.
 */
class MassDelete extends Action implements HttpPostActionInterface
{
    private $collection;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Execute action.
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $reviewsIds = $this->getRequest()->getParam('entity_ids');
        if (!is_array($reviewsIds)) {
            $this->messageManager->addErrorMessage(__('Please select Merchant(s).'));
        } else {
            try {
                foreach ($this->getCollection() as $model) {
                    $model->delete();
                }
                $this->messageManager->addSuccessMessage(
                    __('A total of %1 record(s) have been deleted.', count($reviewsIds))
                );
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('Something went wrong while deleting these records.')
                );
            }
        }
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('trainingbackend_eav/merchant/index');
        return $resultRedirect;
    }

    private function getCollection()
    {
        if ($this->collection === null) {
            $collection = $this->collectionFactory->create();
            $collection->addFieldToFilter(
                $collection->getResource()->getIdFieldName(),
                $this->getRequest()->getParam('entity_ids')
            );

            $this->collection = $collection;
        }

        return $this->collection;
    }
}
