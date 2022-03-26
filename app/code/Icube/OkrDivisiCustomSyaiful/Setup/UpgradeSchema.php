<?php

namespace Icube\OkrDivisiCustomSyaiful\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\Backend\Media;
use Magento\Catalog\Model\Product\Attribute\Backend\Media\ImageEntryConverter;
use Magento\Framework\DB\Ddl\Table;

/**
 * Upgrade the Catalog module DB scheme
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.1') < 0) {
            $table = $setup->getConnection()
                ->newTable($setup->getTable('icube_acara_syaiful'))
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['primary' => true, 'identity' => true, 'nullable' => false],
                    'Smallint'
                )->addColumn(
                    'nama',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Nama acara'
                )->addColumn(
                    'pemateri',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    50,
                    [],
                    'pemateri acara'
                )->setComment("Icube Acara");
            $setup->getConnection()->createTable($table);

            $table = $setup->getConnection()
                ->newTable($setup->getTable('icube_peserta_syaiful'))
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['primary' => true, 'identity' => true, 'nullable' => false],
                    'Smallint'
                )->addColumn(
                    'nama',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Nama peserta'
                )->addColumn(
                    'acara_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false, 'primary' => true],
                    'pemateri peserta'
                )->addForeignKey(
                    $setup->getFkName('icube_peserta_syaiful', 'acara_id', 'icube_acara_syaiful', 'entity_id'),
                    'acara_id',
                    $setup->getTable('icube_acara_syaiful'),
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )->setComment("Icube peserta");
            $setup->getConnection()->createTable($table);
        }

        $setup->endSetup();
    }
}
