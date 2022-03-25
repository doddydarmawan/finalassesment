<?php

namespace Icube\AutoCategory\Observer;

use Icube\AutoCategory\Helper\Config;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Icube\AutoCategory\Model\CategoryManagement;

class AssignCategoryAfterSaveProduct implements ObserverInterface
{    
    protected $config;
    protected $categoryManagement;

    public function __construct(
        CategoryManagement $categoryManagement,
        Config $config
    ) {
        $this->config = $config;
        $this->categoryManagement = $categoryManagement;
    }

    public function execute(Observer $observer)
    {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/mnnLogger.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        

        $_product = $observer->getProduct();
        $product_sku = $_product->getSku();

        $excludeFromNewAttr = $_product->getCustomAttribute('exclude_from_new')->getValue();
        $saleAttr = $_product->getCustomAttribute('sale')->getValue();

        if ($excludeFromNewAttr === "0" && $saleAttr === "1") {
            $logger->info('e = 0 & s = 1');
            $this->categoryManagement->assignProductToCategory($product_sku, [
                (int)$this->config->getValueIdNewArrivals(),
                (int)$this->config->getValueIdSale()
            ]);
        } else {
            if ($excludeFromNewAttr === "1") {
                $logger->info('e = 1');
                $this->categoryManagement->unassignProductFromCategory((int)$this->config->getValueIdNewArrivals(), $product_sku);
            } else {
                $logger->info('e = 0');
                $this->categoryManagement->assignProductToCategory($product_sku, [(int)$this->config->getValueIdNewArrivals()]);
            }
    
            if ($saleAttr === "0") {
                $logger->info('s = 0');
                $this->categoryManagement->unassignProductFromCategory((int)$this->config->getValueIdSale(), $product_sku);
            } else {
                $logger->info('s = 1');
                $this->categoryManagement->assignProductToCategory($product_sku, [(int)$this->config->getValueIdSale()]);
            }
        }
    }   
}