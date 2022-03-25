<?php 

namespace Icube\OkrDivisiCustomSyaiful\Model;

use Icube\OkrDivisiCustomSyaiful\Api\Data\PesertaInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Peserta extends AbstractModel implements PesertaInterface, IdentityInterface
{
    const CACHE_TAG = 'icube_peserta_syaiful';

    protected function _construct() {
        $this->_init('Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\Peserta');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}