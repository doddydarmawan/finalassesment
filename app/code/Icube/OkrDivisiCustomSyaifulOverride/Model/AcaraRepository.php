<?php 

namespace Icube\OkrDivisiCustomSyaifulOverride\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Icube\OkrDivisiCustomSyaiful\Api\AcaraRepositoryInterface;
use Icube\OkrDivisiCustomSyaiful\Model\AcaraFactory;
use Icube\OkrDivisiCustomSyaiful\Model\AcaraRepository as ModelAcaraRepository;
use Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\Acara as AcaraResourceModel;
use Icube\OkrDivisiCustomSyaiful\Model\ResourceModel\Acara\CollectionFactory;
use Icube\OkrDivisiCustomSyaifulOverride\Api\Data\AcaraSearchResultsInterfaceFactory;
use Icube\OkrDivisiCustomSyaifulOverride\Api\Data\AcaraSearchResultsInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\TemporaryState\CouldNotSaveException;
use Magento\Framework\Api\SearchCriteriaInterface;

class AcaraRepository extends ModelAcaraRepository
{
    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var AcaraSearchResultsInterfaceFactory
     */
    protected $acaraSearchResultsFactory;

    private $acaraCollectionFactory;

    /**
     * Constructor
     * @param AcaraFactory $acaraFactory
     * @param AcaraResourceModel $acaraResourceModel
     * @param CollectionFactory $acaraCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param AcaraSearchResultsInterfaceFactory $acaraSearchResultsFactory
     */
    public function __construct(
        AcaraFactory $acaraFactory,
        AcaraResourceModel $acaraResourceModel,
        CollectionFactory $acaraCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        AcaraSearchResultsInterfaceFactory $acaraSearchResultsFactory
    ) {
        parent::__construct(
            $acaraFactory, 
            $acaraResourceModel
        );
        $this->acaraCollectionFactory = $acaraCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->acaraSearchResultsFactory = $acaraSearchResultsFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function create($nama, $pemateri, $tanggal = null)
    {
        try {
            $acara = $this->acaraFactory->create();
            $acara->setNama($nama);
            $acara->setPemateri($pemateri);
            $acara->setTanggal($tanggal);
            $acara->save();
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $acara;
    }

    /**
     * {@inheritDoc}
     */
    public function update($id, $nama, $pemateri, $tanggal = null)
    {
        try {
            $acara = $this->getById($id);
            $acara->setNama($nama);
            $acara->setPemateri($pemateri);
            $acara->setTanggal($tanggal);
            $acara->save();
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $acara;
    }

    /**
     * Get trainee list use search criteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return AcaraSearchResultsInterface
     */
    public function getAcaraBySearchCriteria(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->acaraFactory->create()->getCollection();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->acaraSearchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }
}