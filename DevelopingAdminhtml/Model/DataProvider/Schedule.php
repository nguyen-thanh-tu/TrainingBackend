<?php

namespace TrainingBackend\DevelopingAdminhtml\Model\DataProvider;

use TrainingBackend\DevelopingAdminhtml\Model\ResourceModel\Schedule\CollectionFactory;
use Magento\Framework\App\RequestInterface;

class Schedule extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;
    protected $request;

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
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory;
        $this->request = $request;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Add country key for default billing/shipping blocks on customer addresses tab
     *
     * @return array
     */
    public function getData(): array
    {
        $collection = $this->collection->create();
        $data['items'] = [];
        if ($this->request->getParam('parent_id')) {
            $collection->addFieldToFilter('parent_id', $this->request->getParam('parent_id'));
            $data = $collection->toArray();
        }

        return $data;
    }
}

