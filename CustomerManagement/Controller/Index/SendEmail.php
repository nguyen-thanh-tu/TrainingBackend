<?php

namespace TrainingBackend\CustomerManagement\Controller\Index;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\UrlInterface;

class SendEmail extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var \TrainingBackend\CustomerManagement\Helper\Quote
     */
    protected $quote;

    /**
     * @var \TrainingBackend\CustomerManagement\Helper\Email
     */
    protected $emailSender;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param ResultFactory $resultFactory
     * @param \Magento\Quote\Model\QuoteFactory $quote
     * @param \TrainingBackend\CustomerManagement\Helper\Email $emailSender
     */
    public function __construct
    (
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\ResultFactory $resultFactory,
        \TrainingBackend\CustomerManagement\Helper\Quote $quote,
        \TrainingBackend\CustomerManagement\Helper\Email $emailSender,
        UrlInterface $urlBuilder
    )
    {
        $this->resultFactory = $resultFactory;
        $this->quote = $quote;
        $this->emailSender = $emailSender;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $quoteId = $this->getRequest()->getParam('id');
        $quote = $this->quote->getQuote($quoteId);
        $this->emailSender->sendEmail(
            $this->quote->getQuoteItemsHtml($quoteId),
            $quote->getCouponCode(),
            $this->urlBuilder->getUrl('customermanagement/index/detail', ['id' => $quoteId]),
            $quote->getCustomer()->getEmail()
        );
        $this->messageManager->addSuccess(__("Success! Email Saved Quote sended to your email"));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('customermanagement/index/mysavedquote');
    }
}

