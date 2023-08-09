<?php

namespace TrainingBackend\DevelopingAdminhtml\Model;

use Magento\Framework\Model\AbstractModel;

class Event extends AbstractModel
{
    protected $_idFieldName = 'event_id';

    protected $_eventPrefix = 'trainingbackend_developingadminhtml_event';

    protected function _construct()
    {
        $this->_init('TrainingBackend\DevelopingAdminhtml\Model\ResourceModel\Event');
    }
}
