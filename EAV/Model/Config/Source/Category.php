<?php

namespace TrainingBackend\EAV\Model\Config\Source;

use Magento\Catalog\Model\CategoryFactory;
use Magento\Framework\Data\OptionSourceInterface;

class Category implements OptionSourceInterface
{
    protected $categoryFactory;

    public function __construct(CategoryFactory $categoryFactory)
    {
        $this->categoryFactory = $categoryFactory;
    }

    public function toOptionArray()
    {
        $categories = $this->categoryFactory->create()->getCollection()
            ->addAttributeToSelect('name')
            ->addIsActiveFilter();

        $options = [];

        foreach ($categories as $category) {
            $options[$category->getId()] = [
                'label' => $category->getName(),
                'value' => $category->getId()
            ];
        }

        return $options;
    }
}
