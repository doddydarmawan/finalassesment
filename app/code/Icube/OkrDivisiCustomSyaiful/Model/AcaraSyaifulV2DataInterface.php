<?php

namespace Icube\OkrDivisiCustomSyaiful\Model;

interface AcaraSyaifulV2DataInterface{
   /**
     * Get Field
     * 
     * @return string|null
     */
    public function getNama();

    /**
     * Get Product
     * @param string $nama
     * @return $this
     */
    public function setNama($nama);

        /**
     * Get Field
     * 
     * @return string|null
     */
    public function getPemateri();

    /**
     * Get Product
     * @param string $pemateri
     * @return $this
     */
    public function setPemateri($pemateri);

    /**
     * Get Field
     * 
     * @return string|null
     */
    public function getEntityId();

}