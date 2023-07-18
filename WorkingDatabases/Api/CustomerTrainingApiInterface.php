<?php

namespace TrainingBackend\WorkingDatabases\Api;

interface CustomerTrainingApiInterface
{
    /**
     * Save customer Token
     *
     * @param string $fristName
     * @param string $lastName
     * @param string $address
     * @param string $city
     * @param string $age
     * @param string $storeCode
     *
     * @return \TrainingBackend\WorkingDatabases\Api\Response\CustomerTrainingInterface
     */
    public function create($fristName, $lastName, $address, $city, $age, $storeCode = 'default');

    /**
     * Save customer Token
     * @param string $storeCode
     *
     * @return \TrainingBackend\WorkingDatabases\Api\Response\CustomerTrainingInterface[]
     */
    public function get($storeCode = 'default');

    /**
     * Save customer Token
     *
     * @param int|null $id
     * @param string $fristName
     * @param string $lastName
     * @param string $address
     * @param string $city
     * @param string $age
     * @param string $storeCode
     *
     * @return \TrainingBackend\WorkingDatabases\Api\Response\CustomerTrainingInterface
     */
    public function update($id, $fristName, $lastName, $address, $city, $age, $storeCode = 'default');


    /**
     * Save customer Token
     * @param int $id
     * @param string $storeCode
     *
     * @return \TrainingBackend\WorkingDatabases\Api\Response\CustomerTrainingInterface
     */
    public function delete(int $id, $storeCode = 'default');
}
