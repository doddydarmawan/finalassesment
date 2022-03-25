<?php
namespace Icube\OkrDivisiCustomSyaiful\Repository;

use Icube\OkrDivisiCustomSyaiful\Model\AcaraSyaifulFactory;
use Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\AcaraSyaiful\CollectionFactory;

class AcaraSyaifulRepository
{
    public function __construct(
        AcaraSyaifulFactory $acaraSyaifulFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->acaraSyaifulFactory = $acaraSyaifulFactory;
        $this->acaraSyaifulFactoryCreate = $this->acaraSyaifulFactory->create();
        $this->collectionFactory = $collectionFactory;
    }

    public function findEventByName($params){
        $acaraSyaiful = $this->acaraSyaifulFactoryCreate->load($params, 'nama');
        return $acaraSyaiful;
    }

    public function findEventById($params){
        $acaraSyaiful = $this->acaraSyaifulFactoryCreate->load($params);
        return $acaraSyaiful;
    }

    public function saveData($input){
        $acaraSyaiful = $this->acaraSyaifulFactoryCreate;
        $acaraSyaiful = $this->setField($acaraSyaiful, $input);
		$acaraSyaiful->save();

        return $acaraSyaiful;
    }

    public function edit($input){
        $acaraSyaiful = $this->acaraSyaifulFactoryCreate->load($input['id']);
        $acaraSyaiful = $this->setField($acaraSyaiful, $input);
		$acaraSyaiful->save();
        return $acaraSyaiful;
    }

    private function setField($acaraSyaiful, $input){
        $acaraSyaiful->setNama($input["nama"]);
		$acaraSyaiful->setPemateri($input["pemateri"]);
        return $acaraSyaiful;
    }
}