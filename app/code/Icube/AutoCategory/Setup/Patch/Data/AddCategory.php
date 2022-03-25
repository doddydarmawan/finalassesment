<?php

namespace Icube\AutoCategory\Setup\Patch\Data;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\Data\CategoryInterfaceFactory;
use Magento\Catalog\Setup\Patch\Data\InstallDefaultCategories;
use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;

class AddCategory implements DataPatchInterface
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepositoryInterface;

    /** 
     * @var CategoryInterfaceFactory 
     */
    private $categoryInterfaceFactory;

    /**
     * @var WriterInterface
     */
    private $configWriter;

    /**
     * Constructor
     *
     * @param CategoryRepositoryInterface $categoryRepositoryInterface
     * @param CategoryInterfaceFactory $categoryInterfaceFactory
     * @param WriterInterface $writerInterface
     */
    public function __construct(
        CategoryRepositoryInterface $categoryRepositoryInterface,
        CategoryInterfaceFactory $categoryInterfaceFactory,
        WriterInterface $writerInterface
    ) {
        $this->categoryRepositoryInterface = $categoryRepositoryInterface;
        $this->categoryInterfaceFactory = $categoryInterfaceFactory;
        $this->configWriter = $writerInterface;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $categoriesName = [
            'new_arrivals' => 'New Arrivals',
            'sale' => 'Sale'
        ];

        foreach ($categoriesName as $key => $value) {
            // Save category
            $category = $this->categoryInterfaceFactory->create();
            $category->getParentId();
            $category->setName($value);
            $category->setParentId(2);
            $category->setIsActive(1);
            $category->setData('stores', [0]);
            $this->categoryRepositoryInterface->save($category);

            $this->configWriter->save(
                'autocategory/category/' . $key,
                $category->getId()
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [
            \Magento\Catalog\Setup\Patch\Data\InstallDefaultCategories::class
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
