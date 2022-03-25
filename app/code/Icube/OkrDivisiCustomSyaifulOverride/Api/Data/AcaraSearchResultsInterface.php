<?php 

namespace Icube\OkrDivisiCustomSyaifulOverride\Api\Data;

use Icube\OkrDivisiCustomSyaiful\Api\Data\AcaraInterface;
use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for preorder complete search result
 * @api
 */
interface AcaraSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get test complete list
     *
     * @return AcaraInterface[]
     */
    public function getItems();

    /**
     * Set test complete list
     *
     * @param AcaraInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}