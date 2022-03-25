<?php
namespace Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\PesertaSyaiful;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Icube\OkrDivisiCustomSyaiful\Model\PesertaSyaiful', 'Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\PesertaSyaiful');
    }
}