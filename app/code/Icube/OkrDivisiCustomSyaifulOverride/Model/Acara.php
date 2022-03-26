<?php

namespace Icube\OkrDivisiCustomSyaifulOverride\Model;

use Icube\OkrDivisiCustomSyaifulOverride\Api\Data\AcaraInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Acara extends \Icube\OkrDivisiCustomSyaiful\Model\Acara implements AcaraInterface, IdentityInterface
{
    const CACHE_TAG = 'icube_OkrDivisiCustomSyaifuloverride_acara';

    protected function _construct()
    {
        $this->_init('Icube\OkrDivisiCustomSyaifulOverride\Model\ResourceModel\Acara');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Tanggal
     *
     * @return string
     */
    public function getTanggal()
    {
        return $this->_getData('tanggal');
    }

    /**
     * Set Tanggal
     *
     * @param string $tanggal
     * @return $this
     */
    public function setTanggal($tanggal)
    {
        $this->setData('tanggal', $tanggal);
    }
}
