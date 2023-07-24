<?php

namespace TrainingBackend\EAV\Model\Merchant;

use Magento\Ui\DataProvider\AbstractDataProvider;
use TrainingBackend\EAV\Model\ResourceModel\Merchant\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    protected $_loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $CollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $CollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection
            ->addFieldToSelect('*')
            ->addFieldToFilter('entity_id', ['neq' => ''])
            ->getItems();
        foreach ($items as $brand) {
            $this->_loadedData[$brand->getEntityId()] = $brand->getData();
        }
        return $this->_loadedData;
    }
}
