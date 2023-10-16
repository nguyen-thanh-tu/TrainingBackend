<?php

namespace TrainingBackend\CustomerManagement\Block\Customer;

use Magento\Customer\Block\Account\SortLinkInterface;
use Magento\Reports\Block\Product\Viewed as ReportProductViewed;

class RecentlyView extends \Magento\Framework\View\Element\Html\Link implements SortLinkInterface
{
    /**
     * Template name
     *
     * @var string
     */
    protected $_template = 'TrainingBackend_CustomerManagement::customer_recently_view.phtml';

    /**
     * @var \Magento\Wishlist\Helper\Data
     */
    protected $_wishlistHelper;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Wishlist\Helper\Data $wishlistHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        ReportProductViewed $reportProductViewed,
        array $data = []
    ) {
        $this->reportProductViewed = $reportProductViewed;
        parent::__construct($context, $data);
    }

    /**
     * {@inheritdoc}
     * @since 101.0.0
     */
    public function getSortOrder()
    {
        return $this->getData(self::SORT_ORDER);
    }

    /**
     * Get Collection Recently Viewed product
     * @return mixed
     */
    public function getProductCollection()
    {
        return $this->reportProductViewed->getItemsCollection()->setPageSize(3);
    }
}
