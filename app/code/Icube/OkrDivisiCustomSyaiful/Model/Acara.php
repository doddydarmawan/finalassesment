<?php

namespace Icube\OkrDivisiCustomSyaiful\Model;

use Icube\OkrDivisiCustomSyaiful\Api\Data\AcaraInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Acara extends AbstractModel implements AcaraInterface, IdentityInterface
{
    const CACHE_TAG = 'icube_okrdivisicustomsyaiful_acara';

    protected function _construct()
    {
        $this->_init('Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\Acara');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Nama
     *
     * @return string
     */
    public function getNama()
    {
        return $this->_getData('nama');
    }

    /**
     * Set Nama
     *
     * @param string $nama
     * @return $this
     */
    public function setNama($nama)
    {
        $this->setData('nama', $nama);
    }

    /**
     * Pemateri
     *
     * @return string
     */
    public function getPemateri()
    {
        return $this->_getData('pemateri');
    }

    /**
     * Set Pemateri
     *
     * @param string $pemateri
     * @return $this
     */
    public function setPemateri($pemateri)
    {
        $this->setData('pemateri', $pemateri);
    }
}
