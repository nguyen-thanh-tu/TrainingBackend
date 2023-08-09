<?php

namespace TrainingBackend\DevelopingAdminhtml\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Event extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('trainingbackend_developingadminhtml_event', 'event_id');
    }
}
