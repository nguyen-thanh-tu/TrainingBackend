<?php

namespace TrainingBackend\ArchitectureAndCustomization\Model;

use Magento\Framework\Model\AbstractModel;

class CustomerDirectory extends AbstractModel
{
    /**
     * @inheritdoc
     */
    public function _construct()
    {
        $this->_init(\TrainingBackend\ArchitectureAndCustomization\Model\ResourceModel\CustomerDirectory::class);
    }
}
