<?php

namespace TrainingBackend\EAV\Model\ResourceModel;

use Magento\Eav\Model\Entity\AbstractEntity;
use Magento\Eav\Model\Entity\Context;
use Magento\Framework\DataObject;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use TrainingBackend\EAV\Setup\Patch\Data\MerchantSetup;
use TrainingBackend\EAV\Model\Merchant as ModelMerchant;

class Merchant extends AbstractEntity
{
    protected $_storeId = null;
    protected $entityManager;
    protected $_storeManager;

    public function __construct(
        Context               $context,
        StoreManagerInterface $storeManager,
        array                 $data = []
    )
    {
        parent::__construct($context, $data);
        $this->setType(ModelMerchant::ENTITY_TYPE_CODE);
        $this->_storeManager = $storeManager;
    }

    protected function _beforeSave(\Magento\Framework\DataObject $object)
    {
        $object->setAttributeSetId($object->getAttributeSetId() ?: $this->getEntityType()->getDefaultAttributeSetId());
        $object->setEntityTypeId($object->getEntityTypeId() ?: $this->getEntityType()->getEntityTypeId());
        return parent::_beforeSave($object);
    }

    public function getEntityType()
    {
        if (empty($this->_type)) {
            $this->setType(ModelMerchant::ENTITY_TYPE_CODE);
        }
        return parent::getEntityType();
    }

    protected function _getDefaultAttributes()
    {
        return [
            'attribute_set_id',
            'entity_type_id',
            'created_at',
            'updated_at',
        ];
    }

    public function setStoreId($storeId)
    {
        $this->_storeId = $storeId;
        return $this;
    }

    public function getStoreId()
    {
        if ($this->_storeId === null) {
            return $this->_storeManager->getStore()->getId();
        }
        return $this->_storeId;
    }

    protected function _saveAttribute($object, $attribute, $value)
    {
        $table = $attribute->getBackend()->getTable();
        if (!isset($this->_attributeValuesToSave[$table])) {
            $this->_attributeValuesToSave[$table] = [];
        }
        $entityIdField = $attribute->getBackend()->getEntityIdField();
        $storeId = $object->getStoreId() ?: Store::DEFAULT_STORE_ID;
        $data = [
            $entityIdField => $object->getId(),
            'entity_type_id' => $object->getEntityTypeId(),
            'attribute_id' => $attribute->getId(),
            'value' => $this->_prepareValueForSave($value, $attribute),
            'store_id' => $storeId,
        ];
        if (!$this->getEntityTable() || $this->getEntityTable() == \Magento\Eav\Model\Entity::DEFAULT_ENTITY_TABLE) {
            $data['entity_type_id'] = $object->getEntityTypeId();
        }
        if ($attribute->isScopeStore()) {
            $this->_attributeValuesToSave[$table][] = $data;
        } elseif ($attribute->isScopeWebsite() && $storeId != Store::DEFAULT_STORE_ID) {
            $storeIds = $this->_storeManager->getStore($storeId)->getWebsite()->getStoreIds(true);
            foreach ($storeIds as $storeId) {
                $data['store_id'] = (int)$storeId;
                $this->_attributeValuesToSave[$table][] = $data;
            }
        } else {
            $data['store_id'] = Store::DEFAULT_STORE_ID;
            $this->_attributeValuesToSave[$table][] = $data;
        }
        return $this;
    }
}
