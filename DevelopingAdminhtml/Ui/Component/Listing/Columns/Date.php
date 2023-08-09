<?php

namespace TrainingBackend\DevelopingAdminhtml\Ui\Component\Listing\Columns;

class Date extends \Magento\Ui\Component\Listing\Columns\Date
{
    /**
     * @inheritdoc
     * @since 101.1.1
     */
    public function prepare()
    {
        $config = $this->getData('config');

        $config['editor']['options'] = ["showsTime" => true];

        $this->setData('config', $config);

        parent::prepare();
    }
}
