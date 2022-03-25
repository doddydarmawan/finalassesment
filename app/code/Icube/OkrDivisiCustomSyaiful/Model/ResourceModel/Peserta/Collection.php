<?php 

namespace Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\Peserta;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * {@inheritDoc} Initialization here
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Icube\OkrDivisiCustomSyaiful\Model\Peserta', 'Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\Peserta');
    }
}