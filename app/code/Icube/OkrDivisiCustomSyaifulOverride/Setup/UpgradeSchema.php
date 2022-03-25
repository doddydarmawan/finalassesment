<?php
namespace Icube\OkrDivisiCustomSyaifulOverride\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
	public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
		$installer = $setup;
		$installer->startSetup();

		if(version_compare($context->getVersion(), '1.0.2') < 0) {
			$installer->getConnection()->addColumn(
				$installer->getTable( 'icube_acara_syaiful' ),
				'tanggal',
				[
					'type' => Table::TYPE_DATE,
					'comment' => 'Date of Acara',
					'after' => 'pemateri'
				]
			);
		}

		$installer->endSetup();
	}
}