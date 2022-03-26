<?php

namespace Icube\OkrDivisiCustomSyaifulOverride\Model\ResourceModel;

class Acara extends \Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\Acara
{
    protected function _construct()
    {
        $this->_init('icube_acara_syaiful', 'entity_id');
    }
}
