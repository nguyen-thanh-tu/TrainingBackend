<?php

namespace TrainingBackend\WorkingDatabases\Model\Api;

use TrainingBackend\WorkingDatabases\Api\CustomerTrainingApiInterface;
use TrainingBackend\WorkingDatabases\Api\Response\CustomerTrainingInterface;
use Magento\Framework\Webapi\Exception as WebapiException;
use TrainingBackend\WorkingDatabases\Model\CustomerTrainingFactory;
use TrainingBackend\WorkingDatabases\Model\ResourceModel\CustomerTraining\CollectionFactory as CustomerTrainingCollection;
use TrainingBackend\WorkingDatabases\Model\ResourceModel\CustomerTraining as CustomerTrainingResourceModel;

class CustomerTrainingApi implements CustomerTrainingApiInterface
{
    protected $customerTrainingResponse;
    protected $customerTrainingFactory;
    protected $customerTrainingCollection;
    protected $customerTrainingResourceModel;

    public function __construct
    (
        CustomerTrainingInterface  $customerTrainingResponse,
        CustomerTrainingFactory    $customerTrainingFactory,
        CustomerTrainingCollection $customerTrainingCollection,
        CustomerTrainingResourceModel $customerTrainingResourceModel
    )
    {
        $this->customerTrainingResponse = $customerTrainingResponse;
        $this->customerTrainingFactory = $customerTrainingFactory;
        $this->customerTrainingCollection = $customerTrainingCollection;
        $this->customerTrainingResourceModel = $customerTrainingResourceModel;
    }

    public function create($fristName, $lastName, $address, $city, $age, $storeCode = 'default')
    {
        return $this->update(null, $fristName, $lastName, $address, $city, $age, $storeCode);
    }

    public function get($storeCode = 'default')
    {
        try {
            $collection = $this->customerTrainingCollection->create();
            $items = [];

            foreach ($collection as $ustomerTraining) {
                $item = $this->customerTrainingFactory->create();
                $item->setData(
                    [
                        'id' => $ustomerTraining->getId(),
                        'success' => true,
                        'mess' => __("Get success", ['store' => $storeCode]),
                        'frist_name' => $ustomerTraining->getFristName(),
                        'last_name' => $ustomerTraining->getLastName(),
                        'address' => $ustomerTraining->getAddress(),
                        'city' => $ustomerTraining->getCity(),
                        'age' => $ustomerTraining->getAge()
                    ]
                );
                $items[] = $item;
            }
            return $items;
        } catch (WebapiException $exception) {
            throw new WebapiException(__($exception->getMessage()));
        }
    }

    public function update($id, $fristName, $lastName, $address, $city, $age, $storeCode = 'default')
    {
        try {
            $customerTraining = $this->customerTrainingFactory->create();
            $customerTraining->setData(
                [
                    'id' => $id,
                    'frist_name' => $fristName,
                    'last_name' => $lastName,
                    'address' => $address,
                    'city' => $city,
                    'age' => $age
                ]
            );
            $customerTraining->save();
            $response = $this->customerTrainingFactory->create();
            return $response->setData(
                [
                    'success' => true,
                    'mess' => __("Update success", ['store' => $storeCode]),
                    'frist_name' => $fristName,
                    'last_name' => $lastName,
                    'address' => $address,
                    'city' => $city,
                    'age' => $age
                ]
            );
        } catch (WebapiException $exception) {
            throw new WebapiException(__($exception->getMessage()));
        }
    }

    public function delete(int $id, $storeCode = 'default')
    {
        try {
            $customerTraining = $this->customerTrainingFactory->create();
            $customerTraining->load($id);
            $customerTraining->delete();
            $response = $this->customerTrainingFactory->create();
            return $response->setData(
                [
                    'success' => true,
                    'mess' => __("Update success", ['store' => $storeCode])
                ]
            );
        } catch (WebapiException $exception) {
            throw new WebapiException(__($exception->getMessage()));
        }
    }
}
