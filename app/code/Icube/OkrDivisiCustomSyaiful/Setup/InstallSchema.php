<?php 

namespace Icube\OkrDivisiCustomSyaiful\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface 
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        
        try {
            $table = $setup->getConnection()->newTable(
                $setup->getTable('icube_acara_syaiful')
            )->addColumn(
                'acara_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsign' => true, 'nullable' => false, 'primary' => true],
                'Acara Id'
            )->addColumn(
                'nama',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Nama'
            )->addColumn(
                'pemateri',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                100,
                [],
                'Pemateri'
            );
            $setup->getConnection()->createTable($table);

            $table2 = $setup->getConnection()->newTable(
                $setup->getTable('icube_peserta_syaiful')
            )->addColumn(
                'peserta_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsign' => true, 'nullable' => false, 'primary' => true],
                'Peserta Id'
            )->addColumn(
                'acara_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                255,
                ['unsign' => true, 'nullable' => false, 'primary' => false],
                'Acara Id'
            )->addColumn(
                'nama',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                50,
                [],
                'Nama'
            );
            $setup->getConnection()->createTable($table2);
        } catch (Exception $e) {
            \Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info($err->getMessage());
        }

        $setup->endSetup();
    }
}