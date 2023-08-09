<?php

namespace TrainingBackend\DevelopingAdminhtml\Block\Adminhtml\Event\Edit;

use TrainingBackend\DevelopingAdminhtml\Model\ResourceModel\Event\CollectionFactory as EventCollection;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    public function __construct
    (
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Backend\Model\Auth\Session $authSession,
        EventCollection $eventCollection,
        array $data = []
    )
    {
        $this->eventCollection = $eventCollection;
        parent::__construct($context, $jsonEncoder, $authSession, $data);
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
     * @return \Magento\Backend\Block\Widget\Tabs|Tabs
     */
    protected function _beforeToHtml()
    {
        $eventCollection = $this->eventCollection->create();

        foreacH ($eventCollection as $event) {
            $this->addTab(
                'main_section_'.$event->getEventId(),
                [
                    'label' => $event->getEventName(),
                    'title' => $event->getEventName(),
                    'content' => $this->getLayout()
                        ->createBlock(TabMain::class)
                        ->setData('event_id', $event->getEventId())
                        ->setData('event_ids', implode(',', $eventCollection->getAllIds()))
                        ->toHtml(),
                    'active' => true
                ]
            );
        }

        $this->addTab(
            'main_section',
            [
                'label' => __('Add New Envent'),
                'title' => $event->getEventName(),
                'content' => $this->getLayout()
                    ->createBlock(TabMain::class)
                    ->setData('event_ids', implode(',', $eventCollection->getAllIds()))
                    ->toHtml(),
                'active' => true
            ]
        );

        return parent::_beforeToHtml();
    }
}
