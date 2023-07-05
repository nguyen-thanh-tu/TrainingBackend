<?php

namespace TrainingBackend\ArchitectureAndCustomization\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\App\ResourceConnection;

class CustomerDirectoryData implements DataPatchInterface
{
    private $moduleDataSetup;
    private $connection;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ResourceConnection       $resource
    )
    {
        $this->connection = $resource->getConnection();
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $this->connection->insertMultiple
        ('customer_directory',
            [
                [
                    'customer_directory' => 'Business Name',
                    'fe_description' => 'Manual Input',
                    'consumer' => true,
                    'business' => false,
                    'be_description' => ''
                ],
                [
                    'customer_directory' => 'Description',
                    'fe_description' => 'Manual Input',
                    'consumer' => true,
                    'business' => false,
                    'be_description' => ''
                ],
                [
                    'customer_directory' => 'Business Address',
                    'fe_description' => 'Manual Input. Map to District | Meighbourhood',
                    'consumer' => true,
                    'business' => false,
                    'be_description' => 'Google Business & Reservc with Google'
                ],
                [
                    'customer_directory' => 'Website',
                    'fe_description' => 'Manual Input',
                    'consumer' => true,
                    'business' => false,
                    'be_description' => ''
                ],
                [
                    'customer_directory' => 'Email',
                    'fe_description' => 'Manual Input',
                    'consumer' => true,
                    'business' => false,
                    'be_description' => ''
                ],
                [
                    'customer_directory' => 'Telepone Number',
                    'fe_description' => 'Manual Input',
                    'consumer' => true,
                    'business' => false,
                    'be_description' => 'WhatsApp Only'
                ],
                [
                    'customer_directory' => 'Mobile Number',
                    'fe_description' => 'Manual Input',
                    'consumer' => true,
                    'business' => false,
                    'be_description' => ''
                ],
                [
                    'customer_directory' => 'Primary Category',
                    'fe_description' => 'Master - Selection',
                    'consumer' => true,
                    'business' => false,
                    'be_description' => 'Admin - Master'
                ],
                [
                    'customer_directory' => 'Secondary Category',
                    'fe_description' => 'Master - Selection',
                    'consumer' => true,
                    'business' => false,
                    'be_description' => 'Admin - Master'
                ]
            ]
        );
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}
