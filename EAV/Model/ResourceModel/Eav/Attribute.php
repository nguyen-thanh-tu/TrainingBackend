<?php

namespace TrainingBackend\EAV\Model\ResourceModel\Eav;

use TrainingBackend\EAV\Model\Merchant;
use Magento\Eav\Model\Entity\Attribute as EavAttribute;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class Attribute extends EavAttribute implements ScopedAttributeInterface
{
    const MODULE_NAME = 'MD_Merchant';
    const KEY_IS_GLOBAL = 'is_global';
    const KEY_IS_STATIC = 'static';
    protected $_eventObject = 'attribute';
    protected static $_labels = null;
    protected $_eventPrefix = Merchant::ENTITY_TYPE_CODE . '_attribute';

    protected function _construct()
    {
        $this->_init(\TrainingBackend\EAV\Model\ResourceModel\Attribute::class);
    }

    public function beforeSave()
    {
        $this->setData('modulePrefix', self::MODULE_NAME);
        if (isset($this->_origData[self::KEY_IS_GLOBAL])) {
            if (!isset($this->_data[self::KEY_IS_GLOBAL])) {
                $this->_data[self::KEY_IS_GLOBAL] = self::SCOPE_GLOBAL;
            }
        }
        return parent::beforeSave();

    }

    public function afterSave()
    {
        $this->_eavConfig->clear();
        return parent::afterSave();
    }

    public function getIsGlobal()
    {
        if ($this->getBackendType() === self::KEY_IS_STATIC) {
            return true;
        }
        return $this->_getData(self::KEY_IS_GLOBAL);
    }

    public function isScopeGlobal()
    {
        return $this->getIsGlobal() == self::SCOPE_GLOBAL;
    }

    public function isScopeWebsite()
    {
        return $this->getIsGlobal() == self::SCOPE_WEBSITE;
    }

    public function isScopeStore()
    {
        return !$this->isScopeGlobal() && !$this->isScopeWebsite();
    }

    public function getStoreId()
    {
        $dataObject = $this->getDataObject();
        if ($dataObject) {
            return $dataObject->getStoreId();
        }
        return $this->getData('store_id');
    }

    public function getSourceModel()
    {
        $model = $this->getData('source_model');
        if (empty($model)) {
            if ($this->getBackendType() == 'int' && $this->getFrontendInput() == 'select') {
                return $this->_getDefaultSourceModel();
            }
        }
        return $model;
    }

    public function _getDefaultSourceModel()
    {
        return 'Magento\Eav\Model\Entity\Attribute\Source\Table';
    }

    public function afterDelete()
    {
        $this->_eavConfig->clear();
        return parent::afterDelete();
    }
}
