<?php

namespace TrainingBackend\DevelopingAdminhtml\Model;

use Magento\AsynchronousOperations\Api\Data\OperationInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Serialize\SerializerInterface;

class MassRegistrationConsumer
{
    protected $serializer;
    protected $customerRepository;

    public function __construct
    (
        SerializerInterface $serializer,
        CustomerRepositoryInterface $customerRepository
    )
    {
        $this->serializer = $serializer;
        $this->customerRepository = $customerRepository;
    }

    public function process(OperationInterface $operation)
    {
        $serializedData = $operation->getSerializedData();
        $data = $this->serializer->unserialize($serializedData);

        // Verify customer exists
        $customer = $this->customerRepository->getById($data['user_id']);
        $customer->setCustomAttribute('sechedule_id', $data['sechedule_id'])
            ->setCustomAttribute('note', $data['note']);
        // No need to validate customer and customer address during assigning customer to the group
        $this->customerRepository->save($customer);
    }
}
