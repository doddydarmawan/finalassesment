<?php
namespace Icube\AutoCategory\Cron;

use Icube\AutoCategory\Helper\Config;
use Icube\AutoCategory\Model\CategoryManagement;

class AutoCategory
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var CategoryManagement
     */
    private $categoryManagement;

    /**
     * AutoCategory constructor
     *
     * @param Trainee $traineeManagement
     */
    public function __construct(
        Config $config,
        CategoryManagement $categoryManagement
    ) {
        $this->config = $config;    
        $this->categoryManagement = $categoryManagement;
    }

    /**
     * Execute the cron
     *
     * @return void
     */
	public function execute()
	{
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info('hay'.$this->config->IsEnable());

        if ($this->config->IsEnable()) {
            
            $logger->info('enable mulai');
            $this->categoryManagement->assignCategoryInAllProductByRangeAndExclude();
            $logger->info('enable selesai');

        } else {
            // unasign category 
            $logger->info('disable mulai');
            $this->categoryManagement->unassignCategoryInAllProduct();
            $logger->info('disable selesai');
        }

        return $this;
    }
}
