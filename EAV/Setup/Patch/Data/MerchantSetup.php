<?php

namespace TrainingBackend\EAV\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Customer\Model\Customer;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use TrainingBackend\EAV\Model\Merchant;

class MerchantSetup implements DataPatchInterface
{
    private $eavSetupFactory;
    private $moduleDataSetup;

    public function __construct
    (
        EavSetupFactory $eavSetupFactory,
        ModuleDataSetupInterface $moduleDataSetup
    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        // Create EAV type
        $eavSetup->addEntityType(
            Merchant::ENTITY_TYPE_CODE,
            [
                'entity_model' => Customer::class,
                'attribute_model' => 'TrainingBackend\EAV\Model\ResourceModel\Eav\Attribute',
                'entity_table' => Merchant::ENTITY_TYPE_CODE.'_entity',
                'attribute_table' => Merchant::ENTITY_TYPE_CODE.'_entity_attribute',
                'entity_attribute_collection' => 'TrainingBackend\EAV\Model\ResourceModel\Attribute\Collection',
                'attribute_set_table' => Merchant::ENTITY_TYPE_CODE.'_entity_attribute_set',
                'eav_entity_type' => Merchant::ENTITY_TYPE_CODE,
                'increment_model' => 'Magento\Eav\Model\Entity\Increment\NumericValue',
                'increment_per_store' => '0',
                'additional_attribute_table' => Merchant::ENTITY_TYPE_CODE.'_eav_attribute',
                'entity_attribute_value_table' => Merchant::ENTITY_TYPE_CODE.'_entity_varchar',
                'is_system' => '0',
                'options' => [],
                'attribute_group_id' => '1',
                'attribute_group_name' => 'General',
                'attribute_group_sort_order' => '1',
                'sort_order' => '1',
            ]
        );

        // Add attributes
        $attributeSetId = $eavSetup->getDefaultAttributeSetId(Merchant::ENTITY_TYPE_CODE);
        $attributeGroupId = $eavSetup->getDefaultAttributeGroupId(Merchant::ENTITY_TYPE_CODE, $attributeSetId);

        // Category
        $eavSetup->addAttribute(
            Merchant::ENTITY_TYPE_CODE,
            'category',
            [
                'type' => 'text',
                'label' => 'Category',
                'input' => 'multiselect',
                'source' => 'TrainingBackend\EAV\Model\Config\Source\Category',
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'system' => false,
                'position' => 110,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'group' => 'General',
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
            ]
        );

        $eavSetup->addAttribute(
            Merchant::ENTITY_TYPE_CODE,
            'name',
            [
                'type' => 'varchar',
                'label' => 'Name',
                'input' => 'text',
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'system' => false,
                'position' => 150,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'group' => 'General',
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
            ]
        );

        // Merchant Status
        $eavSetup->addAttribute(
            Merchant::ENTITY_TYPE_CODE,
            'merchant_status',
            [
                'type' => 'int',
                'label' => 'Merchant Status',
                'input' => 'select',
                'source' => 'TrainingBackend\EAV\Model\Config\Source\MerchantStatus',
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'system' => false,
                'position' => 140,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'group' => 'General',
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
            ]
        );

        // City
        $eavSetup->addAttribute(
            Merchant::ENTITY_TYPE_CODE,
            'city',
            [
                'type' => 'varchar',
                'label' => 'City',
                'input' => 'text',
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'system' => false,
                'position' => 150,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'group' => 'General',
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
            ]
        );

        // District
        $eavSetup->addAttribute(
            Merchant::ENTITY_TYPE_CODE,
            'district',
            [
                'type' => 'varchar',
                'label' => 'District',
                'input' => 'text',
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'system' => false,
                'position' => 160,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'group' => 'General',
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
            ]
        );

        // Ward
        $eavSetup->addAttribute(
            Merchant::ENTITY_TYPE_CODE,
            'ward',
            [
                'type' => 'varchar',
                'label' => 'Ward',
                'input' => 'text',
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'system' => false,
                'position' => 170,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'group' => 'General',
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
            ]
        );
        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
