<?php

namespace TrainingBackend\EAV\Controller\Adminhtml\Merchant;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use TrainingBackend\EAV\Model\MerchantFactory;

class Save extends Action
{
    /**
     * @var MerchantFactory
     */
    protected $merchantFactory;

    /**
     * Save constructor.
     *
     * @param Context $context
     * @param MerchantFactory $merchantFactory
     */
    public function __construct(
        Context $context,
        MerchantFactory $merchantFactory
    ) {
        parent::__construct($context);
        $this->merchantFactory = $merchantFactory;
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        if (!$data) {
            return $this->_redirect('trainingbackend_eav/merchant/index');
        }

        try {
            if(empty($data['entity_id'])){
                $data['entity_id'] = null;
            }
            if(!empty($data['category'])){
                $data['category'] = implode(',', $data['category']);
            }
            // Process your data and save to database using MerchantFactory
            $merchantModel = $this->merchantFactory->create();
            // Set data to model
            $merchantModel->setData($data);
            // Save data to database
            $merchantModel->save();

            // Display success message
            $this->messageManager->addSuccessMessage(__('Merchant has been saved successfully.'));
            if (isset($data['back']) && $data['back'] == 'edit') {
                return $this->_redirect('trainingbackend_eav/merchant/form', ['entity_id' => $data['entity_id']]);
            }
        } catch (\Exception $e) {
            // Display error message
            $this->messageManager->addErrorMessage(__('An error occurred while saving the merchant.'));
        }

        // Redirect back to grid
        return $this->_redirect('trainingbackend_eav/merchant/index');
    }
}

