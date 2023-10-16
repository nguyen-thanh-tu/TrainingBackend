<?php

namespace TrainingBackend\CustomerManagement\Controller\Index;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class RestoreQuote extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var \Magento\Quote\Model\QuoteFactory
     */
    protected $quote;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param ResultFactory $resultFactory
     * @param \Magento\Quote\Model\QuoteFactory $quote
     */
    public function __construct
    (
        \Magento\Framework\App\Action\Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Controller\ResultFactory $resultFactory,
        \Magento\Quote\Model\QuoteFactory $quote
    )
    {
        $this->checkoutSession = $checkoutSession;
        $this->resultFactory = $resultFactory;
        $this->quote = $quote;
        return parent::__construct($context);
    }

    /**
     * @return ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $checkoutSession = $this->checkoutSession;
        $quote = $this->quote->create()->load($this->getRequest()->getParam('id'));
        $quote->setIsActive(true);
        $quote->setSavedQuote(true);
        $quote->save();
        $checkoutSession->replaceQuote($quote);
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('checkout/cart/index');
    }
}
