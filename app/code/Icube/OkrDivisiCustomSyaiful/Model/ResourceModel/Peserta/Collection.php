<?php

namespace Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\Peserta;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Icube\OkrDivisiCustomSyaiful\Model\Peserta', 'Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\Peserta');
    }
}
