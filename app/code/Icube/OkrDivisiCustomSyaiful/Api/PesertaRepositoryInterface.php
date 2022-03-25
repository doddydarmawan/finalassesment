<?php 

namespace Icube\OkrDivisiCustomSyaiful\Api;

use Icube\OkrDivisiCustomSyaiful\Api\Data\PesertaInterface;

interface PesertaRepositoryInterface
{
    /**
     * Get peserta by id
     *
     * @param int $id
     * @return PesertaInterface
     */
    public function getById($id);

    /**
     * Get peserta by acara id
     *
     * @param int $acaraId
     * @return PesertaInterface
     */
    public function getByAcaraId($acaraId);

    /**
     * Create new peserta
     *
     * @param string $nama
     * @return PesertaInterface
     */
    public function create($acaraId, $nama);

}