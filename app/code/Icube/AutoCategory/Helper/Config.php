<?php 

namespace Icube\AutoCategory\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper 
{
    const NEW_ARRIVALS_CATEGORY_PATH = 'autocategory/category/new_arrivals';
    const SALE_CATEGORY_PATH = 'autocategory/category/sale';

    const IS_ENABLE_PATH = 'auto_category/general/enable';
    const CRON_PATH = 'auto_category/general/scan_schedule';
    const NEW_RANGE_PATH = 'auto_category/general/new_range';

    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    public function getValueIdNewArrivals()
    {
        return $this->scopeConfig->getValue(self::NEW_ARRIVALS_CATEGORY_PATH, ScopeInterface::SCOPE_STORE);
    }

    public function getValueIdSale()
    {
        return $this->scopeConfig->getValue(self::SALE_CATEGORY_PATH, ScopeInterface::SCOPE_STORE);
    }

    public function IsEnable()
    {
        $value = $this->scopeConfig->getValue(self::IS_ENABLE_PATH, ScopeInterface::SCOPE_STORE);
        return $value == 1 ? true : false;
    }

    public function getCron()
    {
        return $this->scopeConfig->getValue(self::CRON_PATH, ScopeInterface::SCOPE_STORE);
    }

    public function getNewRange()
    {
        return $this->scopeConfig->getValue(self::NEW_RANGE_PATH, ScopeInterface::SCOPE_STORE);
    }
}