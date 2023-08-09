<?php

namespace TrainingBackend\DevelopingAdminhtml\Model\DataProvider;

use TrainingBackend\DevelopingAdminhtml\Model\ResourceModel\Event\CollectionFactory;

class Event extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $_loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
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
            ->addFieldToFilter('event_id', ['neq' => ''])
            ->getItems();
        foreach ($items as $brand) {
            $this->_loadedData[$brand->getEntityId()] = $brand->getData();
        }
        return $this->_loadedData;
    }
}

