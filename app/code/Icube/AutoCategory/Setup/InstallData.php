<?php
namespace Icube\AutoCategory\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Api\CategoryRepositoryInterface;

class InstallData implements InstallDataInterface
{
	private $eavSetupFactory;
    private $category;

	public function __construct(EavSetupFactory $eavSetupFactory, Category $category, CategoryRepositoryInterface $categoryRepository)
	{
		$this->eavSetupFactory = $eavSetupFactory;
        $this->category = $category;
        $this->categoryRepository = $categoryRepository;
	}
	
	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
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
				'required' => true,
				'user_defined' => false,
				'default' => '',
				'searchable' => false,
				'filterable' => false,
				'comparable' => false,
				'visible_on_front' => false,
				'used_in_product_listing' => true,
				'unique' => false,
				'apply_to' => ''
			]
		)->addAttribute(
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
				'required' => true,
				'user_defined' => false,
				'default' => '',
				'searchable' => false,
				'filterable' => false,
				'comparable' => false,
				'visible_on_front' => false,
				'used_in_product_listing' => true,
				'unique' => false,
				'apply_to' => ''
			]
		);
        
        $category2 = $this->category;
        $category2->setName('NewArrival'); 
        $category2->setIsActive(true);
        $category2->setCustomAttributes([
          'description' => 'new arrival',
          'meta_title' => 'new arrival',
          'meta_keywords' => '',
          'meta_description' => '',
        ]);
        $this->categoryRepository->save($category2);

        $category = $this->category;
        $category->setName('Sale');
        $category->setIsActive(true);
        $category->setCustomAttributes([
          'description' => 'sale',
          'meta_title' => 'sale',
          'meta_keywords' => '',
          'meta_description' => '',
        ]);
        $this->categoryRepository->save($category);
	}
}