<?php

namespace Icube\OkrDivisiCustomSyaifulOverride\Api\Data;

interface AcaraInterface extends \Icube\OkrDivisiCustomSyaiful\Api\Data\AcaraInterface
{

    /**
     * Tanggal
     *
     * @return string
     */
    public function getTanggal();

    /**
     * Set Tanggal
     *
     * @param datetime $tanggal
     * @return $this
     */
    public function setTanggal($tanggal);
}
