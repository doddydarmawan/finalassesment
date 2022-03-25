<?php
namespace Icube\OkrDivisiCustomSyaiful\Repository;

use Icube\OkrDivisiCustomSyaiful\Model\PesertaSyaifulFactory;
use Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\PesertaSyaiful\CollectionFactory;

class PesertaSyaifulRepository
{
    public function __construct(
        PesertaSyaifulFactory $pesertaSyaifulFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->pesertaSyaifulFactory = $pesertaSyaifulFactory;
        $this->collectionFactory = $collectionFactory;
    }

    public function savePeserta($data){
        $pesertaSyaiful = $this->pesertaSyaifulFactory->create();
        $pesertaSyaiful->setNama($data['nama']);
        $pesertaSyaiful->setAcaraId($data['acara_id']);
        $pesertaSyaiful->save();
        return $pesertaSyaiful;
    }

    public function findPesertaByAcaraId($params){
        $acaraSyaiful = $this->collectionFactory->create()
         ->addFieldToFilter('acara_id', ['eq' => $params]);

        return $acaraSyaiful;
    }
}