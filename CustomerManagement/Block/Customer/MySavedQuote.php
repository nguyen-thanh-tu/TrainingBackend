<?php

namespace TrainingBackend\CustomerManagement\Block\Customer;

use Magento\Downloadable\Block\Customer\Products\ListProducts;
use Magento\Downloadable\Model\Link\Purchased\Item;

class MySavedQuote extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     */
    protected $currentCustomer;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer
     * @param \Magento\Downloadable\Model\ResourceModel\Link\Purchased\CollectionFactory $linksFactory
     * @param \Magento\Downloadable\Model\ResourceModel\Link\Purchased\Item\CollectionFactory $itemsFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        \Magento\Quote\Model\ResourceModel\Quote\CollectionFactory $quoteCollection,
        array $data = []
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->quoteCollection= $quoteCollection;
        parent::__construct($context, $data);
    }

    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $customer = $this->currentCustomer->getCustomer();
        $quoteCollection = $this->quoteCollection->create()
            ->addFieldToFilter('customer_id' ,$this->currentCustomer->getCustomerId())
//            ->addFieldToFilter('is_active', false)
            ->addFieldToFilter('saved_quote', true)
            ->addFieldToFilter('store_id', $customer->getStoreId())
            ->addOrder('created_at', 'desc');
        $this->setItems($quoteCollection);
    }

    /**
     * Enter description here...
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock(
            \Magento\Theme\Block\Html\Pager::class,
            'mysavedquote.pager'
        )->setCollection(
            $this->getItems()
        )->setPath('customermanagement/index/mysavedquote');
        $this->setChild('pager', $pager);
        $this->getItems()->load();
        return $this;
    }

    /**
     * Enter description here...
     *
     * @return string
     */
    public function getBackUrl()
    {
        if ($this->getRefererUrl()) {
            return $this->getRefererUrl();
        }
        return $this->getUrl('customer/account/');
    }
}
