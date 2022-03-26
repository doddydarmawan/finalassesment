<?php

namespace Icube\OkrDivisiCustomSyaifulOverride\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
// use Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\Acara as AcaraResourceModel;
use Icube\OkrDivisiCustomSyaifulOverride\Api\AcaraRepositoryInterface;
use Icube\OkrDivisiCustomSyaifulOverride\Model\AcaraFactory;
use Icube\OkrDivisiCustomSyaiful\Model\PesertaFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;

class AcaraRepository extends \Icube\OkrDivisiCustomSyaiful\Model\AcaraRepository implements AcaraRepositoryInterface
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
    public function create($nama, $pemateri, $pesertas, $tanggal = null)
    {
        $result = $this->acaraFactory->create();
        $result->setNama($nama);
        $result->setPemateri($pemateri);
        $result->setTanggal($tanggal);
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

    /**
     * {@inheritDoc}
     */
    public function update($id, $nama, $pemateri, $tanggal = null)
    {
        $result = $this->acaraFactory->create()->load($id);
        if ($result->getNama() == null) {
            $result['status'] = "gagal";
            return $result;
        }
        $result->setNama($nama);
        $result->setPemateri($pemateri);
        $result->setTanggal($tanggal);
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

    public function SearchAcara($search_text, $filter_nama, $filter_pemateri, $pageSize, $currentPage)
    {
        

        try {
            $acaraCollection = $this->acaraFactory->create();
            $collection = $acaraCollection->getCollection();

            $currentPage = ($currentPage) ? $currentPage : 1;

            $pageSize = ($pageSize) ? $pageSize : 6;

            if ($search_text != "") {
                $collection->addFieldToFilter(
                    array(
                        'nama',
                        'pemateri'
                    ),
                    array(
                        array('like' => '%' . $search_text . '%'),
                        array('like' => '%' . $search_text . '%')
                    )
                );
            }

            if ($filter_nama !== null) {
                $collection->addFieldToFilter('nama', $filter_nama);
            }


            if ($filter_pemateri !== null) {
                $collection->addFieldToFilter('pemateri', $filter_pemateri);
            }
            $count = $collection->getSize();

            $total_pages = ceil($count / $pageSize);
            $collection->setPageSize($pageSize)->setCurPage($currentPage);
            $count = $collection->getSize();
            $acara_data = [];
            $peserta = $this->pesertaFactory->create();
            $collectionp = $peserta->getCollection();
            foreach ($collection as $acara) {

                $id = $acara->getId();
                $acara_data[$id]['entity_id'] = $acara->getId();
                $acara_data[$id]['nama'] = $acara->getNama();
                $acara_data[$id]['pemateri'] = $acara->getPemateri();
                $peserta_data = [];
                foreach ($collectionp as $pes) {
                    if ($pes->getAcara_id() == $id) {
                        $peserta_data[] = [
                            'nama' => $pes->getNama()
                        ];
                    }
                }
                $acara_data[$id]['peserta'] = $peserta_data;
            }
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return [
            'total_count' => $count, 'total_pages' => $total_pages, 'acaraList' => $acara_data
        ];
    }
}
