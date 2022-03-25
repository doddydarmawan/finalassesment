<?php

namespace Icube\OkrDivisiCustomSyaiful\Model;

use Icube\OkrDivisiCustomSyaiful\Model\AcaraSyaifulV2DataInterface;

class AcaraSyaifulV2Data implements AcaraSyaifulV2DataInterface{
    private $nama;
    private $pemateri;
    private $entityId;

    /**
     * Get Field
     * @return string|null
     */
    public function getNama(){
        return $this->nama;
    }
    
    /**
     * Get Field
     * @param string $nama
     * @return $this
     */
    public function setNama($nama){
        $this->nama = $nama;
    }

    /**
     * Get Field
     * @return string|null
     */
    public function getPemateri(){
        return $this->pemateri;
    }
    
    /**
     * Get Field
     * @param string $pemateri
     * @return $this
     */
    public function setPemateri($pemateri){
        $this->pemateri = $pemateri;
    }

    /**
     * Get Field
     * @return string|null
     */
    public function getEntityId(){
        return $this->entityId;
    }
}