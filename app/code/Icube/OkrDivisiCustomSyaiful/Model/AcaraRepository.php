<?php 

namespace Icube\OkrDivisiCustomSyaiful\Model;

use Icube\OkrDivisiCustomSyaiful\Api\AcaraRepositoryInterface;
use Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\Acara as AcaraResourceModel;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\TemporaryState\CouldNotSaveException;

class AcaraRepository implements AcaraRepositoryInterface
{
    /**
     * @var AcaraFactory
     */
    protected $acaraFactory;

    /**
     * @var AcaraResourceModel
     */
    protected $acaraResourceModel;

    /**
     * Constructor
     *
     * @param AcaraFactory $acaraFactory
     * @param AcaraResourceModel $acaraResourceModel
     */
    public function __construct(
        AcaraFactory $acaraFactory,
        AcaraResourceModel $acaraResourceModel
    ) {
        $this->acaraFactory = $acaraFactory;
        $this->acaraResourceModel = $acaraResourceModel;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getById($id)
    {
        $result = $this->acaraFactory->create();
        $this->acaraResourceModel->load($result, $id);

        if (!$result->getId()) {
            throw new NoSuchEntityException(__('Acara with id "%1" does not exist.', $id));
        }
        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function create($nama, $pemateri)
    {
        try {
            $acara = $this->acaraFactory->create();
            $acara->setNama($nama);
            $acara->setPemateri($pemateri);
            $acara->save();
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $acara;
    }

    /**
     * {@inheritDoc}
     */
    public function update($id, $nama, $pemateri)
    {
        try {
            $acara = $this->getById($id);
            $acara->setNama($nama);
            $acara->setPemateri($pemateri);
            $acara->save();
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $acara;
    }
}