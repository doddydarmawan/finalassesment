<?php

namespace Icube\AutoCategory\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use \Magento\Catalog\Api\ProductRepositoryInterface;

class AutoCategory extends AbstractHelper
{
    protected $productCollectionFactory;
    protected $categoryLinkManagementInterface;

    public function __construct(
        CollectionFactory $productCollectionFactory,
        ScopeConfigInterface $scopeConfigInterface,
        ProductRepositoryInterface $productRepository
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->scopeConfigInterface = $scopeConfigInterface;
        $this->productRepository = $productRepository;
    }

    public function autoCategoryCommand($from)
    {
        $count = 0;
        $result = [];
        $enableon = $this->scopeConfigInterface->getValue('autocategory_setting/configauto/enablemo', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $cronon = $this->scopeConfigInterface->getValue('autocategory_setting/configauto/cron', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if ($enableon == 0) {
            $result['count'] = $count;
            $result['status'] = "Auto Category Disable";
            return $result;
        }
        if ($cronon == "no" && $from != "command") {
            $result['count'] = $count;
            $result['status'] = "Cron was disable, please using command";
            return $result;
        }

        if ($cronon == "yes" && $from != "cron") {
            $result['count'] = $count;
            $result['status'] = "Command was disable, please using cron";
            return $result;
        }

        $collection = $this->productCollectionFactory->create()->addFieldToFilter('exclude_from_new', array('neq' => 1));
        $categoryIdOnNew = $this->scopeConfigInterface->getValue('autocategory/category/new_arrivals', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $rangeon = $this->scopeConfigInterface->getValue('autocategory_setting/configauto/range', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $datenow = date('Y-m-d H:i:s');
        $datera = date('Y-m-d H:i:s', strtotime('-' . $rangeon . ' days', strtotime($datenow)));
        foreach ($collection as $product) {
            if ($product->getCustomAttribute('exclude_from_new')->getValue() == 0) {
                if ($datera > $product->getCreated_at()) {
                    $sku = $product->getSku();
                    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                    $CategoryLinkRepository = $objectManager->get('\Magento\Catalog\Model\CategoryLinkRepository');
                    // $productId = $product->getId();
                    // $products = $this->productRepository->getById($productId);
                    // $products->setData('exclude_from_new', 'true');
                    // $this->productRepository->save($products);
                    try {
                        $CategoryLinkRepository->deleteByIds($categoryIdOnNew, $sku);
                        $count = $count + 1;
                    } catch (\Exception $e) {
                    }
                }
            }
        }
        $result['count'] = $count;
        $result['status'] = "success";
        return $result;
    }
}
