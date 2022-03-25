<?php 

namespace Icube\OkrDivisiCustomSyaiful\Api;

use Icube\OkrDivisiCustomSyaiful\Api\Data\AcaraInterface;

interface AcaraRepositoryInterface
{
    /**
     * Get acara by id
     *
     * @param int $id
     * @return AcaraInterface
     */
    public function getById($id);

    /**
     * create acara acara
     * 
     * @param string $nama
     * @param string $pemateri
     * @return AcaraInterface
     */
    public function create($nama, $pemateri);

    /**
     * upgrade acara by id
     *
     * @param int $id
     * @param string $nama
     * @param string $pemateri
     * @return AcaraInterface
     */
    public function update($id, $nama, $pemateri);
}