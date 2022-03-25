<?php
namespace Icube\OkrDivisiCustomSyaifulOverride\Model;
use Icube\OkrDivisiCustomSyaiful\Model\AcaraSyaiful as AcaraModel;

class AcaraSyaiful extends AcaraModel implements \Icube\OkrDivisiCustomSyaiful\Model\AcaraSyaifulInterface
{
    const CACHE_TAG = 'icube_okrdivisicustomsyaiful_acarasyaiful';

    protected function _construct()
    {
        $this->_init('Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\AcaraSyaiful');
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
     * Pemateri
     *
     * @return string
     */
    public function getPemateri(){
    	return $this->_getData('pemateri');
    }

    /**
     * Set Pemateri
     *
     * @param string $pemateri
     * @return $this
     */
    public function setPemateri($pemateri){
    	$this->setData('pemateri',$pemateri);
    }

    /**
     * Tanggal
     *
     * @return string
     */
    public function getTanggal(){
    	return $this->_getData('tanggal');
    }

    /**
     * Set Tanggal
     *
     * @param string $tanggal
     * @return $this
     */
    public function setTanggal($tanggal){
    	$this->setData('tanggal',$tanggal);
    }

        /**
     * Entity Id
     *
     * @return string
     */
    public function getEntityId(){
    	return $this->_getData('entity_id');
    }
}