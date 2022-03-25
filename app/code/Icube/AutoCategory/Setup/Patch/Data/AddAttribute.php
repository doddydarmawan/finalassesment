<?php
namespace Icube\AutoCategory\Setup\Patch\Data;
 
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
 
class AddAttribute implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /** @var EavSetupFactory */
    private $eavSetupFactory;
 
    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->moduleDataSetup = $moduleDataSetup;
    }
    
    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
 
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'exclude_from_new',
            [
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Exclude From New',
                'input' => 'boolean',
                'class' => '',
                'source' => '',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => '0',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => false,
                'is_wysiwyg_enabled'      => false,
                'unique' => false,
                'apply_to' => ''
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'sale',
            [
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Sale',
                'input' => 'boolean',
                'class' => '',
                'source' => '',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => '0',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => false,
                'is_wysiwyg_enabled'      => false,
                'unique' => false,
                'apply_to' => ''
            ]
        );
        $this->moduleDataSetup->getConnection()->endSetup();
    }
 
    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [
            \Magento\Catalog\Setup\Patch\Data\UpgradeWebsiteAttributes::class
        ];
    }
 
    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}