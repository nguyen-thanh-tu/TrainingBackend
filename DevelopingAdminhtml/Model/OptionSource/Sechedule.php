<?php

namespace TrainingBackend\DevelopingAdminhtml\Model\OptionSource;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Data\OptionSourceInterface;

class Sechedule implements OptionSourceInterface
{
    protected $instanceCollectionFactory;
    protected $request;
    /**
     * ProductWidget constructor.
     *
     * @param \Magento\Widget\Model\ResourceModel\Widget\Instance\CollectionFactory $collectionFactory
     */
    public function __construct(
        \TrainingBackend\DevelopingAdminhtml\Model\ResourceModel\Schedule\CollectionFactory $collectionFactory,
        RequestInterface $request
    ) {
        $this->instanceCollectionFactory = $collectionFactory;
        $this->request = $request;
    }

    public function toOptionArray()
    {
        $allOptions = $this->getAllOptions();
        $result = [['value' => '', 'label' => __('-- Please Select --')]];
        foreach ($allOptions as $label => $value) {
            $result[] = [
                'value' => $value,
                'label' => (string)$label
            ];
        }

        return $result;
    }

    public function getAllOptions()
    {
        $eventId = (int)$this->request->getParam('event_id');

        $options = [];
        $count = 1;
        $events = $this->instanceCollectionFactory->create();
        $events->addFieldToFilter('event_id', $eventId);
        foreach ($events as $event) {
            $title = $event->getDay().' '.$event->getDate();
            if (isset($options[$title])) {
                $options[$title . ' (' . $count . ')'] = $event->getScheduleId();
                $count++;
            } else {
                $options[$title] = $event->getScheduleId();
            }
        }

        return $options;
    }
}
