<?php

namespace TrainingBackend\EAV\Block\Adminhtml\Merchant;

use Magento\Backend\Block\Widget\Grid\Container;

class GridContainer extends Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'TrainingBackend_EAV';
        $this->_controller = 'adminhtml_merchant';
        $this->_headerText = __('Merchant Management');
        $this->_addButtonLabel = __('New');
        parent::_construct();
    }

    /**
     * Create "New" button
     *
     * @return void
     */
    protected function _addNewButton()
    {
        $this->addButton(
            'add',
            [
                'label' => $this->getAddButtonLabel(),
                'onclick' => 'setLocation(\'' . $this->getCreateUrl() . '\')',
                'class' => 'add primary'
            ]
        );
    }

    /**
     * @return string
     */
    public function getCreateUrl()
    {
        return $this->getUrl('trainingbackend_eav/merchant/form');
    }
}
