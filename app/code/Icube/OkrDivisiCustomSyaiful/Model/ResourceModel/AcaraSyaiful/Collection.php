<?php
namespace Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\AcaraSyaiful;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Icube\OkrDivisiCustomSyaiful\Model\AcaraSyaiful', 'Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\AcaraSyaiful');
    }
}