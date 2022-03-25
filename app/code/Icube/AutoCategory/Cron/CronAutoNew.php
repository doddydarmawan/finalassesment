<?php

namespace Icube\AutoCategory\Cron;

use Icube\AutoCategory\Helper\AutoCategory;

class CronAutoNew
{
    /**
     * @var AutoCategory
     */
    protected $autoCategoryHelper;

    public function __construct(
        AutoCategory $autoCategoryHelper
    ) {
        $this->autoCategoryHelper = $autoCategoryHelper;
    }

    public function execute()
    {
        //logic inside here
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/AutoCategory_cron.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('log start here');
        $from = "cron";
        $result = $this->autoCategoryHelper->autoCategoryCommand($from);
        $logger->info($result['status']);
        if ($result['count'] != 0) {
            $logger->info($result['count'] . " product autocategory.");
        }
        return $this;
    }
}
