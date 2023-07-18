<?php

namespace TrainingBackend\WorkingDatabases\Api\Response;

interface CustomerTrainingInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return bool|null
     */
    public function getSuccess();

    /**
     * @param bool $success
     * @return $this
     */
    public function setSuccess($success);

    /**
     * @return string|null
     */
    public function getMess();

    /**
     * @param string $mess
     * @return $this
     */
    public function setMess($mess);

    /**
     * @return string|null
     */
    public function getFristName();

    /**
     * @param string $fristName
     * @return $this
     */
    public function setFristName($fristName);

    /**
     * @return string|null
     */
    public function getLastName();

    /**
     * @param string $lastName
     * @return $this
     */
    public function setLastName($lastName);

    /**
     * @return string|null
     */
    public function getAddress();

    /**
     * @param string $address
     * @return $this
     */
    public function setAddress($address);

    /**
     * @return string|null
     */
    public function getCity();

    /**
     * @param string $city
     * @return $this
     */
    public function setCity($city);

    /**
     * @return string|null
     */
    public function getAge();

    /**
     * @param string $age
     * @return $this
     */
    public function setAge($age);
}
