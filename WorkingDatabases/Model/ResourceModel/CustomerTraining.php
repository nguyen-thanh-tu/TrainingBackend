<?php

namespace TrainingBackend\WorkingDatabases\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CustomerTraining extends AbstractDb
{
    /**
     * Init table
     */
    protected function _construct()
    {
        $this->_setResource('well_trained');
        $this->_init('customer_training', 'id');
    }
}
