<?php 

namespace Icube\OkrDivisiCustomSyaiful\Model;

use Icube\OkrDivisiCustomSyaiful\Api\PesertaRepositoryInterface;
use Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\Peserta as PesertaResourceModel;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\TemporaryState\CouldNotSaveException;

class PesertaRepository implements PesertaRepositoryInterface
{
    /**
     * @var PesertaFactory
     */
    protected $pesertaFactory;

    /**
     * @var PesertaResourceModel
     */
    protected $pesertaResourceModel;

    /**
     * Constructor
     *
     * @param PesertaFactory $pesertaFactory
     * @param PesertaResourceModel $pesertaResourceModel
     */
    public function __construct(
        PesertaFactory $pesertaFactory,
        PesertaResourceModel $pesertaResourceModel
    ) {
        $this->pesertaFactory = $pesertaFactory;
        $this->pesertaResourceModel = $pesertaResourceModel;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getById($id)
    {
        $result = $this->pesertaFactory->create();
        $this->pesertaResourceModel->load($result, $id);

        if (!$result->getId()) {
            throw new NoSuchEntityException(__('Peserta with id "%1" does not exist.', $id));
        }
        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function getByAcaraId($acaraId)
    {
        $result = $this->pesertaFactory->create()
                        ->getCollection()               
                        ->addFieldToFilter('acara_id', $acaraId)
                        ->getData('nama');
        
        if (count($result) <= 0) {
            throw new NoSuchEntityException(__('Peserta with acara id "%1" does not exist.', $acaraId));
        }
        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function create($acaraId, $nama)
    {
        try {
            $peserta = $this->pesertaFactory->create();
            $peserta->setAcaraId($acaraId);
            $peserta->setNama($nama);
            $peserta->save();
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $peserta;
    }
}