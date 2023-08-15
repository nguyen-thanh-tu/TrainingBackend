<?php

namespace TrainingBackend\CustomizingCatalog\Ui\Component\Listing\Column;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Catalog\Model\CategoryFactory as CatalogCategoryFactory;

class Categories extends Column
{
    protected $productRepository;

    /** @var CatalogCategoryFactory  */
    protected $categoryFactory;

    public function __construct(
        ContextInterface           $context,
        UiComponentFactory         $uiComponentFactory,
        ProductRepositoryInterface $productRepository,
        CatalogCategoryFactory  $categoryFactory,
        array                      $components = [],
        array $data = []
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->productRepository = $productRepository;
        $this->categoryFactory = $categoryFactory;
    }

    public function prepareDataSource(array $dataSource)
    {
        $fieldName = $this->getData('name');

        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $productId = $item['entity_id'];

                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $product = $this->productRepository->getById($productId);

                $categoryIds = $product->getCategoryIds();

                $categories = $this->categoryFactory->create()
                    ->getCollection()
                    ->addAttributeToSelect('name')
                    ->addAttributeToFilter('entity_id', ['in' => $categoryIds])
                    ->load();
                $categoriess = [];
                foreach($categories->getItems() as $category)
                {
                    $categoriess[] = $category->getName();
                }
                $item[$fieldName] = implode(',', $categoriess);
            }
        }

        return $dataSource;
    }
}
