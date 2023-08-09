<?php

namespace TrainingBackend\DevelopingAdminhtml\Model;

use Magento\Framework\Bulk\OperationInterface;
use Magento\AsynchronousOperations\Api\Data\OperationInterfaceFactory;
use Magento\Framework\DataObject\IdentityGeneratorInterface;
use Magento\Framework\MessageQueue\PublisherInterface;
use Magento\Framework\Serialize\SerializerInterface;

class MassRegistrationProducer
{
    private $publisher;
    private $operationFactory;
    private $serializer;
    private $identityService;

    public function __construct
    (
        PublisherInterface $publisher,
        OperationInterfaceFactory $operationFactory,
        SerializerInterface $serializer,
        IdentityGeneratorInterface $identityService
    )
    {
        $this->publisher = $publisher;
        $this->operationFactory = $operationFactory;
        $this->serializer = $serializer;
        $this->identityService = $identityService;
    }

    public function sendMassRegistrationMessage($userId, $secheduleId, $note)
    {
        $data = [
            'user_id' => $userId,
            'sechedule_id' => $secheduleId,
            'note' => $note
        ];

        $data = [
            'data' => [
                'bulk_uuid' => $this->identityService->generateId(),
                'topic_name' => 'schedule.assign',
                'serialized_data' => $this->serializer->serialize($data),
                'status' => OperationInterface::STATUS_TYPE_OPEN,
            ]
        ];
        $operation = $this->operationFactory->create($data);
        $this->publisher->publish('schedule.assign', $operation);
    }
}

