<?php

namespace Icube\OkrDivisiCustomSyaifulOverride\Api;

interface AcaraRepositoryInterface extends \Icube\OkrDivisiCustomSyaiful\Api\AcaraRepositoryInterface
{
    /**
     * Create new Acara
     *
     * @param string $nama
     * @param string $pemateri
     * @param array $peserta
     * @param datetime $tanggal
     * @return \Icube\OkrDivisiCustomSyaiful\Api\Data\AcaraInterface
     */
    public function create($nama, $pemateri, $peserta, $tanggal = null);

    /**
     * Update Acara by id
     *
     * @param int $id
     * @param string $nama
     * @param string $pemateri
     * @param datetime $tanggal
     * @return \Icube\OkrDivisiCustomSyaiful\Api\Data\AcaraInterface
     */
    public function update($id, $nama, $pemateri, $tanggal = null);

    /**
     * Search Acara
     * 
     * @param string $search_text
     * @param string $filter_nama
     * @param string $filter_pemateri
     * @param int $pageSize
     * @param int $currentPage
     */
    public function searchAcara($search_text, $filter_nama, $filter_pemateri, $pageSize, $currentPage);
}
