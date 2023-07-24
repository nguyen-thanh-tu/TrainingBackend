<?php

namespace TrainingBackend\EAV\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class ProductMerchant implements DataPatchInterface
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

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'merchant_name',
            [
                'type' => 'varchar',
                'label' => 'Merchant Name',
                'input' => 'hidden',
                'sort_order' => 4,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'required' => false,
                'visible' => false,
                'searchable' => true,
                'is_html_allowed_on_front' => true,
                'visible_in_advanced_search' => true,
                'used_in_product_listing' => true,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_filterable_in_grid' => true,
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'merchant_id',
            [
                'type' => 'int',
                'label' => 'Merchant',
                'input' => 'select',
                'required' => false,
                'source' => \TrainingBackend\EAV\Model\Config\Source\MerchantOptions::class,
                'sort_order' => 9,
                'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
                'searchable' => false,
                'used_in_product_listing' => true,
            ]
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
