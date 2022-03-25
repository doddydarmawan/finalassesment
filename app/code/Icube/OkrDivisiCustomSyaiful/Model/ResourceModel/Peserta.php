<?php 

namespace Icube\OkrDivisiCustomSyaiful\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Peserta extends AbstractDb
{
    /**
     * {@inheritDoc} Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('icube_peserta_syaiful', 'peserta_id');
    }
}