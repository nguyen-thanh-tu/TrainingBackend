<?php

namespace TrainingBackend\EAV\Block\Adminhtml\Merchant;

use Magento\Backend\Block\Widget\Grid\Extended;
use TrainingBackend\EAV\Model\ResourceModel\Merchant\CollectionFactory;

class Grid extends Extended
{
    protected $_merchantCollection;

    public function __construct
    (
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data            $backendHelper,
        CollectionFactory                       $merchantCollection,
        array                                   $data = []
    )
    {
        $this->_merchantCollection = $merchantCollection;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        $this->setId('index');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        parent::_construct();
    }

    protected function _prepareCollection()
    {
        $demo = $this->_merchantCollection->create()
            ->addFieldToSelect('*')
            ->addFieldToFilter('entity_id', ['neq' => '']);
        $this->setCollection($demo);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            [
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'name' => 'entity_id',
                'align' => 'center',
                'index' => 'id',
            ]
        );
        $this->addColumn(
            'entity_id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'entity_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'name',
            [
                'header' => __('Merchant Store Name'),
                'type' => 'text',
                'index' => 'name',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'created_at',
            [
                'header' => __('Active Date'),
                'index' => 'created_at',
                'type' => 'datetime',
            ]
        );
        $this->addColumn(
            'updated_at',
            [
                'header' => __('Latest Updated Date'),
                'index' => 'updated_at',
                'type' => 'datetime',
            ]
        );
        $this->addColumn(
            'merchant_status',
            [
                'header' => __('Status'),
                'type' => 'text',
                'index' => 'merchant_status',
                'filter' => \TrainingBackend\EAV\Block\Adminhtml\Merchant\SelectStatus::class,
                'renderer' => \TrainingBackend\EAV\Block\Adminhtml\Merchant\RendererStatus::class
            ]
        );
        $this->addColumn(
            'category',
            [
                'header' => __('Category'),
                'type' => 'text',
                'index' => 'category',
                'filter' => false,
                'sortable' => false,
                'renderer' => \TrainingBackend\EAV\Block\Adminhtml\Merchant\RendererCategory::class
            ]
        );
        $this->addColumn(
            'city',
            [
                'header' => __('City'),
                'type' => 'text',
                'index' => 'city',
                'header_css_class' => 'col-city',
                'column_css_class' => 'col-city',
            ]
        );
        $this->addColumn(
            'district',
            [
                'header' => __('District'),
                'type' => 'text',
                'index' => 'district',
                'header_css_class' => 'col-district',
                'column_css_class' => 'col-district',
            ]
        );
        $this->addColumn(
            'ward',
            [
                'header' => __('Ward'),
                'type' => 'text',
                'index' => 'ward',
                'header_css_class' => 'col-ward',
                'column_css_class' => 'col-ward',
            ]
        );
        $this->addColumn(
            'action',
            [
                'header' => __('Action'),
                'width' => '100px',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => ['base' => 'trainingbackend_eav/merchant/form'],
                        'field' => 'entity_id'   // pass id as parameter
                    ]
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'entity_id',
                'is_system' => true
            ]
        );
        return parent::_prepareColumns();
    }

    /**
     * Prepare grid mass actions
     *
     * @return void
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->setMassactionIdFilter('entity_id');
        $this->setMassactionIdFieldOnlyIndexValue(true);
        $this->getMassactionBlock()->setFormFieldName('entity_ids');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('trainingbackend_eav/merchant/massdelete'),
                'confirm' => __('Are you sure?')
            ]
        );
    }
}
