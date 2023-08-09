<?php

namespace TrainingBackend\DevelopingAdminhtml\Block\Adminhtml\Event\Edit;

use Magento\Framework\Locale\OptionInterface;

class TabMain extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var \TrainingBackend\DevelopingAdminhtml\Model\EventFactory
     */
    protected $event;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Framework\Locale\ListsInterface $localeLists
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \TrainingBackend\DevelopingAdminhtml\Model\EventFactory $event,
        array $data = []
    ) {
        $this->event = $event;
        parent::__construct($context, $registry, $formFactory, $data);
    }

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
        $this->setTitle(__('All Events'));
    }

    /**
     * Prepare form fields
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @return \Magento\Backend\Block\Widget\Form
     */
    protected function _prepareForm()
    {
        $eventId = $this->getData('event_id');

        $required = false;
        if($eventId){
            $required = true;
        }

        $event = $this->event->create();
        $event->load($eventId);
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('event_'.$eventId.'_');

        $baseFieldset = $form->addFieldset('base_fieldset_'.$eventId, ['legend' => __('Event Details')]);

        $baseFieldset->addField(
            'event_ids',
            'hidden',
            [
                'name' => 'event_ids',
                'id' => 'event_ids'
            ]
        );

        $baseFieldset->addField(
            'event_id',
            'hidden',
            [
                'name' => 'event_id_'.$eventId,
                'id' => 'event_id_'.$eventId,
                'class' => 'event_id'
            ]
        );

        $baseFieldset->addField(
            'event_name',
            'text',
            [
                'name' => 'event_name_'.$eventId,
                'label' => __('Event Name'),
                'id' => 'event_name_'.$eventId,
                'title' => __('Event Name'),
                'required' => $required
            ]
        );

        $baseFieldset->addField(
            'days_before_event',
            'text',
            [
                'name' => 'days_before_event_'.$eventId,
                'label' => __('Days Before Event'),
                'id' => 'days_before_event_'.$eventId,
                'title' => __('Days Before Event'),
                'required' => $required
            ]
        );

        $baseFieldset->addField(
            'end_date',
            'date',
            [
                'name' => 'end_date_'.$eventId,
                'label' => __('End Date'),
                'id' => 'end_date_'.$eventId,
                'title' => __('End Date'),
                'format' => 'Y-mm-dd',
                'date_format' => 'yyyy-MM-dd',
                'input_format' => 'Y-mm-dd',
                'required' => $required
            ]
        );

        $baseFieldset->addField(
            'sort_order',
            'text',
            [
                'name' => 'sort_order_'.$eventId,
                'label' => __('Sort Order'),
                'id' => 'sort_order_'.$eventId,
                'title' => __('Sort Order')
            ]
        );

        $form->addFieldset(
            'default_schedule',
            ['legend' => __('Default Schedule')]
        );

        $data = $event->getData();
        $data['event_ids'] = $this->getData('event_ids');
        $form->setValues($data);

        $this->setForm($form);

        return parent::_prepareForm();
    }
}
