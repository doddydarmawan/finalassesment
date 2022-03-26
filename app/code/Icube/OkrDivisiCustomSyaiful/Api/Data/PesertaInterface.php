<?php

namespace Icube\OkrDivisiCustomSyaiful\Api\Data;

interface PesertaInterface
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
     * Acara_id
     *
     * @return string
     */
    public function getAcara_id();

    /**
     * Set Acara_id
     *
     * @param string $acara_id
     * @return $this
     */
    public function setAcara_id($acara_id);
}
