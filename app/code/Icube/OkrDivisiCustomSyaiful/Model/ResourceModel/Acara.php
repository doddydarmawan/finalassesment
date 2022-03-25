<?php 

namespace Icube\OkrDivisiCustomSyaiful\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Acara extends AbstractDb
{
    /**
     * {@inheritDoc} Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('icube_acara_syaiful', 'acara_id');
    }
}