<?php 
namespace Icube\OkrDivisiCustomSyaiful\Model\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface AcaraSyaifulSearchResultsInterface extends SearchResultsInterface
{
	/**
     * Get items list.
     *
     * @return \Icube\OkrDivisiCustomSyaiful\Model\Data\AcaraSyaifulV2Interface[]
     */
    public function getItems();

    /**
     * Set items list.
     *
     * @param \Icube\OkrDivisiCustomSyaiful\Model\Data\AcaraSyaifulV2Interface[] $items
     * @return $this
     */
    public function setItems(array $items);
}