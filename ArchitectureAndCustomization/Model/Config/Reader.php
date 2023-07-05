<?php

namespace TrainingBackend\ArchitectureAndCustomization\Model\Config;

use Magento\Framework\Config\Reader\Filesystem;

class Reader extends Filesystem
{
    /**
     * List of id attributes for merge
     *
     * @var array
     */
    protected $_idAttributes = ['/config/acl/resources(/resource)+' => 'id'];
}
