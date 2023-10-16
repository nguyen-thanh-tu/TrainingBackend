<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TrainingBackend\CustomizingCatalog\ViewModel\Product;

use Magento\Catalog\Helper\Data;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Serialize\Serializer\JsonHexTag;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Escaper;
use Magento\Store\Model\ScopeInterface;
use Magento\Catalog\Model\CategoryFactory;

/**
 * Product breadcrumbs view model.
 */
class Breadcrumbs extends DataObject implements ArgumentInterface
{
    private const XML_PATH_CATEGORY_URL_SUFFIX = 'catalog/seo/category_url_suffix';
    private const XML_PATH_PRODUCT_USE_CATEGORIES = 'catalog/seo/product_use_categories';

    /**
     * @var Data
     */
    private $catalogData;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * @var JsonHexTag
     */
    private $jsonSerializer;

    /**
     * @var CategoryFactory
     */
    private $categoryFactory;

    /**
     * @param Data $catalogData
     * @param ScopeConfigInterface $scopeConfig
     * @param Escaper $escaper
     * @param JsonHexTag $jsonSerializer
     * @param CategoryFactory $categoryFactory
     */
    public function __construct(
        Data                 $catalogData,
        ScopeConfigInterface $scopeConfig,
        Escaper              $escaper,
        JsonHexTag           $jsonSerializer,
        CategoryFactory      $categoryFactory
    )
    {
        parent::__construct();

        $this->catalogData = $catalogData;
        $this->scopeConfig = $scopeConfig;
        $this->escaper = $escaper;
        $this->jsonSerializer = $jsonSerializer;
        $this->categoryFactory = $categoryFactory;
    }

    /**
     * Returns category URL suffix.
     *
     * @return mixed
     */
    public function getCategoryUrlSuffix()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CATEGORY_URL_SUFFIX,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Checks if categories path is used for product URLs.
     *
     * @return bool
     */
    public function isCategoryUsedInProductUrl(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_PRODUCT_USE_CATEGORIES,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Returns product name.
     *
     * @return string
     */
    public function getProductName(): string
    {
        return $this->catalogData->getProduct() !== null
            ? $this->catalogData->getProduct()->getName()
            : '';
    }

    /**
     * Returns breadcrumb json with html escaped names
     *
     * @return string
     */
    public function getJsonConfigurationHtmlEscaped(): string
    {
        $product = $this->catalogData->getProduct();
        $level = 0;
        $categoryUrl = '';
        foreach ($product->getCategoryIds() as $categoryId) {
            $category = $this->categoryFactory->create()->load($categoryId);
            if ($category->getLevel() > $level && $category->getMainBreadcrumb()) {
                $level = $category->getLevel();
                $categoryUrl = $category->getUrl();
            }
        }
        return $this->jsonSerializer->serialize(
            [
                'breadcrumbs' => [
                    'categoryUrlSuffix' => $this->escaper->escapeHtml($this->getCategoryUrlSuffix()),
                    'useCategoryPathInUrl' => (int)$this->isCategoryUsedInProductUrl(),
                    'product' => $this->escaper->escapeHtml($this->getProductName()),
                    'categoryUrl' => $categoryUrl
                ]
            ]
        );
    }
}