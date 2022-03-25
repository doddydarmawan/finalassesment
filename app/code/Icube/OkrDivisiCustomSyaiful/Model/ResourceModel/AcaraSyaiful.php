<?php
namespace Icube\OkrDivisiCustomSyaiful\Model\ResourceModel;

class AcaraSyaiful extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('icube_acara_syaiful', 'entity_id');
    }
}