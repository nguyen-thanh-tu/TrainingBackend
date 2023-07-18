<?php

namespace TrainingBackend\WorkingDatabases\Model\ResourceModel\CustomerTraining;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use TrainingBackend\WorkingDatabases\Model\CustomerTraining as Model;
use TrainingBackend\WorkingDatabases\Model\ResourceModel\CustomerTraining as ResourceModel;

/**
 * Class Collection
 * Magenest\NotificationBox\Model\ResourceModel\Notification
 */
class Collection extends AbstractCollection
{
    /** @var string */
    protected $_idFieldName = 'id';

    /**
     * Init collection
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
