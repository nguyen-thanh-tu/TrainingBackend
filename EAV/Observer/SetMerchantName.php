<?php

namespace TrainingBackend\EAV\Observer;

class SetMerchantName implements \Magento\Framework\Event\ObserverInterface
{
    protected $merchant;

    public function __construct
    (
        \TrainingBackend\EAV\Model\MerchantFactory $merchant
    )
    {
        $this->merchant = $merchant;
    }

    /**
     * Set the current date to Special Price From attribute if it's empty.
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var  $product \Magento\Catalog\Model\Product */
        $product = $observer->getEvent()->getProduct();
        if (!empty($product->getMerchantId())) {
            $merchant = $this->merchant->create()->load($product->getMerchantId());
            $product->setData('merchant_name', $merchant->getName());
        }
        return $this;
    }
}
