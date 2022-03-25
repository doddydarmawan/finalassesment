<?php
namespace Icube\AutoCategory\Repository;

class AutoCategoryRepository
{
    public function findProductByCategoryAndDateRange($filterDate, $categoryId){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$collection = $objectManager->get('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory')->create();
		$collection->getSelect()->join(
			'catalog_category_product',
			'e.entity_id=`catalog_category_product`.product_id and e.created_at < "'.$filterDate.'" and `catalog_category_product`.category_id = "'.$categoryId.'"'
		);
		$collection->load();

        return $collection;
    }

    public function unassignCategoryFromProduct($product, $categoryId){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $categoryLinkRepository = $objectManager->get('\Magento\Catalog\Model\CategoryLinkRepository');
        $sku = $product->getSku();
        $categoryLinkRepository->deleteByIds($categoryId,$sku);
    }
}