<?php

namespace TrainingBackend\CustomerManagement\Helper;

use Magento\Catalog\Model\Product;
use Magento\Customer\Model\Address\Config as AddressConfig;
use Magento\Directory\Helper\Data;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Event\ManagerInterface;
use Magento\Quote\Model\QuoteFactory;
use Magento\Quote\Model\Quote\Address;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Quote extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $quote;

    protected $storeManager;

    protected $addressConfig;

    protected $eventManager;

    public function __construct
    (
        Context $context,
        QuoteFactory $quote,
        StoreManagerInterface $storeManager,
        AddressConfig $addressConfig,
        ManagerInterface $eventManager
    )
    {
        $this->quote = $quote;
        $this->storeManager = $storeManager;
        $this->addressConfig = $addressConfig;
        $this->eventManager = $eventManager;
        parent::__construct($context);
    }

    public function getQuote($quoteId)
    {
        return $this->quote->create()->load($quoteId);
    }

    public function getQuoteItemsHtml($quoteId)
    {
        $quote = $this->getQuote($quoteId);
        $items = $quote->getAllItems();
        $itemsHtml = "<table style='border-collapse: collapse;width: 100%;'>
                        <tr style='border: 1px solid #ddd;padding: 8px;'>
                            <th style='border: 1px solid #ddd;padding: 8px; padding-top: 12px;padding-bottom: 12px;text-align: center;'>" . __('Image') . "</th>
                            <th style='border: 1px solid #ddd;padding: 8px; padding-top: 12px;padding-bottom: 12px;text-align: center;'>" . __('Name') . "</th>
                            <th style='border: 1px solid #ddd;padding: 8px; padding-top: 12px;padding-bottom: 12px;text-align: center;'>" . __('Qty') . "</th>
                            <th style='border: 1px solid #ddd;padding: 8px; padding-top: 12px;padding-bottom: 12px;text-align: center;'>" . __('Price') . "</th>
                        </tr>";
        foreach ($items as $item) {
            $itemsHtml .= $this->getItemHtml($item);
        }
        $itemsHtml .= "</table>";
        return $itemsHtml;
    }

    public function getItemHtml(\Magento\Quote\Model\Quote\Item $item)
    {
        if ($item->getParentItemId()) {
            return '';
        }
        $currency = $item->getQuote()->getCurrency();
        $currencyCode = $currency ? $currency->getQuoteCurrencyCode() : '';
        $productId = $item->getProduct() ? $item->getProduct()->getId() : null;
        /** @var \Magento\Catalog\Model\Product $product */
        $product = ObjectManager::getInstance()->create(Product::class)->load($productId);
        $productImageUrl = $product->getMediaGalleryImages() ? $product->getMediaGalleryImages()->getFirstItem()->getUrl() : null;
        if ($children = $item->getChildren()) {
            if ($childItem = reset($children)) {
                $childProduct = ObjectManager::getInstance()->create(Product::class)->load($childItem->getProductId());
                $productImageUrl = $childProduct->getMediaGalleryImages() ? $childProduct->getMediaGalleryImages()->getFirstItem()->getUrl() : null;
            }
        }
        $html = "<tr style='border: 1px solid #ddd;padding: 8px;'>
                    <td style='border: 1px solid #ddd;padding: 8px;'>
                        <a href='" . $product->getProductUrl() . "' target='_blank'>
                            <img src='" . $productImageUrl . "' height='150' width='120'>
                        </a>
                    </td>
                    <td style='border: 1px solid #ddd;padding: 8px;'>
                        <span class='product-name'>" . $product->getName() . "</span>
                    </td>
                    <td style='border: 1px solid #ddd;padding: 8px;'>
                        <p style='font-weight: bold'>" . number_format($item->getQty(), 2) . "</p>
                    </td>
                    <td style='border: 1px solid #ddd;padding: 8px;'>
                        <p style='font-weight: bold'>" . number_format($item->getPrice(), 2) . ' ' . $currencyCode . "</p>
                    </td>
                </tr>";
        return $html;
    }

    public function getBillingAddressHtml($quoteId)
    {
        $quote = $this->getQuote($quoteId);
        return $this->format($quote->getBillingAddress(), 'html');
    }

    public function getShippingAddressHtml($quoteId)
    {
        $quote = $this->getQuote($quoteId);
        return $this->format($quote->getShippingAddress(), 'html');
    }

    /**
     * Format address in a specific way
     *
     * @param Address $address
     * @param string $type
     * @return string|null
     */
    public function format(Address $address, $type)
    {
        $orderStore = $address->getQuote()->getStore();
        $this->storeManager->setCurrentStore($orderStore);
        $formatType = $this->addressConfig->getFormatByCode($type);
        if (!$formatType || !$formatType->getRenderer()) {
            return null;
        }
        $this->eventManager->dispatch('customer_address_format', ['type' => $formatType, 'address' => $address]);
        $addressData = $address->getData();
        $addressData['locale'] = $this->getLocaleByStoreId((int) $orderStore->getId());

        return $formatType->getRenderer()->renderArray($addressData);
    }

    /**
     * Returns locale by storeId
     *
     * @param int $storeId
     * @return string
     */
    private function getLocaleByStoreId(int $storeId): string
    {
        return $this->scopeConfig->getValue(Data::XML_PATH_DEFAULT_LOCALE, ScopeInterface::SCOPE_STORE, $storeId);
    }
}
