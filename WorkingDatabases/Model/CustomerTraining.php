<?php

namespace TrainingBackend\WorkingDatabases\Model;

use Magento\Framework\Model\AbstractModel;

class CustomerTraining extends AbstractModel
{
    /**
     * @inheritdoc
     */
    public function _construct()
    {
        $this->_init(\TrainingBackend\WorkingDatabases\Model\ResourceModel\CustomerTraining::class);
    }
}
