<?php

namespace TrainingBackend\EAV\Ui\Component\Form\Merchant;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $_loadedData;

    public function __construct
    (
        $name,
        $primaryFieldName,
        $requestFieldName,
        \TrainingBackend\EAV\Model\ResourceModel\Merchant\Collection $collection,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collection;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection
            ->addFieldToSelect('*')
            ->addFieldToFilter('entity_id', ['neq' => ''])
            ->getItems();
        if(!empty($items)){
            $this->_loadedData[null] = [];
        }else{
            foreach ($items as $brand) {
                $this->_loadedData[$brand->getEntityId()] = $brand->getData();
            }
        }
        return $this->_loadedData;
    }
}
