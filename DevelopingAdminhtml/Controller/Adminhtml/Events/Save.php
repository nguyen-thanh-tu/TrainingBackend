<?php

namespace TrainingBackend\DevelopingAdminhtml\Controller\Adminhtml\Events;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResourceConnection;
use TrainingBackend\DevelopingAdminhtml\Model\EventFactory;

class Save extends Action
{
    /**
     * @var EventFactory
     */
    protected $eventFactory;

    protected $resource;

    /**
     * Save constructor.
     *
     * @param Context $context
     * @param EventFactory $eventFactory
     */
    public function __construct(
        Context $context,
        EventFactory $eventFactory,
        ResourceConnection $resource
    ) {
        parent::__construct($context);
        $this->eventFactory = $eventFactory;
        $this->resource = $resource;
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        if (!$data) {
            return $this->_redirect('customer/index/index');
        }

        try {
            if(count($data) < 2){
                return $this->_redirect('deveadmin/events/addandedit');
            }
            if(empty($data['event_id'])){
                $data['event_id'] = null;
            }
            // Process your data and save to database using eventFactory

            $eventIds = explode(',', $data['event_ids']);
            $schedules = [];
            foreach($eventIds as $eventId) {
                $endDate = $data['end_date_'.$eventId];
                $daysDeforeEvent = $data['days_before_event_'.$eventId];
                $dataSave = [
                    'event_id' => $data['event_id_'.$eventId],
                    'event_name' => $data['event_name_'.$eventId],
                    'days_before_event' => $data['days_before_event_'.$eventId],
                    'end_date' => $endDate,
                    'sort_order' => $data['sort_order_'.$eventId],
                ];
                $merchantModel = $this->eventFactory->create();
                // Set data to model
                $merchantModel->setData($dataSave);
                // Save data to database
                $merchantModel->save();
                for($i = 1; $i <= $daysDeforeEvent; $i++) {
                    $date = date('y/m/d', strtotime($endDate . '-'. $i .' day'));
                    $schedules[] = [
                        'event_id' => $eventId,
                        'day' => date('l', strtotime($endDate . '-'. $i .' day')),
                        'date' => $date,
                        'details_message' => 'Details Message',
                        'event_time' => ''
                    ];
                }
            }

            if(empty($data['event_id_']) && !empty($data['event_name_']) && !empty($data['days_before_event_']) && !empty($data['end_date_'])){
                $newData = [
                    'event_id' => null,
                    'event_name' => $data['event_name_'],
                    'days_before_event_' => $data['days_before_event_'],
                    'end_date' => $data['end_date_'],
                    'sort_order' => $data['sort_order_'],
                ];
                $merchantModel = $this->eventFactory->create();
                // Set data to model
                $merchantModel->setData($newData);
                // Save data to database
                $merchantModel->save();
            }

            $this->resource->getConnection()->insertMultiple
            (
                'trainingbackend_developingadminhtml_schedule',
                $schedules
            );

            // Display success message
            $this->messageManager->addSuccessMessage(__('Event has been saved successfully.'));
        } catch (\Exception $e) {
            // Display error message
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        if (isset($data['back']) && $data['back'] == 'edit') {
            return $this->_redirect('deveadmin/events/addandedit');
        }

        // Redirect back to grid
        return $this->_redirect('customer/index/index');
    }
}
