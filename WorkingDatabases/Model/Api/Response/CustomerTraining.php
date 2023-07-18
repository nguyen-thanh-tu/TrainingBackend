<?php

namespace TrainingBackend\WorkingDatabases\Model\Api\Response;

use Magento\Framework\DataObject;
use TrainingBackend\WorkingDatabases\Api\Response\CustomerTrainingInterface;

class CustomerTraining extends DataObject implements \TrainingBackend\WorkingDatabases\Api\Response\CustomerTrainingInterface
{
    public function getId()
    {
        return $this->_getData('id');
    }

    public function setId($id)
    {
        $this->setData('id', $id);
        return $this;
    }

    public function getSuccess()
    {
        return $this->_getData('success');
    }

    public function setSuccess($success)
    {
        $this->setData('success', $success);
        return $this;
    }

    public function getMess()
    {
        return $this->_getData('mess');
    }

    public function setMess($mess)
    {
        $this->setData('mess', $mess);
        return $this;
    }

    public function getFristName()
    {
        return $this->_getData('frist_name');
    }

    public function setFristName($fristName)
    {
        $this->setData('frist_name', $fristName);
        return $this;
    }

    public function getLastName()
    {
        return $this->_getData('last_name');
    }

    public function setLastName($lastName)
    {
        $this->setData('last_name', $lastName);
        return $this;
    }

    public function getAddress()
    {
        return $this->_getData('address');
    }

    public function setAddress($address)
    {
        $this->setData('address', $address);
        return $this;
    }

    public function getCity()
    {
        return $this->_getData('city');
    }

    public function setCity($city)
    {
        $this->setData('city', $city);
        return $this;
    }

    public function getAge()
    {
        return $this->_getData('age');
    }

    public function setAge($age)
    {
        $this->setData('age', $age);
        return $this;
    }
}
