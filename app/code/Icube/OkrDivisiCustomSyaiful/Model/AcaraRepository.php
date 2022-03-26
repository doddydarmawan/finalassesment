<?php

namespace Icube\OkrDivisiCustomSyaiful\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
// use Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\Acara as AcaraResourceModel;
use Icube\OkrDivisiCustomSyaiful\Api\AcaraRepositoryInterface;
use Icube\OkrDivisiCustomSyaiful\Model\AcaraFactory;
use Icube\OkrDivisiCustomSyaiful\Model\PesertaFactory;

class AcaraRepository implements AcaraRepositoryInterface
{
    protected $acaraFactory;
    protected $collectionProcessor;
    protected $acaraSearchResultsFactory;
    protected $acaraResourceModel;
    protected $pesertaFactory;

    public function __construct(
        AcaraFactory $acaraFactory,
        PesertaFactory $pesertaFactory,
        // AcaraResourceModel $acaraResourceModel,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->acaraFactory = $acaraFactory;
        $this->pesertaFactory = $pesertaFactory;

        // $this->acaraResourceModel = $acaraResourceModel;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * {@inheritDoc}
     */
    public function getById($id)
    {
        $result = $this->acaraFactory->create();
        $result = $result->load($id);
        if ($result->getNama() == null) {
            $result['status'] = "gagal";
            return $result;
        }
        $datapeserta = [];
        $peserta = $this->pesertaFactory->create();
        $collection = $peserta->getCollection();
        foreach ($collection as $collect) {
            if ($collect->getAcara_id() == $id) {
                $datapeserta[] = [
                    'nama' => $collect->getNama()
                ];
            }
        }
        $result = $result->getData();
        $result['peserta'] = $datapeserta;
        $result['status'] = "berhasil";
        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function create($nama, $pemateri, $pesertas)
    {
        $result = $this->acaraFactory->create();
        $result->setNama($nama);
        $result->setPemateri($pemateri);
        $result->save();
        $id = $result->getId();

        $datapeserta = [];
        foreach ($pesertas as $ipeserta) {
            $peserta = $this->pesertaFactory->create();
            $peserta->setNama($ipeserta['nama']);
            $peserta->setAcara_id($id);
            $peserta->save();
            $datapeserta[] = $ipeserta;
        }
        $result['peserta'] = $datapeserta;

        return $result;
    }

    public function create2($nama, $acara_id)
    {
        $result = $this->pesertaFactory->create();
        $result->setNama($nama);
        $result->setAcara_id($acara_id);
        $result->save();
        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function update($id, $nama, $pemateri)
    {
        $result = $this->acaraFactory->create()->load($id);
        if ($result->getNama() == null) {
            $result['status'] = "gagal";
            return $result;
        }
        $result->setNama($nama);
        $result->setPemateri($pemateri);
        $result->save();
        $datapeserta = [];
        $peserta = $this->pesertaFactory->create();
        $collection = $peserta->getCollection();
        foreach ($collection as $collect) {
            if ($collect->getAcara_id() == $id) {
                $datapeserta[] = [
                    'nama' => $collect->getNama()
                ];
            }
        }

        $result['peserta'] = $datapeserta;
        $result['status'] = "berhasil";
        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function delete($id)
    {
        $result = $this->acaraFactory->create()->load($id);
        if ($result->getNama() == null) {
            $data['status'] = "gagal";
            return $data;
        }


        $result->delete();
        $data['status'] = "berhasil";
        return $data;
    }
}
