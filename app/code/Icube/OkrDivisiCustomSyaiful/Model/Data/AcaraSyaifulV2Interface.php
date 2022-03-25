<?php 
namespace Icube\OkrDivisiCustomSyaiful\Model\Data;

interface AcaraSyaifulV2Interface{

	/**
	 * Get Traini
	 * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
	 * @return \Icube\OkrDivisiCustomSyaiful\Model\Data\AcaraSyaifulSearchResultsInterface
	 */
	public function getAcaraSyaifulBySearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

}