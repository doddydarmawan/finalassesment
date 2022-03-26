<?php

namespace Icube\OkrDivisiCustomSyaiful\Model;

use Icube\OkrDivisiCustomSyaiful\Api\Data\PesertaInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Peserta extends AbstractModel implements PesertaInterface, IdentityInterface
{
    const CACHE_TAG = 'icube_okrdivisicustomsyaiful_peserta';

    protected function _construct()
    {
        $this->_init('Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\Peserta');
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
     * Acara_id
     *
     * @return string
     */
    public function getAcara_id()
    {
        return $this->_getData('acara_id');
    }

    /**
     * Set Acara_id
     *
     * @param string $acara_id
     * @return $this
     */
    public function setAcara_id($acara_id)
    {
        $this->setData('acara_id', $acara_id);
    }
}
