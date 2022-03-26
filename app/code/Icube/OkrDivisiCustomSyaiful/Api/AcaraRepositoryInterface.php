<?php

namespace Icube\OkrDivisiCustomSyaiful\Api;

interface AcaraRepositoryInterface
{

    /**
     * Get Acara by id
     *
     * @param int $id
     * @return \Icube\OkrDivisiCustomSyaiful\Api\Data\AcaraInterface
     */
    public function getById($id);

    /**
     * Create new Acara
     *
     * @param string $nama
     * @param string $pemateri
     * @param array $peserta
     * @return \Icube\OkrDivisiCustomSyaiful\Api\Data\AcaraInterface
     */
    public function create($nama, $pemateri, $peserta);

    /**
     * Create new Peserta
     *
     * @param string $nama
     * @param string $acara_id
     * @return \Icube\OkrDivisiCustomSyaiful\Api\Data\PesertaInterface
     */
    public function create2($nama, $acara_id);

    /**
     * Update Acara by id
     *
     * @param int $id
     * @param string $nama
     * @param string $pemateri
     * @return \Icube\OkrDivisiCustomSyaiful\Api\Data\AcaraInterface
     */
    public function update($id, $nama, $pemateri);

    /**
     * Delete Acara by id
     *
     * @param int $id
     * @return string
     */
    public function delete($id);
}
