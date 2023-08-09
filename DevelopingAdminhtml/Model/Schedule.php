<?php

namespace TrainingBackend\DevelopingAdminhtml\Model;

use Magento\Framework\Model\AbstractModel;

class Schedule extends AbstractModel
{
    protected $_idFieldName = 'schedule_id';

    protected $_eventPrefix = 'trainingbackend_developingadminhtml_schedule';

    protected function _construct()
    {
        $this->_init('TrainingBackend\DevelopingAdminhtml\Model\ResourceModel\Schedule');
    }
}
