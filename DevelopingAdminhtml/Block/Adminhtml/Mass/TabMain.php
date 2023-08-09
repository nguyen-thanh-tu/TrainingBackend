<?php

namespace TrainingBackend\DevelopingAdminhtml\Block\Adminhtml\Mass;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Registry;

class TabMain extends \Magento\Backend\Block\Widget\Form\Generic
{
    protected $secheduleOption;
    protected $_coreRegistry;

    public function __construct
    (
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \TrainingBackend\DevelopingAdminhtml\Model\OptionSource\Sechedule $secheduleOption,
        Registry $coreRegistry,
        array $data = []
    )
    {
        $this->secheduleOption = $secheduleOption;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form fields
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @return \Magento\Backend\Block\Widget\Form
     */
    protected function _prepareForm()
    {
        $eventId = implode(',', $this->_coreRegistry->registry('customer_ids'));

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('event_'.$eventId.'_');

        $baseFieldset = $form->addFieldset('base_fieldset', ['legend' => __('Event Details')]);

        $baseFieldset->addField(
            'customer_ids',
            'hidden',
            [
                'name' => 'customer_ids',
                'id' => 'customer_ids'
            ]
        );

        $baseFieldset->addField(
            'sechedule_id',
            'select',
            [
                'name' => 'sechedule_id',
                'label' => __('Select Sechedule'),
                'title' => __('Select Sechedule'),
                'options' => array_flip($this->secheduleOption->getAllOptions()),
                'class' => 'select'
            ]
        );

        $baseFieldset->addField(
            'note',
            'textarea',
            [
                'name' => 'note',
                'label' => __('Note'),
                'id' => 'note',
                'title' => __('Note'),
            ]
        );

        $data = [];
        $data['customer_ids'] = $eventId;

        $form->setValues($data);

        $this->setForm($form);

        return parent::_prepareForm();
    }
}
