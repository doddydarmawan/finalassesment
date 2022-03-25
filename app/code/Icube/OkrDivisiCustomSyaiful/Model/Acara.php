<?php 

namespace Icube\OkrDivisiCustomSyaiful\Model;

use Icube\OkrDivisiCustomSyaiful\Api\Data\AcaraInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Acara extends AbstractModel implements AcaraInterface, IdentityInterface
{
    const CACHE_TAG = 'icube_acara_syaiful';

    protected function _construct() {
        $this->_init('Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\Acara');
    }

    public function getIdentities()
    {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/mnnLogger.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info([self::CACHE_TAG . '_' . $this->getId()]);
        
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}