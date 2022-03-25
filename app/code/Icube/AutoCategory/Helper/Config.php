<?php

namespace Icube\AutoCategory\Helper;

use \Magento\Framework\App\Helper\Context;
use \Magento\Store\Model\ScopeInterface;

class Config extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_ENABLE = 'auto_category_setting/general/enable';
    const XML_PATH_DAYS_RANGE = 'auto_category_setting/general/days_range';
    const XML_PATH_CRON = 'auto_category_setting/general/cron';

    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    public function getConfigEnable()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ENABLE, ScopeInterface::SCOPE_STORE);
    }

    public function getConfigDaysRange()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_DAYS_RANGE, ScopeInterface::SCOPE_STORE);
    }

    public function getConfigCron()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_CRON, ScopeInterface::SCOPE_STORE);
    }
}
