<?php

namespace Icube\AutoCategory\Observer;

use Magento\Framework\Event\ObserverInterface;
use \Magento\Framework\App\Config\ScopeConfigInterface;

class SaveCategory implements ObserverInterface
{
    protected $categoryLinkManagementInterface;

    public function __construct(
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Api\CategoryLinkManagementInterface  $categoryLinkManagementInterface,
        ScopeConfigInterface $scopeConfigInterface
    ) {
        $this->categoryLinkManagementInterface = $categoryLinkManagementInterface;
        $this->productFactory = $productFactory;
        $this->scopeConfigInterface = $scopeConfigInterface;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getProduct();
        $sku = $product->getSku();
        $onsale = $product->getSale();
        $onExclude = $product->getExclude_from_new();
        $categoryIdOnSale = $this->scopeConfigInterface->getValue('autocategory/category/sale', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $categoryIdOnNew = $this->scopeConfigInterface->getValue('autocategory/category/new_arrivals', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $categoryIds = [];
        if ($onsale == true) {
            $categoryIds[] = $categoryIdOnSale;
        }
        if ($onExclude == false) {
            $categoryIds[] = $categoryIdOnNew;
        }
        $this->categoryLinkManagementInterface->assignProductToCategories($sku, $categoryIds);
    }
}
