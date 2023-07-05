<?php

namespace TrainingBackend\ArchitectureAndCustomization\Model\ResourceModel\CustomerDirectory;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use TrainingBackend\ArchitectureAndCustomization\Model\CustomerDirectory as Model;
use TrainingBackend\ArchitectureAndCustomization\Model\ResourceModel\CustomerDirectory as ResourceModel;

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
