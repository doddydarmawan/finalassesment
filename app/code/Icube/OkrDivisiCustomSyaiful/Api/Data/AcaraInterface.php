<?php

namespace Icube\OkrDivisiCustomSyaiful\Api\Data;

interface AcaraInterface
{
    /**
     * Entity_Id
     *
     * @return int|null
     */
    public function getEntityId();

    /**
     * Set Entity_id
     *
     * @param int $entityId
     * @return $this
     */
    public function setEntityId($entityId);

    /**
     * Nama
     *
     * @return string
     */
    public function getNama();

    /**
     * Set Nama
     *
     * @param string $nama
     * @return $this
     */
    public function setNama($nama);

    /**
     * Pemateri
     *
     * @return string
     */
    public function getPemateri();

    /**
     * Set Pemateri
     *
     * @param string $pemateri
     * @return $this
     */
    public function setPemateri($pemateri);
}
