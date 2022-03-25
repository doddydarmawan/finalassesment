<?php
namespace Icube\OkrDivisiCustomSyaiful\Model;

class PesertaSyaiful extends \Magento\Framework\Model\AbstractModel implements \Icube\OkrDivisiCustomSyaiful\Model\PesertaSyaifulInterface
{
    const CACHE_TAG = 'icube_okrdivisicustomsyaiful_pesertasyaiful';

    protected function _construct()
    {
        $this->_init('Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\PesertaSyaiful');
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
    public function getNama(){
    	return $this->_getData('nama');
    }

    /**
     * Set Nama
     *
     * @param string $nama
     * @return $this
     */
    public function setNama($nama){
    	$this->setData('nama',$nama);
    }

        /**
     * AcaraId
     *
     * @return string
     */
    public function getAcaraId(){
    	return $this->_getData('acara_id');
    }

    /**
     * Set AcaraId
     *
     * @param string $acaraId
     * @return $this
     */
    public function setAcaraId($acaraId){
    	$this->setData('acara_id',$acaraId);
    }

    /**
     * Set Peserta
     *
     * @param string $peserta
     * @return $this
     */
    public function setPeserta($peserta){
    	$this->setData('peserta', $peserta);
    }
}