<?php

namespace TrainingBackend\CustomizingCatalog\Ui\DataProvider\Product;

use Magento\Framework\Api\Filter;

class ProductDataProvider extends \Magento\Catalog\Ui\DataProvider\Product\ProductDataProvider
{
    public function addFilter(Filter $filter)
    {
        if ($filter->getField() == 'category_ids') {
            $this->getCollection()->addCategoriesFilter(['in' => $filter->getValue()]);
        } else if (isset($this->addFilterStrategies[$filter->getField()])) {
            $this->addFilterStrategies[$filter->getField()]
                ->addFilter(
                    $this->getCollection(),
                    $filter->getField(),
                    [$filter->getConditionType() => $filter->getValue()]
                );
        } else {
            parent::addFilter($filter);
        }
    }
}
