<?php

namespace TrainingBackend\WorkingDatabases\Setup\Patch\Data;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;
use Magento\Framework\DB\Ddl\Table;

class CustomerTraining implements DataPatchInterface
{
    private $moduleDataSetup;
    private $connection;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ResourceConnection       $resource
    )
    {
        $this->connection = $resource->getConnection('well_trained');
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $table = $this->connection->newTable('customer_training')
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'ID'
            )
            ->addColumn(
                'frist_name',
                Table::TYPE_TEXT,
                15,
                ['nullable' => true],
                'Frist Name'
            )->addColumn(
                'last_name',
                Table::TYPE_TEXT,
                15,
                ['nullable' => true],
                'Last Name'
            )->addColumn(
                'address',
                Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Frist Name'
            )->addColumn(
                'city',
                Table::TYPE_TEXT,
                15,
                ['nullable' => true],
                'City'
            )->addColumn(
                'age',
                Table::TYPE_TEXT,
                15,
                ['nullable' => true],
                'Age'
            )
            ->setComment('Customer Training')
            ->setOption('type', 'InnoDB')
            ->setOption('charset', 'utf8');
        $this->connection->createTable($table);
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
