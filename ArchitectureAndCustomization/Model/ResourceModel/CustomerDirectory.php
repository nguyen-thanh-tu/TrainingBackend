<?php

namespace TrainingBackend\ArchitectureAndCustomization\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CustomerDirectory extends AbstractDb
{
    /**
     * Init table
     */
    protected function _construct()
    {
        $this->_init('customer_directory', 'id');
    }
}
