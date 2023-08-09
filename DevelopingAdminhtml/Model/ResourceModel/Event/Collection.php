<?php

namespace TrainingBackend\DevelopingAdminhtml\Model\ResourceModel\Event;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use TrainingBackend\DevelopingAdminhtml\Model\Event as Model;
use TrainingBackend\DevelopingAdminhtml\Model\ResourceModel\Event as ResourceModel;

class Collection extends AbstractCollection
{
    /** @var string */
    protected $_idFieldName = 'event_id';

    /**
     * Init collection
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
