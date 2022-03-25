<?php

namespace Icube\AutoCategory\Observer;

use Magento\Framework\Event\ObserverInterface;
use Icube\AutoCategory\Helper\Config;

class AutoCategory implements ObserverInterface
{
    /**
     * Catalog data
     *
     * @var Config
     */
    protected $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if($this->config->getConfigEnable()){
            $product = $observer->getEvent()->getProduct();

            $sku = $product->getSku();
            $categoryIds = [];
            if (!$product->getExcludeFromNew()) {
                $categoryIds[] = '7';
            }
    
            if ($product->getSale()) {
                $categoryIds[] = '6';
            }
    
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $categoryLinkRepository = $objectManager->get('\Magento\Catalog\Api\CategoryLinkManagementInterface');
            $categoryLinkRepository->assignProductToCategories($sku, $categoryIds);
        }
    }
}
