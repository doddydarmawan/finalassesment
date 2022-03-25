<?php
namespace Icube\AutoCategory\Model;

use Exception;
use Magento\Catalog\Api\CategoryLinkRepositoryInterface;
use Magento\Catalog\Api\CategoryLinkManagementInterface;
use Magento\Catalog\Api\Data\CategoryProductLinkInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Icube\AutoCategory\Helper\Config;

class CategoryManagement
{
    /**
     * @var CategoryLinkRepositoryInterface
     */
    private $categoryLinkRepository;

    /**
     * @var CategoryLinkManagementInterface
     */
    private $categoryLinkManagement;

    private $productCollection;

    private $config;

    /**
     * COnstructor
     *
     * @param CategoryLinkRepositoryInterface $categoryLinkRepository
     * @param CategoryLinkManagementInterface $categoryLinkManagement
     * @param CollectionFactory $productCollection
     * @param Config $config
     */
    public function __construct(
        CategoryLinkRepositoryInterface $categoryLinkRepository,
        CategoryLinkManagementInterface $categoryLinkManagement,
        CollectionFactory $productCollection,
        Config $config
    ) {
        $this->categoryLinkRepository = $categoryLinkRepository;
        $this->categoryLinkManagement = $categoryLinkManagement;
        $this->productCollection = $productCollection;
        $this->config = $config;
    }

    /**
     * UnAssigned Product to single/multiple Category
     *
     * @param int $categoryId
     * @param string $sku
     * @return bool
     */
    public function unassignProductFromCategory($categoryId, $sku)
    {
        $isProductUnassigned = $this->categoryLinkRepository->deleteByIds($categoryId, $sku);
        return $isProductUnassigned;
    }

    /**
     * Assigned Product to single/multiple Category
     *
     * @param int $categoryId
     * @param string $sku
     * @return bool
     */
    public function assignProductToCategory(string $productSku, array $categoryIds)
    {
        $hasProductAssignedSuccess = $this->categoryLinkManagement->assignProductToCategories($productSku, $categoryIds);
        return $hasProductAssignedSuccess;
    }

    /**
     * Get all product filter by exclude_from_new = 0 & 
     * created_at in the new_range days from now
     *
     * @return CollectionFactory
     */
    public function getProductsWithInRangeAndExclude()
    {
        $collection = $this->productCollection->create()
                ->addAttributeToSelect('*')
                ->addFieldToFilter('exclude_from_new', array('neq' => 1))
                ->addFieldToFilter('created_at', array(
                    'gt' => date("Y-m-d H:i:s", strtotime('-'.$this->config->getNewRange().' day'))
                ));

        return $collection;
    }

    /**
     * Get all product filter by exclude_from_new = 0 &
     * created_at inthe new_range days from now &
     * have sale product attribute
     *
     * @return void
     */
    public function getProductsWithInRangeAndExcludeAndSale()
    {
        $collection = $this->productCollection->create()
                ->addAttributeToSelect('*')
                ->addFieldToFilter('exclude_from_new', array('neq' => 1))
                ->addFieldToFilter('sale', array('neq' => 0))
                ->addFieldToFilter('created_at', array(
                    'gt' => date("Y-m-d H:i:s", strtotime('-'.$this->config->getNewRange().' day'))
                ));

        return $collection;
    }

    /**
     * Get all product filter by exclude_from_new = 0 &
     * created_at out of the new_range days for now
     *
     * @return CollectionFactory
     */
    public function getProductsWithOutOfRangeAndExclude()
    {
        $collection = $this->productCollection->create()
                ->addAttributeToSelect('*')
                ->addFieldToFilter('exclude_from_new', array('neq' => 1)) // exclude = 0
                ->addCategoriesFilter(array('in' => $this->config->getValueIdNewArrivals()))
                ->addFieldToFilter('created_at', array(
                    'lt' => date("Y-m-d H:i:s", strtotime('-'.$this->config->getNewRange().' day'))
                ));

        return $collection;
    }

    /**
     * Get all products
     *
     * @return CollectionFactory
     */
    public function getProductByCategoryNewArrivals()
    {
        $collection = $this->productCollection->create()
                ->addAttributeToSelect('*')
                ->addCategoriesFilter(array('in' => $this->config->getValueIdNewArrivals()));
        return $collection;
    }

    /**
     * logic for assign and unassign product from category if the config AutoCategory is enable
     *
     * @return void
     */
    public function assignCategoryInAllProductByRangeAndExclude()
    {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);

        $productsNotNewArrivals = $this->getProductsWithOutOfRangeAndExclude();
        if ($productsNotNewArrivals->getSize() > 0) {
            // check dulu punya new arrival tapi tanggalnya udah kadaluarsa
            $logger->info('enable & product not new arrivals mulai');
            foreach ($productsNotNewArrivals as $product) {
                $this->unassignProductFromCategory(
                    (int)$this->config->getValueIdNewArrivals(), 
                    $product->getSku()
                );
            }
            $logger->info('enable & product not new arrivals selesai');
        }

        $productsNewArrivals = $this->getProductsWithInRangeAndExclude();
        if ($productsNewArrivals->getSize() > 0) {
            // assign all product by exclude from new = 1 and new range
            $logger->info('enable & products getsize > 0 mulai');

            $productNewArrivalsAndSale = $this->getProductsWithInRangeAndExcludeAndSale();
            if ($productNewArrivalsAndSale->getSize() > 0) {
                $logger->info('enable & products getsize > 0 & sale = 1 mulai');
                foreach ($productsNewArrivals as $product) {
                    $this->assignProductToCategory(
                        $product->getSku(), 
                        [
                            (int)$this->config->getValueIdNewArrivals(),
                            (int)$this->config->getValueIdSale()
                        ]
                    );
                }
                $logger->info('enable & products getsize > 0 & sale = 1 selesai');
            } else {
                $logger->info('enable & products getsize > 0 & sale = 0 mulai');
                foreach ($productsNewArrivals as $product) {
                    $this->assignProductToCategory(
                        $product->getSku(), 
                        [(int)$this->config->getValueIdNewArrivals()]
                    );
                }
                $logger->info('enable & products getsize > 0 & sale = 0 selesai');
            }
            

            $logger->info('enable & products getsize > 0 selesai');
        }
    }

    /**
     * Logic for unassign category from product if the config AutoCategory is disable
     *
     * @return void
     */
    public function unassignCategoryInAllProduct()
    {
        // not used this func, because optional can use console comand
        // foreach ($this->getProductByCategoryNewArrivals() as $product) {
        //     $this->unassignProductFromCategory(
        //         (int)$this->config->getValueIdNewArrivals(), 
        //         $product->getSku()
        //     );
        // }
    }
}