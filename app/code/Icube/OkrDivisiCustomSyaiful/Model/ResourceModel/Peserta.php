<?php

namespace Icube\OkrDivisiCustomSyaiful\Model\ResourceModel;

class Peserta extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('icube_peserta_syaiful', 'entity_id');
    }
}
