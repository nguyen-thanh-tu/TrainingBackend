<?php

namespace TrainingBackend\DevelopingAdminhtml\Block\Adminhtml\Mass;

class Schedule extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('page_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('All Schedule'));
    }

    /**
     * @return Schedule
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'main_section',
            [
                'label' => __('Ássign Schedule'),
                'title' => __('Ássign Schedule'),
                'content' => $this->getLayout()
                    ->createBlock(TabMain::class)
                    ->toHtml(),
                'active' => true
            ]
        );

        return parent::_beforeToHtml();
    }
}
