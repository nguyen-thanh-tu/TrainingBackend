<?php

namespace TrainingBackend\CustomerManagement\Block\Customer;

use Magento\Framework\View\Element\Template;
use TrainingBackend\CustomerManagement\Helper\Quote;

class SavedQuoteDetail extends \Magento\Framework\View\Element\Template
{
    public function __construct
    (
        Template\Context $context,
        Quote $quote,
        array $data = []
    )
    {
        $this->quote = $quote;
        parent::__construct($context, $data);
    }

    public function getQuoteItemsHtml()
    {
        return $this->quote->getQuoteItemsHtml($this->getRequest()->getParam('id'));
    }

    public function getBillingAddressHtml()
    {
        return $this->quote->getBillingAddressHtml($this->getRequest()->getParam('id'));
    }

    public function getShippingAddressHtml()
    {
        return $this->quote->getShippingAddressHtml($this->getRequest()->getParam('id'));
    }

    public function getShippingMethod()
    {
        return $this->quote->getQuote($this->getRequest()->getParam('id'))->getShippingAddress()->getShippingDescription();
    }

    public function getCouponCode()
    {
        return $this->quote->getQuote($this->getRequest()->getParam('id'))->getCouponCode();
    }
}
