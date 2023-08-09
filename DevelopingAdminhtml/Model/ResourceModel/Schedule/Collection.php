<?php

namespace TrainingBackend\DevelopingAdminhtml\Model\ResourceModel\Schedule;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use TrainingBackend\DevelopingAdminhtml\Model\Schedule as Model;
use TrainingBackend\DevelopingAdminhtml\Model\ResourceModel\Schedule as ResourceModel;

class Collection extends AbstractCollection
{
    /** @var string */
    protected $_idFieldName = 'schedule_id';

    /**
     * Init collection
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
