<?php

namespace TrainingBackend\FullPageCache\Plugin;

use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable as ConfigurableType;

class GetQty
{
    protected $stockRegistry;
    protected $configurableType;

    public function __construct
    (
        StockRegistryInterface $stockRegistry,
        ConfigurableType       $configurableType
    )
    {
        $this->stockRegistry = $stockRegistry;
        $this->configurableType = $configurableType;
    }

    public function afterExecute(\Magento\InventoryCatalogFrontendUi\Controller\Product\GetQty $subject, $result)
    {
        $stockItem = $this->stockRegistry->getStockItemBySku($subject->getRequest()->getParam('sku'));
        $qty = $stockItem->getQty();
        $result->setData(
            [
                'qty' => $qty
            ]
        );
        return $result;
    }
}
