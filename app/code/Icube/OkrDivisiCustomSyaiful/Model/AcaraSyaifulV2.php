<?php 
namespace Icube\OkrDivisiCustomSyaiful\Model;

use Icube\OkrDivisiCustomSyaiful\Model\Data\AcaraSyaifulV2Interface;

class AcaraSyaifulV2 implements AcaraSyaifulV2Interface{

	public function __construct(
		\Magento\Catalog\Model\Product $product,
		\Icube\OkrDivisiCustomSyaiful\Model\AcaraSyaifulV2DataFactory $acaraSyaifulV2DataFactory,
		\Icube\OkrDivisiCustomSyaiful\Model\AcaraSyaifulV2Data $acaraSyaifulV2Data,
		\Icube\OkrDivisiCustomSyaiful\Model\AcaraSyaifulFactory $acaraSyaifulFactory,
		\Icube\OkrDivisiCustomSyaiful\Model\Data\AcaraSyaifulSearchResultsInterfaceFactory $acaraSyaifulSearchResults,
		\Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
	){
		$this->product = $product;
		$this->acaraSyaifulV2DataFactory = $acaraSyaifulV2DataFactory;
		$this->acaraSyaifulV2Data = $acaraSyaifulV2Data;
		$this->acaraSyaifulFactory = $acaraSyaifulFactory;
		$this->acaraSyaifulSearchResults = $acaraSyaifulSearchResults;
		$this->collectionProcessor = $collectionProcessor;
	}

	/**
	 * Get Traini
	 * @param \Magento\Framework\Api\SearchCriteriaInterface
	 * @return \Icube\OkrDivisiCustomSyaiful\Model\Data\AcaraSyaifulSearchResultsInterface
	 */
	public function getAcaraSyaifulBySearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria){
		
		$acaraSyaifulCollection = $this->acaraSyaifulFactory->create()->getCollection();

		$this->collectionProcessor->process($searchCriteria, $acaraSyaifulCollection);

		$searchResults = $this->acaraSyaifulSearchResults->create();
		$searchResults->setSearchCriteria($searchCriteria);
		$searchResults->setTotalCount($acaraSyaifulCollection->getSize());
		$searchResults->setItems($acaraSyaifulCollection->getItems());

		return $searchResults;
	}
}